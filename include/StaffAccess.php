<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class StaffAccess extends DataObject
{
	protected $action;
	protected $level;

	public static function getKnownActions()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT action FROM staffAccess;");

		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_COLUMN,0);

	}


	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM staffAccess WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $id);

		$statement->execute();

		$resultObject = $statement->fetchObject("StaffAccess");
		if($resultObject != false)
		{
			$resultObject->isNew = false;
		}
		return $resultObject;
	}
	public static function getByAction($action)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM staffAccess WHERE action = :id LIMIT 1;");
		$statement->bindParam(":id", $action);

		$statement->execute();

		$resultObject = $statement->fetchObject("StaffAccess");
		if($resultObject != false)
		{
			$resultObject->isNew = false;
		}
		else
		{
			$resultObject->action = $action;
			$resultObject->level = 99;
			$resultObject->save();
		}
		return $resultObject;
	}

	public function getAction()
	{
		return $this->action;
	}
	public function getLevel()
	{
		return $this->level;
	}
	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function save()
	{
		global $gDatabase;

		if($this->isNew)
		{ // insert
			$statement = $gDatabase->prepare("INSERT INTO staffAccess VALUES (null, :action, :accesslvl);");
			$statement->bindParam(":action", $this->action);
			$statement->bindParam(":accesslvl", $this->level);
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
			$statement = $gDatabase->prepare("UPDATE staffAccess SET action = :action, level = :accesslvl WHERE id = :id LIMIT 1;");
			$statement->bindParam(":action", $this->action);
			$statement->bindParam(":accesslvl", $this->level);
			$statement->bindParam(":id", $this->id);

			if(!$statement->execute())
			{
				throw new SaveFailedException();
			}
		}
	}

	public function delete()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("DELETE FROM staffAccess WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $this->id);
		$statement->execute();

		$this->id=0;
		$this->isNew = true;
	}
}
