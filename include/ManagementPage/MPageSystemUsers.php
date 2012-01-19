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
                        if(WebRequest::post("pass") != WebRequest::post("pass2"))
                                throw new Exception("Passwords do not match");

			if(trim(WebRequest::post("username")) =="")
				throw new Exception("Username is empty");

                        $password = WebRequest::post("pass");
			$username = WebRequest::post("username");
			$user = new InternalUser();
			$user->setUsername($username);
			$user->setPassword($password);
			$user->save();

			global $cScriptPath;
			$this->mHeaders[] = "Location: {$cScriptPath}/SystemUsers";
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
			if(WebRequest::post("newpass") != WebRequest::post("newpass2"))
				throw new Exception("Passwords do not match");

			$password = WebRequest::post("newpass");

			$user = InternalUser::getById($userid);
			$user->setPassword($password);
			$user->save();

			global $cScriptPath;
			$this->mHeaders[] = "Location: {$cScriptPath}/SystemUsers";
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
