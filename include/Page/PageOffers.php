<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageOffers extends PageBase
{
	protected function runPage()
	{
		$this->mSmarty->assign("content", Message::getMessage("offers-page"));
	}
}
