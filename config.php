<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

// main configuration file

ini_set('display_errors',1);

$cIncludePath = "include";
$cFilePath = __DIR__;
$cScriptPath = $_SERVER['SCRIPT_NAME'];

$pparts = pathinfo($_SERVER["SCRIPT_NAME"]);
$cWebPath = $pparts["dirname"] == "/" ? "" : $pparts["dirname"];

// database details
$cDatabaseConnectionString = 'mysql:host=dbmaster.helpmebot.org.uk;dbname=dvs_hotel';
$cDatabaseModule = "pdo_mysql";
$cMyDotCnfFile = ".my.cnf";

$cLoggerName="FakeLogger";

// array of global scripts to be included
// Global scripts are included first, then local scripts second
$cGlobalScripts = array(
	'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', 
	);

$cGlobalStyles = array(
	);
	
$cAvailableLanguages = array(
	'zxx' => "(Language Tag Codes)",
	'en-GB' => "English (British)",
	'fi' => "Suomi",
	);
	
// list of required php extensions.
// The PDO module required is set above, and need not be listed here also.
// Optional ones such as Tidy should not be listed here - the site will run 
// without them. 
$cRequiredExtensions = array(
	"PDO",
	"SPL",
	);
	
// use Tidy to make pretty HTML.
$cUseTidy = false;
	
$cTidyOptions = array(
	//"hide-comments" => 1, // discards html comments
	"logical-emphasis" => 1, // swaps <b> for <strong> and <i> for <em>
	"output-xhtml" => 1,
	"indent" => "auto",
	"wrap" => 0, // disables wrapping
	"vertical-space" => 1, // adds vertical spacing for readability
	);
///////////////// don't put new config options below this line

if(file_exists("config.local.php"))
{
	require_once("config.local.php");
}

// Load the main hotel file
require_once($cIncludePath . "/Hotel.php");
