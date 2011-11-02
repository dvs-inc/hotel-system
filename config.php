<?php

// main configuration file

ini_set('display_errors',1);

$cIncludePath = "include";
$cFilePath = __DIR__;

$pparts = pathinfo($_SERVER["SCRIPT_NAME"]);
$cWebPath = $pparts["dirname"];

// array of global scripts to be included
// Global scripts are included first, then local scripts second
$cGlobalScripts = array(
	'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', 
	$cWebPath.'/scripts/jquery.slideViewerPro.1.5.js', 
	$cWebPath.'/scripts/jquery.timers-1.2.js', 
	$cWebPath.'/scripts/imageslider.js',
	);

$cGlobalStyles = array(
	$cWebPath.'/style/svwp_style.css',
	);

// autoload function handles all the silly require stuff for us automatically;
function autoLoader($class_name)
{
	global $cIncludePath;
	require_once($cIncludePath . "/" . $class_name . ".php");
}

// not caught by the above :(
require_once('smarty/Smarty.class.php');

spl_autoload_register("autoLoader");

