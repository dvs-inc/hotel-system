<?php

// main configuration file


$cIncludeDirectory = "include";

// autoload function handles all the silly require stuff for us automatically;
function __autoload($class_name)
{
	global $cIncludeDirectory;
	require_once($cIncludeDirectory . "/" . $class_name . ".php");
}
