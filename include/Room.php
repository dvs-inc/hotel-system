<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Room extends DataObject
{
	protected $type;
	protected $maxPeople;
	protected $minPeople;
	protected $price;

	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM room WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $id);
		
		$statement->execute();
		
		$resultObject = $statement->fetchObject("Room");
		if($resultObject != false)
		{
			$resultObject->isNew = false;
		}
		
		return $resultObject;
	}
	
	public function save()
	{
	
	}

	public function delete()
	{
	
	}
}
