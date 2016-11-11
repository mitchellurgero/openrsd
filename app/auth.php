<?php
function auth($username, $password){
	if(file_exists("app/blocked_ip/".$_SERVER['REMOTE_ADDR'])){
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
    		return false;
    }
	$result = exec("sudo ./app/bin/chkpasswd $username $password");
	if($result == "Not Authenticated"){
		return false;
	} elseif($result == "Authenticated"){
		return true;
	} else {
		$_SESSION['loginAPIError'] = $result;
		return false;
	}
}



?>