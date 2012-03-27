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
		$this->mSmarty->assign("galimg1", "$cWebPath/images/image14.png");
		$this->mSmarty->assign("galimg2", "$cWebPath/images/image15.png");
		$this->mSmarty->assign("galimg3", "$cWebPath/images/image16.png");
		$this->mSmarty->assign("galimg4", "$cWebPath/images/image17.png");
		$this->mSmarty->assign("galimg5", "$cWebPath/images/image5.png");
		$this->mSmarty->assign("galimg6", "$cWebPath/images/image6.png");
		$this->mSmarty->assign("galimg7", "$cWebPath/images/image7.png");
		$this->mSmarty->assign("galimg8", "$cWebPath/images/image8.png");
		$this->mSmarty->assign("galimg9", "$cWebPath/images/image9.png");
		$this->mSmarty->assign("galimg10", "$cWebPath/images/image10.png");
		$this->mSmarty->assign("galimg11", "$cWebPath/images/image11.png");
		$this->mSmarty->assign("galimg12", "$cWebPath/images/image12.png");
		$this->mSmarty->assign("galimg13", "$cWebPath/images/image13.png");

	}
}
