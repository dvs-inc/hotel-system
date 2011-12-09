<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Hotel
{
	public function run()
	{
		$this->setupEnvironment();
		$this->main();
		$this->cleanupEnvironment();
	}
	
	// autoload function handles all the silly require stuff for us automatically;
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
		
		global $gCookieJar;
		$gCookieJar = array();
	}
	
	private function cleanupEnvironment()
	{
		// discard any extra content
		ob_end_clean();
	}
	
	private function main()
	{
		// create a page...
		$page = PageBase::create();
		
		// ...and execute it.
		$page->execute();
	}
}