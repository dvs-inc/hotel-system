<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageForgotPassword extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage= "forgottenpassword.tpl";
		
		//	if(WebRequest::wasPosted())
		//	{
		//		try{
		//		$suEmail=WebRequest::post("suEmail");
			
				// validation

		//		if($suEmail=="")
		//		{
		//			throw new CreateCustomerException("Email not specified");
		//		}
			
		//		$customer->sendForgetPasswordMail();
		//		}
				
		//		catch (CreateCustomerException $ex)
		//		{
		//			$this->mBasePage="forgottenpassword.tpl";
		//			$this->error($ex->getMessage());
		//		}
		//	}
			
		//	else
		//	{	
		//		$this->mBasePage="forgottenpassword.tpl";
		//	}
		
		
	}
}
