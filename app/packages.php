<?php
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
switch($_POST['type']){
	case "update":
		update();
		break;
	case "upgrade":
		upgrade();
		break;
	default:
		echo "Error";
		break;
}

function update(){
	ob_start(); 
	set_time_limit(0); 

	while (@ ob_end_flush()); // end all output buffers if any
	$proc = popen("sudo bash ./scripts/updates_get.sh 2>&1", 'r');
	
	echo '<div class="row"><div class="col-lg-12"><pre>';
	while (!feof($proc))
	{
    	echo fread($proc, 1024);
    	@ ob_flush();
    	@ flush();
	}
	echo '</pre></div></div>';
	echo '';
	?>
	<button class="btn btn-raised btn-success" onClick="pageLoad('packages');">Back to Package Updates</button>
	<?php
}

function upgrade(){
	ob_start(); 
	set_time_limit(0); 

	while (@ ob_end_flush()); // end all output buffers if any
	$proc = popen("sudo apt-get upgrade -y 2>&1", 'r');
	
	echo '<div class="row"><div class="col-lg-12"><pre>';
	while (!feof($proc))
	{
    	echo fread($proc, 1024);
    	@ ob_flush();
    	@ flush();
	}
	echo '</pre></div></div>';
	echo '';
	?>
	<button class="btn btn-success" onClick="pageLoad('packages');">Back to Package Updates</button>
	<?php
	
	
}
?>
