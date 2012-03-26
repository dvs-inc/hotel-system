<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageMain extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mBasePage="mgmt/home.tpl";
		
		global $cWebPath;
		
		$this->mStyles[] = $cWebPath . '/style/jsDatePick_ltr.min.css';
		$this->mScripts[] = $cWebPath . '/scripts/jsDatePick.full.1.3.js';
	}
}
