<?php
function auth($username, $password){
	$date = date('m-d-Y.h:i:s.a', time());
	$date2 = date('m-d-Y', time());
	$dir = getcwd();
	$ip = $_SERVER['REMOTE_ADDR'];
	$cpu = php_uname("m");
	$chkpasswd = "chkpasswd";
	if(!file_exists("app/auth_log/$date2.log")){touch("app/auth_log/$date2.log");}
	if(file_exists("app/blocked_ip/".$ip)){
		
		file_put_contents("app/auth_log/$date2.log","$date [AUTH] - Authentication for $ip failed!($ip) \n", FILE_APPEND);
		return false;
	}
	$password = escapeshellarg($password);
	$users = shell_exec("sudo bash ./app/scripts/listusers.sh");
    $usersAr = explode("\n", $users);
    $usersAr2 = array_filter($usersAr);
    $uAr1 = array();
    foreach($usersAr2 as $u){
    	$u2 = explode(":", $u);
    	array_push($uAr1, $u2[0]);
    }
    if (!in_array($username, $uAr1)) {
    		file_put_contents("app/auth_log/$date2.log","$date [AUTH] - Authentication for $username failed!($ip) \n", FILE_APPEND);
    		return false;
    }
    //test if RPi0 / 1 / 2
    if($cpu == "armv6l"){
    	$chkpasswd = "chkpasswd6";
    }
	$result = exec("sudo ./app/bin/$chkpasswd $username $password");
	if($result == "Not Authenticated"){
		file_put_contents("app/auth_log/$date2.log","$date [AUTH] - Authentication for $username failed!($ip) \n", FILE_APPEND);
		return false;
	} elseif($result == "Authenticated"){
		return true;
	} else {
		$_SESSION['loginAPIError'] = $result;
		file_put_contents("app/auth_log/$date2.log","$date [AUTH] - Authentication for $username failed!($ip) \n", FILE_APPEND);
		return false;
	}
}



?>
