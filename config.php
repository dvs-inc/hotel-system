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

// array of global scripts to be included
// Global scripts are included first, then local scripts second
$cGlobalScripts = array(
	'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', 
	);

$cGlobalStyles = array(
	);
	
$cAvailableLanguages = array(
	'en-GB' => "English (British)",
	'fi' => "Suomi",
	'zxx' => "(Language Tag Codes)",
	);
	
// change this before using it on a live system! this is for test purposes only.
$cCardEncryptionKey = base64_decode(
	"XDI3MVwzMzJTeFwyNzQ7XDMyXDM0MCdcMjIxIVwzNTVcMzY2XlwyMjFcMzQyZVwz".
	"NzBcMzM1XDMzNzV3XDM1MVp0JGNdcFwyNzVcMzU3XDM1M1wyMDJcMjIyLlwyNTdc".
	"MjAxXDM1N1wzNjZcMzYyXDMzNVwzMTUwJSZfa1wzNTRcMjMzXDMwNFwzNTdcMjQz".
	"XDIxN1wzMDN3XCJcMjI2XDMwNFwzNDJcMjcxXDM1N1wyOlVJXDIzNVwzNjZcMzMy".
	"flowIyR2XDMzM1wyMzR6XDM3NVwiNFwzMTZcMzQ3cVwyNTMsSVwzMTFcMjQ3XDI0".
	"NFwzMTBcMzBcMjQyXDMxNFwyMDRcMjI1XDM3KlwzMTFcNFwyNzJcMitcMzQ3XDMz".
	"MVwyNjNcMzQ1XDI1N1wyMDRcMjUxXDIwNFwzMTUzXDM2MlwyNjNcMjczXDIxM1wy".
	"MzFQXDIwMUFgXDM0NGxcMjVcMzUzXDIyMVwzN1w2LVwyMTRcMzI3b1wzNzN2XDMz"
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
$cUseTidy = true;
	
$cTidyOptions = array(
	//"hide-comments" => 1, // discards html comments
	"logical-emphasis" => 1, // swaps <b> for <strong> and <i> for <em>
	"output-xhtml" => 1,
	"indent" => 1,
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