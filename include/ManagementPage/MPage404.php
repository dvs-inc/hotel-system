<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPage404 extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mHeaders[] = "HTTP/1.0 404 Not Found";
		$this->mPageTitle = "mpage-title-404";
		$this->mSmarty->assign("content", "Sorry, what you were looking for couldn't be found.");
	}
}
