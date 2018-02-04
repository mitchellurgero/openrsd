<?php if(!defined("OPENRSD")){die();} ?>
<?php
//Check for valid session:
if (!isset($_SESSION)) { session_start(); };
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}

$max_exec_time = ini_get('max_execution_time');
$inipath = php_ini_loaded_file();

$updates = shell_exec("sudo bash ./app/scripts/updates_list.sh");
$updates_array = explode("\n", $updates);
$updates_count = (count($updates_array) - 1);
// echo "\n<!-- \n".$updates."\n -->\n"; /* uncomment to debug updates list response */
?>

	<div class="row">
        <div class="col-lg-12">
<?php
        if ( $max_exec_time < 300 ) {
            echo "<h5><span class=\"label label-info\" > <span class=\"fa fa-info-circle\"></span> The processing time limit of PHP is ".$max_exec_time." seconds. This is too low, we suggest to <b>set it to 300</b>, it can be changed for example in <u>".$inipath."</u></span></h5>";
        }
?>
            <h1 class="page-header">Package Updates <small><a href="#"><div onClick="pageLoad('packages');" class="fa fa-refresh rotate"></div></a>  &nbsp;&nbsp;&nbsp;<button onClick="apt_update();" class="btn btn-raised btn-info">Get Updates</button> &nbsp;&nbsp;&nbsp;<button onClick="apt_upgrade();" class="btn btn-raised btn-<?php if($updates_count == 0){ echo "outline-"; } ?>warning" <?php if($updates_count == 0){ echo "disabled "; } ?>>Install Upgrades</button></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<?php
                        if($updates_count == 0){
    				echo "<p>There are currently no packages that need updating.</p>";
                        } else {
                                // Only print the table if updates available, this fixes "Undefined offset:" in the foreach loop
    			echo '<table class="table">';
    			?>
    			<thead>
    				<th>Package Name</th>
    				<th>Installed Version</th>
    				<th>New Version</th>
    			</thead>
    			<?php
    			foreach($updates_array as $upd){
    				$updAr = explode(" ", $upd);
    				$u_name = $updAr[0];
    				$u_installed = $updAr[2];
    				$u_new = $updAr[4];
    				echo '<tr><td>'.$u_name.'</td><td>'.$u_installed.'</td><td>'.$u_new.'</td></tr>'."\n";
    			}
    			echo '</table>';
                        }
    		?>
    	</div>
    </div>