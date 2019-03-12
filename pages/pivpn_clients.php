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
    </div>
    <div class="row">
    	<div class="col-lg-6">
    		<table class="table" id="ConnClients">
    			<thead>
    				<th>OpenVPN Connected Clients</th>
                </thead>
                <div id="resultClients"><?php echo '<!--'.shell_exec("sudo cat /var/log/openvpn-status.log").'-->'; ?></div>
			</table><br>
	    </div>
    </div>
    <div class="row">
	<div class="col-lg-12">

	</div>

    </div>