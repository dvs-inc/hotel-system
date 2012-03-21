<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageCustomers extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-customers";
	}

	protected function runPage()
	{
		$this->mSubMenu = array(
			"MPageCustomersList" => array(
				"title" => "mpage-customers-list",
				"link" => "/Customers?action=list",
				),
			"MPageCustomersCreate" => array(
				"title" => "mpage-customers-create",
				"link" => "/Customers?action=create",
				),

		);
	
		$action = WebRequest::get("action");
		switch($action)
		{
			case "del":
				self::checkAccess("delete-customer");
				//$this->doDeleteRoomAction();
				break;
			case "edit":
				self::checkAccess("edit-customer");
				//$this->showEditRoomPage();
				break;
			case "create":
				self::checkAccess("create-customer");
				//$this->showCreateRoomPage();
				break;
			case "list":
			default:
				$this->showListCustomerPage();
				break;
		}
	}
/*
	private function showCreateRoomPage()
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
				
				
				$room = new Room();
				
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
				$this->mBasePage="mgmt/roomCreate.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/roomCreate.tpl";
		}
		
		$this->mSmarty->assign("rtlist", RoomType::$data);
	}	
	
	private function showEditRoomPage()
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
	private function showListCustomerPage()
	{
		$idList = Customer::getIdList();

		$custList = array();

		foreach($idList as $id)
		{
			$custList[] = Customer::getById($id);
		}

		$this->mSmarty->assign("custList", $custList);

		$this->mBasePage="mgmt/custList.tpl";
	}
/*
	private function doDeleteRoomAction()
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