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
if ($_POST['type'] == "delete") {
    $ac = $_POST['type2'];
    $name1 = $_POST['name2'];
    $result = shell_exec("sudo rm -f /etc/cron.$ac/$name1");
    if ($result == "" || $result == "\n") {
        echo "Cron Job deleted successfully!";
    } else {
        echo $result;
    }
    die();
}
if ($_POST['type'] == "edit") {
    $ac = $_POST['type2'];
    $name1 = $_POST['name2'];
    if (!file_exists("/etc/cron.$ac/$name1")) {
        die("Cron job no longer exists!");
    }
    $result = shell_exec("sudo cat /etc/cron.$ac/$name1");
    if ($result == "" || $result == "\n") {
        echo "Cron Job does not exist!";
    } else {
        echo $result;
    }
    die();
}
$cron_content = $_POST['content'];
$type = $_POST['type'];
$name = $_POST['name'];
if ($name == "") {
    die("The name must contain SOMETHING.");
}
$name = str_replace(" ", "", $name);
switch ($type) {
    case "daily":
        daily($cron_content, $name);
        break;
    case "hourly":
        hourly($cron_content, $name);
        break;
    case "monthly":
        monthly($cron_content, $name);
        break;
    case "weekly":
        weekly($cron_content, $name);
        break;
    default:
        echo "That is not a proper option!";
        break;
}

function daily($content, $name)
{
    $currentDIR = realpath(dirname(__FILE__));
    file_put_contents("$currentDIR/tmp/$name", $content);
    $result = shell_exec("sudo cp $currentDIR/tmp/$name /etc/cron.daily/$name 2>&1");
    if ($result == "" || $result == "\n") {
        echo "Cron Job made successfully!";
    } else {
        echo $result;
    }
    unlink("$currentDIR/tmp/$name");
}
function hourly($content, $name)
{
    $currentDIR = realpath(dirname(__FILE__));
    file_put_contents("$currentDIR/tmp/$name", $content);
    $result = shell_exec("sudo cp $currentDIR/tmp/$name /etc/cron.hourly/$name 2>&1");
    if ($result == "" || $result == "\n") {
        echo "Cron Job made successfully!";
    } else {
        echo $result;
    }
    unlink("$currentDIR/tmp/$name");
}
function monthly($content, $name)
{
    $currentDIR = realpath(dirname(__FILE__));
    file_put_contents("$currentDIR/tmp/$name", $content);
    $result = shell_exec("sudo cp $currentDIR/tmp/$name /etc/cron.monthly/$name 2>&1");
    if ($result == "" || $result == "\n") {
        echo "Cron Job made successfully!";
    } else {
        echo $result;
    }
    unlink("$currentDIR/tmp/$name");
}
function weekly($content, $name)
{
    $currentDIR = realpath(dirname(__FILE__));
    file_put_contents("$currentDIR/tmp/$name", $content);
    $result = shell_exec("sudo cp $currentDIR/tmp/$name /etc/cron.weekly/$name 2>&1");
    if ($result == "" || $result == "\n") {
        echo "Cron Job made successfully!";
    } else {
        echo $result;
    }
    unlink("$currentDIR/tmp/$name");
}
