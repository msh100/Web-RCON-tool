<?php
if(REQ !== true) die();
$loginfail	=	false; // Declare var
if(isset($_POST['username'])){
	// Checking if form has been posted
	if(registerlogin($_POST['username'], $_POST['password'])){
		// Logged in
		$redirectto	=	"./";
		include("theme/redirect.php");
	}
	else{
		// Not logged in
		$loginfail	=	true;
		include("theme/login.php");
	}
}
else include("theme/login.php"); // Show login form
