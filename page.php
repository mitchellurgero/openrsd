<?php
session_start();
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
?>