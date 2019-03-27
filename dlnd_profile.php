<?php
if (!isset($_SESSION)) {
    session_start();
};
if (isset($_SESSION['username']) && isset($_GET['filename'])) {
    $filename = str_replace(array("..","/"),array("",""),$_GET['filename']);
    $iuser = exec("sudo cat /etc/pivpn/INSTALL_USER");
    $file = '/home/'.$iuser.'/ovpns/'.$filename;
    if(file_exists($file)){
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Content-length: ' . filesize($file));
        readfile($file);
    } else {
        die("Invalid filename!");
    }
} else {
    header("Location: ./index.php");
}
