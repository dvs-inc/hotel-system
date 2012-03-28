<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Bill_item extends DataObject
{
	private $name;
	private $price;
	private $booking;
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getPrice()
	{
		return $this->price;
	}
	
	public function getBooking()
	{
		return Booking::getById($this->booking);
	}	

	public function setName($value)
	{
		$this->name = $value;
	}

	public function setPrice($value)
	{
		$this->price = $value;
	}

	public function setBooking($value)
	{
		$this->booking = $value->getId();
	}
	
	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM bill_item WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $id);
		
		$statement->execute();
		
		$resultObject = $statement->fetchObject("Bill_item");
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
			$statement = $gDatabase->prepare("INSERT INTO bill_item VALUES (null, :name, :price, :booking);");
			$statement->bindParam(":name", $this->name );
			$statement->bindParam(":price", $this->price );
			$statement->bindParam(":booking", $this->booking );
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
			$statement = $gDatabase->prepare("UPDATE bill_item SET name= :name,price= :price, booking=:booking WHERE id=:id LIMIT 1;");
			$statement->bindParam(":name", $this->name );
			$statement->bindParam(":price", $this->price );
			$statement->bindParam(":booking", $this->booking );
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
		$statement = $gDatabase->prepare("DELETE FROM bill_item WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id",$this->id);
		$statement->execute();
		$this->id=0;
		$this->isNew=true;
	}
	
	public static function getIdListByBooking($booking)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT id FROM bill_item WHERE booking = :booking ;");
		$statement->bindParam(":booking", $booking);
		$statement->execute();

		$result = $statement->fetchAll(PDO::FETCH_COLUMN,0);

		return $result;
	}
}
