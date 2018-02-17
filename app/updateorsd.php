<?php
//Check for valid session:
if (!isset($_SESSION)) {
    session_start();
};
if (basename(dirname(__FILE__)) == 'app') {
    require_once('functions.php');
};
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
shell_exec("git branch --set-upstream-to=origin/master master");
$c = htmlspecialchars(shell_exec("git fetch && git status"));
if (strpos($c, 'no changes added to commit') !== false) {
    echo '<p>You modified OpenRSD files, we cannot update this. Please reinstall!</p>';
} elseif (strpos($c, 'behind') !== false) {
    ?>
	<pre width="100%" height="95%">
	<?php
    if (ob_get_level() == 0) {
        ob_start();
    }
    while (@ ob_end_flush()); // end all output buffers if any

    $proc = popen("git pull", 'r');
    echo '<pre>';
    while (!feof($proc)) {
        echo fread($proc, 4096);
        @ flush();
    } ?>
	</pre>
	<?php
} elseif (strpos($c, 'up-to-date') !== false) {
        echo '<p>OpenRSD is completely up to date!</p>';
    } else {
        echo '<p> There was an error processing the update request:<p>';
        echo '<pre>'.$c.'</pre>';
    }
?>

<br>
<br>
<a href="../index.php">Back to Dashboard...</a>
