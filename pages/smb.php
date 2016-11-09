<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
if(!file_exists("/etc/samba/smb.conf")){
	die("<br><br><br>Samba not installed.");
}
echo '';
?>
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">SMB Share Config Editor<small><a href="#"><div onClick="pageLoad('Samba');" class="fa fa-refresh rotate"></div></a> </small></h1>
            <p>Note:</p><p>You must restart the samba service when finished editing this file.</p>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<button class="btn btn-raised btn-info" onClick="smbSave()">Save Changes</button>
    	</div>
    </div>
    <br />
    <div class="row">
    	<div class="col-lg-12">
    		<textarea rows="20" class="form-control" id="rpiConfigFile"><?php
    				echo shell_exec("sudo cat /etc/samba/smb.conf 2>&1");
    			?>
    		</textarea>
    	</div>
    </div>