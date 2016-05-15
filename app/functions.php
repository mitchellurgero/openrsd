<?php
function getRam(){
	$total = exec("grep MemTotal /proc/meminfo | awk '{print $2}'");
	$free = exec("grep MemFree /proc/meminfo | awk '{print $2}'");
	$cached = shell_exec("grep Cached /proc/meminfo | awk '{print $2}'");
	$used = $total - $free - $cached;
	$free = $free + $cached;
	$total = round($total / 1024, 2)."MB";
	$free = round($free / 1024, 2)."MB";
	$used = round($used / 1024, 2)."MB";
//	if($return == "total"){
//		return $total;
//	} elseif($return == "free"){
//		return $free;
//	} elseif($return == "used"){
//		return $used;
//	} else {
//		return "Bad Arguments!";
//	}
	return "Total: $total<br />Used: $used <br />Free: $free";
}
function getCPUTemp(){
	$temp = exec("cat /sys/class/thermal/thermal_zone0/temp");
	$temp2 = $temp / 1000;
	echo $temp2."'C";
}
function getUptime(){
    $file = @fopen('/proc/uptime', 'r');
    if (!$file) return 'Opening of /proc/uptime failed!';
    $data = @fread($file, 128);
    if ($data === false) return 'fread() failed on /proc/uptime!';
    $upsecs = (int)substr($data, 0, strpos($data, ' '));
    $uptime = Array (
        'days' => floor($data/60/60/24),
        'hours' => $data/60/60%24,
        'minutes' => $data/60%60,
        'seconds' => $data%60
    );
    return "Uptime: ".$uptime["days"]."D ".$uptime["hours"]."H ".$uptime["minutes"]."M";
}
function getCurrentIP($name){
	return exec("/sbin/ifconfig $name | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'");
}
function getCPU(){
	$speed = 1;
    //Sets variable with current CPU information and then turns it into an array seperating each word.
    $prevVal = shell_exec("cat /proc/stat");
    $prevArr = explode(' ',trim($prevVal));
    //Gets some values from the array and stores them.
    $prevTotal = $prevArr[2] + $prevArr[3] + $prevArr[4] + $prevArr[5];
    $prevIdle = $prevArr[5];
    //Wait a period of time until taking the readings again to compare with previous readings.
    usleep($speed * 1000000);
    //Does the same as before.
    $val = shell_exec("cat /proc/stat");
    $arr = explode(' ',trim($val));
    //Same as before.
    $total = $arr[2] + $arr[3] + $arr[4] + $arr[5];
    $idle = $arr[5];
    //Does some calculations now to work out what percentage of time the CPU has been in use over the given time period.
    $intervalTotal = intval($total - $prevTotal);
    //Does a few more calculations and outputs total CPU usage as an integer.
    return intval(100 * (($intervalTotal - ($idle - $prevIdle)) / $intervalTotal));
	//return  "CPU Usage:".exec("top -b -n1 | grep \"Cpu(s)\" | awk '{print $2 + $4}'")."%";
}
function generateString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getUpdates(){
	$isThere = shell_exec("./scripts/updates.sh");
	$number = substr_count( $isThere, PHP_EOL );
	$number = $number - 1;
	if($number <= 0){
		return "No updates found";
	} else {
		return $number.' <a href="#" data-toggle="modal" data-target="#checkUpdates">Updates available.</a>';
	}

}
function writeFileA($file, $content){
	$myfile = fopen($file, "a") or die("Unable to open file!");
	fwrite($myfile, $content."\n");
	fclose($myfile);
	return true;
}

function writeFileC($file, $content){
	$myfile = fopen($file, "w") or die("Unable to open file!");
	fwrite($myfile, $content) or die(false);
	fclose($myfile);
	return true;
}
function readFileAll($file){
	$fileContent = file_get_contents($file);
	return $fileContent;
}
function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        $dno = false;
        $ext = array(".gz", ".zip");
        foreach($ext as $t){
        	if(substr($value, -3) == $t or substr($value, -4) == $t){ $dno = true; }
        }
        if(!is_dir($path)) {
        	if($dno != true){
        		$results[] = $path;
        	}
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            //$results[] = $path;
        }
    }

    return $results;
}
?>