<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLogin extends ManagementPageBase
{
	protected function runPage()
	{
		if(WebRequest::wasPosted())
		{
			$this->handleLogin();
		}
		else
		{
			$this->showLoginForm();
		}
	}
	
	private function showLoginForm()
	{
		global $cWebPath;
		$this->mStyles[] = $cWebPath . "/style/loginform.css";

		$this->mBasePage = "mgmt/login.tpl";
		$this->mMainMenu = array(		
			"MPageLogin" => array(
				"title" => "mpage-login",
				"link" => "/Login",
				)
			);
		$this->mSubMenu = array();
	}
	
	private function handleLogin()
	{
		if(/*success*/ true)
		{
			$_SESSION["uid"] = "0";
			global $cWebPath;
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/management.php";
		}
		else
		{
		
		}
		
	}
}
