<?php
require_once("Address.php");
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Customer extends DataObject
{
	private $firstname;
	private $surname;
	private $address;
	private $email;
	private $language;
	
	public function getFirstname()
	{
		return $this->firstname;
	}
	
	public function getSurname()
	{
		return $this->surname;
	}
	
	public function getAddress()
	{ //get address from Address Class
		Address::getById($this->address);
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getLanguage()
	{
		return $this->language;
	}
	
	public function setFirstname($value)
	{
		$this->firstname = $value;
	}
	
	public function setSurname($value)
	{
		$this->surname = $value;
	}
	
	public function setAddress($value)
	{
		$this->address = $value;
	}
	
	public function setEmail($value)
	{
		$this->email = $value;
	}
	
	public function setLanguage($value)
	{
		$this->language = $value;
	}
	
	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM customer WHERE id = :id LIMIT 1;");
		
		$statement->bindParam(":id", $id);
		
		$statement->execute();
		
		$resultObject = $statement->fetchObject("Customer");
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
			$statement = $gDatabase->prepare("INSERT INTO customer VALUES (null, :firstname, :surname, :address, :email, :language");
			$statement->bindParam(":adults", $this->firstname );
			$statement->bindParam(":children",$this->surname );
			$statement->bindParam(":startDate", $this->address );
			$statement->bindParam(":endDate", $this->email );
			$statement->bindParam(":promocode", $this->language );
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
			$statement = $gDatabase->prepare("UPDATE customer SET firstname= :firstname,surname= :surname,address= :address, email=:email, language=:language WHERE id=:id LIMIT 1;");
			$statement->bindParam(":firstname", $this->firstname );
			$statement->bindParam(":surname",$this->surname );
			$statement->bindParam(":address", $this->address );
			$statement->bindParam(":email", $this->email );
			$statement->bindParam(":language", $this->language );
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
		$statement = $gDatabase->prepare("DELETE FROM customer WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id",$this->id);
		$statement->execute();
		$this->id=0;
		$this->isNew=true;
	}
}
