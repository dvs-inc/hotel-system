<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageBook extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "book.tpl";
	}
}
