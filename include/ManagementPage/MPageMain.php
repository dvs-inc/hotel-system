<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageMain extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mBasePage="mgmt/home.tpl";
		
		$this->mSubMenu = array(
			"MPagePhpInfo" => array(
				"title" => "mpage-phpinfo",
				"link" => "/PhpInfo",
				),
			"MPageSystemUsers" => array(
				"title" => "mpage-systemusers",
				"link" => "/SystemUsers",
				),
			"MPageLanguages" => array(
				"title" => "mpage-languages",
				"link" => "/Languages",
				),
			);
	}
}
