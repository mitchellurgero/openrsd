<?php
class dashBoard extends Plugin
    {
        public function __construct(){
            //this is required by the plugin system to get working properly. This adds all the below events to global like {Class}::{onEventName};
            parent::__construct(); //Required
            return true;
        }

        public function initialize(){
            return true;
        }

        public function mountTable()
        {
            $return = shell_exec("sudo cat /var/log/openvpn-status.log");
            $shll_array = explode("\n", $return);
            $finalStr = "";
            for($i = 0; $i < count($shll_array); $i++)
            {
                if(strpos($shll_array[$i], 'CLIENT_LIST') !== false and strpos($shll_array[$i], 'HEADER') == false and strpos($shll_array[$i], 'Common Name') == false)
                {
                    $fin_array = explode("\t", $shll_array[$i]);
                    $ip_noport = explode(":", $fin_array[2]);
                    $finalStr = $finalStr . "<tr><td>".$fin_array[1]."</td><td>".$ip_noport[0]."</td><td>".$fin_array[3]."</td><td>".$fin_array[7]."</td></tr>";
                }
            }
            return $finalStr;
            // $finalStr;
        }
        
        public function onDashboardEnd($sess)
        {
                echo '<div class="col-lg-4">
                <div class="panel panel-default">
                <div class="panel-heading h3">
                    Logged in vpn
                </div>
                <div class="panel-body">
                    <p>
                        </p>
                        <table class="table">
                        <tbody id="tableBody">
                        <tr>
                            <th>User</th>
                            <th>IP WAN</th>
                            <th>IP Lan</th>
                            <th>Connect time</th>
                        </tr>'.$this->mountTable().'</tbody>
                            </table>
                        <p></p>
                    </div>
                    <div class="panel-footer">
                        &nbsp;
                    </div>
                    </div>
                </div>';
            return true;
        }
    }
?>