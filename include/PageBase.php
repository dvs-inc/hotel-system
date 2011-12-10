<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

abstract class PageBase
{
	// array of extra (per-page) javascript files to add
	protected $mScripts = array();

	// array of extra (per-page) CSS stylesheets to add
	protected $mStyles = array();

	protected $mSmarty;

	// message containing the title of the page
	protected $mPageTitle = "html-title";

	// base template to use
	protected $mBasePage = "base.tpl";

	// main menu
	protected $mMainMenu = array(
		/* Format:
			"Class name" => array(
				"title" => "Message name to display",
				"link" => "Link to show",
				),
			*/		
		"PageMain" => array(
			"title" => "page-home",
			"link" => "/",
			),
		);
		
	// array of HTTP headers to add to the request.
	protected $mHeaders = array();

	protected function setupPage()
	{
		$this->mSmarty = new Smarty();

		$this->mSmarty->registerPlugin(
			"function",
			"message", 
			array(
				"Message", 
				"smartyGetRealMessageContentWithDynamicLanguageFromUser" . 
					"PrefsAndCookies"
				)
			);
		
		$this->addSystemCssJs();
	}
	
	protected function finalSetup()
	{
		global $cGlobalScripts;
		$scripts = array_merge($cGlobalScripts, $this->mScripts);
		$this->mSmarty->assign("scripts",$scripts);

		global $cGlobalStyles;
		$styles = array_merge($cGlobalStyles, $this->mStyles);
		$this->mSmarty->assign("styles",$styles);

		$this->mSmarty->assign("pagetitle", $this->mPageTitle);

		// setup the current page on the menu, but only if the current page 
		// exists on the main menu in the first place
		if(array_key_exists(get_class($this), $this->mMainMenu))
		{
			$this->mMainMenu[get_class($this)]["current"] = true;
		}
		$this->mSmarty->assign("mainmenu", $this->mMainMenu);

		global $cWebPath, $cScriptPath;
		$this->mSmarty->assign("cWebPath", $cWebPath);
		$this->mSmarty->assign("cScriptPath", $cScriptPath);
	}
	
	/**
	 * Adds the "global" CSS / JS for this part of the system.
	 *
	 * This differs for the management side of the system, hence is overridden over there.
	 * This method is just to make it easier to override.
	 */
	protected function addSystemCssJs()
	{
		global $cWebPath;
		// $mStyles[] = $cWebPath . "/style/main.css";
		
		$this->mStyles[] = $cWebPath . '/style/svwp_style.css';
		
		$this->mScripts[] = $cWebPath . '/scripts/jquery.slideViewerPro.1.5.js';
		$this->mScripts[] = $cWebPath . '/scripts/jquery.timers-1.2.js';
		$this->mScripts[] = $cWebPath . '/scripts/imageslider.js';
	}
	
	public function execute()
	{
		// set up the page
		$this->setupPage();

		// "run" the page - allow the user to make any customisations to the
		// current state
		$this->runPage();

		// perform any final setup for the page, overwriting any user 
		// customisations which aren't allowed, and anything that potentially 
		// needs to be rebuilt/updated.
		$this->finalSetup();

		// get the page content
		$content = $this->mSmarty->fetch($this->mBasePage);

		// set any HTTP headers
		foreach($this->mHeaders as $h)
		{
			header($h);
		}
		
		// send the cookies to make the client smile and go mmmmm nom nom
		WebRequest::sendCookies();
		
		// send the output
		WebRequest::output($content);
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
