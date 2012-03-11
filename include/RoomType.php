<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class RoomType extends DataObject
{
	public static $data = array(
				1 => "roomtype-1",
				2 => "roomtype-2",
				3 => "roomtype-3",
				4 => "roomtype-4",
				5 => "roomtype-5",
		);

	protected $name;
	
	/**
	 * Retrieves a data object by it's row ID.
	 */
	public static function getById($id)
	{
		if(!isset(self::$data[$id]))
		{
			throw new ArgumentException();
		}
		
		$rt = new RoomType();
		$rt->id = $id;
		$rt->name = self::$data[$id];
		
		return $rt;
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function save()
	{
		throw new YouShouldntBeDoingThatException();
	}

	public function delete()
	{
		throw new YouShouldntBeDoingThatException();
	}

	public static function getIdList()
	{
		return array_keys(self::$data);
	}	
}