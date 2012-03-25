<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Mail
{
	public static function send($to, $subject, $content)
	{
		mail($to, $subject, $content);
	}
}