<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLanguages extends ManagementPageBase
{
	protected function runPage()
	{
		if(WebRequest::wasPosted())
		{
			$this->save();
			global $cWebPath;
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/management.php/Languages";
			return;
		}
	
		$this->mBasePage="mgmt/lang.tpl";
		
		$keys = Message::getMessageKeys();
		
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
