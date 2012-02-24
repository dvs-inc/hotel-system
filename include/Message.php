<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Message extends DataObject
{

	protected static $requestLanguage = "";

	/**
	 * Database fields
	 */
	protected $name;
	protected $code;
	protected $content;

	/**
	 * Retrieves a list of all the known message keys
	 */
	public static function getMessageKeys()
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT DISTINCT name FROM message;");
		$statement->execute();

		$result = $statement->fetchAll(PDO::FETCH_COLUMN,0);

		return $result;
	}

	public static function getById($id)
	{
		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM message WHERE id = :id LIMIT 1;");
		$statement->bindParam(":id", $id);

		$statement->execute();

		$resultMessage = $statement->fetchObject("Message");

		$resultMessage->isNew = false;

		return $resultMessage;
	}

	public static function getByName($name, $language)
	{
		// language pseudocode exception
		// the idea of this is you can use language code zxx
		// to view all the available language codes in situ.
		if($language == "zxx")
		{
			$m = new Message();
			$m->name = $name;
			$m->code = $language;
			$m->content = $name;

			return $m;
		}
		// end of language pseudocode exception

		global $gDatabase;
		$statement = $gDatabase->prepare("SELECT * FROM message WHERE name = :name AND code = :language LIMIT 1;");
		$statement->bindParam(":name", $name);
		$statement->bindParam(":language", $language);

		$statement->execute();

		$resultMessage = $statement->fetchObject("Message");

		if($resultMessage != false)
		{
			$resultMessage->isNew = false;
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
		if(strlen($name) == 0)
			throw new Exception("Cannot create an error Message object with no name!");
	
		if(strlen($language) == 0)
			throw new Exception("Cannot create an error Message object with no language!");
	
		$em = new Message();
		$em->code = $language;
		$em->name = $name;
		$em->content = "&lt;$language:$name&gt;";
		$em->isNew = true;

		$em->save();

		return $em;
	}
	
	public static function getActiveLanguage()
	{
		global $cAvailableLanguages;
	
		// look in the order of most volatile first - if we find something, use it.
		// request cache
		if(self::$requestLanguage != "")
		{
			return self::$requestLanguage;
		}
		
		// get parameter
		$getParam = WebRequest::get("lang");
		if($getParam != false)
		{
			// check value is in list of allowed values
			if(array_key_exists($getParam, $cAvailableLanguages))
			{
				// save local cache for other messages this request
				self::$requestLanguage = $getParam;
			
				// set a cookie to persist that option for this session (do we want
				// this option to set the preferences too?)
				WebRequest::setCookie("lang", $getParam);
			
				// use this value.
				return $getParam;
			}
		}
		
		// cookie
		$cookie = WebRequest::getCookie("lang");
		if($cookie != false)
		{
			// check value is in list of allowed values
			if(array_key_exists($cookie, $cAvailableLanguages))
			{
				// save local cache for other messages this request
				self::$requestLanguage = $cookie;
			
				// use this value.
				return $getParam;
			}
		
		}
		// user preference
		
		// site default
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
		try
		{
		if($this->isNew)
		{
			global $gDatabase;
			$statement = $gDatabase->prepare("INSERT INTO message (name, code, content) VALUES (:name, :code, :content);");

			if($this->name == "")
				throw new SaveFailedException("No name set!");
			
			if($this->code == "")
				throw new SaveFailedException("No code set!");
			
			$statement->bindParam(":name", $this->name);
			$statement->bindParam(":code", $this->code);
			$statement->bindParam(":content", $this->content);

			if($statement->execute())
			{
				$this->isNew = false;
				$this->id = $gDatabase->lastInsertId();
			}
			else
			{
				throw new SaveFailedException();
			}
		}
		else
		{
			global $gDatabase;
			$statement = $gDatabase->prepare("UPDATE message SET content = :content WHERE id = :id LIMIT 1;");

			$statement->bindParam(":id", $this->id);
			$statement->bindParam(":content", $this->content);

			if(! $statement->execute())
			{
				throw new SaveFailedException();
			}
		}
		}
		catch( PDOException $ex)
		{
			throw new SaveFailedException($ex->getMessage(), $ex->getCode, $ex);
		}
	}

	public function delete()
	{
		throw new Exception("Not implemented");
	}
}
