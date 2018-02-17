<?php if (!defined("OPENRSD")) {
    die();
}

//Check for valid session:
if (!isset($_SESSION)) {
    session_start();
};
require_once('app/functions.php');
if (!isset($_SESSION['username'])) {
    die("You must be logged in to view this page!");
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Shell in a Box <small><a href="#"><div onClick="pageLoad('shellinabox');" class="fa fa-refresh rotate"></div></a></small></h1>
    </div>
</div>
<script>
$('.container').onresize = function() {
  resize_frame();
};

$(window).onresize = function() {
  resize_frame();
};

$(window).onload = function() {
  resize_frame();
};

</script>
<div class="row">
	<div class="col-md-12">
		<div id="shellinaboxdiv">
    		<iframe id="shellinaboxframe" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>:4200/" onload="resize_frame()">
	    		Your browser does not support inline frames.
    		</iframe>
		</div>
	</div>
</div>
