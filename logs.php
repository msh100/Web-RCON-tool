<?php
if(REQ !== true) die(); 

$userlist	=	mysql_query("SELECT uid, username FROM `users`");
while($user = mysql_fetch_array($userlist)){
	$users[]	=	$user;
}

$smarty->assign("users", $users);	
$smarty->assign("logperpage", $logperpage);	

$smarty->display("header.tpl");
$smarty->display("logs.tpl");
$smarty->display("footer.tpl");