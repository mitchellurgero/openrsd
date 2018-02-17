<?php if (!defined("OPENRSD")) {
    die();
}

//Check for valid session:
if (!isset($_SESSION)) {
    session_start();
};
require_once('app/functions.php');
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
?>

	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Logs <small><a href="#"><div onClick="pageLoad('logs');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table">
    			<thead>
    				<th>Log file</th>
    			</thead>
    			<tbody>
    				<?php
                    $log_files = OpenRSD::getDirContents('/var/log');
                    foreach ($log_files as $log) {
                        echo'<tr><td><a href="#" onClick="displayLog(\''.$log.'\')">'.$log.'</a></td></tr>';
                    }
                    $log_files = OpenRSD::getDirContents('app/auth_log');
                    foreach ($log_files as $log) {
                        echo'<tr><td><a href="#" onClick="displayLog(\''.$log.'\')">'.$log.'</a></td></tr>';
                    }
                    ?>
    			</tbody>
    		</table>
    	</div>
    </div>
