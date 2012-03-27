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
				$this->doRemoveBillItemAction();
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
			$total += Bill_item::getById($i)->getPrice();
		}
		
		$this->mBasePage="mgmt/bill.tpl";
		$this->mSmarty->assign("total", $total);
		$this->mSmarty->assign("billitems", $items);
	}
	
	private function showEditBillPage()
	{
		$this->mBasePage="mgmt/editbill.tpl";
	}
	
		private function doRemoveBillItemAction()
	{
		$id=WebRequest::getInt("id");
		if($id < 1)
				throw new Exception("Bill Item Id too small");

		if(Booking::getById($id) == null)
				throw new Exception("Bill Item does not exist");

		Booking::getById($id)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Billing";
	}
}