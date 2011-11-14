<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Database extends PDO
{
	protected $hasActiveTransaction = false;

	/**
	 * Determines if this connection has a transaction in progress or not
	 * @return true if there is a transaction in progress.
	 */
	public function hasActiveTransaction()
	{
		return $this->hasActiveTransaction;
	}
	
	public function beginTransaction () 
	{
		if ( $this->hasActiveTransaction ) 
		{
			return false;
		} 
		else 
		{
			$this->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
			$this->hasActiveTransaction = parent::beginTransaction();
			return $this->hasActiveTransaction;
		}
	}

	public function commit () 
	{
		parent::commit();
		$this->hasActiveTransaction = false;
	}

	public function rollBack () 
	{
		parent::rollback();
		$this->hasActiveTransaction = false;
	}
}