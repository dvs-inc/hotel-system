<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageGallery extends PageBase
{
	protected function runPage()
	{
		global $cWebPath;
		$this->mBasePage = "gallery.tpl";
		$this->mStyles[] = "$cWebPath/style/gallery.css";
		$this->mSmarty->assign("galimg1", "$cWebPath/images/image1.png");
	}
}
