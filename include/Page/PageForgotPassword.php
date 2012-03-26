<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageForgotPassword extends PageBase
{
	protected function runPage()
	{
		try{
			if(WebRequest::wasPosted())
			{
				try{
				$suEmail=WebRequest::post("suEmail");
			
				// validation

				if($suEmail ==""){throw new CreateCustomerException("Email not specified");}
			
				$customer->sendForgetPasswordMail();
			}

			else	
			{
				$this->mBasePage="forgottenPassword.tpl";
			}
		}
		catch (CreateCustomerException $ex)
		{
			$this->mBasePage="forgottenPassword.tpl";
			$this->error($ex->getMessage());
		}	
	}
}
