<?php if(!defined("OPENRSD")){die();} ?>
<?php
//Check for valid session:
if (!isset($_SESSION)) { session_start(); };
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
echo '';
?>
 			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard <small><a href="#"><div onClick="pageLoad('dashboard');" class="fa fa-refresh rotate"></div></a></small></h1>
                </div>
            </div>
			<div class="row">
				<div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            Pi Stats
                        </div>
                        <div class="panel-body">
                            <p><text style="font-size=12px" id="uptime"><?php echo getUptime(); ?></text></p>
                            <table class="table table-bordered table-responsive table-hover">
                                <thead>
                                        <th><b>CPU</b></th>
                                        <th><b>RAM</b></th>
                                </thead>
                            <tbody><tr>
                            <td><br />CPU Perf. = <?php echo getCPU(); ?>% <br />CPU Temp = <?php echo getCPUTemp();?><br /></td>
                            <td><br /><?php echo getRAM(); ?></td>
                            </tr></tbody>
                            </table>
                            <p>
                            	<b>Disk Usage</b><br />
                            	<table class="table table-bordered table-responsive table-hover">
                            		<thead>
                            			<th>Dev./Part.</th>
                            			<th>Free(MB)</th>
                            			<th>Total(MB)</th>
                            		</thead>
                            	<?php
                                $com = shell_exec("df -h  -h -t ext2 -t ext3 -t ext4 -t vfat -t xfs");
                            	$dr = explode("\n", $com);
                            	foreach($dr as $mount){
                            		$mt = explode(" ", $mount);
                            		$e = end($mt);
                            		if($e == "on" || $e == ""){
                            			continue;
                            		}
                            		$dir = $e;
									$free = disk_free_space($dir);
									$total = disk_total_space($dir);
									$free_to_mbs = $free / (1024*1024);
									$total_to_mbs = $total / (1024*1024);
									echo '<tr><td>'.$e.'</td><td>'.round($free_to_mbs, 2).'</td><td>'.round($total_to_mbs, 2).'</td></tr>';
                            	}
                            	
                            	
                            	?>
                            	</table>
                            </p>
                        </div>
                        <br>
                        <div class="panel-footer">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                	<div class="row">
                		<div class="panel panel-default">
	                        <div class="panel-heading">
	                            Updates
	                        </div>
	                        <div class="panel-body">
	                            <p>
	                            	<?php
                                                                $aptupdates = packageUpdates();
                                                                $updates_count = $aptupdates['count'];
                                                                if($updates_count == 0){
	    								echo "<p>There are currently no packages that need updating.</p>";
	    							} else {
                                                                        echo "<p>".$updates_count." package(s) are ready to be updated.</p>";
	    							}
	    							shell_exec("git branch --set-upstream-to=origin/master master");
	                            	$c = htmlspecialchars(shell_exec("git fetch && git status"));
						    		if (strpos($c, 'no changes added to commit') !== false) {
                                                                        $ccount = preg_match_all('/modified:   (?<c_src>[\w\.\/]+)/', $c, $cmatch, PREG_SET_ORDER);
                                                                        echo '<p>You modified '.$ccount.' OpenRSD files:</p><ul>';
                                                                        foreach( $cmatch as $cfile ){
                                                                                echo '<li>'.$cfile['c_src'].'</li>';
                                                                        }
                                                                        echo '</ul><p>We cannot update this. Please reinstall!</p>';
									}elseif (strpos($c, 'behind') !== false) {
						    			echo '<p>An update for OpenRSD available!</p>';
									} elseif (strpos($c, 'up-to-date') !== false) {
										echo '<p>OpenRSD is completely up to date!</p>';
									} else {
										echo '<p> There was an error checking for OepnRSD updates.<p>';
									}
									echo '<b>Installed Version: '.VERSHORT;
	                            	?>
	                            </p>
	                        </div>
	                        <div class="panel-footer">
	                            &nbsp;
	                        </div>
	                    </div>
                	</div>
                	<div class="row">
                		<div class="panel panel-default">
	                        <div class="panel-heading">
	                            Logged in users
	                        </div>
	                        <div class="panel-body">
	                            <p>
	                            	
	                            	<?php
	                            	$result_who = shell_exec("sudo who");
	                            	$result_who_new = explode("\n", $result_who);
	                            	if(count($result_who_new) - 1 == 0){
	                            		echo '<p>There are no users logged into console, rdp, or ssh.</p>';
	                            	} else {
	                            		echo '<table class="table">';
	                            		foreach(array_filter($result_who_new) as $per){
	                            			if(!$per == "" && !$per == null){
		                            			$per_new = explode(" ", $per); //Maybe to clean up table, for now we will display all the information.
	                            				echo "<tr><td>".$per."</td></tr>";
	                            			}
		                            	}
		                            	echo '</table>';
	                            	}
	                            	?>
	                            	
	                            </p>
	                        </div>
	                        <div class="panel-footer">
	                            &nbsp;
	                        </div>
	                    </div>
                	</div>
                </div>
                <div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            Network Adapters
                        </div>
                        <div class="panel-body">
                            <table class="table">
                            	<?php
                                $adapters = getNetworkInterfaces();
                                foreach($adapters['if_array'] as $dev){
                                        if($dev['ip_dev'] != ""){
                                                echo '<tr><td>'.$dev['ip_dev'].'</td><td>'.$dev['ip_addr'].'</tr>';
    								}
    							}
                            	?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            &nbsp;
                        </div>
                    </div>
                </div>
			</div>
<?php



?>
