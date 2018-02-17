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
//Run selected script, but only if it exists in the scr_up folder.
switch ($_POST['type']) {
    case "run":
        $script = $_POST['script'];
        $script1 = str_replace(" ", "", $script);
        $script2 = str_replace("..", "", $script1);
        $script = $script2;
        $result = shell_exec("bash scr_up/".$script);
        echo $result;
        break;
    case "delete":
        $script = $_POST['script'];
        $result = shell_exec("sudo rm -f scr_up/$script");
        if ($result == "" || $result == "\n") {
            echo "Script deleted successfully!";
        } else {
            echo $result;
        }
        break;
    default:
        echo "That function does not exisit!";
        break;
}
