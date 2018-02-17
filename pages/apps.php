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
            <h1 class="page-header">Applications & Scripts <small><a href="#"><div onClick="pageLoad('apps');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<h3>Upload a script or executable:</h3>
				<form action="app/upload.php" method="post" enctype="multipart/form-data" target="uploadTarget" onsubmit="startUpload();" >
    				<p id="uploadProcess">Uploading...<br/><img src="img/loader.gif" /><br/></p>
    				<p id="uploadForm"><br/>
        				<label>
            				File: <input name="myfile" type="file" size="30" />
        				</label><Br />
        				<label>
            				<input type="submit" name="submitBtn" class="btn btn-raised btn-info" value="Upload" />
        				</label>
    				</p>
    				<iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
				</form>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<h3>List of Scripts & Executables on the server:</h3>
    		<small>Please note: scripts that daemonize will not work properly here!</small>
    		<?php
                echo '<table class="table">';
                echo '
    				<thead>
    					<th>File Name</th>
    					<th>Options</th>
    				</thead>
    			';
                $files1 = scandir("./app/scr_up");
                foreach ($files1 as $file) {
                    if ($file != ".." && $file != ".") {
                        echo '<tr><td style="vertical-align: middle;"><a onClick="runScript(\''.$file.'\');">'.$file.'</a></td><td><button onClick="delScript(\''.$file.'\')" class="btn btn-sm btn-raised btn-warning">Delete Script</button></td></tr>';
                    }
                }
            ?>
    	</div>
    </div>
