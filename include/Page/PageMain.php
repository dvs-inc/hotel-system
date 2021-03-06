<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageMain extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "home.tpl";
		
		$this->mSmarty->assign("valQbCheckin", "");
		$this->mSmarty->assign("valQbCheckout", "");
		$this->mSmarty->assign("valQbAdults", "");
		$this->mSmarty->assign("valQbChildren", "");
		$this->mSmarty->assign("valQbPromoCode", "");
		
		global $cWebPath;
		
		$this->mStyles[] = $cWebPath . '/style/jsDatePick_ltr.min.css';
		$this->mScripts[] = $cWebPath . '/scripts/jsDatePick.full.1.3.js';
	}
}
