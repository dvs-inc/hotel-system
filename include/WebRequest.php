<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

/**
 * Holds functions to abstract away from the web, and provides a safe API to the web server information etc.
 */
class WebRequest
{
	/**
	 * Retrieves the PATH_INFO server variable, if it is set
	 */
	public static function pathInfo()
	{
		if(isset($_SERVER['PATH_INFO']))
		{
			return $_SERVER['PATH_INFO'];
		}
		else
		{
			return false;
		}
	}

	/**
	 * Retrieves a GET variable, if it is set.
	 */
	public static function get($variable)
	{
		if(isset($_GET[$variable]))
		{
			return $_GET[$variable];
		}
		else
		{
			return false;
		}
	}

	/**
	 * Retrieves a POST variable, if it is set.
	 */
	public static function post($variable)
	{
		if(isset($_POST[$variable]))
		{
			return $_POST[$variable];
		}
		else
		{
			return false;
		}
	}
	
	public static function postString($variable)
	{
		return htmlentities(self::post($variable));
	}
	
	public static function postInt($variable)
	{
		$x = self::post($variable);
		return is_numeric($x) && intval($x)==$x ? intval($x) : false;
	}

	public static function getPostKeys()
	{
		return array_keys($_POST);
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
	
	public static function setCookie($name, $content)
	{	
		global $gCookieJar;
		$gCookieJar[$name] = $content;
	}
	
	public static function sendCookies()
	{	
		global $gCookieJar;
		foreach($gCookieJar as $name => $value)
		{
			setcookie($name, $value);
		}
	}
	
	public static function getCookie($name)
	{
		if(isset($_COOKIE[$name]))
		{
			return $_COOKIE[$name]; // nom nom!
		}
		else
		{
			return false; // :'(
		}
	}
	
	/**
	 * Outputs all content to the browser
	 */
	public static function output($content)
	{
		// final transformations?
		$content = Hooks::run("BeforeOutputSend",array($content));
	
		// clean the output buffer so anything that's been rogue sent to the 
		// browser is discarded
		ob_clean();
		
		// write the HTML to the buffer
		print $content;
		
		// flush the buffer to the browser
		ob_flush();
	}
}
