<?php
//Check for valid session:
session_start();
include('functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
switch($_POST['power']){
	case "reboot":
		$result = shell_exec("sudo reboot");
		break;
	case "shutdown":
		$result = shell_exec("sudo shutdown now");
		break;
	case "halt":
		$result = shell_exec("sudo halt");
		break;
	
	default:
		echo "NO.";
		break;
}
if(isset($result)){
	echo $result;
}

?>