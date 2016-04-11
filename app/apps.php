<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
//Run selected script, but only if it exists in the scr_up folder.
$script = $_POST['script'];
$script1 = str_replace(" ", "", $script);
$script2 = str_replace("..","",$script1);
$script = $script2;

$result = shell_exec("bash scr_up/".$script);

echo $result;
?>