<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Room extends DataObject
{
	protected $type;
	protected $maxPeople;
	protected $minPeople;
	protected $price;
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getMaxPeople()
	{
		return $this->maxPeople;
	}
	
	public function getMinPeople()
	{
		return $this->minPeople;
	}	
	public function getPrice()
	{
		return $this->price;
	}
	
	public funtion setType($value)
	{
		$this->type = $value;
	}

	public funtion setMaxPeople($value)
	{
		$this->maxPeople = $value;
	}

	public funtion setMinPeople($value)
	{
		$this->minPeople = $value;
	}

	public funtion setPrice($value)
	{
		$this->price = $value;
	}	
	
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
		global $gDatabase;
		
		if($this->isNew)
		{
			$statement = $gDatabase->prepare("INSERT INTO room VALUES (null, :type, :maxPeople, :minPeople, :price");
			$statement->bindParam(":type", $this->type );
			$statement->bindParam(":maxPeople", $this->maxPeople );
			$statement->bindParam(":minPeople", $this->minPeople );
			$statement->bindParam(":price", $this->price );
			if($statement->execute())
			{
				$this->isNew = false;
				$this->id = $gDatabase->lastInsertId();
			}
			else
			{
				throw new SaveFailedException();
			}
		}
		else
		{
			$statement = $gDatabase->prepare("UPDATE room SET type= :type,maxPeople= :maxPeople, minPeople=:minPeople, price=:price WHERE id=:id LIMIT 1;");
			$statement->bindParam(":type", $this->type );
			$statement->bindParam(":maxPeople", $this->maxPeople );
			$statement->bindParam(":minPeople", $this->minPeople );
			$statement->bindParam(":price", $this->price );
			$statement->bindParam(":id", $this->id );
			if(!$statement->execute())
			{
				throw new SaveFailedException();
			}
		}
	}

	public function delete()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("DELETE FROM room WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id",$this->id);
		$statement->execute();
		$this->id=0;
		$this->isNew=true;
	}
}
