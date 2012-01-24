<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

/**
 * A fake logging system for production use which actually does nothing.
 */
class FakeLogger implements ILogger
{
	public function log($message)
	{
	}
}