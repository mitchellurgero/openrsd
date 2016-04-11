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
                    <h1 class="page-header">Dashboard <small><a href="#"><div onClick="pageLoad('dashboard');" class="fa fa-refresh rotate"></div></a></small></h1>
                </div>
            </div>
			<div class="row">
				<div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            CPU Usage
                        </div>
                        <div class="panel-body">
                            <p><?php echo getCPU(); ?> % <br /><br /></p>
                        </div>
                        <div class="panel-footer">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            RAM Usage
                        </div>
                        <div class="panel-body">
                            <p><?php echo getRAM(); ?></p>
                        </div>
                        <div class="panel-footer">
                            &nbsp;
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
                            	$adapters_com = shell_exec("sudo bash ./app/scripts/adapters.sh");
    							$adapters = explode("\n", $adapters_com);
    							foreach($adapters as $dev){
    								if($dev != ""){
    									echo '<tr><td>'.$dev.'</td><td>'.getCurrentIP($dev).'</tr>';
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
			<div class="row">
				<div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            Disk Usage
                        </div>
                        <div class="panel-body">
                            <p>
                            	<table class="table table-bordered">
                            		<thead>
                            			<th>Dev./Part.</th>
                            			<th>Free(MB)</th>
                            			<th>Total(MB)</th>
                            		</thead>
                            	<?php
                            	$dir = '/';
								$free = disk_free_space($dir);
								$total = disk_total_space($dir);
								$free_to_mbs = $free / (1024*1024);
								$total_to_mbs = $total / (1024*1024);
								echo '<tr><td>SDCard:</td><td>'.round($free_to_mbs, 2).'</td><td>'.round($total_to_mbs, 2).'</td></tr>';
                            	
                            	?>
                            	</table>
                            </p>
                        </div>
                        <div class="panel-footer">
                           &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            Updates
                        </div>
                        <div class="panel-body">
                            <p>
                            	<?php
                            	$updates = shell_exec("sudo bash ./app/scripts/updates_list.sh");
    							//echo "<p>$updates</p>";
    							$updates_array = explode("\n", $updates);
    							$count = count($updates_array) - 1; // -1 for the extra space that is output at the end of the script that is ran above.
    							if($count == 0){
    								echo "<p>There are currently no packages that need updating.</p>";
    							} else {
    								echo "<p>$count package(s) are ready to be updated.</p>";
    							}
                            	
                            	?>
                            </p>
                        </div>
                        <div class="panel-footer">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
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
                            	}
                            	foreach($result_who_new as $per){
                            		if(!$per == "" || !$per == null){
                            			$per_new = explode("\n", $per);
                            			echo "<td><tr>".$per_new[0]."</tr></td>";
                            		}
                            		
                            	}
                            	if(count($result_who_new) - 1 == 0){
	                            	// Nothing to see here.
                            	} else {
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

<?php



?>
