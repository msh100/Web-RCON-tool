<?php
if(REQ !== true) die();
$uid	=	(int) $_SESSION['uid'];

$serveraccess	=	mysql_query("SELECT `servers`.`sid`, `servers`.`ip`, `servers`.`port`, `servers`.`type`, `servers`.`name` FROM `user_access` JOIN  `servers` ON `servers`.`sid` =  `user_access`.`sid` WHERE `uid` = '$uid'");
$access	=	array();

while($accessrow = mysql_fetch_array($serveraccess)){
	$access[$accessrow['sid']]	=	$accessrow;
}

$smarty->assign("access", $access);	
$smarty->assign("typeahead", $typeahead);	

$smarty->display("header.tpl");
$smarty->display("control.tpl");
$smarty->display("footer.tpl");