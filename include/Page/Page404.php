<?php

class Page404 extends PageBase
{
	protected function runPage()
	{
		header("HTTP/1.0 404 Not Found");
		$this->mPageTitle = "404 Not Found";
		$this->mSmarty->assign("content", "Sorry, what you were looking for couldn't be found.");
	}
}
