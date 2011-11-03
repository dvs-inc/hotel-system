<?php

class PageMain extends PageBase
{
	protected function runPage()
	{
		ob_start();
		phpinfo();
		$pinfo = ob_get_contents();
		ob_end_clean();

		$this->mSmarty->assign("content",$pinfo);
	}
}
