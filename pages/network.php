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
            <h1 class="page-header">Network Config <small><a href="#"><div onClick="pageLoad('network');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table">
    			<thead>
    				<th>Adapter</th>
    				<th>IP Address</th>
    				<th>Options</th>
    			</thead>
    			<?php
    			$adapters_com = shell_exec("sudo bash ./app/scripts/adapters.sh");
    			$adapters = explode("\n", $adapters_com);
    			foreach($adapters as $dev){
    				if($dev != ""){
    					echo '<tr><td>'.$dev.'</td><td>'.getCurrentIP($dev).'</td><td>Options here at some point...</td></tr>';
    				}
    				
    			}
    			?>
    		</table>
    	</div>
    </div>