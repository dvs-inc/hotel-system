<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageBookings extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-bookings";
	}

	protected function runPage()
	{
		global $cWebPath;
		
		$this->mStyles[] = $cWebPath . '/style/jsDatePick_ltr.min.css';
		$this->mScripts[] = $cWebPath . '/scripts/jsDatePick.full.1.3.js';
		
		$this->mSubMenu = array(
			"MPageBookingsList" => array(
				"title" => "mpage-bookings-list",
				"link" => "/Bookings?action=list",
				),
			"MPageBookingsCreate" => array(
				"title" => "mpage-bookings-create",
				"link" => "/Bookings?action=create",
				),

		);
	
		$action = WebRequest::get("action");
		switch($action)
		{
			case "del":
				self::checkAccess("delete-booking");
				$this->doDeleteBookingAction();
				break;
			case "edit":
				self::checkAccess("edit-booking");
				$this->showEditBookingPage();
				break;
			case "create":
				self::checkAccess("create-booking");
				$this->showCreateBookingPage();
				break;
			case "list":
			default:
				$this->showListBookingsPage();
				break;
		}
	}
	
	private function showCreateBookingPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$bcust = WebRequest::postInt("bcust");
				$badults = WebRequest::postInt("badults");
				$bchildren = WebRequest::postInt("bchildren");
				$bstart = WebRequest::post("bstart");
				$bend = WebRequest::post("bend");
				$bpromo = WebRequest::postInt("bpromo");
				
			
				// data validation
				if($badults == 0)
				{
					throw new CreateBookingException("no-adults");
				}	
				
				if($bstart == null)
				{
					throw new CreateBookingException("no-start-date");
				}
				
				if($bend == null)
				{
					throw new CreateBookingException("no-end-date");
				}
				
				if($bcust == 0)
				{
					throw new CreateBookingException("no-customer-for-booking");
				}				
				
				$booking = new Booking();
				
				// set values
				$booking->setCustomer($bcust);
				$booking->setAdults($badults);
				$booking->setChildren($bchildren);
				$booking->setStartDate($bstart);
				$booking->setEndDate($bend);
				$booking->setPromocode($bpromo);
				
				
				$booking->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Bookings";
			}
			catch (CreateBookingException $ex)
			{
				$this->mBasePage="mgmt/bookingCreate.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/bookingCreate.tpl";
		}
		
	}	
	
	private function showEditBookingPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$bcust = WebRequest::postInt("bcust");
				$badults = WebRequest::postInt("badults");
				$bchildren = WebRequest::postInt("bchildren");
				$bstart = WebRequest::post("bstart");
				$bend = WebRequest::post("bend");
				$bpromo = WebRequest::postInt("bpromo");
				$id = WebRequest::getInt("id");
				
				// data validation
				if($badults == 0)
				{
					throw new CreateBookingException("no-adults");
				}	
				
				if($bstart == null)
				{
					throw new CreateBookingException("no-start-date");
				}
				
				if($bend == null)
				{
					throw new CreateBookingException("no-end-date");
				}
				
				if($bcust == null)
				{
					throw new CreateBookingException("no-customer-for-booking");
				}
				
				
				$booking = Booking::getById($id);
				
				if($booking == null)
				{
					throw new CreateBookingException("Booking does not exist");
				}
				
				// set values
				$booking->setCustomer($bcust);
				$booking->setAdults($badults);
				$booking->setChildren($rmin);
				$booking->setStartDate($rmax);
				$booking->setEndDate($rprice);
				$booking->setPromocode($bpromo);
				
				
				$booking->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Bookings";
			}
			catch (CreateBookingException $ex)
			{
				$this->mBasePage="mgmt/bookingEdit.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			try{
				$this->mBasePage="mgmt/bookingEdit.tpl";
			
				$booking = Booking::getById(WebRequest::getInt("id")) ;
			
				if($booking == null)
				{
					throw new Exception("Booking does not exist");
				}
			
				$this->mSmarty->assign("bookingid", $booking->getId());
				$this->mSmarty->assign("bcust", $booking->getCustomer()->getId());
				$this->mSmarty->assign("badults", $booking->getAdults());
				$this->mSmarty->assign("bchildren", $booking->getChildren());
				$this->mSmarty->assign("bstart", $booking->getStartDate());
				$this->mSmarty->assign("bend", $booking->getEndDate());
				$this->mSmarty->assign("bpromo", $booking->getPromocode());
			} catch (Exception $ex)
			{
				$this->mBasePage="mgmt/bookingEdit.tpl";
				$this->error($ex->getMessage());
			}
		}
		
	}	

	private function showListBookingsPage()
	{
		$idList = Booking::getIdList();

		$bookingList = array();

		foreach($idList as $id)
		{
			$bookingList[] = Booking::getById($id);
		}

		$this->mSmarty->assign("bookingList", $bookingList);

		$this->mBasePage="mgmt/bookingList.tpl";
	}

	private function doDeleteBookingAction()
	{
		$bid=WebRequest::getInt("id");
		if($bid < 1)
				throw new Exception("BookingId too small");

		if(Booking::getById($bid) == null)
				throw new Exception("Booking does not exist");

		Booking::getById($bid)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Bookings";
	}

}