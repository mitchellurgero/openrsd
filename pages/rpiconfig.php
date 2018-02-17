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
            <h1 class="page-header">Raspi-Config Editor<small><a href="#"><div onClick="pageLoad('rpiconfig');" class="fa fa-refresh rotate"></div></a> </small></h1>
            <p>Note:</p><p>Editing this file can cause bootloops, please be careful when making edits.</p>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<button class="btn btn-raised btn-info" onClick="configSave()">Save Changes</button>
    	</div>
    </div>
    <br />
    <div class="row">
    	<div class="col-lg-12">
    		<textarea rows="20" class="form-control" id="rpiConfigFile"><?php
                    echo shell_exec("sudo cat /boot/config.txt 2>&1");
                ?>
    		</textarea>
    	</div>
    </div>
