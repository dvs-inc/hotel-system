<?php

include_once('smarty/Smarty.class.php');

$smarty = new Smarty();

//$smarty->assign("name", "simon walker");
//$smarty->assign("address", "Heriot-Watt University");

$smarty->display("base.tpl");
