<?php
require_once("Customer.php");
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Booking extends DataObject
{
	private $adults;
	private $children;
	private $startDate;
	private $endDate;
	private $promocode;
	private $customer;
	
	public function getAdults()
	{
		return $this->adults;
	}
	
	public function getChildren()
	{
		return $this->children;
	}
	
	public function getStartDate()
	{
		$start = new DateTime($startDate);
		return date_format($start,'d-m-Y');
	}
	
	public function getEndDate()
	{
		$end = new DateTime($endDate);
		return date_format($end,'d-m-Y');
	}
	
	public function getPromocode()
	{
		return $this->promocode;
	}
		
	public function getCustomer()
	{
		return Customer::getById($this->customer);
	}
	
	public function setAdults($value)
	{
		$this->adults = $value;
	}
	
	public function setChildren($value)
	{
		$this->children = $value;
	}
	
	public function setStartDate($value)
	{
		$start = new DateTime($value);
		$this->startDate = date_format($start,'d-m-Y');
	}
	
	public function setEndDate($value)
	{
		$end = new DateTime($value);
		$this->endDate = date_format($end,'d-m-Y');
	}
	
	public function setPromocode($value)
	{
		$this->promocode = $value;
	}
	
	public function setCustomer($value)
	{
		$this->customer = $value;
	}
	
	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM booking WHERE id = :id LIMIT 1;");
		
		$statement->bindParam(":id", $id);
		
		$statement->execute();
		
		$resultObject = $statement->fetchObject("Booking");
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
			$statement = $gDatabase->prepare("INSERT INTO booking VALUES (null, :adults, :children, :startDate, :endDate, :promocode, :customer);");
			$statement->bindParam(":adults", $this->adults );
			$statement->bindParam(":children",$this->children );
			$statement->bindParam(":startDate", $this->startDate );
			$statement->bindParam(":endDate", $this->endDate );
			$statement->bindParam(":promocode", $this->promocode );
			$statement->bindParam(":customer", $this->customer );
			
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
			$statement = $gDatabase->prepare("UPDATE booking SET adults= :adults,children= :children,startDate= :startDate, endDate=:endDate, promocode=:promocode, customer= :customer WHERE id=:id LIMIT 1;");
			$statement->bindParam(":adults", $this->adults );
			$statement->bindParam(":children",$this->children );
			$statement->bindParam(":startDate", $this->startDate );
			$statement->bindParam(":endDate", $this->endDate );
			$statement->bindParam(":promocode", $this->promocode );
			$statement->bindParam(":customer", $this->customer );
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
		$statement = $gDatabase->prepare("DELETE FROM booking WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id",$this->id);
		$statement->execute();
		$this->id=0;
		$this->isNew=true;
	}
	
	public static function getIdList()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT id FROM booking;");
		$statement->execute();

		$result = $statement->fetchAll(PDO::FETCH_COLUMN,0);

		return $result;
	}
}
