<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

abstract class ManagementPageBase extends PageBase
{
	// message containing the title of the page
	protected $mPageTitle = "management-title";

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
		"PagePhpInfo" => array(
			"title" => "page-phpinfo",
			"link" => "/PhpInfo",
			),
		);

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
		
		$pagename = "MPage" . $page;
		
		global $cIncludePath;
		$filepath = $cIncludePath . "/ManagementPage/" . $pagename . ".php";
		
		if(file_exists($filepath))
			require_once($filepath);
		else
		{	// oops, couldn't find the requested page, let's fail gracefully.
			$pagename = "MPage404";
			$filepath = $cIncludePath . "/ManagementPage/" . $pagename . ".php";
			require_once($filepath);
		}	

		if(class_exists($pagename))
		{
			$pageobject = new $pagename;
			
			if(get_parent_class($pageobject) == "ManagementPageBase")
				return $pageobject;
			else	// defined, but doesn't inherit properly, so we can't guarentee stuff will work.
				throw new Exception();
		}
		else // file exists, but the class "within" doesn't, this is a problem as stuff isn't where it should be.
			throw new Exception();
	}
}
