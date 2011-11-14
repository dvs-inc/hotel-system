<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class CreditCard extends DataObject
{
	public function __construct()
	{
	}
	
	public static function create($number, $name, $expiry, $cvc)
	{
		$card = new self();
	
		$card->isNew = true;
		$card->mCardDetails["cardnumber"] = $number;
		$card->mCardDetails["name"] = $name;
		$card->mCardDetails["expiry"] = $expiry;
		$card->mCardDetails["cvc"] = $cvc;
		
		return $card;
	}

	/**
	 * Encrypted bata blob from db
	 */
	private $card;
	
	private $mCardDetails = array(
		"cardnumber" => "",
		"name" => "",
		"expiry" => "",
		"cvc" => "",
		),
		
	public static function getById($id)
	{
		// get from DB
		
		if(/*success*/ false)
		{
			$blob = /* data blob from db */ false;
		
			$dataArray = CreditCard::decrypt($blob);
			
			$obj = new CreditCard(
				$dataArray["cardnumber"],
				$dataArray["name"],
				$dataArray["expiry"],
				$dataArray["cvc"]
				);
				
			$obj->isNew = false;
			$obj->id = $id;
			$obj->card = $blob;
			
			return $obj;
		}
		else
		{
			return false;
		}
	}
	
	private static function decrypt($data)
	{
		global $cCardEncryptionKey;

		return 
			unserialize(
				rtrim(
					mcrypt_decrypt(
						MCRYPT_RIJNDAEL_256, 
						md5($cCardEncryptionKey), 
						base64_decode($data), 
						MCRYPT_MODE_CBC, 
						md5(md5($cCardEncryptionKey))
					),
					"\0"
				)
			);
	}
	
	private static function encrypt($data)
	{
		global $cCardEncryptionKey;

		return 
			base64_encode(
				mcrypt_encrypt(
					MCRYPT_RIJNDAEL_256, 
					md5($cCardEncryptionKey), 
					serialize($data), 
					MCRYPT_MODE_CBC, 
					md5(md5($cCardEncryptionKey))
				)
			);
	}
	
	public function getNumber()
	{
		return $this->mCardDetails["cardnumber"];
	}
	
	public function getLast4Digits()
	{
		
	}
	
	public function getName()
	{
		return $this->mCardDetails["name"];
	}
	
	public function getExpiry()
	{
		return $this->mCardDetails["expiry"];
	}
	
	public function getCvc()
	{
		return $this->mCardDetails["cvc"];
	}
	
	public function save()
	{
		$this->card = encrypt($this->mCardDetails);
	
		if($this->isNew)
		{ // insert
		
		}
		else
		{ // update
		
		
		}
	}
}