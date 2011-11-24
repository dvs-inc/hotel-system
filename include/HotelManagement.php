<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class HotelManagement extends Hotel
{
	private function main()
	{
		// create a page...
		$page = ManagementPageBase::create();
		// ...and execute it.
		$page->execute();
	}
}