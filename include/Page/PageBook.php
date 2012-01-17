<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageBook extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "book.tpl";
		
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
	}
}
