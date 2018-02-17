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
            <h1 class="page-header">Network Config <small><a href="#"><div onClick="pageLoad('network');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-6">
    		<table class="table">
    			<thead>
    				<th>Adapter</th>
    				<th>IP Address</th>
    			</thead>
    			<?php
                                $adapters = OpenRSD::getNetworkInterfaces();
                                foreach ($adapters['if_array'] as $dev) {
                                    if ($dev['ip_dev'] != "") {
                                        echo "<tr><td>".$dev['ip_dev']."</td><td>".$dev['ip_addr']."</td></tr>\n";
                                    }
                                }
                ?>
    		</table>
    	</div>
    </div>
