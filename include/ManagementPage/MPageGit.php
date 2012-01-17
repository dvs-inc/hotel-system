<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageGit extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mBasePage="mgmt/git.tpl";
		$this->mSmarty->assign("softwareVersion", exec("git describe --always"));
	}
}
