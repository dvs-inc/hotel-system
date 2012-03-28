<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageForgotPassword extends PageBase
{
	protected function runPage()
	{
		if(Session::isCustomerLoggedIn() )
		{
			global $cWebPath;

			// redirect to main page
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/index.php";
			
			return;
		}
			
	
		if(WebRequest::wasPosted())
		{
			if(WebRequest::get("id") && WebRequest::get("hash"))
			{ 
				// setting password
				$id = WebRequest::get("id");
				$hash = WebRequest::get("hash");
				
				$customer = Customer::getById($id);
				
				try
				{
					if($customer->getMailChecksum() != $hash)
					{
						throw new InvalidChecksumException();
					}
					
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
					
					// log them in
					Session::setLoggedInCustomer($id);
			
					// redirect to main page
					global $cWebPath;
					$this->mHeaders[] = "HTTP/1.1 303 See Other";
					$this->mHeaders[] = "Location: " . $cWebPath . "/index.php";
				}
				catch (CreateCustomerException $ex)
				{
					$this->mBasePage="changePassword.tpl";
					$this->error($ex->getMessage());
				}
				catch (InvalidChecksumException $ex)
				{
					$this->mBasePage="changePassword.tpl";
					$this->error($ex->getMessage());
				}
			}
			else
			{ 
				// requesting
				
				try
				{
					$suEmail=WebRequest::post("suEmail");
				
					// validation

					if($suEmail=="")
					{
						throw new CreateCustomerException("Email not specified");
					}
				
					$customer = Customer::getByEmail($suEmail);
				
					if($customer == null)
					{
						throw new NonexistantObjectException();
					}
				
					$customer->sendPasswordReset();
					
					$this->mBasePage="forgotpassword.tpl";
					
					// TODO: show some confirmation, check email, etc
				}	
				catch (CreateCustomerException $ex)
				{
					$this->mBasePage="forgottenpassword.tpl";
					$this->error($ex->getMessage());
				}
				catch (NonexistantObjectException $ex)
				{
					$this->mBasePage="forgottenpassword.tpl";
					$this->error("nonexistant object");
				}
		
			}
		
		}		
		else
		{	
			if(WebRequest::get("id") && WebRequest::get("hash"))
			{
				// show reset password form
				try
				{				
					$id = WebRequest::get("id");
					$hash = WebRequest::get("hash");
					
					$customer = Customer::getById($id);
					
					if($customer->getMailChecksum() != $hash)
					{
						throw new InvalidChecksumException();
					}
					
					$this->mBasePage="changePassword.tpl";
					
					$this->mSmarty->assign("cpid", $id);
					$this->mSmarty->assign("cphash", $hash);
					
				}
				catch (InvalidChecksumException $ex)
				{
					$this->mBasePage="forgottenpassword.tpl";
					$this->error("invalid checksum");
				}
			}
			else
			{
				// show request form
				$this->mBasePage="forgottenpassword.tpl";
				return;
			}
		}
	}
}
