<?php
class dashboard_ClientsPlugin extends Plugin
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
                    $finalStr += "<tr><td>".$fin_array[1]."</td><td>".$ip_noport[0]."</td><td>".$fin_array[3]."</td><td>".$fin_array[7]."</td></tr>";
                }
            }
            return $finalStr;
        }
        
        public function onPageLoadEnd($sess, &$post)
        {
            /* 
            Panel example:
            <div class="panel panel-default">
                <div class="panel-heading h3">
                    Logged in users
                </div>
                <div class="panel-body">
                    <p>
                        </p>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        pi       tty7         Mar 13 01:51 (:0)
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        pi       pts/0        Mar 14 17:20 (192.168.1.35)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <p></p>
                </div>
                <div class="panel-footer">
                    &nbsp;
                </div>
            </div>
            */
            if($post['page'] == "dashboard")
            {    
                echo '<div class="panel panel-default">
                <div class="panel-heading h3">
                    Logged in users
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
                </div>';
            }
            echo "<!-- teste :". $post['page'] ."--> ";
            return true;
        }
        
        public function onPageLoad($s, &$p){
		
            //echo '<div class="alert alert-success">This should be displayed via the Exmaple Plugin!</div>';
            
            return true; //So we continue processing plugins
        }
    }
?>