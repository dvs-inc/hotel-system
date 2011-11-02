<?php

abstract class PageBase
{
	// array of extra (per-page) javascript files to add
	protected $mScripts = array();

	// array of extra (per-page) CSS stylesheets to add
	protected $mStyles = array();

	protected $mSmarty;

	// title of the page
	protected $mPageTitle = "The Blackfish Hotel";

	// base template to use
	protected $mBasePage = "base.tpl";

	public function execute()
	{
		$this->mSmarty = new Smarty();

		// "run" the page - allow the user to make any customisations to the current state
		$this->runPage();

		global $cGlobalScripts;
		$scripts = array_merge($cGlobalScripts, $this->mScripts);
		$this->mSmarty->assign("scripts",$scripts);

		global $cGlobalStyles;
		$styles = array_merge($cGlobalStyles, $this->mStyles);
		$this->mSmarty->assign("styles",$styles);

		$this->mSmarty->assign("pagetitle",$this->mPageTitle);

		// actually display the page.
		$this->mSmarty->display($this->mBasePage);
	}

	protected abstract function runPage();

	public static function create()
	{
		return new PageMain();
	}
}
