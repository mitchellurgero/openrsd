<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
?>
<pre width="100%" height="95%">
	<?php
	if (ob_get_level() == 0) ob_start();
	while (@ ob_end_flush()); // end all output buffers if any

	$proc = popen("git pull", 'r');
	echo '<pre>';
	while (!feof($proc))
	{
	    echo fread($proc, 4096);
	    @ flush();
	}
	
	?>
</pre>
<br>
<br>
<a href="../index.php">Back to Dashboard</a>