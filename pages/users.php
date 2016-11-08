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
            <h1 class="page-header">Users <small><a href="#"><div onClick="pageLoad('users');" class="fa fa-refresh rotate"></div></a>&nbsp;&nbsp;&nbsp;<button data-toggle="modal" data-target="#newUserModal" class="btn btn-raised btn-info">Add User</button></small></h1>
        	<small>Users made through this interface are added to the sudoers file so they can use sudo commands.</small>
        	<small>If you do not want this, make the users through a console or SSH session.</small>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<table class="table">
    			<thead>
    				<th>User</th>
    				<th>Options</th>
    			</thead>
    			<tbody>
    				<?php
    				$users = shell_exec("sudo bash ./app/scripts/listusers.sh");
    				$usersAr = explode("\n", $users);
    				if(count($usersAr) -1 != 0){
    					foreach($usersAr as $user){
    						$user_ex = explode(":", $user);
    						if($user_ex[0] != ""){
    							if($user_ex[0] == "root"){
    								echo '<tr><td>'.$user_ex[0].'</td><td>You cannot modify the root account through this interface.</td></tr>';
    							} else {
    								$u1 = "'".$user_ex[0]."'";
    								if($user_ex[0] == "pi"){
    									echo '<tr><td style="vertical-align: middle;">'.$user_ex[0].'</td><td><button class="btn btn-raised btn-info" onClick="changePwd('.$u1.');">Change Password</button>&nbsp;&nbsp;You cannot delete the user \'pi\', apache is running as this user.</td></tr>';
    								} else {
    									if($user_ex[0] == $_SESSION['username']){
    										echo '<tr><td style="vertical-align: middle;">'.$user_ex[0].'</td><td><button class="btn btn-raised btn-info" onClick="changePwd('.$u1.');">Change Password</button>&nbsp;&nbsp;You cannot delete the user you are logged in as.</td></tr>';
    									} else {
    										echo '<tr><td style="vertical-align: middle;">'.$user_ex[0].'</td><td><button class="btn btn-raised btn-info" onClick="changePwd('.$u1.');">Change Password</button>&nbsp;&nbsp;<button class="btn btn-raised btn-warning" onClick="delUser('.$u1.');">Delete User</button></td></tr>';
    									}
    								}
    								
    							}
    						}
    						
    					}
    				} else {
    					echo "<p>No users on the system?! That's not right! Seems there was an error! Check the apache logs for more information! </p>";
    				}
    				
    				?>
    			</tbody>
    		</table>
    		<div class="modal" id="newUserModal">
  			<div class="modal-dialog">
    			<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<h4 class="modal-title" id="newUserModalHeader">Add New User</h4>
      			</div>
      			<div class="modal-body" id="newUserModalBody">
        			<p>
        				<form class="bs-component">
          				<div class="form-group label-floating is-empty" >
            				<label class="control-label" for="newUser1">Username for new user</label>
            				<input class="form-control" id="newUser1" type="text">
          					<span class="material-input"></span>
          				</div>
          				<div class="form-group label-floating is-empty" >
            				<label class="control-label" for="newPasswd1">Password for new user</label>
            				<input class="form-control" id="newPasswd1" type="password">
          					<span class="material-input"></span>
          				</div>
          				<div class="form-group label-floating is-empty" >
            				<label class="control-label" for="newPasswd2">Password for new user (again)</label>
            				<input class="form-control" id="newPasswd2" type="password">
          					<span class="material-input"></span>
          				</div>
						<br />
    				</form>
        				
        			</p>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancel</button>
        			<button type="button" class="btn btn-raised btn-primary" onClick="addUser()">Add User</button>
      			</div>
    			</div>
  			</div>
		</div>
		<div class="modal" id="changePwdModal">
  			<div class="modal-dialog">
    			<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<h4 class="modal-title" id="changePwdModalHeader">Change Current Password for user: <div id="changeUserPasswd"></div></h4>
      			</div>
      			<div class="modal-body" id="changePwdModalBody">
        			<p>
        				<form class="bs-component">
          				<div class="form-group label-floating is-empty" >
            				<label class="control-label" for="newPasswd3">Password for new user</label>
            				<input class="form-control" id="newPasswd3" type="password">
          					<span class="material-input"></span>
          				</div>
          				<div class="form-group label-floating is-empty" >
            				<label class="control-label" for="newPasswd4">Password for new user (again)</label>
            				<input class="form-control" id="newPasswd4" type="password">
          					<span class="material-input"></span>
          				</div>
						<br />
    				</form>
        				
        			</p>
      			</div>
      			<div class="modal-footer" id="changePwdModalFooter">
        			<button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancel</button>
        			<button type="button" class="btn btn-raised btn-primary" >Change Password</button>
      			</div>
    			</div>
  			</div>
		</div><div class="modal" id="delUserModal">
  			<div class="modal-dialog">
    			<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<h4 class="modal-title" id="changePwdModalHeader">Delete User?</h4>
      			</div>
      			<div class="modal-body" id="delUserModalBody">
        			<p>
        				Are you sure you want to delete X?
        			</p>
      			</div>
      			<div class="modal-footer" id="delUserModalFooter">
        			
      			</div>
    			</div>
  			</div>
		</div>
    	</div>
    </div>