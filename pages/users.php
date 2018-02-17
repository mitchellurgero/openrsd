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
                                $users_list = OpenRSD::getUsers();
//                              echo "<!-- \n" .print_r($users_list,true). "\n -->\n";
                                if ($users_list['user_count'] != 0) {
                                    foreach ($users_list['users_array'] as $user) {
                                        if ($user['u_name'] != "") {
                                            if ($user['u_name'] == "root") {
                                                echo '<tr><td>'.$user['u_name'].'</td><td>You cannot modify the root account through this interface.</td></tr>';
                                            } else {
                                                $u1 = "'".$user['u_name']."'";
                                                if ($user['u_name'] == "pi") {
                                                    echo '<tr><td style="vertical-align: middle;">'.$user['u_name'].'</td><td><button class="btn btn-raised btn-info" onClick="changePwd('.$u1.');">Change Password</button>&nbsp;&nbsp;You cannot delete the user \'pi\', apache is running as this user.</td></tr>';
                                                } else {
                                                    if ($user['u_name'] == $_SESSION['username']) {
                                                        echo '<tr><td style="vertical-align: middle;">'.$user['u_name'].'</td><td><button class="btn btn-raised btn-info" onClick="changePwd('.$u1.');">Change Password</button>&nbsp;&nbsp;You cannot delete the user you are logged in as.</td></tr>';
                                                    } else {
                                                        echo '<tr><td style="vertical-align: middle;">'.$user['u_name'].'</td><td><button class="btn btn-raised btn-info" onClick="changePwd('.$u1.');">Change Password</button>&nbsp;&nbsp;<button class="btn btn-raised btn-warning" onClick="delUser('.$u1.');">Delete User</button></td></tr>';
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
    <div class="row">
    	<div class="col-md-12">
    		<h3>Authentication Failures <small>(For today, see Logs tab for more log files.)</small></h3>
    		<table class="table">
    			<thead>
    				<th>Log item</th>
    			</thead>
    			<?php
                $date2 = date('m-d-Y', time());
                if (!file_exists("app/auth_log/$date2.log")) {
                    touch("app/auth_log/$date2.log");
                }
                $data = explode("\n", file_get_contents("app/auth_log/$date2.log"));
                foreach ($data as $line) {
                    echo "<tr><td>$line</td></tr>";
                }
                ?>
    		</table>
    	</div>
    </div>
