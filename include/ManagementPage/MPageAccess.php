<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageAccess extends ManagementPageBase
{
	public function __construct()
	{
		$this->mAccessName = "view-access-levels";
	}

	protected function runPage()
	{
		try
		{
			self::checkAccess('edit-access-levels');
			$this->mSmarty->assign("readonly", '');
		}
		catch(AccessDeniedException $ex)
		{
			// caution: if you're copying this, this is a hack to make sure 
			//			users know they don't have the access to do this, not
			// 			to actually stop them from doing it, though it will have
			// 			that effect to the non-tech-savvy.
			$this->mSmarty->assign("readonly", 'disabled="disabled"');
		}
		
	
		if(WebRequest::wasPosted())
		{
			// make SURE we have the right access level for this operation
			self::checkAccess('edit-access-levels');
		
			foreach(WebRequest::getPostKeys() as $k)
			{
				$entry = StaffAccess::getById($k);
				if($entry == null)
				{
					continue;
				}

				if($entry->getLevel() != WebRequest::postInt($k))
				{
					$entry->setLevel(WebRequest::postInt($k));
					$entry->save();
				}
			}

			global $cWebPath;

			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/management.php/Access";


			return;
		}

		$this->mBasePage="mgmt/access.tpl";


		$accesslist = array();

		$accessKeys = StaffAccess::getKnownActions();

		foreach($accessKeys as $k)
		{
			$accessEntry = StaffAccess::getByAction($k);

			global $gLogger;
			$gLogger->log("Access entry {$accessEntry->getAction()}({$accessEntry->getLevel()}) found!");

			$accesslist[]=array(
				id=>$accessEntry->getId(),
				name=>$accessEntry->getAction(),
				value=>$accessEntry->getLevel(),
				);
		}

		$this->mSmarty->assign("accesslist", $accesslist);
	}
}
