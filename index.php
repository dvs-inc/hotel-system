<?php

include_once('smarty/Smarty.class.php');

$smarty = new Smarty();

$gScripts = array('scripts/jquery.slideViewerPro.1.5.js', 'scripts/jquery.timers-1.2.js', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');

$gStyles = array('style/svwp_style.css');

$smarty->assign("scripts",$gScripts);

$smarty->assign("styles",$gStyles);

$smarty->display("base.tpl");
