<?php

include_once('smarty/Smarty.class.php');

$smarty = new Smarty();

$gScripts = array();

$smarty->assign("scripts",$gScripts);

$smarty->display("base.tpl");
