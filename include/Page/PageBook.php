<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageBook extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "book.tpl";
		
		global $cWebPath;
		
		$this->mStyles[] = $cWebPath . '/style/jsDatePick_ltr.min.css';
		$this->mScripts[] = $cWebPath . '/scripts/jsDatePick.full.1.3.js';
		
		// set up the default values for the 
		if(WebRequest::wasPosted())
		{
			$this->mSmarty->assign("valQbCheckin", 
				WebRequest::postString("qbCheckin")
				);
			$this->mSmarty->assign("valQbCheckout",  
				WebRequest::postString("qbCheckout")
				);
			$this->mSmarty->assign("valQbAdults",  
				WebRequest::postInt("qbAdults")
				);
			$this->mSmarty->assign("valQbChildren",  
				WebRequest::postInt("qbChildren")
				);
			$this->mSmarty->assign("valQbPromoCode",  
				WebRequest::postString("qbPromoCode")
				);		
		}
		else
		{
			$this->mSmarty->assign("valQbCheckin", "");
			$this->mSmarty->assign("valQbCheckout", "");
			$this->mSmarty->assign("valQbAdults", "");
			$this->mSmarty->assign("valQbChildren", "");
			$this->mSmarty->assign("valQbPromoCode", "");
		}
		
		if(Session::isCustomerLoggedIn())
		{
			$customer = Customer::getById(Session::getLoggedInCustomer());
		
			$this->mSmarty->assign("qbTitle",$customer->getTitle());
			$this->mSmarty->assign("qbFirstname",$customer->getFirstname());
			$this->mSmarty->assign("qbLastname",$customer->getSurname());
			$this->mSmarty->assign("qbAddress",$customer->getAddress()->getLine1());
			$this->mSmarty->assign("qbCity",$customer->getAddress()->getCity());
			$this->mSmarty->assign("qbPostcode",$customer->getAddress()->getPostcode());
			$this->mSmarty->assign("qbCountry",$customer->getAddress()->getCountry());
			$this->mSmarty->assign("qbEmail",$customer->getEmail());
			
		}
		else
		{
			$this->mSmarty->assign("qbTitle","");
			$this->mSmarty->assign("qbFirstname","");
			$this->mSmarty->assign("qbLastname","");
			$this->mSmarty->assign("qbAddress","");
			$this->mSmarty->assign("qbCity","");
			$this->mSmarty->assign("qbPostcode","");
			$this->mSmarty->assign("qbEmail","");
			$this->mSmarty->assign("qbCountry"," ");
		}
	}
}
