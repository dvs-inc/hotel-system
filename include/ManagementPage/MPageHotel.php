<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageHotel extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mBasePage="mgmt/base.tpl";
		$this->mSmarty->assign("content", Message::getMessage("mgmt-hotel-content"));
	}
}
