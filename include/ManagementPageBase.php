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
			"description" => "mpage-hotel-desc",
			"items" => array(
				"MPageCustomers" => array(
					"title" => "mpage-customers",
					"link" => "/Customers",
					),
				"MPageBookings" => array(
					"title" => "mpage-booking",
					"link" => "/Bookings",
					),
				"MPageRooms" => array(
					"title" => "mpage-rooms",
					"link" => "/Rooms",
					),
				),
			),
		"MPageSystem" => array(
			"title" => "mpage-system",
			"link" => "/System",
			"description" => "mpage-system-desc",
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
		"MPagePublicSite" => array(
			"title" => "mpage-publicsite",
			"link" => "/PublicSite",
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
		
		global $cIncludePath, $gLogger;
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
				$gLogger->log("MPage object created.");
			
				if(! $pageobject->isProtected())
				{
					$gLogger->log("MPage object not protected.");
				
					return $pageobject;
				}
				else
				{
					$gLogger->log("MPage object IS protected.");
				
					if(Session::isLoggedIn())
					{	
						$gLogger->log("Session is logged in");

						Hooks::register("PreRunPage", 
							function($parameters)
							{
								ManagementPageBase::checkAccess($parameters[1]->getAccessName());
								return $parameters[0];
							});
					
						$pageobject = Hooks::run("AuthorisedCreatePage", array($pageobject));
					
						return $pageobject;
					}
					else
					{ // not logged in
						$gLogger->log("Session NOT logged in");

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

	public static function checkAccess($actionName)
	{
		global $gLogger;
		$gLogger->log("Entering checkPageAccessLevel");
			
		$userAccessLevel = InternalUser::getById(Session::getLoggedInUser())->getAccessLevel();
		
		$gLogger->log("checkPageAccessLevel: user access is $userAccessLevel, page action name is $actionName");

		
		if($actionName == "public")
		{
			$pageAccessLevel = 0;
		}
		else
		{
			$actionObject = StaffAccess::getByAction($actionName);
			$pageAccessLevel = $actionObject->getLevel();
			$gLogger->log("checkPageAccessLevel: page access is " . $pageAccessLevel);

		}
				
		if($userAccessLevel < $pageAccessLevel)
		{
			throw new AccessDeniedException();
		}
	}

	public function handleAccessDeniedException($ex)
	{
		$this->mHeaders = "HTTP/1.1 403 Forbidden";
		$this->mBasePage = "mgmt/accessdenied.tpl";
	}
}
