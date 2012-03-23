<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageLogin extends PageBase
{
	protected function runPage()
	{
		if(WebRequest::wasPosted()) // sanity check
		{
			if(! ($email = WebRequest::postString("lgEmail")))
			{
				// no email address specified
			}
			if(! ($password = WebRequest::postString("lgPasswd")))
			{
				// no email address specified
			}

			$cust = Customer::getByEmail($email);
			if($cust == null)
			{
				// customer doesn't exist. offer to signup or retry?
			}

			if(! $cust->authenticate($password) )
			{
				// not a valid password
			}

			// seems to be ok.

			// set up the session

			// redirect back home
		}
		else
		{
			// urm, something's not quite right here...
			// redirect back to the main page.
			$this->mHeaders[] = "HTTP/1.1 303 See Other";
			$this->mHeaders[] = "Location: " . $cWebPath . "/index.php";
		}
	}
}
