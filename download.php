<?php
if (!isset($_SESSION)) {
    session_start();
};
if (isset($_SESSION['username']) && isset($_GET['filename'])) {
    $file = './app/scr_up/'.$_GET['filename'];
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$_GET['filename'].'"');
    header('Content-length: ' . filesize($file));
    readfile($file);
} else {
    header("Location: ./index.php");
}
