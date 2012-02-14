<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageSystemUsers extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mSubMenu = array(
			"MPageSystemUserList" => array(
				"title" => "mpage-user-list",
				"link" => "/SystemUsers?action=list",
				),
			"MPageCreateUser" => array(
				"title" => "mpage-user-create",
				"link" => "/SystemUsers?action=create",
				),

		);

		$action = WebRequest::get("action");
		switch($action)
		{
			case "changepw":
				$this->showChangePasswordPage();
				break;
			case "del":
				$this->doDeleteUserAction();
				break;
			case "create":
				$this->showCreateUserPage();
				break;
			case "list":
			default:
				$this->showListUserPage();
				break;
		}
	}

	private function showCreateUserPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				if(WebRequest::post("pass") != WebRequest::post("pass2"))
					throw new CreateUserException("password-nomatch");

				if(trim(WebRequest::post("username")) =="")
					throw new CreateUserException("blank-username");

				$password = WebRequest::post("pass");
				$username = WebRequest::post("username");
				$level = WebRequest::postInt("accesslevel");
				$user = new InternalUser();
				$user->setUsername($username);
				$user->setPassword($password);
				$user->setAccessLevel($level);
				$user->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/SystemUsers";
			}
			catch (CreateUserException $ex)
			{
				$this->mBasePage="mgmt/iuserCreate.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/iuserCreate.tpl";
		}
	}

	private function showListUserPage()
	{
		$idList = InternalUser::getIdList();

		$userList = array();

		foreach($idList as $id)
		{
			$userList[] = InternalUser::getById($id);
		}

		$this->mSmarty->assign("iuserlist", $userList);

		$this->mBasePage="mgmt/iuserlist.tpl";

		if(isset($_SESSION['uid']))
		{
			$this->mSmarty->assign("currentUid", $_SESSION['uid']);
		}
	}

	private function showChangePasswordPage()
	{
		$userid=WebRequest::getInt("id");
		if($userid < 1)
			throw new Exception("UserID too small");

		if(InternalUser::getById($userid) == null)
			throw new Exception("User does not exist");

		if(WebRequest::wasPosted())
		{
			try{
				if(WebRequest::post("newpass") != WebRequest::post("newpass2"))
					throw new CreateUserException("Passwords do not match");

				$password = WebRequest::post("newpass");

				$user = InternalUser::getById($userid);
				$user->setPassword($password);
				$user->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/SystemUsers";
			}
			catch(CreateUserException $ex)
			{
				$this->error("password-nomatch");
				$this->mSmarty->assign("userid",$userid);
				$this->mBasePage="mgmt/iuserChangePw.tpl";
			}
		}
		else
		{
			$this->mSmarty->assign("userid",$userid);
			$this->mBasePage="mgmt/iuserChangePw.tpl";
		}
	}

	private function doDeleteUserAction()
	{
		$userid=WebRequest::getInt("id");
		if($userid < 1)
				throw new Exception("UserID too small");

		if(InternalUser::getById($userid) == null)
				throw new Exception("User does not exist");

		InternalUser::getById($userid)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/SystemUsers";
	}
}
