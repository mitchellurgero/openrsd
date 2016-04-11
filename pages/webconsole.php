<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
echo '';
?>
<div id="frame">
    <iframe src="pages/web-console.php">
	    Your browser does not support inline frames.
    </iframe>
</div>