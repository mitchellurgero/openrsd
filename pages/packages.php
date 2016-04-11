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
            <h1 class="page-header">Package Updates <small><a href="#"><div onClick="pageLoad('packages');" class="fa fa-refresh rotate"></div></a>  &nbsp;&nbsp;&nbsp;<button onClick="apt_update();" class="btn btn-raised btn-info">Get Updates</button> &nbsp;&nbsp;&nbsp;<button onClick="apt_upgrade();" class="btn btn-raised btn-warning">Install Upgrades</button></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<?php
    			$updates = shell_exec("sudo bash ./app/scripts/updates_list.sh");
    			//echo "<p>$updates</p>";
    			$updates_array = explode("\n", $updates);
    			if(count($updates_array) - 1 == 0){
    				echo "<p>There are currently no packages that need updating.</p>";
    			}
    			echo '<table class="table">';
    			echo '';
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
    		?>
    	</div>
    </div>