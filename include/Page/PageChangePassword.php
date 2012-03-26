<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageChangePassword extends PageBase
{
protected function runPage()
{
	try{

		$email = WebRequest::get("email");
		$hash = WebRequest::get("hash");

		$customer = Customer::getByEmail($email);
		if($customer->getMailChecksum == $hash && $customer->getEmail == $email)
		{
			$this->mPageBase="changePassword.tpl";
		}

		if($customer==null)
		{
			throw new NonExistantObjectException();
				
		}

		if(WebRequest::wasPosted() && $customer!=null)
		{
			try{
				$suPassword = WebRequest::post("suPassword");
				$suConfirm = WebRequest::post("suConfirm");

				// validation
				
				if($suPassword == ""){throw new CreateCustomerException("Password not specified");}
				if($suConfirm == ""){throw new CreateCustomerException("Confirmed password not specified");}
				if($suPassword != $suConfirm){throw new CreateCustomerException("Password mismatch");}
	
				// validation			

				if ($suPassword != "" && $suPassword == $suConfirm)
				{
					$customer->setPassword($suPassword);
				}	

				$customer->save();
			}

			catch (CreateCustomerException $ex)
			{	
				$this->mBasePage="changePassword.tpl";
				$this->error($ex->getMessage());
			}
		}
	}

	catch (NonexistantObjectException $ex)
	{
		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}";
	}
}
}