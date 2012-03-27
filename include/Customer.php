<?php
require_once("Address.php");
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Customer extends DataObject
{
	private $title;
	private $firstname;
	private $surname;
	private $address;
	private $email;
	private $password;
	private $creditcard;
	private $language;
	private $mailconfirm;
	private $mailchecksum;
	
	public function __construct()
	{
		$this->language = "en-GB";
		
	}
	
//////////////////////////////////////////////////////////////////////////////////////////

	public function getTitle()
	{
		return $this->title;
	}
	
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
		return Address::getById($this->address);
	}
	
	public function getEmail()
	{
		return $this->email;
	}

	public function getCreditCard()
	{
		return CreditCard::getById($this->creditcard);
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function getMailConfirm()
	{
		return $this->mailconfirm;
	}
	
	public function getMailChecksum()
	{
		return $this->mailchecksum;
	}

	public function isMailConfirmed()
	{
		return $this->mailconfirm == "Confirmed";
	}

	public function generateMailChecksum()
	{
		$this->mailchecksum = self::generateHash($this->email);
	}

//////////////////////////////////////////////////////////////////////////////////////////

	public function setTitle($value)
	{
		$this->title = $value;
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
		$this->address = $value->getId();;
	}	
	
	public function setCity($value)
	{
		$this->city = $value;
	}
	
	public function setEmail($value)
	{
		$this->email = $value;
		$this->mailconfirm = self::generateHash($this->email);
	}

	public function setPassword($newPassword)
	{
		$this->password = self::encryptPassword($this->email, $newPassword);
	}

	public function setCreditCard($value)
	{
		$this->creditcard = $value->getId();
	}

	public function setLanguage($value)
	{
		$this->language = $value;
	}

	public function confirmEmail($hash)
	{
		global $gLogger;
		
		$gLogger->log("MC is " . $this->mailconfirm . ", hash is $hash .");
		
		if($this->mailconfirm == $hash)
		{
			$gLogger->log("Successfully confirmed email address");
			$this->mailconfirm = "Confirmed";
			$this->save();
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////


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

	public static function getByEmail($email)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM customer WHERE email = :email LIMIT 1;");
		
		$statement->bindParam(":email", $email);
		
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
			$checkStatement = $gDatabase->prepare("SELECT COUNT(*) as count FROM customer WHERE email = :email;");
			$checkStatement->bindParam(":email", $this->email );
			$checkStatement->execute();
			if($checkStatement->fetchColumn())
				throw new SaveFailedException("Customer already exists");
			
			$statement = $gDatabase->prepare("INSERT INTO customer VALUES (null, :title, :firstname, :surname, :address, :email, :password, :creditcard, :language, :mailconfirm, :mailchecksum);");
			$statement->bindParam(":title", $this->title );
			$statement->bindParam(":firstname", $this->firstname );
			$statement->bindParam(":surname",$this->surname );
			$statement->bindParam(":address", $this->address );
			$statement->bindParam(":email", $this->email );
			$statement->bindParam(":password", $this->password );
			$statement->bindParam(":creditcard", $this->creditcard );
			$statement->bindParam(":language", $this->language );
			$statement->bindParam(":mailconfirm", $this->mailconfirm );	
			$statement->bindParam(":mailchecksum", $this->mailchecksum );
			
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
			$statement = $gDatabase->prepare("UPDATE customer SET title = :title, firstname= :firstname,surname= :surname,address= :address,email=:email, password=:password, creditcard=:creditcard, language=:language, mailconfirm=:mailconfirm, mailchecksum=:mailchecksum WHERE id=:id LIMIT 1;");
			$statement->bindParam(":title", $this->title );
			$statement->bindParam(":firstname", $this->firstname );
			$statement->bindParam(":surname",$this->surname );
			$statement->bindParam(":address", $this->address );
			$statement->bindParam(":email", $this->email );
			$statement->bindParam(":password", $this->password );
			$statement->bindParam(":creditcard", $this->creditcard );
			$statement->bindParam(":language", $this->language );
			$statement->bindParam(":mailconfirm", $this->mailconfirm );
			$statement->bindParam(":mailchecksum", $this->mailchecksum );
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
	
	public static function getIdList()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT id FROM customer;");
		$statement->execute();

		$result = $statement->fetchAll(PDO::FETCH_COLUMN,0);

		return $result;
	}
/////////////////////////////////////////////////////////////////////////////

	public function sendMailConfirm()
	{
		global $cWebPath;
		$message = Message::getMessage("signup-mailconfirm");
		$link = 'http://'.WebRequest::httpHost().$cWebPath.'/index.php/Confirm?id='.$this->getId().'&hash='.$this->getMailConfirm();
		$message = str_replace('$1', $link, $message);
		Mail::send($this->getEmail(),Message::getMessage("signup-mailconfirm-subject"),$message);
	}

	// Function to send an email with a link to the change password page
	public function sendPasswordReset()
	{
		global $cWebPath;
		$message = Message::getMessage("forgotPassword-mail");
		$this->generateMailChecksum();
		$this->save();
		$link = 'http://'.WebRequest::httpHost().$cWebPath.'/index.php/ForgotPassword?id='.$this->id.'&hash='.$this->getMailChecksum();
		$message = str_replace('$1', $link, $message);
		Mail::send($this->getEmail(),Message::getMessage("forgotPassword-mail-subject"),$message);
	}

	/**
	 * Check the stored password against the provided password
	 * @returns true if the password is correct
	 */
	public function authenticate($password)
	{
		global $gLogger;
		$encpass = self::encryptPassword($this->email, $password);
		$gLogger->log("Customer::authenticate: Comparing {$this->password} to {$encpass}");
		return ( $this->password == $encpass);
	}

	// let's not make a decrypt method.... we don't need it.
	protected static function encryptPassword($email, $password)
	{
		// simple encryption. MD5 is very easy to compute, and very hard to reverse.
		// As it's easy to compute, people make tables of possible values to decrypt
		// it (see: Rainbow Tables). We completely nerf that by adding a known 
		// changable factor to the hash, known as a salt. This makes rainbow
		// tables practically useless against this set of passwords.
		return md5(md5($email . md5($password)));
	}
	
	protected static function generateHash($email)
	{
		// do some time-sensitive stuff related to the specified email address.
		// (the idea being that the same hash won't be generated twice by two 
		//        different servers serving an identical request)
		
		$mt = microtime(); // microseconds past the epoch
		$mts = sha1($mt);

		$key = sha1($email);
		
		$rand = mt_rand(); // random number
		
		$mt2 = microtime();
		$mts2 = sha1($mt2);

		$result = sha1($rand . md5($mts . $key) . $mts2);
		
		return $result;
	}
}
