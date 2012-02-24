<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPagePublicSite extends ManagementPageBase
{
	protected function runPage()
	{
		global $cWebPath;
	
		$this->mHeaders[] = "HTTP/1.1 303 See Other";
		$this->mHeaders[] = "Location: " . $cWebPath . "/index.php";
	}
}
