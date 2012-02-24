<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLanguages extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-language-messages";
	}

	protected function runPage()
	{
		// try to get more access than we may have.
		try
		{
			self::checkAccess('edit-language-messages');
			$this->mSmarty->assign("readonly", '');
		}
		catch(AccessDeniedException $ex) // nope, catch the error and handle gracefully
		{
			// caution: if you're copying this, this is a hack to make sure 
			//			users know they don't have the access to do this, not
			// 			to actually stop them from doing it, though it will have
			// 			that effect to the non-tech-savvy.
			$this->mSmarty->assign("readonly", 'disabled="disabled"');
		}
		
	
		global $cWebPath;
		$this->mStyles[] = $cWebPath . "/style/pager.css";
	
		if(WebRequest::wasPosted())
		{
			self::checkAccess("edit-language-messages");
		
			$this->save();
			global $cWebPath;
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/management.php/Languages";
			return;
		}
	
		$this->mBasePage="mgmt/lang.tpl";
		
		$keys = array();
		if(WebRequest::get("showall"))
		{
			$keys = Message::getMessageKeys();
		}
		else
		{
			if(WebRequest::get("prefix"))
			{
				$keys = Message::getMessageKeys();
				$keys = array_filter($keys, function($value){
					$prefix = WebRequest::get("prefix");
					return (substr($value, 0, strlen($prefix)) == $prefix);
				});
			}
		}		
		
		
		if(count($keys) > 0)
		{
			$this->mSmarty->assign("showtable", 1);
			global $cAvailableLanguages;
			
			// retrieve the message table as an array (of message keys) of arrays 
			// (of languages) of arrays (of id/current content)
			$messagetable = array();
			foreach($keys as $mkey)
			{
				$messagetable[$mkey] = array();
				foreach($cAvailableLanguages as $lang => $langname)
				{
					$message = Message::getByName($mkey, $lang);
					$messagetable[$mkey][$lang] = array(
						"id" => $message->getId(),
						"content" => $message->getContent()
						);
				}
			}
			
			$this->mSmarty->assign("languagetable", $messagetable);
			$this->mSmarty->assign("languages",$cAvailableLanguages);
		}
		else
		{
			$this->mSmarty->assign("showtable", 0);
		}
	}

	private function save()
	{
		$keys = WebRequest::getPostKeys();
		
		foreach($keys as $k)
		{
			// extract id from POST request
			$id=str_replace("lang","",$k);
			$id=str_replace("msg","",$id);
			if(! is_numeric($id))
			{
				throw new ArgumentException("$k: [$id] is not an integer", 0);
			}
			
			// retrieve message object
			$message = Message::getById($id);
			if($message == null)
			{
				throw new ArgumentException("Message ID $id could not be found");
			}
			
			$value=WebRequest::post($k);
			
			if($message->getContent != $value)
			{
				// write content
				$message->setContent($value);
				
				// save object
				$message->save();
			}
		}
	}
}
