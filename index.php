<?php
error_reporting(E_ALL);
define("REQ", true);

// Load functions and DB connection
include_once("includes.php");

if(isset($_GET['action'])){
	if($_GET['action'] == "logout") registerlogout();
}

if(!checklogin()){
	// Login required
	include("login.php");
}
else{
	// User logged in
	if(!isset($_GET['page'])) $_GET['page'] = "home"; // Declare var/ PHP strict
	$smarty->assign("page", $_GET['page']);
	$smarty->assign("isadmin", isadmin());	

	switch ($_GET['page']) { // Switch between page modules
	case "users":
		
		break;
	case "servers":
		if(isadmin()){
			$includefile	=	"servers.php";
		} 
		else{
			// Not an admin
			$_GET['page'] 	= 	"home";
			$includefile	=	"control.php";
		}
		break;
	case "logs":
		if(isadmin()){
			$includefile	=	"logs.php";
		} 
		else{
			// Not an admin
			$_GET['page'] 	= 	"home";
			$includefile	=	"control.php";
		}
		break;

	default:
		// Load home page
		$_GET['page'] 	= 	"home";
		$includefile	=	"control.php";
		
		break;
	}
	//include("theme/header.php");
	include($includefile);
	//include("theme/footer.php");
}
