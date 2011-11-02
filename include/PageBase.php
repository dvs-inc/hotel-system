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

		global $test;
		$this->mSmarty->assign("pagetitle", $this->mPageTitle);

		// actually display the page.
		$this->mSmarty->display($this->mBasePage);
	}

	protected abstract function runPage();

	public static function create()
	{
		// use "Main" as the default
		$page = "Main";

		// check the requested page title for safety and sanity
		
		$pathinfo = explode('/', WebRequest::pathInfo());
		$pathinfo = array_values(array_filter($pathinfo));
		if(
			count($pathinfo) >= 1 &&
			$pathinfo[0] != "" &&  // not empty
			(!ereg("[^a-zA-Z0-9]", $pathinfo[0])) // contains only alphanumeric chars
		)
		{
			$page = $pathinfo[0];
		}
		
		// okay, the page title should be reasonably safe now, let's try and make the page
		
		$pagename = "Page" . $page;
		
		global $cIncludePath;
		$filepath = $cIncludePath . "/Page/" . $pagename . ".php";
		
		if(file_exists($filepath))
			require_once($filepath);
		else
		{	// oops, couldn't find the requested page, let's fail gracefully.
			$pagename = "Page404";
			$filepath = $cIncludePath . "/Page/" . $pagename . ".php";
			require_once($filepath);
		}	

		if(class_exists($pagename))
		{
			$pageobject = new $pagename;
			
			if(get_parent_class($pageobject) == "PageBase")
				return $pageobject;
			else	// defined, but doesn't inherit properly, so we can't guarentee stuff will work.
				throw new Exception();
		}
		else // file exists, but the class "within" doesn't, this is a problem as stuff isn't where it should be.
			throw new Exception();
	}
}
