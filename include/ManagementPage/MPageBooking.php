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
				//$this->doDeleteBookingAction();
				break;
			case "edit":
				self::checkAccess("edit-booking");
				//$this->showEditBookingPage();
				break;
			case "create":
				self::checkAccess("create-booking");
				//$this->showCreateBookingPage();
				break;
			case "list":
			default:
				$this->showListBookingsPage();
				break;
		}
	}
/*
	private function showCreateBookingPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$adults = WebRequest::postInt("adults");
				$children = WebRequest::postInt("children");
				$startdate = WebRequest::post("startdate");
				$enddate = WebRequest::post("enddate");
				$promocode = WebRequest::postInt("promocode");
				$customer = WebRequest::postInt("customer");
			
				// data validation
				if($adults == 0)
				{
					throw new CreateBookingException("no-adults");
				}	
				
				if($startdate == "")
				{
					throw new CreateBookingException("no-start-date");
				}
				
				if($enddate == "")
				{
					throw new CreateBookingException("no-end-date");
				}
				
				if(customer == 0)
				{
					throw new CreateBookingException("no-customer-for-booking");
				}				
				
				$booking = new Booking();
				
				// set values
				$booking->setAdults($adults);
				$booking->setChildren($children);
				$booking->setStartDate($startdate);
				$booking->setEndDate($enddate);
				$booking->setPromocode($promocode);
				$booking->setCustomer($customer);
				
				
				$room->save();

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
		
		$this->mSmarty->assign("rtlist", RoomType::$data);
	}	
	
	private function showEditBookingPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$rname = WebRequest::post("rname");
				$rtype = WebRequest::postInt("rtype");
				$rmin = WebRequest::postInt("rmin");
				$rmax = WebRequest::postInt("rmax");
				$rprice = WebRequest::postFloat("rprice");
				$id = WebRequest::getInt("id");
				
				// data validation
				if($rname == "")
				{
					throw new CreateRoomException("blank-roomname");
				}	
				
				if($rtype == 0)
				{
					throw new CreateRoomException("blank-roomtype");
				}
				
				if($rmax < 1 || $rmin < 0)
				{
					throw new CreateRoomException("room-capacity-too-small");
				}
				
				if($rmin > $rmax)
				{
					throw new CreateRoomException("room-capacity-min-gt-max");
				}
				
				if($rprice != abs($rprice))
				{
					throw new CreateRoomException("room-price-negative");
				}
				
				
				$room = Room::getById($id);
				
				if($room == null)
				{
					throw new Exception("Room does not exist");
				}
				
				// set values
				$room->setName($rname);
				$room->setType($rtype);
				$room->setMinPeople($rmin);
				$room->setMaxPeople($rmax);
				$room->setPrice($rprice);
				
				
				$room->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Rooms";
			}
			catch (CreateRoomException $ex)
			{
				$this->mBasePage="mgmt/roomEdit.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/roomEdit.tpl";
			
			$room = Room::getById(WebRequest::getInt("id")) ;
			
			if($room == null)
			{
				throw new Exception("Room does not exist");
			}
			
			$this->mSmarty->assign("roomid", $room->getId());
			$this->mSmarty->assign("rname", $room->getName());
			$this->mSmarty->assign("rmin", $room->getMinPeople());
			$this->mSmarty->assign("rmax", $room->getMaxPeople());
			$this->mSmarty->assign("rprice", $room->getPrice());
			$this->mSmarty->assign("rtype", $room->getType()->getId());
		}
		
		$this->mSmarty->assign("rtlist", RoomType::$data);
	}	
*/
	private function showListBookingsPage()
	{
		$idList = Booking::getIdList();

		$bookingsList = array();

		foreach($idList as $id)
		{
			$bookingsList[] = Booking::getById($id);
		}

		$this->mSmarty->assign("bookingList", $bookingList);

		$this->mBasePage="mgmt/bookingList.tpl";
	}
/*
	private function doDeleteBookingAction()
	{
		$rid=WebRequest::getInt("id");
		if($rid < 1)
				throw new Exception("RoomId too small");

		if(Room::getById($rid) == null)
				throw new Exception("Room does not exist");

		Room::getById($rid)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Rooms";
	}
*/
}