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
            <h1 class="page-header">Cron Configuration <small><a href="#"><div onClick="pageLoad('cron');" class="fa fa-refresh rotate"></div></a></small></h1>
            <h4>Some of these cron jobs are system cron jobs, please be careful when deleting them!</h4>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<button class="btn btn-raised btn-info" data-toggle="modal" data-target="#cronModal" onclick="clearCron()">New Job</button>
    	</div>
    </div>
    <br />
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table">
    			<caption><h3>Daily Jobs</h3></caption>
    			<thead>
    				<th>Job Title</th>
    				<th>Options</th>
    			</thead>
    			<?php
                $files1 = scandir("/etc/cron.daily");
                foreach ($files1 as $file) {
                    if ($file != ".." && $file != "." && $file != ".placeholder" && $file != "apache2" && $file != "lighttpd" && $file != "apt" && $file != "apt-compat" && $file != "aptitude" && $file != "bsdmainutils" && $file != "cracklib-runtime" && $file != "dpkg" && $file != "logrotate" && $file != "man-db" && $file != "ntp" && $file != "passwd") {
                        echo '<tr><td style="vertical-align: middle;">'.$file.'</td><td><button onClick="cronEdit(\''.$file.'\',\'daily\')" class="btn btn-sm btn-raised btn-info">Edit Script</button>&nbsp;&nbsp;<button onClick="cronDelete(\''.$file.'\',\'daily\')" class="btn btn-sm btn-raised btn-warning">Delete Script</button></td></tr>';
                    }
                }
                ?>
    		</table>
    		<table class="table">
    			<caption><h3>Hourly Jobs</h3></caption>
    			<thead>
    				<th>Job Title</th>
    				<th>Options</th>
    			</thead>
    			<?php
                $files1 = scandir("/etc/cron.hourly");
                foreach ($files1 as $file) {
                    if ($file != ".." && $file != "." && $file != ".placeholder" && $file != "fake-hwclock") {
                        echo '<tr><td style="vertical-align: middle;">'.$file.'</td><td><button onClick="cronEdit(\''.$file.'\',\'hourly\')" class="btn btn-sm btn-raised btn-info">Edit Script</button>&nbsp;&nbsp;<button onClick="cronDelete(\''.$file.'\',\'hourly\')" class="btn btn-sm btn-raised btn-warning">Delete Script</button></td></tr>';
                    }
                }

                ?>
    		</table>
    		<table class="table">
    			<caption><h3>Monthly Jobs</h3></caption>
    			<thead>
    				<th>Job Title</th>
    				<th>Options</th>
    			</thead>
    			<?php
                $files1 = scandir("/etc/cron.monthly");
                foreach ($files1 as $file) {
                    if ($file != ".." && $file != "." && $file != ".placeholder" && $file != "apache2" && $file != "lighttpd" && $file != "apt" && $file != "apt-compat" && $file != "aptitude" && $file != "bsdmainutils" && $file != "cracklib-runtime" && $file != "dpkg" && $file != "logrotate" && $file != "man-db" && $file != "ntp" && $file != "passwd") {
                        echo '<tr><td style="vertical-align: middle;">'.$file.'</td><td><button onClick="cronEdit(\''.$file.'\',\'monthly\')" class="btn btn-sm btn-raised btn-info">Edit Script</button>&nbsp;&nbsp;<button onClick="cronDelete(\''.$file.'\',\'monthly\')" class="btn btn-sm btn-raised btn-warning">Delete Script</button></td></tr>';
                    }
                }

                ?>
    		</table>
    		<table class="table">
    			<caption><h3>Weekly Jobs</h3></caption>
    			<thead>
    				<th>Job Title</th>
    				<th>Options</th>
    			</thead>
    			<?php
                $files1 = scandir("/etc/cron.weekly");
                foreach ($files1 as $file) {
                    if ($file != ".." && $file != "." && $file != ".placeholder" && $file != "man-db") {
                        echo '<tr><td style="vertical-align: middle;">'.$file.'</td><td><button onClick="cronEdit(\''.$file.'\',\'weekly\')" class="btn btn-sm btn-raised btn-info">Edit Script</button>&nbsp;&nbsp;<button onClick="cronDelete(\''.$file.'\',\'weekly\')" class="btn btn-sm btn-raised btn-warning">Delete Script</button></td></tr>';
                    }
                }

                ?>
    		</table>
		<div class="modal" id="cronModal">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<h4 class="modal-title" id="cronHeader">New Cron Job</h4>
      			</div>
      			<div class="modal-body" id="cronBody">
        			<p>
        				<label for="cronNewName" class="sr-only">Job Name(No Spaces!)</label>
        					<input type="text" id="cronNewName" name="cronNewName" class="form-control" placeholder="Job Name(No Spaces!)" required><br />
        				<label for="cronType">Select list:</label>
        					<select class="form-control" id="cronType">
        						<option value="daily">Daily</option>
        						<option value="hourly">Hourly</option>
        						<option value="monthly">Monthly</option>
        						<option value="weekly">Weekly</option>
        					</select>

        				<label for="cronContent">Script Content:</label>
  							<textarea class="form-control" rows="5" id="cronContent">#!/bin/bash
echo "Script Content goes here!"
</textarea>

        			</p>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-raised btn-warning" data-dismiss="modal">Cancel</button>
        			<button type="button" class="btn btn-raised btn-primary" onClick="cronSave()">Save</button>
      			</div>
    			</div>
  			</div>
		</div>
    	</div>
    </div>
