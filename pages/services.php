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
            <h1 class="page-header">Services <small><a href="#"><div onClick="pageLoad('services');" class="fa fa-refresh rotate"></div></a></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12 text-center">
    		<p>Not all services can be interacted with from this interface, for most things, you will need to login via console, or SSH to interact with these services.</p>
    	</div>
    	<div class="col-lg-8 col-lg-offset-2">
    		<table class="table">
    			<thead>
    				<th>Service Name</th>
    				<th>Status</th>
    				<th>Options</th>
    			</thead>
    			<?php
                $services = shell_exec("sudo service --status-all");
                $ser = explode("\n", $services);
                foreach ($ser as $s) {
                    if (strlen($s) > 0) {
                        $s_name = explode(" ", $s);
                    } else {
                        continue;
                    }
                    $pos_true = strpos("+", $s_name[2]);
                    $pos_false = strpos("-", $s_name[2]);
                    $active;
                    $action;
                    $button;
                    if ($pos_true === false) {
                        $active = '<span style="color:red;">Stopped</span>';
                        $action = "'start'";
                        $action2 = "start";
                    } else {
                        $active = '<span style="color:green;">Running</span>';
                        $action = "'stop'";
                        $action2 = "stop";
                    }
                    if ($s != "") {
                        //$action = "restart";
                        if ($s_name[5] == "apache2" || $s_name[5] == "ssh" || $s_name[5] == "xrdp" || $s_name[5] == "networking" || $s_name[5] == "nginx" || $s_name[5] == "lighttpd" || $s_name[5] == "php7.0-fpm") {
                            $sname = $s_name[5];
                            $name = "'$sname'";
                            $button = '<button class="btn btn-sm btn-raised btn-warning" onClick="serviceAction('.$name.',\'restart\');">Restart</button>';
                        } else {
                            $sname = $s_name[5];
                            $name = "'$sname'";
                            $button = '<button class="btn btn-sm btn-raised btn-warning" onClick="serviceAction('.$name.',\'restart\');">Restart</button>&nbsp;&nbsp;<button class="btn btn-sm btn-raised btn-warning" onClick="serviceAction('.$name.','.$action.');">'.ucfirst($action2).'</button>';
                        }
                        echo '<tr><td style="vertical-align: middle;">'.$s_name[5].'</td><td style="vertical-align: middle;">'.$active.'</td><td>'.$button.'</td></tr>';
                    }
                }
                ?>
    		</table>
    	</div>
    </div>
