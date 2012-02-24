<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageGit extends ManagementPageBase
{
	public function __construct()
	{
		$this->mIsProtectedPage = false;
	}

	protected function runPage()
	{
		$this->mBasePage="mgmt/git.tpl";
		$this->mSmarty->assign("softwareVersion", exec("git describe --always --dirty"));
	}
}
