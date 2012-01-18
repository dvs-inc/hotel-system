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
		$this->mBasePage="mgmt/home.tpl";

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
}
