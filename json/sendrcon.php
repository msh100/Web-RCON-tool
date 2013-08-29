<?php
// RCON handling nonsense
error_reporting(E_NONE); //dont ruin json
define("REQ", true);
include_once("../includes.php");

$command	=	$_GET['cmd'];
$ip		=	(int) ip2long($_SERVER['REMOTE_ADDR']);
$time	=	time();

if(checklogin()){ 

	if(isset($_GET['sid']) && is_numeric($_GET['sid']) && $_GET['sid'] > 0){
		$uid	=	(int) $_SESSION['uid'];
		$sid	=	(int) $_GET['sid'];
		
		$access	=	mysql_query("SELECT * FROM `user_access` WHERE `uid` = '$uid' AND `sid` = '$sid'");
		$access	=	mysql_fetch_array($access);
		
		if($access['fid'] == 0) $forbidden = false; // forbid nothing
		else{
			// check forbids
			$fid		=	$access['fid'];
			$forbids	=	mysql_query("SELECT * FROM `forbid_vals` WHERE `fid` = '$fid'");

			$commandspl	=	preg_split('/[" ;]/', strtolower($command));
			
			$forbidden	=	false;
			
			while($forbidrow = mysql_fetch_array($forbids)){
				foreach($commandspl as $cmd){
					if($cmd == $forbidrow['cmd']){
						$forbidden	=	true;
						$forbidon	=	mysql_real_escape_string($forbidrow['cmd']);					
					}
				}
			}
		}
		
		if($forbidden == true){
			$return['success']	=	false;
			$return['error']	=	"forbidden";
			$return['forbid']	=	$forbidon;
			$command	=	mysql_real_escape_string($command);
			
			mysql_query("INSERT INTO `logs` (`uid`, `logtype`, `ip`, `time`, `data`, `data2`) VALUES ('$uid', 'forbid', '$ip', '$time', '$forbidon', '$command')");
		}
		else if(strlen($command) < 1){
			$return['success']	=	false;
			$return['error']	=	"empty";
		}
		else{
			// run rcon
			$serverdata	=	mysql_query("SELECT * FROM `servers` WHERE `sid` = '$sid'");
			$serverdata	=	mysql_fetch_array($serverdata);
			$srvip			=	long2ip($serverdata['ip']);
			$port		=	$serverdata['port'];
			$rcon		=	$serverdata['rcon'];
			
			$return['rcon']	=	q3cols("^7".str_replace("\n","<br/>",rcon($srvip, $port, $rcon, $command)));
			$return['success']	=	true;
			$command	=	mysql_real_escape_string($command);
			$output		=	mysql_real_escape_string($return['rcon']);
			mysql_query("INSERT INTO `logs` (`uid`, `logtype`, `ip`, `time`, `data`, `data2`) VALUES ('$uid', 'rcon', '$ip', '$time', '$command', '$output')");
		}
	}
	else{
		$return['success']	=	false;
		$return['error']	=	"invalidsid";
	}
}
else{
	// Not Logged in
	$return['success']	=	false;
	$return['error']	=	"nologin";
}

echo json_encode($return);
?>