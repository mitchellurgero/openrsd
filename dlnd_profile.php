<?php
session_start();
if (isset($_SESSION['username']) && isset($_GET['filename'])) {
  $iuser = exec("sudo cat /etc/pivpn/INSTALL_USER");
  $file = '/home/'.$iuser.'/ovpns/'.$_GET['filename'];
  header('Content-type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.$_GET['filename'].'"');
  header('Content-length: ' . filesize($file));
  readfile($file);
} else {
	header("Location: ./index.php");
}

?>