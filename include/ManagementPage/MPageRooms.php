<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageRooms extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-rooms";
	}

	protected function runPage()
	{
		$this->mSubMenu = array(
			"MPageRoomsList" => array(
				"title" => "mpage-rooms-list",
				"link" => "/Rooms?action=list",
				),
			"MPageRoomsCreate" => array(
				"title" => "mpage-rooms-create",
				"link" => "/Rooms?action=create",
				),

		);
	
		$action = WebRequest::get("action");
		switch($action)
		{
			case "del":
				self::checkAccess("delete-room");
				$this->doDeleteRoomAction();
				break;
			case "edit":
				self::checkAccess("edit-room");
				//$this->doDeleteRoomAction();
				break;
			case "create":
				self::checkAccess("create-room");
				$this->showCreateRoomPage();
				break;
			case "list":
			default:
				$this->showListRoomPage();
				break;
		}
	}

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
	
	private function showListRoomPage()
	{
		$idList = Room::getIdList();

		$roomList = array();

		foreach($idList as $id)
		{
			$roomList[] = Room::getById($id);
		}

		$this->mSmarty->assign("roomlist", $roomList);

		$this->mBasePage="mgmt/roomList.tpl";
	}
	
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
}