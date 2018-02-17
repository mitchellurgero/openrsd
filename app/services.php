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

switch ($_POST['type']) {
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

function restart($service)
{
    $result = shell_exec("sudo service $service restart 2>&1");
    echo "<pre>".$result."\n".shell_exec("sudo service $service status")."</pre>";
}
function stop($service)
{
    $result = shell_exec("sudo service $service stop 2>&1");
    echo "<pre>".$result."\n".shell_exec("sudo service $service status")."</pre>";
}
function start($service)
{
    $result = shell_exec("sudo service $service start 2>&1");
    echo "<pre>".$result."\n".shell_exec("sudo service $service status")."</pre>";
}
