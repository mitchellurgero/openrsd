<?php
$ver = new QuickGit();
define("OPENRSD", TRUE);
define("VERSHORT", $ver->version()['short']);
define("VERLONG", $ver->version()['full']);
if (!isset($_SESSION)) { session_start(); };
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
if(isset($_POST['page'])){
	switch($_POST['page']){
		case "dashboard":
			dashboard();
			break;
		case "apps":
			apps();
			break;
		case "firewall":
			firewall();
			break;
		case "nat":
			nat();
			break;
		case "network":
			network();
			break;
		case "block":
			blocked();
			break;
		case "packages":
			packages();
			break;
		case "rpiconfig":
			rpiconfig();
			break;
		case "services":
			services();
			break;
		case "shellinabox":
			shellinabox();
			break;
		case "init":
			init();
			break;
		case "cron":
			cron();
			break;
		case "users":
			users();
			break;
		case "updates":
			updates();
			break;
		case "webconsole":
			webconsole();
			break;
		case "logs":
			logs();
			break;
		case "PiVPN":
			openvpn();
			break;
		case "Samba":
			samba();
			break;
		case "check":
			check();
			break;
		case "webproxy":
			webproxy();
			break;
		default:
			echo "404 - Page not found!";
			break;
		
	}
}

//Simple page functions..
function webconsole(){
	include('pages/webconsole.php');
}
function dashboard(){
	include('pages/dashboard.php');
}
function logs(){
	include('pages/logs.php');
}
function blocked(){
	include('pages/block.php');
}
function cron(){
	include('pages/cron.php');
}
function init(){
	include('pages/init.php');
}
function nat(){
	include('pages/nat.php');
}
function network(){
	include('pages/network.php');
}
function packages(){
	include('pages/packages.php');
}
function rpiconfig(){
	include('pages/rpiconfig.php');
}
function services(){
	include('pages/services.php');
}
function shellinabox(){
	include('pages/shellinabox.php');
}
function updates(){
	include('pages/updates.php');
}
function apps(){
	include('pages/apps.php');
}

function firewall(){
	include('pages/firewall.php');
}
function users(){
	include('pages/users.php');
}
function openvpn(){
	include('pages/openvpn.php');
}
function samba(){
	include('pages/smb.php');
}
function check(){
	include('pages/check.php');
}
function webproxy(){
	include('pages/webproxy.php');
}
//GitVersionCheckClass
class QuickGit {
  public static function version() {
    exec('git describe --always',$version_mini_hash);
    exec('git rev-list HEAD | wc -l',$version_number);
    exec('git log -1',$line);
    $version['short'] = "v".trim($version_number[0]).".".$version_mini_hash[0];
    $version['full'] = "v".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ','',$line[0]).")";
    return $version;
  }
}
?>
