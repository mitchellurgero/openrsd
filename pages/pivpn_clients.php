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
            <h1 class="page-header">PiVPN Profiles <small><a href="#"><div onClick="pageLoad('PiVPN');" class="fa fa-refresh rotate"></div></a></small></h1>
	    <small>This page only works with <a href="http://pivpn.io" target="_blank">pivpn.io</a></small>
		<br />
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table" id="ConnClients">
    			<thead>
    				<th>OpenVPN Connected Clients</th>
                </thead>
                <div id="resultClients"><?php echo '<!--'.shell_exec("sudo cat /var/log/openvpn-status.log").'-->'; ?></div>
                <tbody id="tableBody">
                    <tr>
                        <th>User</th>
                        <th>IP WAN</th>
                        <th>IP Lan</th>
                        <th>Connect time</th>
                    </tr>
                    <?php 
                        $return = shell_exec("sudo cat /var/log/openvpn-status.log");
                        echo "<div>".$return."</div>";
                        $shll_array = explode("\n", $return);
                        for($i = 0; $i < count($shll_array); $i++)
                        {
                            if(strpos($shll_array[$i], 'CLIENT_LIST') !== false)
                            {
                                $fin_array = explode("\t", $shll_array[i]);
                                echo "<tr><td>".$fin_array[1]."</td><td>".$fin_array[2]."</td><td>".$fin_array[3]."</td><td>".$fin_array[7]."</td></tr>";
                            }
                        }
                    ?>
                </tbody>
			</table><br>
            <button type="button" onclick="CreateClientsTable">teste</button>
	    </div>
    </div>
    <div class="row">
	<div class="col-lg-12">

	</div>

    </div>
