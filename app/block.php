<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
if(isset($_POST['ip'])){
	$ip = $_POST['ip'];
	$ip = str_replace(" ","", $ip);
	$ip = str_replace("..","",$ip);
	unlink("blocked_ip/$ip");
} else {
	die("That is not an ip address, or it does not exist in our records. Please try again.");
}



?>