<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

abstract class ManagementPageBase extends PageBase
{
	// is this page a protected by login page?
	// defaults to true, so we protect everything and have to explicitly 
	// unprotect if desired.
	protected $mIsProtectedPage = true;

	// message containing the title of the page
	protected $mPageTitle = "management-title";

	// base template to use
	protected $mBasePage = "mgmt/base.tpl";

	// main module menu
	protected $mMainMenu = array(
		"MPageHome" => array(
			"title" => "mpage-home",
			"link" => "/",
			),
		"MPageSystem" => array(
			"title" => "mpage-system",
			"link" => "/System",
			"items" => array(
				"MPagePhpInfo" => array(
					"title" => "mpage-phpinfo",
					"link" => "/PhpInfo",
					),
				"MPageSystemUsers" => array(
					"title" => "mpage-systemusers",
					"link" => "/SystemUsers",
					),
				"MPageLanguages" => array(
					"title" => "mpage-languages",
					"link" => "/Languages",
					),
				"MPageGit" => array(
					"title" => "mpage-git",
					"link" => "/Git",
					),
				)
			),
		"MPageLogout" => array(
			"title" => "mpage-logout",
			"link" => "/Logout",
			),
		);
		
	protected $mSubMenu = array();

	public function isProtected()
	{
		return $this->mIsProtectedPage;
	}
	
	protected function addSystemCssJs()
	{
		global $cWebPath;
		$this->mStyles[] = $cWebPath . "/style/management.css";
	}
	
	protected function finalSetup()
	{
		parent::finalSetup();
		
		$this->mSmarty->assign("subnavigation", $this->mSubMenu);
	}
	
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
			{
				if(! $pageobject->isProtected())
				{
					return $pageobject;
				}
				else
				{
					if(isset($_SESSION['uid']))
					{
						return $pageobject;
					}
					else
					{ // not logged in
						require_once($cIncludePath . "/ManagementPage/MPageLogin.php");
						return new MPageLogin();
					}
				}
			}
			else	// defined, but doesn't inherit properly, so we can't guarentee stuff will work.
				throw new Exception();
		}
		else // file exists, but the class "within" doesn't, this is a problem as stuff isn't where it should be.
			throw new Exception();
	}
}
