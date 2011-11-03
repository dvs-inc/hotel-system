<?php

/**
 * Holds functions to abstract away from the web, and provides a safe API to the web server information etc.
 */
class WebRequest
{
	/**
	 * Retrieves the PATH_INFO server variable, if it is set
	 */
	static function pathInfo()
	{
		if(isset($_SERVER['PATH_INFO']))
		{
			return $_SERVER['PATH_INFO'];
		}
		else
		{
			return "";
		}
	}

	/**
	 * Retrieves a GET variable, if it is set.
	 */
	static function get(string $variable)
	{
		if(isset($_GET[$variable]))
		{
			return $_GET[$variable];
		}
		else
		{
			return "";
		}
	}

	/**
	 * Retrieves a POST variable, if it is set.
	 */
	static function post(string $variable)
	{
		if(isset($_POST[$variable]))
		{
			return $_POST[$variable];
		}
		else
		{
			return "";
		}
	}

	/**
	 * Returns true if the request was sent via a HTTP POST, false otherwise
	 */
	public static function wasPosted()
	{
		if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
		{
			return true;
		}

		return false;
	}
}
