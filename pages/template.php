<?php
//Check for valid session:
session_start();
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}

?>