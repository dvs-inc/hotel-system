<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Hooks
{
	// array of arrays
	private static $registeredHandlers = array();
	
	public static function register($name, $callback)
	{
		if(!isset(self::$registeredHandlers[$name]))
		{
			self::$registeredHandlers[$name]=array();
		}
		array_push(self::$registeredHandlers[$name],$callback);
	}

	/**
	 * Run hooks
	 * 
	 * First item in the parameters array is the return value of the last hook 
	 * to be run - should be used as the value to be processed by the hook
	 */
	public static function run($hook, $parameters)
	{
		if(isset(self::$registeredHandlers[$hook]))
		{
			if(! (isset($parameters) && is_array($parameters)))
			{
				$parameters = array("");
			}
			
			foreach(self::$registeredHandlers[$hook] as $func)
			{
				$retval = call_user_func($func, $parameters);
				if($retval !== false)
				{
					$parameters[0] = $retval;
				}
			}
		}
		
		return $parameters[0];
	}
}