<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
$file = $_POST['log'];
$result = htmlspecialchars(shell_exec("sudo cat $file"));
echo $result;
?>
