<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

abstract class ManagementPageBase extends PageBase
{
	// is this page a protected by login page?
	// defaults to 1, so we protect everything and have to explicitly 
	// unprotect if desired.
	protected $mIsProtectedPage = false;

	// message containing the title of the page
	protected $mPageTitle = "management-title";

	// base template to use
	protected $mBasePage = "mgmt/base.tpl";

	protected $mAccessName = "public";
	
	// main module menu
	protected $mMainMenu = array(
		"MPageHome" => array(
			"title" => "mpage-home",
			"link" => "/",
			),
		"MPageHotel" => array(
			"title" => "mpage-hotel",
			"link" => "/Hotel",
			"items" => array(
				"MPageRooms" => array(
					"title" => "mpage-rooms",
					"link" => "/Rooms",
					),
				)
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
				"MPageAccess" => array(
					"title" => "mpage-access",
					"link" => "/Access",
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
	
	public function getAccessName()
	{
		return $this->mAccessName;
	}
	
	protected function addSystemCssJs()
	{
		global $cWebPath;
		$this->mStyles[] = $cWebPath . "/style/management.css";
	}
	
	protected function setupPage()
	{
		parent::setupPage();

		$this->mSmarty->assign("showError", "no");
	}

	protected function finalSetup()
	{
		global $gLogger;
		$gLogger->log("MPage final setup");
		if(Session::getLoggedInUser())
		{
			$gLogger->log("uid is set");
			$uid = Session::getLoggedInUser();
			if($uid!=0)
			{
				$gLogger->log("uid is $uid");

				$user = InternalUser::getById($uid);

				$gLogger->log("name is" . $user->getUsername());

				$this->mMainMenu["MPageLogout"]["data"] = " (". $user->getUsername().")";
			}
		}

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
		{  //if
			$page = $pathinfo[0];
		} // fi
		
		// okay, the page title should be reasonably safe now, let's try and make the page
		
		$pagename = "MPage" . $page;
		
		global $cIncludePath;
		$filepath = $cIncludePath . "/ManagementPage/" . $pagename . ".php";
		
		if(file_exists($filepath))
		{
			require_once($filepath);
		}
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
				Hooks::run("CreatePage", array($pageobject));
			
				if(! $pageobject->isProtected())
				{
					return $pageobject;
				}
				else
				{
					if(Session::isLoggedIn())
					{
						Hooks::register("AuthorisedCreatePage", ManagementPageBase::checkPageAccessLevel);
					
						$pageobject = Hooks::run("AuthorisedCreatePage", array($pageobject));
					
						return $pageobject;
					}
					else
					{ // not logged in
						require_once($cIncludePath . "/ManagementPage/MPageLogin.php");
						return new MPageLogin();
					}
				}
			}
			else
			{
				// defined, but doesn't inherit properly, so we can't guarentee stuff will work.
				throw new Exception();
			}
		}
		else 
		{
			// file exists, but the class "within" doesn't, this is a problem as stuff isn't where it should be.
			throw new Exception();
		}
	}

	protected function error($messageTag)
	{
		$this->mSmarty->assign("showError", "yes");
		$this->mSmarty->assign("errortext", $messageTag);
	}
	
	private static function checkPageAccessLevel($parameters)
	{
		$page = $parameters[0];
		
		$userAccessLevel = InternalUser::getById(Session::getLoggedInUser())->getAccessLevel();
		$actionName=$page->getAccessName();
		if($actionName == "public")
		{
			$pageAccessLevel = 0;
		}
		else
		{
			$pageAccessLevel = StaffAccess::getByAction()->getLevel();
		}
				
		if($userAccessLevel < $pageAccessLevel)
		{
			
		}
	}
}
