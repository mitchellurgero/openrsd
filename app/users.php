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

if (!isset($_POST['username'], $_POST['password'], $_POST['type'])) {
    die("Missing required parameters");
}

if (isset($_POST['username'])) {
    $username = escapeshellcmd(escapeshellarg($_POST['username']));
}
if (isset($_POST['password'])) {
    $password = escapeshellcmd(escapeshellarg($_POST['password']));
}
$type = $_POST['type'];

switch ($type) {
    case "add":
        adduser($username, $password);
        break;
    case "del":
        deluser($username);
        break;
    case "change":
        changePass($username, $password);
        break;
    default:
        die("Error");
        break;
}

function adduser($u, $p)
{
    $result = shell_exec("sudo useradd -m -p $p $u; echo $u; sudo adduser $u sudo");
    echo $result."\n";
    echo changePass($u, $p);
}
function deluser($u)
{
    if ($u == "pi") {
        die("You cannot delete this user, apache runs as this user.");
        return;
    }
    $result = shell_exec("sudo deluser --remove-home $u 2>&1");
    echo $result;
}
function changePass($u, $p)
{
    $result = change_password($u, $p);
    echo $result;
}
function change_password($user, $newpwd)
{

    // Open a handle to expect in write mode
    $p = popen('sudo /usr/bin/expect', 'w');

    // Log conversation for verification
    $log = './tmp/passwd_' . md5($user . time());
    $cmd .= "log_file -a \"$log\"; ";

    // Spawn a shell as $user
    $cmd .= "spawn /bin/bash; ";
    //$cmd .= "expect \"Password:\"; ";
    //$cmd .= "send \"$currpwd\\r\"; ";
    //$cmd .= "expect \"$user@\"; ";

    // Change the unix password
    $cmd .= "send \"sudo /usr/bin/passwd $user\\r\"; ";
    //$cmd .= "expect \"(current) UNIX password:\"; ";
    //$cmd .= "send \"$currpwd\\r\"; ";
    $cmd .= "expect \"Enter new UNIX password:\"; ";
    $cmd .= "send \"$newpwd\\r\"; ";
    $cmd .= "expect \"Retype new UNIX password:\"; ";
    $cmd .= "send \"$newpwd\\r\"; ";
    $cmd .= "expect \"passwd: password updated successfully\"; ";

    // Commit the command to expect & close
    fwrite($p, $cmd);
    pclose($p);

    // Read & delete the log
    $fp = fopen($log, r);
    $output = fread($fp, 2048);
    fclose($fp);
    unlink($log);
    print "Notification : $output ";
    $output = explode("\n", $output);


    return (trim($output[count($output)-2]) == 'passwd: password updated successfully') ? true : false;
}
