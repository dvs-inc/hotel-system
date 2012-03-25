<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageSignup extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "signup.tpl";
		
		if(Session::isCustomerLoggedIn() ){
			// why do you want another account?
			// redirect to main page
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/index.php";
		}
			
		if(WebRequest::wasPosted())
		{
			try{
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
				if($suTitle == ""){throw new CreateCustomerException("Title not specified");}
				if($suFirstname == ""){throw new CreateCustomerException("Firstname not specified");}
				if($suLastname == ""){throw new CreateCustomerException("Lastname not specified");}
				if($suAddress == ""){throw new CreateCustomerException("Address not specified");}
				if($suCity == ""){throw new CreateCustomerException("City not specified");}
				if($suPostcode == ""){throw new CreateCustomerException("Postcode not specified");}
				if($suCountry == ""){throw new CreateCustomerException("Country not specified");}
				if($suEmail == ""){throw new CreateCustomerException("Email not specified");}
				if($suPassword == ""){throw new CreateCustomerException("Password not specified");}
				if($suConfirm == ""){throw new CreateCustomerException("Confirmed password not specified");}
				if($suPassword != $suConfirm){throw new CreateCustomerException("Password mismatch");}

				$customer = new Customer();
				
				if($suPassword != "" && $suPassword == $suConfirm)
				{
					$customer->setPassword($suPassword);
				}
			
				// set values
				$customer->setTitle($suTitle);
				$customer->setFirstname($suFirstname);
				$customer->setSurname($suLastname);
			
				$address = new Address();
				$address->setLine1($suAddress);
				$address->setCity($suCity);
				$address->setPostCode($suPostcode);
				$address->setCountry($suCountry);
				$address->save();
			
				$customer->setAddress($address);
			
				$customer->setEmail($suEmail);
			
				// save it
				$customer->save();
				
				$customer->sendMailConfirm();
				
				global $cScriptPath;
				
				$this->mHeaders[] = "Location: {$cScriptPath}";
			}
			catch (CreateCustomerException $ex)
			{
				$this->mBasePage="signup.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="signup.tpl";
		}
	}
}
