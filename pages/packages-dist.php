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

$max_exec_time = ini_get('max_execution_time');
$inipath = php_ini_loaded_file();

$aptupdates = OpenRSD::getPackageDistUpdates();
$updates_count = $aptupdates['count'];
$installs_count = $aptupdates['newcount'];
$removes_count = $aptupdates['rmcount'];
$updates_array = $aptupdates['array'];
$installs_array = $aptupdates['instarray'];
$removes_array = $aptupdates['rmarray'];
// echo "\n<!-- \n".print_r($aptupdates,true)."\n -->\n"; /* uncomment to debug updates list response */
?>

	<div class="row">
        <div class="col-lg-12">
<?php
        if ($max_exec_time < 300) {
            echo "<h5><span class=\"label label-info\" > <span class=\"fa fa-info-circle\"></span> The processing time limit of PHP is ".$max_exec_time." seconds. This is too low, we suggest to <b>set it to 300</b>, it can be changed for example in <u>".$inipath."</u></span></h5>";
        }
?>
<?php
            echo "<h5><span class=\"label label-danger\" > <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> The Dist-Upgrade process contains the installation of new packages, and removal of conflicting or unnecessary packages.</span></h5>";
?>
            <h1 class="page-header">Dist-Upgrades <small><a href="#"><div onClick="pageLoad('packagesdist');" class="fa fa-refresh rotate"></div></a>  &nbsp;&nbsp;&nbsp;<button onClick="apt_update();" class="btn btn-raised btn-info">Get Updates</button> &nbsp;&nbsp;&nbsp;<button onClick="apt_distupgrade();" class="btn btn-raised btn-<?php if (($updates_count == 0)  && ($installs_count == 0) && ($removes_count == 0)) {
    echo "outline-";
} ?>danger" <?php if (($updates_count == 0) && ($installs_count == 0) && ($removes_count == 0)) {
    echo "disabled ";
} ?>>Install Dist-Upgrades</button></small></h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<?php
                        if ($updates_count == 0) {
                            echo "<p>There are currently no packages that need updating.</p>";
                            $updates_summary = $aptupdates['updsum_arr'][0];
                            //echo "\n<!-- \n".print_r($updates_summary,true)."\n -->\n"; /* uncomment to debug updates list response */
                            echo '<p>'.$updates_summary['cnt_upg'].' upgraded, '.$updates_summary['cnt_new'].' newly installed, '.$updates_summary['cnt_rem'].' to remove and '.$updates_summary['cnt_notup'].' not upgraded.'."</p>\n";
                        } else {
                            // Only print the table if updates available, this fixes "Undefined offset:" in the foreach loop
                            $updates_summary = $aptupdates['updsum_arr'][0];
                            //echo "\n<!-- \n".print_r($updates_summary,true)."\n -->\n"; /* uncomment to debug updates list response */
                            echo '<p>'.$updates_summary['cnt_upg'].' upgraded, '.$updates_summary['cnt_new'].' newly installed, '.$updates_summary['cnt_rem'].' to remove and '.$updates_summary['cnt_notup'].' not upgraded.'."</p>\n";
            echo "<h5><span class=\"label label-danger\" > <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> Please review carefully the table below before starting the Dist-Upgrade</span></h5>";

                            echo '<table class="table">'; ?>
    			<thead>
    				<th>Package Name</th>
    				<th>Installed Version</th>
    				<th>New Version</th>
    			</thead>
    			<?php
                foreach ($updates_array as $upd) {
                    $u_name = $upd['u_name'];
                    $u_installed = $upd['u_installed'];
                    $u_new = $upd['u_new'];
                    echo '<tr><td>'.$u_name.'</td><td>'.$u_installed.'</td><td>'.$u_new.'</td></tr>'."\n";
                }
    		    echo "<tr><th>New Package</th><th>New Version</th><th>&nbsp;</th></tr>\n";
                foreach ($installs_array as $instd) {
                    $i_name = $instd['i_name'];
                    $i_new = $instd['i_new'];
                    echo '<tr><td>'.$i_name.'</td><td>'.$i_new.'</td><td>installed</td></tr>'."\n";
                }
    		    echo "<tr><th>Removed Package</th><th>Removed Version</th><th>&nbsp;</th></tr>\n";
                foreach ($removes_array as $rmd) {
                    $r_name = $rmd['r_name'];
                    $r_installed = $rmd['r_installed'];
                    echo '<tr><td>'.$r_name.'</td><td>'.$r_installed.'</td><td>removed</td></tr>'."\n";
                }
                            echo '</table>';
                        }
            ?>
    	</div>
    </div>
