<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Message extends DataObject
{

	/**
	 * Database fields
	 */
	protected $name;
	protected $code;
	protected $content;

	public static function getById(int $id)
	{

	}
	
	public static function getByName(int $id)
	{
	
	}
	
	public function save()
	{
	
	}
}