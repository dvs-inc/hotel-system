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

	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM message WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $name);
		
		$statement->execute();
		
		$resultMessage = $statement->fetchObject("Message");
		
		return $resultMessage;
	}
	
	public static function getByName($name, $language)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM message WHERE name = :name AND code = :language LIMIT 1;");
		$statement->bindParam(":name", $name);
		$statement->bindParam(":language", $language);
		
		$statement->execute();
		
		$resultMessage = $statement->fetchObject("Message");
		
		if($resultMessage != false)
		{
			return $resultMessage;
		}
		else
		{
			return self::getError($name, $language);
		}
	}
	
	public static function retrieveContent($name, $language)
	{
		return self::getByName($name, $language)->getContent();
	}
	
	public static function getMessage($name)
	{
		return self::getByName($name, self::getActiveLanguage())->getContent();
	}
	
	/**
	 * Returns an error version of a requested message.
	 */
	public static function getError( $name,  $language)
	{
		$em = new Message();
		$em->code = $language;
		$em->name = $name;
		$em->content = "&lt;$language:$name&gt;";
		$em->isNew = true;
		return $em;
	}
	
	public static function getActiveLanguage()
	{
		/* figure out some sensible non-global way of getting 
		   the language in here */
		return "en-GB";
	}
	
	/**
	 * Never call this function.
	 *
	 * Really, don't do it.
	 *
	 * Don't delete it either.
	 *
	 * -- Simon :D xx
	 */
	public static function 
		smartyGetRealMessageContentWithDynamicLanguageFromUserPrefsAndCookies
		($params, $smarty)
	{
		$language = self::getActiveLanguage();
		
		$name = $params["name"];
		
		return self::retrieveContent($name, $language);
	}
	
	public function getName()
	{
		return $this->name;
	}
	public function getCode()
	{
		return $this->code;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function setContent($newcontent)
	{
		$this->content = $newcontent;
	}
	
	public function save()
	{
	
	}
}