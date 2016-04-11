<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}

switch($_POST['type']){
	case "restart":
		restart($_POST['service']);
		break;
	case "start":
		start($_POST['service']);
		break;
	case "stop":
		stop($_POST['service']);
		break;
}

function restart($service){
	$result = shell_exec("sudo service $service restart");
	echo $result;
}
function stop($service){
	$result = shell_exec("sudo service $service stop");
	echo $result;
}
function start($service){
	$result = shell_exec("sudo service $service start");
	echo $result;
}
?>