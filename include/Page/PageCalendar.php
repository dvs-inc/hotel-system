<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageCalendar extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "cal.tpl";
				
		global $cWebPath;

		$startdate = new DateTime();
		$enddate = clone $startdate;
		$enddate = $enddate->modify("+6 day");
		
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
	}
	
	
}
