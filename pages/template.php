<?php if (!defined("OPENRSD")) {
    die();
}

//Check for valid session:
if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
