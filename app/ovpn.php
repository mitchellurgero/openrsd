<?php
require_once("./functions.php");
/*
libopenvpn.php - Written by Mitchell Urgero  & released under the MIT license.

Definitions:

Current Config: The current running configuration of OpenVPN (Assuming it was configured originally with the class file)
Display Config: Display what was just configured before setting writeConfig.



Example usage:

### Get Current Config, make a change, then write the new change to the current config NOTE: This needs to be done in order to preserve other configuration options!!!!###
$ovpn = new openvpn; //Make new object
$curConfig = $ovpn->ovpnCurrentConfig();  //This needs to be done in order to get the Current OpenVPN object from the file saved during the initial configuration.
echo $curConfig->port; //OUTPUT: 1194
$curConfig->port = "1195"; //Change port to new value
$curConfig->ovpnWriteConfig('server.conf'); //Write the current config back (Since we read the config before this line, any option NOT changed will be preserved.)
echo $curConfig->port; //OUTPUT: 1195


#############################################


### Make a new config (From scratch), write it to file and display result ###
$ovpn = new openvpn;

$ovpn->srvConfigPath = "./server.conf";
$ovpn->proto = "TCP";
$ovpn->port = "1194";
$ovpn->dev = "tun0";
$ovpn->ca = "ca.crt";
$ovpn->cert = "server.crt";
$ovpn->keys = "server.key";
$ovpn->dh = "diffie.pem";
$ovpn->server = "10.8.0.0 255.255.255.0";
$ovpn->ifconfig_pool_persist = "ipp.txt";
$ovpn->push_routes = "route 192.168.10.0 255.255.255.0";
$ovpn->push_dns = "dhcp-option DNS 10.8.0.1";
$ovpn->client_to_client = "client-to-client";
$ovpn->keepAlive = "10 120";
$ovpn->maxclients = "50";
$ovpn->ovpnWriteConfig('server.conf');

echo $ovpn->ovpnDisplayConfig();   (Or ovpnDisplayConfigSet() to display what was set above and not in the file)

*/


class openvpn
{
	//set editable variables
	var $srvConfigPath; //May be removed since the calling functions need to specify path during ovpnWriteConfig($path); function
	var $proto;
	var $port;
	var $dev;
	var $ca;
	var $cert;
	var $keys;
	var $dh;
	var $server;
	var $ifconfig_pool_persist;
	var $server_bridge;
	var $push_routes;
	var $push_gateway = "redirect-gateway";
	var $push_dns;
	var $client_to_client = "client-to-client";
	var $keepalive = "10 120";
	var $maxclients = "100";
	var $compression = "comp-lzo";
	var $log = "openvpn.log";
	var $verb = "3";
	
	//Write the configuration from above ^^^ Note: Needs better check and balance system?//
	function ovpnWriteConfig($path){
		//unset($path);
		$myfile = fopen($path, "w") or die("Unable to open file!");
		fclose($myfile);
		$myfile = fopen($path, "a") or die("Unable to open file!");
		foreach($this as $key=>$value){
			if($key == "keys"){
				$key = "key";
			}
			if($key == "maxclients"){
				$key = "max-clients";
			}
			if($value == "" or $value === null){
				continue;
			}
			if(strpos($key,'_') !== false){
    			$key = str_replace("_", "-", $key);
			}
			if($key == "compression" or $key == "srvConfigPath"){
				continue;
			}
			if($key == "client-to-client"){
				fwrite($myfile, "$value\n");
				continue;
			}
			if($key == "push-routes" or $key == "push-dns"){
				$quo = '"';
				$key = "push";
				$value = "$quo$value$quo\n";
			}
			if($key == "push-gateway"){
				fwrite($myfile, "push $quo$value$quo\n");
				continue;
			}
			fwrite($myfile, "$key $value\n");
		}
		fclose($myfile);
		//Done setting config, lets save the new object of items in a file for later processing
		$myfile = fopen("./vpn/urgent.conf", "w") or die("Unable to open file!");
		fwrite($myfile, serialize($this));
		fclose($myfile);
	}
	
	//Display what was set using $ovpn->variable (Not written to running config yet)
	function ovpnDisplayConfigSet(){
		foreach($this as $key=>$value){
			echo "$key = $value<br />\n";
		}
	}
	
	//Display what is in the running config
	function ovpnDisplayConfig(){
		$readArr = unserialize(file_get_contents("./vpn/ovpn.array.config"));
		foreach($readArr as $key=>$value){
			echo "$key = $value<br />\n";
		}
	}
	
	//Return the running config to calling function (This returns an OBJECT not an array!!!)
	function ovpnCurrentConfig(){
		$readArr = unserialize(file_get_contents("./vpn/ovpn.array.config"));
		return $readArr;
	}
}

?>