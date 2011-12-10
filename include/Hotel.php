<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Hotel
{
	private $managementMode = false;

	public function run()
	{
		$this->setupEnvironment();
		$this->main();
		$this->cleanupEnvironment();
	}
	
	public function setManagementMode($value)
	{
		if($value == "1" || $value == "2")
		{
			$this->managementMode = $value;
		}
		else
		{
			$this->managementMode = true;
		}
	}
	
	private static function autoLoader($class_name)
	{
		global $cIncludePath;
		require_once($cIncludePath . "/" . $class_name . ".php");
	}	

	private function checkPhpExtensions()
	{
		global $cRequiredExtensions;
		
		foreach($cRequiredExtensions as $ext)
		{
			if(!extension_loaded($ext))
			{
				throw new ExtensionUnavailableException($ext);
			}
		}
	}
	
	private function setupEnvironment()
	{
		global $gDatabase, $cDatabaseConnectionString, $cMyDotCnfFile, 
			$cDatabaseModule, $cIncludePath;

		session_start();
	
		// check all the required PHP extensions are enabled on this SAPI
		$this->checkPhpExtensions();
	
		// start output buffering before anything is sent to the browser.
		ob_start();
	
		// many exceptions defined in one file, let's not clutter stuff. 
		// This ofc breaks the autoloading, so let's include them all now.
		require_once($cIncludePath . "/_Exceptions.php");

		// not caught by the autoloader :(
		require_once('smarty/Smarty.class.php');

		spl_autoload_register("Hotel::autoLoader");
			
		if(!extension_loaded($cDatabaseModule))
		{
			throw new ExtensionUnavailableException($cDatabaseModule);
		}
		
		$mycnf = parse_ini_file($cMyDotCnfFile);
		
		$gDatabase = new Database($cDatabaseConnectionString,$mycnf["user"], $mycnf["password"]);
		
		// tidy up sensitive data we don't want lying around.
		unset($mycnf);
		
		// can we tidy up the output with tidy before we send it?
		if(extension_loaded("tidy"))
		{ // Yes!
		
			global $cUseTidy;
			if($cUseTidy)
			{
				// register a new function to hook into the output bit
				Hooks::register("BeforeOutputSend", function($params) {
						$tidy = new Tidy();
						global $cTidyOptions;
						return $tidy->repairString($params[0], $cTidyOptions, "utf8");
					});
			}
		}
		
		
		
		global $gCookieJar;
		$gCookieJar = array();
	}
	
	protected function cleanupEnvironment()
	{
		// discard any extra content
		ob_end_clean();
	}
	
	protected function main()
	{
		$basePage = $this->managementMode ? "ManagementPageBase" : "PageBase";
	
		// create a page...
		$page = $basePage::create();
		
		// ...and execute it.
		$page->execute();
	}
}