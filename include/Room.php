<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Room extends DataObject
{
	protected $name;
	protected $type;
	protected $maxPeople;
	protected $minPeople;
	protected $price;
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getType()
	{
		return RoomType::getById($this->type);
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
	
	public function setName($value)
	{
		$this->name = $value;
	}
	
	public function setType($value)
	{
		$this->type = $value;
	}

	public function setMaxPeople($value)
	{
		$this->maxPeople = $value;
	}

	public function setMinPeople($value)
	{
		$this->minPeople = $value;
	}

	public function setPrice($value)
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
			$statement = $gDatabase->prepare("INSERT INTO room VALUES (null, :name, :type, :maxPeople, :minPeople, :price);");
			$statement->bindParam(":name", $this->name );
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
			$statement = $gDatabase->prepare("UPDATE room SET name = :name, type = :type, maxPeople = :maxPeople, minPeople = :minPeople, price = :price WHERE id = :id LIMIT 1;");
			$statement->bindParam(":name", $this->name );
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
	
	public static function getIdList()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT id FROM room;");
		$statement->execute();

		$result = $statement->fetchAll(PDO::FETCH_COLUMN,0);

		return $result;
	}
}
