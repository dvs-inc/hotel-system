<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageConfirm extends PageBase
{
	protected function runPage()
	{
			try{
				$id = WebRequest::getInt("id");
				$hash = WebRequest::get("hash");
			
				// data validation

				$customer = Customer::getById();
				
				if($customer==null)
				{
					throw new NonexistantObjectException();
				}
			
				$customer->confirmEmail($hash);
			
				// save
				$customer->save();
				
				Session::setLoggedInCustomer($id);
				
				$this->mSmarty->assign("content", Message::getMessage("mail-confirmed"));
			}
			catch (NonexistantObjectException $ex)
			{
				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}";
			}
		}
	}
}
