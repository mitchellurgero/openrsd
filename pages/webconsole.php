<?php if(!defined("OPENRSD")){die();} ?>
<?php
//Check for valid session:
session_start();
include('app/functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
echo '';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Web Console <small><a href="#"><div onClick="pageLoad('webconsole');" class="fa fa-refresh rotate"></div></a></small></h1>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="frame">
    		<iframe src="pages/web-console.php">
	    		Your browser does not support inline frames.
    		</iframe>
		</div>
	</div>
</div>
