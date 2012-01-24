<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class InternalUser extends DataObject
{

	protected $username;
	protected $password;

	public static function getIdList()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT id FROM internaluser;");
		$statement->execute();

		$result = $statement->fetchAll(PDO::FETCH_COLUMN,0);

		return $result;
	}

	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM internaluser WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $id);

		$statement->execute();

		$resultObject = $statement->fetchObject("InternalUser");
		if($resultObject != false)
		{
			$resultObject->isNew = false;
		}
		return $resultObject;
	}

	public static function getByName($name)
	{
		global $gLogger;
		$gLogger->log("InternalUser: getting $name from database");
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM internaluser WHERE username = :username LIMIT 1;");
		$statement->bindParam(":username", $name);

		$statement->execute();

		$resultObject = $statement->fetchObject("InternalUser");
		if($resultObject != false)
		{
			$gLogger->log("InternalUser::getByName: $name exists");
			$resultObject->isNew = false;
		}

		return $resultObject;
	}

	/**
	 * Check the stored password against the provided password
	 * @returns true if the password is correct
	 */
	public function authenticate($password)
	{
		global $gLogger;
		$encpass = self::encryptPassword($this->username, $password);
		$gLogger->log("InternalUser::authenticate: Comparing {$this->password} to {$encpass}");
		return ( $this->password == $encpass);
	}

	// let's not make a decrypt method.... we don't need it.
	protected static function encryptPassword($username, $password)
	{
		// simple encryption. MD5 is very easy to compute, and very hard to reverse.
		// As it's easy to compute, people make tables of possible values to decrypt
		// it (see: Rainbow Tables). We completely nerf that by adding a known 
		// changable factor to the hash, known as a salt. This makes rainbow
		// tables practically useless against this set of passwords.
		return md5(md5($username . md5($password)));
	}

	public function save()
	{
		global $gDatabase;

		if($this->isNew)
		{ // insert
			$statement = $gDatabase->prepare("INSERT INTO internaluser VALUES (null, :username, :password);");
			$statement->bindParam(":username", $this->username);
			$statement->bindParam(":password", $this->password);
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
			$statement = $gDatabase->prepare("UPDATE internaluser SET username = :username, password = :password WHERE id = :id LIMIT 1;");
			$statement->bindParam(":username", $this->username);
			$statement->bindParam(":password", $this->password);
			$statement->bindParam(":id", $this->id);

			if(!$statement->execute())
			{
				throw new SaveFailedException();
			}
		}
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setPassword($password)
	{
		$this->password = self::encryptPassword($this->username, $password);
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function delete()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("DELETE FROM internaluser WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $this->id);
		$statement->execute();

		$this->id=0;
		$this->isNew = true;
	}
}
