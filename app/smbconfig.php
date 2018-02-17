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
switch ($_POST['func']) {
    case "get":
        getShareOption($_POST['share']);
        break;
    case "save":
        save($_POST['data']);
        break;
    default:
        die("No function for that!");
        break;
}


function getShareOption($share)
{
    $smb_s = shell_exec("sudo cat /etc/samba/smb.conf 2>&1");
    $smb = parse_ini_string($smb_s, true);
    foreach ($smb as $item) {
        if (current($item) == $share) {
            echo json_encode($item);
        }
    }
}

function save($data)
{
    die();
    $content = $_POST['content'];
    $currentDIR = realpath(dirname(__FILE__));

    file_put_contents("$currentDIR/tmp/smb.conf", $content);

    $newConfig = md5_file("$currentDIR/tmp/smb.conf");
    $oldConfig = md5_file("/etc/samba/smb.conf");
    $result = shell_exec("sudo cp $currentDIR/tmp/smb.conf /etc/samba/smb.conf 2>&1");
    $cConfig = md5_file("/etc/samba/smb.conf");
    if ($cConfig == $newConfig) {
        echo "<pre>Configuration save successfully! \nPlease restart the Samba service for changes to take affect.</pre>";
    } else {
        echo "<pre>Configuration failed! \nPlease check the file for any inconsistency\n\n\n".$result."</pre>";
    }
    unlink("$currentDIR/tmp/smb.conf");
}
