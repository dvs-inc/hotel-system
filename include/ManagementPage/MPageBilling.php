<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageBilling extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-billing-page";
	}

	protected function runPage()
	{
		$action = WebRequest::get("action");
		switch($action)
		{
			case "view":
				self::checkAccess("view-bill");
				//$this->showViewBillPage();
				break;
			case "edit":
				self::checkAccess("edit-bill");
				//$this->showEditBillPage();
				break;
			case "add":
				self::checkAccess("append-bill");
				//$this->showAddBillItemPage();
				break;
			case "pay":
				self::checkAccess("pay-bill");
				//$this->showPayBillPage();
			case "list":
			default:
				
				break;
		}
	}
}