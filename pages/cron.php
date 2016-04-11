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
            <h1 class="page-header">Cron Configuration <small><a href="#"><div onClick="pageLoad('cron');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<button class="btn btn-raised btn-info">Save Changes</button>
    	</div>
    </div>
    <br />
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table">
    			<thead>
    				<th>Job Command</th>
    				<th>Job Timer</th>
    			</thead>
    		<?php
    			$crontab_file = shell_exec("sudo cat /etc/crontab 2>&1");
    			$crontab = explode("\n",$crontab_file);
    			foreach($crontab as $cronjob){
    				$pos = strpos($cronjob, "#");
    				if($cronjob != "" || $cronjob != " "){
    					if($pos === false){
    						$pos1 = strpos($cronjob, 'SHELL=/bin/sh');
    						$pos2 = strpos($cronjob, 'PATH=');
    						if($pos1 === false && $pos2 === false){
    							$job = explode("\t", $cronjob);
    							$command = $job[3];
    							$time1 = $job[0];
    							$time2 = $job[1];
    							if($command != ""){
    								echo "<tr><td>$command</td><td>$time1 $time2</td></tr>";
    							}
    						}
    					}
    				}
    				
    			}
    		?>
    		</table>
    	</div>
    </div>