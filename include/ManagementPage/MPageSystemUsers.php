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
}
