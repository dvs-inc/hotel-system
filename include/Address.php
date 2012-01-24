<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Address extends DataObject
{
	private $line1;
	private $line2;
	private $city;
	private $postcode;
	private $country;
	
	public function getLine1()
	{
		return $this->line1;
	}
	
	public function getLine2()
	{
		return $this->line2;
	}
	
	public function getCity()
	{
		return $this->city
	}
	
	public function getPostcode()
	{
		return $this->postcode;
	}
	
	public function getCountry()
	{
		return $this->country;
	}
	
	public function setLine1($value)
	{
		$this->line1 = $value;
	}
	
	public function setLine2($value)
	{
		$this->line2 = $value;
	}
	
	public function setCity($value)
	{
		$this->city = $value;
	}
	
	public function setPostcode($value)
	{
		$this->postcode = $value;
	}
	
	public function setCountry($value)
	{
		$this->country = $value;
	}
	
	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM address WHERE id = :id LIMIT 1;");
		
		$statement->bindParam(":id", $id);
		
		$statement->execute();
		
		$resultObject = $statement->fetchObject("Address");
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
		{ // insert
			$statement = $gDatabase->prepare("INSERT INTO address VALUES (null, :line1, :line2, :city, :postcode, :country");
			$statement->bindParam(":line1", $this->line1 );
			$statement->bindParam(":line2", $this->line2 );
			$statement->bindParam(":city", $this->city );
			$statement->bindParam(":postcode", $this->postcode );
			$statement->bindParam(":country", $this->country );
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
		{ // update
			$statement = $gDatabase->prepare("UPDATE address SET line1= :line1,line2= :line2, city=:city, postcode=:postcode, country=:country WHERE id=:id LIMIT 1;");
			$statement->bindParam(":line1", $this->line1 );
			$statement->bindParam(":line2", $this->line2 );
			$statement->bindParam(":city", $this->city );
			$statement->bindParam(":postcode", $this->postcode );
			$statement->bindParam(":country", $this->country );
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
		$statement = $gDatabase->prepare("DELETE FROM address WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id",$this->id);
		$statement->execute();
		$this->id=0;
		$this->isNew=true;
	}
}
