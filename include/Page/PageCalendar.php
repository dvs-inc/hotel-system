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
				$this->showCal();
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
				$customer = new Customer();
				
				$suTitle = WebRequest::post("qbTitle");
				$suFirstname = WebRequest::post("qbFirstname");
				$suLastname = WebRequest::post("qbLastname");
				$suAddress = WebRequest::post("qbAddress");
				$suCity = WebRequest::post("qbCity");
				$suPostcode = WebRequest::post("qbPostcode");
				$suCountry = WebRequest::post("qbCountry");
				$suEmail = WebRequest::post("qbEmail");
				
				$customer->setPassword($suEmail);
				
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
				
				// save it again
				$customer->save();
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
			
			$msg = Message::getMessage("booking-confirmation");
			
			$msg = str_replace("$1", $booking->getStartDate(), $msg);
			$msg = str_replace("$2", $booking->getEndDate(), $msg);
			$msg = str_replace("$3", $booking->getAdults(), $msg);
			$msg = str_replace("$4", $booking->getChildren(), $msg);
			$msg = str_replace("$5", $booking->getRoom()->getName(), $msg);
			
			Mail::send($customer->getEmail(), Message::getMessage("booking-confimation-subject"), $msg);
			
			$this->mSmarty->assign("content", $msg);
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
