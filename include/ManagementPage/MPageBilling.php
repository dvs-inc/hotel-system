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
				$this->showEditBillItemPage();
				break;
			case "add":
				self::checkAccess("append-bill");
				$this->showAddBillItemPage();
				break;
			case "pay":
				self::checkAccess("pay-bill");
				$this->doPayBillAction();
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
		$billitems = array();
		$total = 0;
		foreach($items as $i)
		{
			$bi = Bill_item::getById($i);
			$total += $bi->getPrice();
			$billitems[]=$bi;
		}
		
		$this->mBasePage="mgmt/bill.tpl";
		$this->mSmarty->assign("total", $total);
		$this->mSmarty->assign("billitems", $billitems);
		$this->mSmarty->assign("bid", $id);
		
	}
	
	private function showEditBillItemPage()
	{
		$rt = WebRequest::getInt("rt");
		$id = WebRequest::getInt("id");
		
		$bi = Bill_item::getById($id);
		if($bi == null)
		{
			throw new NonexistantObjectException();
		}
		
		if(WebRequest::wasPosted())
		{
			$bi->setName(WebRequest::post("billname"));
			$bi->setPrice(WebRequest::post("billprice"));
			$bi->save();
			global $cScriptPath;
			$this->mHeaders[] = "Location: {$cScriptPath}/Billing?action=view&id=$rt";
		}
		else
		{
			$this->mSmarty->assign("billname", $bi->getName());
			$this->mSmarty->assign("billprice", $bi->getPrice());
			$this->mSmarty->assign("bid", $rt);
			$this->mSmarty->assign("itemid", $id);
			$this->mBasePage="mgmt/billedit.tpl";
		}
	}
	private function showAddBillItemPage()
	{
		$rt = WebRequest::getInt("id");
		
		if(WebRequest::wasPosted())
		{
			$bi = new Bill_item();
			$bi->setBooking(Booking::getById($rt));
			$bi->setName(WebRequest::post("billname"));
			$bi->setPrice(WebRequest::post("billprice"));
			$bi->save();
			global $cScriptPath;
			$this->mHeaders[] = "Location: {$cScriptPath}/Billing?action=view&id=$rt";
		}
		else
		{
			$this->mSmarty->assign("bid", $rt);
			$this->mBasePage="mgmt/billcreate.tpl";
		}
	}
	
	private function doRemoveBillItemAction()
	{
		$id=WebRequest::getInt("id");
		if($id < 1)
				throw new Exception("Bill Item Id too small");

		if(Bill_item::getById($id) == null)
				throw new Exception("Bill Item does not exist");

		Bill_item::getById($id)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Billing?action=view&id=".WebRequest::getInt("rt");
	}

	private function doPayBillAction()
	{
		$id=WebRequest::getInt("id");

		$items = Bill_item::getIdListByBooking($id);
		$total = 0;
		foreach($items as $i)
		{
			$bi = Bill_item::getById($i);
			$total += $bi->getPrice();
		}

		$inv = new Bill_item();
		$inv -> setBooking(Booking::getById($id));
		$inv -> setName("Payment");
		$inv -> setPrice( - $total);
		$inv->save();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Billing?action=view&id=".$id;
	}
}