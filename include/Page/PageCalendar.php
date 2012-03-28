<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageCalendar extends PageBase
{
	protected function runPage()
	{
	
		if(WebRequest::wasPosted())
		{
			
			if(!WebRequest::postInt("calroom")) 
			{
				$this->showCal()
				return;
			}
			
			$startdate = new DateTime(WebRequest::post("qbCheckin"));
			$enddate = new DateTime(WebRequest::post("qbCheckout"));
			$room=Room::getById(WebRequest::postInt("calroom"));
			for($date = $startdate ;$date < $enddate ; $date->modify("+1 day"))
			{
				if(!$room->isAvailable($date))
				{
					$this->error("room-not-available");
					$this->showCal();
					return;
				}
			}
			
			// search for customer
			if(! ($customer = Customer::getByEmail(WebRequest::post("qbEmail"))))
			{
				// create customer
			}
			
			$booking = new Booking();
			$booking->setStartDate(WebRequest::post("qbCheckin"));
			$booking->setEndDate(WebRequest::post("qbCheckout"));
			$booking->setAdults(WebRequest::post("qbAdults"));
			$booking->setChildren(WebRequest::post("qbChildren"));
			$booking->setPromocode(WebRequest::post("qbPromoCode"));
			$booking->setRoom($room->getId());
			$booking->setCustomer($customer->getId());
			
			$booking->save();
			
			return;
		}
		throw new YouShouldntBeDoingThatException();
	}
	
	public function showCal()
	{
		$this->mBasePage = "cal.tpl";
				
		global $cWebPath;

		$startdate = new DateTime(WebRequest::post("qbCheckin"));
		$enddate = new DateTime(WebRequest::post("qbCheckout"));
		
		$idlist = Room::getIdList();
		
		$dates = array();
		
		for($date = $startdate ;$date < $enddate ; $date->modify("+1 day"))
		{
			$dates[] = clone $date;
		}
	
		$availabilityMatrix = array();
		$roomlist = array();
		foreach($idlist as $id)
		{
			$r = Room::getById($id);
			$roomlist[$id]=$r;
			$availabilityMatrix[$id] = array();
			foreach($dates as $d)
			{
				$availabilityMatrix[$id][array_search($d,$dates)] = (!$r->isAvailable($d));
			}
		}
		
		$this->mSmarty->assign("availmatrix", $availabilityMatrix);
		$this->mSmarty->assign("datelist", $dates);
		$this->mSmarty->assign("roomlist", $roomlist);
		
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
			
					
		$this->mSmarty->assign("valQbTitle", WebRequest::post("qbTitle"));
		$this->mSmarty->assign("valQbFirstname", WebRequest::post("qbFirstname"));
		$this->mSmarty->assign("valQbLastname", WebRequest::post("qbLastname"));
		$this->mSmarty->assign("valQbAddress", WebRequest::post("qbAddress"));
		$this->mSmarty->assign("valQbCity", WebRequest::post("qbCity"));
		$this->mSmarty->assign("valQbPostcode", WebRequest::post("qbPostcode"));
		$this->mSmarty->assign("valQbCountry", WebRequest::post("qbCountry"));
		$this->mSmarty->assign("valQbEmail", WebRequest::post("qbEmail"));
	}
	
	
}
