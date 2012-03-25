<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Session
{
	public static function start()
	{
		session_start();
	}
	
	public static function setLoggedInCustomer($id)
	{
		$_SESSION['cid'] = $id;
	}
	
	public static function getLoggedInCustomer()
	{
		if(isset($_SESSION['cid']))
		{
			return $_SESSION['cid'];
		}
		else
		{
			return false;
		}
	}
	
	public static function isCustomerLoggedIn()
	{
		return isset($_SESSION['cid']);
	}
	
	public static function setLoggedInUser($id)
	{
		$_SESSION['uid'] = $id;
	}
	
	public static function getLoggedInUser()
	{
		if(isset($_SESSION['uid']))
		{
			return $_SESSION['uid'];
		}
		else
		{
			return false;
		}
	}
	
	public static function isLoggedIn()
	{
		return isset($_SESSION['uid']);
	}

	public static function destroy()
	{
		session_destroy();
	}
}