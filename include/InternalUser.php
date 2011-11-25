<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class InternalUser extends DataObject
{

	protected $username;
	protected $password;

	public static function getById($id)
	{
		
	}
	
	public static function getByName($name)
	{
	
	}
	
	/**
	 * Check the stored password against the provided password
	 * @returns true if the password is correct
	 */
	public function authenticate($password)
	{
		return ( $this->password == encryptPassword($this->username, $password));
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
		if($this->isNew)
		{
		
		}
		else
		{
		
		}
	}

}