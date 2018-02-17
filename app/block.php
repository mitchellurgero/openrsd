<?php
//Check for valid session:
if (!isset($_SESSION)) {
    session_start();
};
if (basename(dirname(__FILE__)) == 'app') {
    require_once('functions.php');
};
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
if (isset($_POST['ip'])) {
    $ip = $_POST['ip'];
    $ip = str_replace(" ", "", $ip);
    $ip = str_replace("..", "", $ip);
    unlink("blocked_ip/$ip");
} else {
    die("That is not an ip address, or it does not exist in our records. Please try again.");
}
