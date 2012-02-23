<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLogin extends ManagementPageBase
{
	protected function runPage()
	{
		global $gLogger;
		$gLogger->log("Login page initialising");
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
		global $gLogger;
		$gLogger->log("Showing login form");
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
		global $gLogger;
		$gLogger->log("Handling login");

		// variable to set the status of the login
		// defaults to false.
		$success = false;
		$error = "";

		$username = WebRequest::post("lgUsername");
		$password = WebRequest::post("lgPassword");

		$userAccount = InternalUser::getByName($username);
		if($userAccount)
		{
			if($userAccount->authenticate($password))
			{
				// log in
				$gLogger->log("Login: OK");

				$success = true;
				Session::setLoggedInUser($userAccount->getId());
			}
			else
			{
				$error = "bad-password";
				$gLogger->log("Login:Bad password");

			}
		}
		else
		{
			$error = "bad-username";
			$gLogger->log("Login:Bad username");

		}

		// TODO: remove this after login username agreed with group
		// --stw 23/01/2011
		if(WebRequest::postString("bypass") == "bypass")
		{
			$success=true;
			Session::setLoggedInUser(0);
			$gLogger->log("LOGIN BYPASSED!");
		}

		if($success)
		{
			global $cWebPath;
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/management.php";
		}
		else
		{
			$this->error($error);
			$this->showLoginForm();
		}
	}
}
