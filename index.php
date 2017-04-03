<?php
session_start();
include("app/auth.php");
//Always push out header...

head();

//Check for login or dashboard...
if(isset($_POST['username']) && isset($_POST['password'])){
	//Attempt to login...
	if(file_exists("app/blocked_ip/".$_SERVER['REMOTE_ADDR'])){
		$_SESSION['loginError'] = "Too many login attempts, please contact the system administrator.";
	} else {
		$u = $_POST['username'];
		$p = $_POST['password'];
		if(auth($u, $p)){
			$_SESSION['username'] = $u;
			$_SESSION['q'] = $p;
		} else {
			if(!isset($_SESSION['attempts'])){
				$_SESSION['attempts'] = 0;
			} 
			$_SESSION['attempts'] = $_SESSION['attempts']  + 1;
			$_SESSION['loginError'] = "Username or password is incorrect.";
			if($_SESSION['attempts'] >= 5){
				file_put_contents("app/blocked_ip/".$_SERVER['REMOTE_ADDR'],"");
				$_SESSION['loginError'] = "Too many login attempts, please contact the system administrator.";
			}
		}	
	}
}

if(!isset($_SESSION['username'])){
	//Load login
	bodyLogin();
} else {
	body();
}

footer();

//Functions for header...

function head(){
	echo '';
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>

    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="">
    	<meta name="author" content="">
	    <title><?php echo exec("hostname"); ?> Admin Panel</title>
	    <!-- Bootstrap Core CSS -->
	    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    
	    <link href="css/bootstrap-material-design.css" rel="stylesheet">
  		<link href="css/ripples.min.css" rel="stylesheet">
  		
	    <!-- MetisMenu CSS -->
	    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	    <!-- Timeline CSS -->
	    <link href="dist/css/timeline.css" rel="stylesheet">
	    <!-- Custom CSS -->
	    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
	    <!-- Morris Charts CSS -->
	    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">
	    <link href="css/custom.css" rel="stylesheet">
	    <!-- Custom Fonts -->
	    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
        	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
   		<?php
   			if(!isset($_SESSION['username'])){ echo '<link href="./css/sign-in.css" rel="stylesheet" type="text/css">'; }
   		?>
   		<!-- ORSD JS Functions -->
   		<script src="app/functions-orsd.js"></script>
   		
	</head>
	
	<?php
	
}
function bodyLogin(){
	echo '<body>';
	echo '';
	//Javascript...
	?>
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="./"><?php echo exec("hostname"); ?> Admin Panel</a>
            </div>
        </nav>
        <nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="https://github.com/mitchellurgero/openrsd" target="_blank">Powered by OpenRSD</a>
            </div>
        </nav>
        <div class="container">
        	<div class="row">
        		<div class="col-lg-6">
	        		<form class="form-signin" method="POST" action="index.php">
	        			<h2 class="form-signin-heading text-center">Sign In to <?php echo exec("hostname"); ?></h2>
	        			<label for="password" class="sr-only">Username</label>
	        			<input type="username" id="username" name="username" class="form-control" placeholder="Username" required autofocus><br />
	        			<label for="password" class="sr-only">Password</label>
	        			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required><br />
	        			<button class="btn btn-lg btn-raised btn-primary btn-block" type="submit">Sign in</button><Br />
	        			<p style="color:red"><?php if(isset($_SESSION['loginError'])){ echo $_SESSION['loginError']; $_SESSION['loginError'] = "";}?></p>
	      			</form>
	      		</div>
	      		<div class="col-lg-4">
        			<img class="img-responsive" src="img/serveimage.png"></img>
        		</div>
        	</div>
        	
        </div>
		<!-- jQuery -->
    	<script src="bower_components/jquery/dist/jquery.min.js"></script>
    	<!-- Bootstrap Core JavaScript -->
    	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    	<script src="js/material.js"></script>
	    <script>$.material.init();</script>
    	<!-- Metis Menu Plugin JavaScript -->
    	<script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    	<!-- Morris Charts JavaScript -->
    	<script src="bower_components/raphael/raphael-min.js"></script>
    	<script src="bower_components/morrisjs/morris.min.js"></script>
    	<script src="js/morris-data.js"></script>
    	<!-- Custom Theme JavaScript -->
    	<script src="dist/js/sb-admin-2.js"></script>
	<?php
	echo '</body>';	
	
}
function body(){
	echo '<body>';
	echo '';
	//Javascript...
	
	?>
	
	<script>window.onload = function () { pageLoad("dashboard"); }</script>
		<nav class="navbar navbar-default">
  			<div class="container-fluid">
    			<div class="navbar-header">
      				<a class="navbar-brand" href="./"><?php echo exec("hostname"); ?> Admin Panel</a>
      				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span> 
      				</button>
    			</div>
    			<div class="collapse navbar-collapse" id="myNavbar">
    			<ul class="nav navbar-nav">
      				<li>&nbsp;</li>
      				<li>&nbsp;</li>
      				<li><a href="#" onclick="pageLoad('dashboard');"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
      				<li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;Basic Configuration</a>
        				<ul class="dropdown-menu">
      						<li><a href="#" onclick="pageLoad('apps');"><i class="fa fa-laptop fa-fw"></i> Applications & Scripts</a></li>
                        	<li><a href="#" onclick="pageLoad('packages');"><i class="fa fa-archive fa-fw"></i> Packages</a></li>
                        	<li><a href="#" onclick="pageLoad('users');"><i class="fa fa-users fa-fw"></i> Users</a></li>
                        	<li><a href="#" onclick="pageLoad('webproxy');"><i class="fa fa-download fa-fw"></i> Web Proxy</a></li>
        				</ul>
      				</li>
      				<li>&nbsp;</li>
      				<li>&nbsp;</li>
      				<li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;Advanced Configuration</a>
        				<ul class="dropdown-menu">
        					<li><a href="#" onclick="pageLoad('block');"><i class="fa fa-cloud fa-fw"></i> Blocked IPs</a></li>
                        	<li><a href="#" onclick="pageLoad('cron');"><i class="fa fa-repeat fa-fw"></i> CRON</a></li>
        					<li><a href="#" onclick="pageLoad('logs');"><i class="fa fa-paperclip fa-fw"></i> Logs</a></li>
          					<li><a href="#" onclick="pageLoad('rpiconfig');"><i class="fa fa-paperclip fa-fw"></i> Raspi-Config</a></li>
          					<li><a href="#" onclick="pageLoad('services');"><i class="fa fa-book fa-fw"></i> Services</a></li>
          					<li><a href="#" onclick="pageLoad('check');"><i class="fa fa-arrow-up fa-fw"></i> Updates</a></li>
        				</ul>
      				</li>
                    <li>&nbsp;</li>
      				<li>&nbsp;</li>
      				<li><a href="#" onclick="pageLoad('PiVPN');"><i class="fa fa-lock fa-fw"></i> PiVPN Profiles</a></li>
      				<li>&nbsp;</li>
      				<li>&nbsp;</li>
                    <li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-power-off fa-fw"></i> Power Options</a>
        				<ul class="dropdown-menu">
          					<li><a href="#" onclick="power('reboot');">Reboot</a></li>
          					<li><a href="#" onclick="power('shutdown');">Shutdown</a></li>
          					<li><a href="#" onclick="power('halt');">Halt</a></li>
        				</ul>
      				</li>
    			</ul>
    			<ul class="nav navbar-nav navbar-right">
                   	<li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i>&nbsp;Logged in as: <?php echo $_SESSION['username']; ?></a>
        				<ul class="dropdown-menu">
          					<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout <?php echo $_SESSION['username']; ?></a></li>
        				</ul>
      				</li>
                </ul>
                &nbsp;&nbsp;&nbsp;
    			</div>
  			</div>
		</nav>
		<div class="container">
			<div id="pageContent"  role="main">
				Please select an item from the menu.
			
			</div>
			<br />
			<br />
			<br />
			
		</div>
		<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="https://github.com/mitchellurgero/openrsd" target="_blank">Powered by OpenRSD</a>
            </div>
        </nav>
		
		<!-- General Modal for info's/warning's/error's -->
		
		<div class="modal" id="genModal">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<h4 class="modal-title" id="genModalHeader">Modal title</h4>
      			</div>
      			<div class="modal-body" id="genModalBody">
        			<p>One fine body…</p>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-raised btn-primary" data-dismiss="modal">Close Message</button>
      			</div>
    			</div>
  			</div>
		</div>
		<!--<div id="coverlay"></div>-->
		<div class="loading" id="loadAnim">Loading&#8230;</div>
		<!-- jQuery -->
    	<script src="./bower_components/jquery/dist/jquery.min.js"></script>
    	<!-- Bootstrap Core JavaScript -->
    	<script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    	<script src="js/material.js"></script>
	    <script>$.material.init();</script>
	    <script>
	    	$(".rotate").click(function(){
    			$(this).toggleClass("down"); 
			});
	    </script>
    	<!-- Metis Menu Plugin JavaScript -->
    	<script src="./bower_components/metisMenu/dist/metisMenu.min.js"></script>
    	<!-- Morris Charts JavaScript -->
    	<script src="./bower_components/raphael/raphael-min.js"></script>
    	<script src="./bower_components/morrisjs/morris.min.js"></script>
    	<!-- Custom Theme JavaScript -->
    	<script src="./dist/js/sb-admin-2.js"></script>
	<?php
	echo '</body>';
}

function footer(){
	echo '';
	?>
<script type="text/javascript">
  			$(document).ready(ajustamodal);
  			$(window).resize(ajustamodal);
  			function ajustamodal() {
    			var altura = $(window).height() - 160; //value corresponding to the modal heading + footer
    			$(".ativa-scroll").css({"height":altura,"overflow-y":"auto"});
  			}
		</script>
	</html>
	<?php
}
?>
