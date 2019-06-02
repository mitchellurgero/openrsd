<?php
class OpenRSD
{
    public static function getRam()
{
    $total = exec("grep MemTotal /proc/meminfo | awk '{print $2}'");
    $free = exec("grep MemFree /proc/meminfo | awk '{print $2}'");
    $cached = shell_exec("grep Cached /proc/meminfo | awk '{print $2}'");
    $used = intval($total) - intval($free) - intval($cached);
    $free = intval($free) + intval($cached);
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

    public static function getCPUTemp()
{
    $temp = exec("cat /sys/class/thermal/thermal_zone0/temp");
    $temp2 = $temp / 1000;
    echo $temp2."'C";
}

    public static function getUptime()
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
        'days' => floor(intval($data)/60/60/24),
        'hours' => intval($data)/60/60%24,
        'minutes' => intval($data)/60%60,
        'seconds' => intval($data)%60
    );
    return "<b>Uptime</b><br />".$uptime["days"]."D ".$uptime["hours"]."H ".$uptime["minutes"]."M";
}

    public static function getCPU()
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

    public static function generateString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

    public static function getCurrentIP($name)
    {
        return exec("/sbin/ifconfig $name | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'");
    }


    public static function getPackageUpdates()
{
    $updates_result=array();
    $updates_cmd = shell_exec("sudo LC_ALL=C apt-get --just-print upgrade 2>&1");
    $updates_filter = '/Inst (?<u_name>[\w\-\.\:\+]+) \[(?<u_installed>[\.\d\:\w\-\+\~]+)\] \((?<u_new>[\.\d\:\w\-\+\~]+) .+ \[(?<u_arch>\w+)\]\)/';
    $updates_result['count'] = preg_match_all($updates_filter, $updates_cmd, $updates_result['array'], PREG_SET_ORDER);
    $updsum_filter = '/(?<cnt_upg>[\d]+) upgraded, (?<cnt_new>[\d]+) newly installed, (?<cnt_rem>[\d]+) to remove and (?<cnt_notup>[\d]+) not upgraded./';
    $updates_result['sumcount'] = preg_match_all($updsum_filter, $updates_cmd, $updates_result['updsum_arr'], PREG_SET_ORDER);
    return $updates_result;
}

    public static function getPackageDistUpdates()
{
    $updates_result=array();
    $updates_cmd = shell_exec("sudo LC_ALL=C apt-get --just-print dist-upgrade 2>&1");
    $updates_filter = '/Inst (?<u_name>[\w\-\.\:\+]+) \[(?<u_installed>[\.\d\:\w\-\+\~]+)\] \((?<u_new>[\.\d\:\w\-\+\~]+) .+ \[(?<u_arch>\w+)\]\)/';
    $updates_result['count'] = preg_match_all($updates_filter, $updates_cmd, $updates_result['array'], PREG_SET_ORDER);
    $installs_filter = '/Inst (?<i_name>[\w\-\.\:\+]+) \((?<i_new>[\.\d\:\w\-\+\~]+)/';
    $updates_result['newcount'] = preg_match_all($installs_filter, $updates_cmd, $updates_result['instarray'], PREG_SET_ORDER);
    $removes_filter = '/Remv (?<r_name>[\w\-\.\:\+]+) \[(?<r_installed>[\.\d\:\w\-\+\~]+)\] /';
    $updates_result['rmcount'] = preg_match_all($removes_filter, $updates_cmd, $updates_result['rmarray'], PREG_SET_ORDER);
    $updsum_filter = '/(?<cnt_upg>[\d]+) upgraded, (?<cnt_new>[\d]+) newly installed, (?<cnt_rem>[\d]+) to remove and (?<cnt_notup>[\d]+) not upgraded./';
    $updates_result['sumcount'] = preg_match_all($updsum_filter, $updates_cmd, $updates_result['updsum_arr'], PREG_SET_ORDER);
    return $updates_result;
}

    public static function getNetworkInterfaces()
{
    $adapters_result=array();
    $adapters_com = shell_exec("ip add show");
    $adapters_filter = '/inet (?<ip_addr>[0-9\.]+)\/[0-9]+ .*scope (host|global) (?<ip_dev>[a-z0-9]+)$/im';
    $adapters_result['if_count'] = preg_match_all($adapters_filter, $adapters_com, $adapters_result['if_array'], PREG_SET_ORDER);
    return $adapters_result;
}

    public static function getUsers()
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

    public static function writeFileA($file, $content)
{
    $myfile = fopen($file, "a") or die("Unable to open file!");
    fwrite($myfile, $content."\n");
    fclose($myfile);
    return true;
}

    public static function writeFileC($file, $content)
{
    $myfile = fopen($file, "w") or die("Unable to open file!");
    fwrite($myfile, $content) or die(false);
    fclose($myfile);
    return true;
}

    public static function readFileAll($file)
{
    $fileContent = file_get_contents($file);
    return $fileContent;
}

    public static function getDirContents($dir, &$results = array())
{
    if ( ! ( $files = @scandir($dir) ))
    {
        return false;
    }

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
            OpenRSD::getDirContents($path, $results);
            //$results[] = $path;
        }
    }

    return $results;
}
    public static function setini(){
        ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        ini_set('max_execution_time',300);
    }
}

//GitVersionCheckClass
class QuickGit
{
    public static function version()
    {
        exec('git describe --always', $version_mini_hash);
        exec('git rev-list HEAD | wc -l', $version_number);
        exec('git log -1', $line);
        $version['short'] = "v".trim($version_number[0]).".".$version_mini_hash[0];
        $version['full'] = "v".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ', '', $line[0]).")";
        return $version;
    }
}

