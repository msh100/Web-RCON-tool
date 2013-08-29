<?php
if(REQ !== true) die();

if(!isset($_GET['action'])) $_GET['action'] = "list"; // Declare var/ PHP strict
switch ($_GET['action']) { // Switch between action modules
//	case "users":
		
//		break;

	default:
		// Load home page
		$_GET['action'] = "list";
		
		
		$serverlist	=	mysql_query("SELECT * FROM `servers`");
		while($row = mysql_fetch_array($serverlist)){
			$servers[]	=	$row; // Assemble server data array
		}
		include("theme/serverlist.php"); // Require server list
		
		$forbidlist	=	mysql_query("SELECT * FROM `forbid`");
		while($row = mysql_fetch_array($forbidlist)){
			$fid			=	(int) $row['fid'];
			$forbids[$fid]	=	$row;
			$forbidvals		=	mysql_query("SELECT * FROM `forbid_vals` WHERE `fid` = '$fid'");
			while($forbidval = mysql_fetch_array($forbidvals)){
				$forbids[$fid]['vals'][]	=	$forbidval['cmd'];
			}
		}
		
		include("theme/forbidlist.php"); // Require forbid list
		
		break;
}












?>