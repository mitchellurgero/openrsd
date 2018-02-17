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
            <h1 class="page-header">Blocked IPs <small><a href="#"><div onClick="pageLoad('block');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="rows">
    	<div class="col-lg-12">
    		<table class="table">
    			<thead>
    				<th>IP Address</th>
    				<th>Origin Country</th>
    				<th>Options</th>
    			</thead>
    			<?php
                $files1 = scandir("app/blocked_ip");
                foreach ($files1 as $file) {
                    if ($file != "dummy" && $file != "." && $file != "..") {
                        $geolocate = shell_exec("geoiplookup $file");
                        $c = explode(":", $geolocate);
                        $country = $c[1];
                        if (strpos($c[1], "IP Address not found")) {
                            $country = "This might be a LAN ip address.";
                        }
                        echo '<tr><td style="vertical-align: middle;">'.$file.'</td><td style="vertical-align: middle;">'.$country.'</td><td><button class="btn btn-raised btn-default" onClick="unblock(\''.$file.'\')">Unblock</button></td></tr>';
                    }
                }
                ?>
    		</table>
    	</div>
    </div>
