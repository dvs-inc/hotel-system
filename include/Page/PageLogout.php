<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageLogout extends PageBase
{
	protected function runPage()
	{
		Session::destroy();
		
		global $cScriptPath;
		$this->mHeaders[] = "HTTP/1.1 303 See Other";
		$this->mHeaders[] = "Location: " . $cScriptPath;;
	}
}
