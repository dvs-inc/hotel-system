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
	
	private function setupEnvironment()
	{
		global $gDatabase, $cDatabaseConnectionString, $cMyDotCnfFile;
		
		$mycnf = parse_ini_file($cMyDotCnfFile);
		
		$gDatabase = new Database($cDatabaseConnectionString,$mycnf["user"], $mycnf["password"]);
		
		// tidy up sensitive data we don't want lying around.
		unset($mycnf);
		
		global $gCookieJar;
		$gCookieJar = array();
	}
	
	private function cleanupEnvironment()
	{
	
	}
	
	private function main()
	{
		// create a page...
		$page = PageBase::create();
		// ...and execute it.
		$page->execute();
	}
}