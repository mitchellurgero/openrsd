<?php
//Check for valid session:
if (!isset($_SESSION)) { session_start(); };
include('functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
switch($_POST['div']){
	case "uptime":
		echo getUptime();
		break;
	
	
	default:
		echo "DIV NOT FOUND.";
		break;
}


?>