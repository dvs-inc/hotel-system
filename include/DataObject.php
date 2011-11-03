<?php

/**
 * DataObject is the base class for all the database access classes. Each "DataObject" holds one record from the database, and
 * provides functions to allow loading from and saving to the database.
 *
 *
 */
abstract class DataObject
{
	/**
	 * Retrieves a data object by it's row ID.
	 */
	public abstract function getById(int $id);

	/**
	 * Saves a data object to the database, either updating or inserting a record.
	 */
	public abstract function save();
}
