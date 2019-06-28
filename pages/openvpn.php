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
            <h1 class="page-header">PiVPN Profiles <small><a href="#"><div onClick="pageLoad('PiVPN');" class="fa fa-refresh rotate"></div></a></small></h1>
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
                    //Copied and modified from log.php :) why rewrite the wheel?? :D
                    $iuser = exec("sudo cat /etc/pivpn/INSTALL_USER");
                    $log_files = OpenRSD::getDirContents('/home/'.$iuser.'/ovpns');
                    foreach ($log_files as $log) {
                        $f = explode("/", $log);
                        $file = end($f);
                        echo'<tr><td style="vertical-align: middle;"><a href="#" onClick="displayProfile(\''.$log.'\')">'.$log.'</a></td><td><button class="btn btn-sm btn-raised btn-warning" onclick="rProfile(\''.$log.'\')">Revoke Client</button></td><td><a href="dlnd_profile.php?filename='.$file.'" class="btn btn-sm btn-raised btn-info">Download</a></td></tr>';
                    }
                    ?>
    			</tbody>
    		</table>
    		<h3>PiVPN Client List (OpenVPN)</h3>
    		<table class="table">
    			<thead>
    				<th>Client Name</th>
    				<th>Client IP Address</th>
    			</thead>
    			<tbody>
    			<?php
    			$pivpnClientList = array();
				exec("sudo cat /var/log/openvpn-status.log", $pivpnClientList);
				foreach($pivpnClientList as $line){
					if(substr($line, 0, 11) === "CLIENT_LIST"){
						$l = explode("\t", $line);
						echo "<tr><td>".$l[1]."</td><td>".$l[3]."</td></tr>";
					}
				}
    			?>
    			</tbody>
			</table><br>
			<p>Debug output for troubleshooting (openvpn-status.log, for more logs, go to the Log page.):</p>
			<?php
			
			//Test output
			echo "<pre>".implode($pivpnClientList, "\r\n")."</pre>";
			?>
	    </div>
	<div class="col-lg-6">
		<table class="table">
    			<thead>
    				<th>OpenVPN Profile Status</th>
    			</thead>
		</table>
	<?php
    $profile_stats = shell_exec("pivpn list");
    echo "<pre>".$profile_stats."</pre>";
    ?>
	</div>
    </div>
    <div class="row">
	<div class="col-lg-12">

	</div>

    </div>
