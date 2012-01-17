<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageContact extends PageBase
{
	protected function runPage()
	{
		$this->mSmarty->assign("content", Message::getMessage("contact-page"));
	}
}
