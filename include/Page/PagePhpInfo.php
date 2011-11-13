<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PagePhpInfo extends PageBase
{
	protected function runPage()
	{
//		phpinfo(INFO_VARIABLES);

		ob_start();
		phpinfo(INFO_VARIABLES);
		$pinfo = ob_get_contents();
		ob_end_clean();

		$pinfo1 = explode("<h2>", $pinfo);
		$pinfo = "<h2>".$pinfo1[1];
		$pinfo1 = explode("<br />", $pinfo);
		$pinfo = $pinfo1[0];

		$pinfo = str_replace('class="e"', 'style="background-color: #ccccff; font-weight: bold; color: #000000;border: 1px solid #000000; font-size: 75%; vertical-align: baseline;"', $pinfo);
		$pinfo = str_replace('class="v"', 'style="background-color: #cccccc; color: #000000;border: 1px solid #000000; font-size: 75%; vertical-align: baseline;"', $pinfo);
		$pinfo = str_replace('<table ', '<table style="border-collapse: collapse;font-family: sans-serif;" ', $pinfo);

		$this->mSmarty->assign("content",$pinfo);
	}
}
