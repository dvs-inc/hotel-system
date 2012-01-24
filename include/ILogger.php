<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

/**
 * Defines a logging interface for the code to use.
 */
interface ILogger
{
	public function log($message);
}