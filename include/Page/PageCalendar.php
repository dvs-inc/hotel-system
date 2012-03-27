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
		
		foreach($idlist as $id)
		{
			echo "hi";
			$r = Room::getById($id);
			//$availabilityMatrix[$r] = array();
			//foreach($dates as $d)
			//{
			//	$availabilityMatrix[$r][] = 0;
			//}
		}
		
		print_r($availabilityMatrix);
		
		$this->mSmarty->assign("availmatrix", $availabilityMatrix);
		$this->mSmarty->assign("datelist", $dates);
	}
}
