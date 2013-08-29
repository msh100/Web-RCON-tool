<?php
// RCON handling nonsense
error_reporting(E_NONE); //dont ruin json
define("REQ", true);
include_once("../includes.php");

if(checklogin() && isadmin()){ 
	// logged in as admin
	$page	=	(int) $_GET['page'];
	if($page > 0){
		$page	=	$page-1;
		$limit	=	"LIMIT ".($page * $logperpage).",".(($page * $logperpage)+$logperpage);
	}
	else $limit = "LIMIT $logperpage";
	
	$uid	=	(int) $_GET['uid'];
	if($uid > 0){
		$whereparam[] =	"`logs`.`uid` = '$uid'";
	}
	
	$showlog	=	(int) $_GET['level'];
	if($showlog == 2){
		$whereparam[]	=	"`logtype` = 'rcon'";
	}
	else if($showlog == 3){
		$whereparam[]	=	"`logtype` = 'forbid'";
	}
	
	if(count($whereparam) > 0) $where = "WHERE ".implode(" AND ", $whereparam);	

	$rows=	"SELECT * FROM `logs`
	JOIN `geoip` ON (`geoip`.`longstart` < `logs`.`ip` AND `geoip`.`longend` > `logs`.`ip`)
	JOIN `users` ON `users`.`uid` = `logs`.`uid` 
	$where ";
	$count	=	mysql_query($rows);
	$rows .= "ORDER BY `time` DESC $limit";
	$rows=	mysql_query($rows);
	
	while($row = mysql_fetch_assoc($rows)){
		$row['ccode']	=	strtolower($row['ccode']);
		$row['ip']		=	long2ip($row['ip']);
		$row['time']	=	date("H:i d/m/y", $row['time']);
		unset($row['password']);
		$output[]	=	$row;
	}
	$output['count']	=	mysql_num_rows($count);
	echo json_encode($output);
}
?>