<?php
function getRam()
{
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
function getCPUTemp()
{
    $temp = exec("cat /sys/class/thermal/thermal_zone0/temp");
    $temp2 = $temp / 1000;
    echo $temp2."'C";
}
function getUptime()
{
    $file = @fopen('/proc/uptime', 'r');
    if (!$file) {
        return 'Opening of /proc/uptime failed!';
    }
    $data = @fread($file, 128);
    if ($data === false) {
        return 'fread() failed on /proc/uptime!';
    }
    $upsecs = (int)substr($data, 0, strpos($data, ' '));
    $uptime = array(
        'days' => floor($data/60/60/24),
        'hours' => $data/60/60%24,
        'minutes' => $data/60%60,
        'seconds' => $data%60
    );
    return "<b>Uptime</b><br />".$uptime["days"]."D ".$uptime["hours"]."H ".$uptime["minutes"]."M";
}
function getCurrentIP($name)
{
    return exec("/sbin/ifconfig $name | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'");
}
function getCPU()
{
    $speed = 1;
    //Sets variable with current CPU information and then turns it into an array seperating each word.
    $prevVal = shell_exec("cat /proc/stat");
    $prevArr = explode(' ', trim($prevVal));
    //Gets some values from the array and stores them.
    $prevTotal = $prevArr[2] + $prevArr[3] + $prevArr[4] + $prevArr[5];
    $prevIdle = $prevArr[5];
    //Wait a period of time until taking the readings again to compare with previous readings.
    usleep($speed * 1000000);
    //Does the same as before.
    $val = shell_exec("cat /proc/stat");
    $arr = explode(' ', trim($val));
    //Same as before.
    $total = $arr[2] + $arr[3] + $arr[4] + $arr[5];
    $idle = $arr[5];
    //Does some calculations now to work out what percentage of time the CPU has been in use over the given time period.
    $intervalTotal = intval($total - $prevTotal);
    //Does a few more calculations and outputs total CPU usage as an integer.
    return intval(100 * (($intervalTotal - ($idle - $prevIdle)) / $intervalTotal));
    //return  "CPU Usage:".exec("top -b -n1 | grep \"Cpu(s)\" | awk '{print $2 + $4}'")."%";
}
function generateString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function packageUpdates()
{
    $updates_result=array();
    $updates_cmd = shell_exec("sudo LC_ALL=C apt-get --just-print upgrade 2>&1");
    $updates_filter = '/Inst (?<u_name>[\w\-]+) \[(?<u_installed>[\.\d\w\-\~]+)\] \((?<u_new>[\.\d\w\-\~]+)/';
    $updates_result['count'] = preg_match_all($updates_filter, $updates_cmd, $updates_result['array'], PREG_SET_ORDER);
    return $updates_result;
}

function getNetworkInterfaces()
{
    $adapters_result=array();
    $adapters_com = shell_exec("ip add show");
    $adapters_filter = '/inet (?<ip_addr>[0-9\.]+)\/[0-9]+ .*scope (host|global) (?<ip_dev>[a-z0-9]+)$/im';
    $adapters_reslut['if_count'] = preg_match_all($adapters_filter, $adapters_com, $adapters_result['if_array'], PREG_SET_ORDER);
    return $adapters_result;
}

function getUsers()
{
    $valid_shells=array();
    $shells_array = file('/etc/shells');
    foreach ($shells_array as $shell_entry) {
        if (substr($shell_entry, 0, 1) != "#") {
            $valid_shells[]=str_replace("\n", '', str_replace('/', '\/', $shell_entry));
        }
    }
    $shells_filter=implode("|", $valid_shells);
    $users_result=array();
    $users_com = shell_exec("getent passwd");
    $users_filter = '/^(?<u_name>[a-z0-9\.]+):x:(?<u_uid>[0-9]+):(?<u_gid>[0-9]+):(?<u_gecos>[[:print:]]+):(?<u_home>[\/a-z0-9_]+):(?<ip_shell>'.$shells_filter.')$/im';
    $users_result['user_count'] = preg_match_all($users_filter, $users_com, $users_result['users_array'], PREG_SET_ORDER);
    return $users_result;
}

function writeFileA($file, $content)
{
    $myfile = fopen($file, "a") or die("Unable to open file!");
    fwrite($myfile, $content."\n");
    fclose($myfile);
    return true;
}

function writeFileC($file, $content)
{
    $myfile = fopen($file, "w") or die("Unable to open file!");
    fwrite($myfile, $content) or die(false);
    fclose($myfile);
    return true;
}
function readFileAll($file)
{
    $fileContent = file_get_contents($file);
    return $fileContent;
}
function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        $dno = false;
        $ext = array(".gz", ".zip");
        foreach ($ext as $t) {
            if (substr($value, -3) == $t or substr($value, -4) == $t) {
                $dno = true;
            }
        }
        if (!is_dir($path)) {
            if ($dno != true) {
                $results[] = $path;
            }
        } elseif ($value != "." && $value != "..") {
            getDirContents($path, $results);
            //$results[] = $path;
        }
    }

    return $results;
}
