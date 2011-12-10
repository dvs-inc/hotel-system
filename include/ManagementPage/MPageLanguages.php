<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLanguages extends ManagementPageBase
{
	protected function runPage()
	{
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
}
