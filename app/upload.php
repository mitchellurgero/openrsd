<?php
if (!isset($_SESSION)) {
    session_start();
};
require_once('functions.php');
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
    $success = 0;
    $uploadedFile = '';

    //File upload path
    $uploadPath = './scr_up/';
    $file = basename($_FILES['myfile']['name']);
    $wfile = str_replace("..", "", $file);
    $wfile = str_replace(" ", "", $file);
    $targetPath = $uploadPath . $wfile;

    if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $targetPath)) {
        $success = 1;
        $uploadedFile = $targetPath;
    }

    sleep(1);
?>
<script type="text/javascript">window.top.window.stopUpload(<?php echo $success; ?>,'<?php echo $uploadedFile; ?>');</script>

