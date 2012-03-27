<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageCustomers extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-customers";
	}

	protected function runPage()
	{
		$this->mSubMenu = array(
			"MPageCustomersList" => array(
				"title" => "mpage-customers-list",
				"link" => "/Customers?action=list",
				),
			"MPageCustomersCreate" => array(
				"title" => "mpage-customers-create",
				"link" => "/Customers?action=create",
				),

		);
	
		$action = WebRequest::get("action");
		switch($action)
		{
			case "del":
				self::checkAccess("delete-customer");
				$this->doDeleteCustomerAction();
				break;
			case "rsconfirm":
				$this->doResendCustomerAction();
				break;
			case "edit":
				self::checkAccess("edit-customer");
				$this->showEditCustomerPage();
				break;
			case "create":
				self::checkAccess("create-customer");
				$this->showCreateCustomerPage();
				break;
			case "list":
			default:
				$this->showListCustomerPage();
				break;
		}
	}

	private function showCreateCustomerPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$suTitle = WebRequest::post("suTitle");
				$suFirstname = WebRequest::post("suFirstname");
				$suLastname = WebRequest::post("suLastname");
				$suAddress = WebRequest::post("suAddress");
				$suCity = WebRequest::post("suCity");
				$suPostcode = WebRequest::post("suPostcode");
				$suCountry = WebRequest::post("suCountry");
				$suEmail = WebRequest::post("suEmail");
				$suPassword = WebRequest::post("suPassword");
				$suConfirm = WebRequest::post("suConfirm");
				
				// data validation
				if($suTitle == ""){throw new CreateCustomerException("suTitle not specified");}
				if($suFirstname == ""){throw new CreateCustomerException("suFirstname not specified");}
				if($suLastname == ""){throw new CreateCustomerException("suLastname not specified");}
				if($suAddress == ""){throw new CreateCustomerException("suAddress not specified");}
				if($suCity == ""){throw new CreateCustomerException("suCity not specified");}
				if($suPostcode == ""){throw new CreateCustomerException("suPostcode not specified");}
				if($suCountry == ""){throw new CreateCustomerException("suCountry not specified");}
				if($suEmail == ""){throw new CreateCustomerException("suEmail not specified");}
				if($suPassword == ""){throw new CreateCustomerException("suPassword not specified");}
				if($suConfirm == ""){throw new CreateCustomerException("suConfirm not specified");}
				if($suPassword != $suConfirm){throw new CreateCustomerException("Password mismatch");}

				$customer = new Customer();
				
				// set values
				$customer->setTitle($suTitle);
				$customer->setFirstname($suFirstname);
				$customer->setSurname($suLastname);

				$address = new Address();
				$address->setLine1($suAddress);
				$address->setCity($suCity);
				$address->setPostcode($suPostcode);
				$address->setCountry($suCountry);
				$address->save();
				
				$customer->setAddress($address);
				
				$customer->setEmail($suEmail);
				$customer->setPassword($suPassword);
				
				$customer->setMailconfirm("Confirmed");
				
				// save it
				$customer->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Customers";
			}
			catch (CreateCustomerException $ex)
			{
				$this->mBasePage="mgmt/custCreate.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/custCreate.tpl";
		}
	}	

	private function showEditCustomerPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$suTitle = WebRequest::post("suTitle");
				$suFirstname = WebRequest::post("suFirstname");
				$suLastname = WebRequest::post("suLastname");
				$suAddress = WebRequest::post("suAddress");
				$suCity = WebRequest::post("suCity");
				$suPostcode = WebRequest::post("suPostcode");
				$suCountry = WebRequest::post("suCountry");
				$suEmail = WebRequest::post("suEmail");
				$suPassword = WebRequest::post("suPassword");
				$suConfirm = WebRequest::post("suConfirm");
				
				$id = WebRequest::getInt("id");
				
				// data validation
				if($suTitle == ""){throw new CreateCustomerException("suTitle not specified");}
				if($suFirstname == ""){throw new CreateCustomerException("suFirstname not specified");}
				if($suLastname == ""){throw new CreateCustomerException("suLastname not specified");}
				if($suAddress == ""){throw new CreateCustomerException("suAddress not specified");}
				if($suCity == ""){throw new CreateCustomerException("suCity not specified");}
				if($suPostcode == ""){throw new CreateCustomerException("suPostcode not specified");}
				if($suCountry == ""){throw new CreateCustomerException("suCountry not specified");}
				if($suEmail == ""){throw new CreateCustomerException("suEmail not specified");}

				$customer = Customer::getById($id);
				
				if($customer == null)
				{
					throw new Exception("Custoemr does not exist");
				}
				
				if($suPassword != "" && $suPassword == $suConfirm)
				{
					$customer->setPassword($suPassword);
				}
				
				// set values
				$customer->setTitle($suTitle);
				$customer->setFirstname($suFirstname);
				$customer->setSurname($suLastname);

				$address = $customer->getAddress();
				$address->setLine1($suAddress);
				$address->setCity($suCity);
				$address->setPostcode($suPostcode);
				$address->setCountry($suCountry);
				
				if($customer->getEmail() != $suEmail)
				{
					$customer->setEmail($suEmail);
				}
				
				// save it
				$address->save();
				$customer->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Customers";
			}
			catch (CreateCustomerException $ex)
			{
				$this->mBasePage="mgmt/roomEdit.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/custEdit.tpl";
			
			$customer = Customer::getById(WebRequest::getInt("id")) ;
			
			if($customer == null)
			{
				throw new Exception("Customer does not exist");
			}
			
			$this->mSmarty->assign("custid",$customer->getId());
			$this->mSmarty->assign("suTitle",$customer->getTitle());
			$this->mSmarty->assign("suFirstname",$customer->getFirstName());
			$this->mSmarty->assign("suLastname",$customer->getSurname());
			$this->mSmarty->assign("suAddress",$customer->getAddress()->getLine1());
			$this->mSmarty->assign("suCity",$customer->getAddress()->getCity());
			$this->mSmarty->assign("suPostcode",$customer->getAddress()->getPostcode());
			$this->mSmarty->assign("suCountry",$customer->getAddress()->getCountry());
			$this->mSmarty->assign("suEmail",$customer->getEmail());
		}
	}	

	private function showListCustomerPage()
	{
		$idList = Customer::getIdList();

		$custList = array();

		foreach($idList as $id)
		{
			$custList[] = Customer::getById($id);
		}

		$this->mSmarty->assign("custList", $custList);

		$this->mBasePage="mgmt/custList.tpl";
	}

	private function doDeleteCustomerAction()
	{
		$cid=WebRequest::getInt("id");
		if($cid < 1)
				throw new Exception("CustomerId too small");

		if(Customer::getById($cid) == null)
				throw new Exception("CustomerId does not exist");

		Customer::getById($cid)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Customers";
	}
	
	private function doResendCustomerAction()
	{
		$cid=WebRequest::getInt("id");
		if($cid < 1)
				throw new Exception("CustomerId too small");

		$customer = Customer::getById($cid);
		if($customer == null)
				throw new Exception("CustomerId does not exist");

		$customer->setEmail($customer->getEmail());
		$customer->save();
		$customer->sendMailConfirm();
		
		
		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Customers";
	}

}