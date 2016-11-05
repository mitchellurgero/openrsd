<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
echo '';
?>
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">OpenVPN Profiles <small><a href="#"><div onClick="pageLoad('openvpn');" class="fa fa-refresh rotate"></div></a></small></h1>
	    <small>This page only works with <a href="http://pivpn.io" target="_blank">pivpn.io</a></small>
		<br />
		<button class="btn btn-sm btn-raised btn-info" onclick="createProfile()">Create VPN Profile</button>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-6">
    		<table class="table">
    			<thead>
    				<th>OpenVPN Client Profile</th>
    			</thead>
    			<tbody>
    				<?php
    				$log_files = getDirContents('/home/pi/ovpns');
    				foreach($log_files as $log){
    					echo'<tr><td><a href="#" onClick="displayProfile(\''.$log.'\')">'.$log.'</a></td><td><button class="btn btn-sm btn-raised btn-warning" onclick="rProfile(\''.$log.'\')">Revoke Client</button></td></tr>';
    				}
    				?>
    			</tbody>
    		</table>
    	</div>
	<div class="col-lg-6">
		<table class="table">
    			<thead>
    				<th>OpenVPN Profile Status</th>
    			</thead>
		</table><br>
	<?php
	$profile_stats = shell_exec("pivpn list");
	echo "<pre>".$profile_stats."</pre>";
	?>
	</div>
    </div>
    <div class="row">
	<div class="col-lg-12">
		<table class="table">
    			<thead>
    				<th>OpenVPN Client List</th>
    			</thead>
		</table><br>
		<pre><?php echo shell_exec("sudo cat /var/log/openvpn-status.log"); ?></pre>
	</div>

    </div>
