<?php

if(REQ !== true) die(); // Script can not be loaded directly


// Smarty
define('THEME_DIR', dirname(__FILE__)."/theme" );
include_once(THEME_DIR . '/libs/Smarty.class.php');
$smarty = new Smarty();

// Determine theme, for now just default
$themename	=	"default";

$smarty->setTemplateDir(THEME_DIR . '/templates/'.$themename.'/');
$smarty->setCompileDir(THEME_DIR . '/templates_c/');
$smarty->setConfigDir(THEME_DIR . '/configs/');
$smarty->setCacheDir(THEME_DIR . '/cache/');

include_once("db.php");

$link = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($db);

session_start();

include_once("q3cols.php"); // Include Quake3 colours

$logperpage	=	20;

$typeahead[]	=	"say ";
$typeahead[]	=	"status";
$typeahead[]	=	"map ";
$typeahead[]	=	"devmap ";
$typeahead[]	=	"cj_promote ";
$typeahead[]	=	"cj_demote ";
$typeahead[]	=	"punish ";
$typeahead[]	=	"cj_soviet_promote ";

function rcon($ip, $port, $rcon_pass, $command){ // Function for running RCON commands
    $fp = fsockopen("udp://$ip",$port, $errno, $errstr, 2);
    stream_set_timeout($fp,0,300000);

    if (!$fp)    {
        echo "$errstr ($errno)<br>\n";
    } else {
        $query = "\xFF\xFF\xFF\xFFrcon \"" . $rcon_pass . "\" " . $command;
        fwrite($fp,$query);
    }
    $data = '';
    while ($d = fread ($fp, 100)) {
        $data .= $d;
    }
    fclose ($fp);
    $data = preg_replace ("/....print\n/", "", $data);

    return $data;
}

function checklogin(){ // Function to check user is logged in
	global $link; // Scope SQL socket
	
	if(isset($_SESSION['uid'])){
		$uid	=	(int) $_SESSION['uid'];
		$ip		=	(int) ip2long($_SERVER['REMOTE_ADDR']);
		$query	=	mysql_query("SELECT * FROM `ips` WHERE `uid` = '$uid' AND `ip` = '$ip'");

		if(mysql_num_rows($query) == 1){			
			$checkrows	=	mysql_query("SELECT suspended FROM `users` WHERE `uid` = '$uid'", $link);
			$querydata	=	mysql_fetch_array($checkrows);
			if($querydata['suspended'] == "1"){
				usersuspended();
			}
			
			return true;
		}
		else return false;
	}
	else return false;
}

function registerlogin($user, $pass){
	global $link; // Scope SQL socket
	
	// Escape quotes - anti SQL injection
	$user	=	mysql_real_escape_string($user);
	$pass	=	mysql_real_escape_string(md5($pass));
	$time	=	(int) time();

	// Check user and pass are correct
	$checkrows	=	mysql_query("SELECT uid, suspended FROM `users` WHERE `username` = '$user' AND `password` = '$pass'", $link);
	
	if(mysql_num_rows($checkrows) == 1){
		// User exists with this pass
		$userdata			=	mysql_fetch_array($checkrows);
		$_SESSION['uid']	=	(int) $userdata['uid'];
		
		// Check if IP has been used before by user
		$ip		=	(int) ip2long($_SERVER['REMOTE_ADDR']);
		$query	=	mysql_query("SELECT * FROM `ips` WHERE `uid` = '". $_SESSION['uid'] ."' AND `ip` = '$ip'");
		
		if(mysql_num_rows($query) == 1){
			// Update last login
			mysql_query("UPDATE `ips` SET `last` = '$time' WHERE `uid` = '". $_SESSION['uid'] ."' AND `ip` = '$ip'");
		}
		else{
			// Insert IP Record
			mysql_query("INSERT INTO `ips` (`uid`, `ip`, `first`, `last`) VALUES ('". $_SESSION['uid'] ."', '$ip', '$time', '$time')");
		}
		
		if($userdata['suspended'] == "1"){
			usersuspended();
		}
		
		return true; // User logged in
	}
	else return false; // User/pass combo incorrect
}

function registerlogout(){
	unset($_SESSION['uid']);
}

function ip2country($ip){
	global $link; // Scope SQL socket

	if(!is_numeric($ip)) $ip = (int) ip2long($ip); // Convert IP to Long
	else $ip = (int) $ip; // ensure datatype
	
	$row	=	mysql_query("SELECT ccode FROM `geoip` WHERE `longstart` < '$ip' AND `longend` > '$ip'");
	$row	=	mysql_fetch_array($row);
	return $row['ccode'];
}

function isadmin(){
	global $link; // Scope SQL socket

	$uid	=	(int) $_SESSION['uid'];
	if($uid < 1) return false;
	else{
		$data	=	mysql_query("SELECT access FROM `users` WHERE `uid` = '$uid'");
		$data	=	mysql_fetch_array($data);
		if($data['access'] == 1) return true;
		else return false;
	}
}

function usersuspended(){
	include("suspended.php");
	die();	
}

?>
