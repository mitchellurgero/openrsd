<?php
//Check for valid session:
if (!isset($_SESSION)) {
    session_start();
};
require_once('functions.php');
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
switch ($_POST['div']) {
    case "uptime":
        echo OpenRSD::getUptime();
        break;
    default:
        echo "DIV NOT FOUND.";
        break;
}
