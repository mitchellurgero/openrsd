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
if (!isset($_POST['profile'])) {
    die("No profile name selected!");
}
$iuser = exec("sudo cat /etc/pivpn/INSTALL_USER");
$pro = $_POST['profile'];
$pro = str_replace("/home/$iuser/ovpns/", "", $pro);
$pro = str_replace(".ovpn", "", $pro);
revoke_vpn_profile($pro);
//Run selected script, but only if it exists in the scr_up folder.
function revoke_vpn_profile($profile)
{

    // Open a handle to expect in write mode
    $p = popen('sudo /usr/bin/expect', 'w');

    // Log conversation for verification
    $log = './tmp/passwd_' . md5($profile . time());
    $cmd .= "log_file -a \"$log\"; ";

    // Spawn a shell as $user
    $cmd .= "spawn /bin/bash; ";
    // Change the unix password
    $cmd .= "send \"pivpn revoke\\r\"; ";
    $cmd .= "expect \"Please enter the Name of the client to be revoked from the list above:\\r\"; ";
    $cmd .= "send \"$profile\\r\"; ";
    $cmd .= "expect \"Completed!\"; ";
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

    return $output;
}
