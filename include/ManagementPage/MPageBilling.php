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
				$this->showViewBillPage();
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
				break;
			case "del":
				self::checkAccess("remove-bill-item");
				//$this->doRemoveBillItemPage();
				break;
		}
	}
	
	private function showViewBillPage()
	{
		if(!WebRequest::getInt("id"))
		{
			return;
		}
		
		$id = WebRequest::getInt("id");
		
		$items = Bill_item::getIdListByBooking($id);
		
		$total = 0;
		foreach($items as $i)
		{
			$total += $i->getPrice();
		}
		
		$this->mBasePage="mgmt/bill.tpl";
		$this->mSmarty->assign("total", $total);
		$this->mSmarty->assign("billitems", $items);
	}
}