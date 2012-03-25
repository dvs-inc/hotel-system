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
				$this->doDeleteRoomAction();
				break;
			case "edit":
				self::checkAccess("edit-customer");
				//$this->showEditRoomPage();
				break;
			case "create":
				self::checkAccess("create-customer");
				$this->showCreateCustomerPage();
				break;
			case "list":
			default:
				$this->showListCustomerPage();
				break;
		}
	}

	private function showCreateCustomerPage()
	{
		if(WebRequest::wasPosted())
		{
			try{
				// get variables
				$suTitle = WebRequest::post("suTitle");
				$suFirstname = WebRequest::post("suFirstname");
				$suLastname = WebRequest::post("suLastname");
				$suAddress = WebRequest::post("suAddress");
				$suCity = WebRequest::post("suCity");
				$suPostcode = WebRequest::post("suPostcode");
				$suCountry = WebRequest::post("suCountry");
				$suEmail = WebRequest::post("suEmail");
				$suPassword = WebRequest::post("suPassword");
				$suConfirm = WebRequest::post("suConfirm");
				
				// data validation
				if($suTitle == ""){throw new CreateCustomerException("suTitle not specified");}
				if($suFirstname == ""){throw new CreateCustomerException("suFirstname not specified");}
				if($suLastname == ""){throw new CreateCustomerException("suLastname not specified");}
				if($suAddress == ""){throw new CreateCustomerException("suAddress not specified");}
				if($suCity == ""){throw new CreateCustomerException("suCity not specified");}
				if($suPostcode == ""){throw new CreateCustomerException("suPostcode not specified");}
				if($suCountry == ""){throw new CreateCustomerException("suCountry not specified");}
				if($suEmail == ""){throw new CreateCustomerException("suEmail not specified");}
				if($suPassword == ""){throw new CreateCustomerException("suPassword not specified");}
				if($suConfirm == ""){throw new CreateCustomerException("suConfirm not specified");}
				if($suPassword != $suConfirm){throw new CreateCustomerException("Password mismatch");}

				$customer = new Customer();
				
				// set values
				$customer->setTitle($suTitle);
				$customer->setFirstname($suFirstname);
				$customer->setSurname($suLastname);

				$address = new Address();
				$address->setLine1($suAddress);
				$address->setCity($suCity);
				$address->setPostcode($suPostcode);
				$address->setCountry($suCountry);
				$address->save();
				
				$customer->setAddress($address);
				$customer->setEmail($suEmail);
				$customer->setPassword($suPassword);
				
				// save it
				$customer->save();

				global $cScriptPath;
				$this->mHeaders[] = "Location: {$cScriptPath}/Customers";
			}
			catch (CreateCustomerException $ex)
			{
				$this->mBasePage="mgmt/custCreate.tpl";
				$this->error($ex->getMessage());
			}
		}
		else
		{
			$this->mBasePage="mgmt/custCreate.tpl";
		}
	}	
/*	
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

	private function doDeleteCustomerAction()
	{
		$cid=WebRequest::getInt("id");
		if($cid < 1)
				throw new Exception("CustomerId too small");

		if(Customer::getById($cid) == null)
				throw new Exception("CustomerId does not exist");

		Customer::getById($cid)->delete();

		global $cScriptPath;
		$this->mHeaders[] = "Location: {$cScriptPath}/Customers";
	}

}