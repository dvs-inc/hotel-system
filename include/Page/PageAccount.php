<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageAccount extends PageBase
{
	protected function runPage()
	{
		$this->showAccount();
	}
	
	private function showAccount()
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
				
				$id = Session::getLoggedInCustomer();
				
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
					$customer->sendMailConfirm();
				}
				
				// save it
				$address->save();
				$customer->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Account";
			}
			catch (CreateCustomerException $ex)
			{
				$this->mBasePage="account.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="account.tpl";
			
			$customer = Customer::getById(Session::getLoggedInCustomer()) ;
			
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
}