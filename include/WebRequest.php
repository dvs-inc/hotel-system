<?php

class WebRequest
{
	public static function pathInfo()
	{
		if(isset($_SERVER['PATH_INFO']))
			return $_SERVER['PATH_INFO'];
		else return "";
	}

	public static function get(string $variable)
	{
		if(isset($_GET[$variable]))
		{
			return $_GET[$variable];
		}
		else return "";
	}

	public static function post(string $variable)
	{
		if(isset($_POST[$variable]))
		{
			return $_POST[$variable];
		}
		else return "";
	}
}
