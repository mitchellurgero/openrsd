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

$content = $_POST['content'];
$currentDIR = realpath(dirname(__FILE__));

file_put_contents("$currentDIR/tmp/config.txt", $content);

$newConfig = md5_file("$currentDIR/tmp/config.txt");
$oldConfig = md5_file("/boot/config.txt");
$result = shell_exec("sudo cp $currentDIR/tmp/config.txt /boot/config.txt 2>&1");
$cConfig = md5_file("/boot/config.txt");
if ($cConfig == $newConfig) {
    echo "<pre>Configuration save successfully! \nPlease reboot your RPi for changes to take affect!</pre>";
} else {
    echo "<pre>Configuration failed! \nPlease check the file for any inconsistency\n\n\n".$result."</pre>";
}
unlink("$currentDIR/tmp/config.txt");
