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
if (!file_exists("/etc/samba/smb.conf")) {
    die("<br><br><br>Samba not installed. Please install Samba to use this page.");
}
?>

	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">SMB Shares & Configurations<small><a href="#"><div onClick="pageLoad('Samba');" class="fa fa-refresh rotate"></div></a> <br> This page is currently broken.</small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<button class="btn btn-raised btn-info" onClick="smbSave()">Add New Share</button>
    	</div>
    </div>
    <br />
    <div class="row">
    	<div class="col-lg-12">
    		<!--<textarea rows="20" class="form-control" id="rpiConfigFile">
    			<?php
                    $smb_s = shell_exec("sudo cat /etc/samba/smb.conf 2>&1");
                    echo $smb_s;
                ?>
    		</textarea>-->

    		<?php
            //Attempt to parse smb ini file so we can put it in a table :D
            $smb = parse_ini_string($smb_s, true);
            echo'<table class="table" title="'.$item.'">
    			<thead>
    				<th>Share Name</th>
    				<th>&nbsp;</th>
    			</thead>
    			';
            foreach ($smb as $item) {
                echo '<tr><td style="vertical-align: middle;">'.current($item).'</td><td><small><button class="btn btn-sm btn-raised btn-info" onclick="smbGet(\''.current($item).'\')">Edit Options</button>&nbsp;&nbsp;<button class="btn btn-sm btn-raised btn-warning">Remove Share / Config</button></small></td></tr>';
            }
            echo'</table>';
            ?>
    	</div>
    </div>
