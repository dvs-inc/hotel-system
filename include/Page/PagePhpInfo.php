<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PagePhpInfo extends PageBase
{
	protected function runPage()
	{
		if(WebRequest::get("showall") === "yes")
		{
			$phpinfo_parts = INFO_ALL;
			$linktarget = "?showall=no";
		}
		else
		{
			$phpinfo_parts = INFO_VARIABLES;
			$linktarget = "?showall=yes";
		}

		ob_clean();
		phpinfo($phpinfo_parts);
		$pinfo = ob_get_contents();
		ob_clean();

		if(WebRequest::get("showall") === "yes")
		{
			$pinfo1 = explode("<table", $pinfo,2);
			$pinfo = "<table".$pinfo1[1];
			$pinfo1 = explode("<h2>PHP License</h2>", $pinfo);
			$pinfo = $pinfo1[0];
		}
		else
		{
			$pinfo1 = explode("<h2>", $pinfo);
			$pinfo = "<h2>".$pinfo1[1];
			$pinfo1 = explode("<br />", $pinfo);
			$pinfo = $pinfo1[0];
		}
		
		$pinfo = str_replace('class="e"', 'style="background-color: #ccccff; font-weight: bold; color: #000000;border: 1px solid #000000; font-size: 75%; vertical-align: baseline;"', $pinfo);
		$pinfo = str_replace('class="v"', 'style="background-color: #cccccc; color: #000000;border: 1px solid #000000; font-size: 75%; vertical-align: baseline;"', $pinfo);
		$pinfo = str_replace('<table ', '<table style="border-collapse: collapse;font-family: sans-serif;" ', $pinfo);

		$this->mSmarty->assign("content","<a href=\"$linktarget\">Toggle all/variables</a>".$pinfo);
	}
}
