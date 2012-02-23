<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLogout extends ManagementPageBase
{
	protected function runPage()
	{
		Session::destroy();
		
		global $cWebPath;
		$this->mHeaders[] = "HTTP/1.1 303 See Other";
		$this->mHeaders[] = "Location: " . $cWebPath . "/management.php/Login";
	}
}
