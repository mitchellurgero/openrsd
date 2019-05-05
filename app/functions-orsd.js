//uptime = window.setInterval(function(){status("uptime")}, 60000);
 function pageLoad(page){
 	document.title = "Loading..."
 	document.getElementById("pageContent").innerHTML = "<p>Loading " + page + ", Please wait...</p>";
 	load(true);
 	$.ajax({
		method:'post',
		url:'./page.php',
		data:{
			page:page
		},
		success:function(result) {
			document.getElementById("pageContent").innerHTML = result;
			document.title = capitalizeFirstLetter(page);
			load(false);
		}
		}).fail(function(e) {
			document.getElementById("pageContent").innerHTML = "Loading the page failed. Please try again.";
			genModal("Error", "Loading the page failed. Please try again.");
			load(false);
		});
    }
function changePwd(username){
	document.getElementById("changeUserPasswd").innerHTML = username;
	document.getElementById("changePwdModalFooter").innerHTML = '<button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-raised btn-primary" id="changePasswdModalBtn" onClick="changePasswd();">Change Password</button>';
	$("#changePwdModal").modal('show');
}
function delUser(username){
    			document.getElementById("delUserModalBody").innerHTML = "Are you sure you want to delete " + username + "?";
    			document.getElementById("delUserModalFooter").innerHTML = '<button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-raised btn-primary" id="delUserModalBtn" onClick="deleteUser(\'' + username + '\');">Delete User</button>';
    			$("#delUserModal").modal('show');
}
function addUser(){
	var username = document.getElementById("newUser1").value;
	var password = document.getElementById("newPasswd1").value;
	var password2 = document.getElementById("newPasswd2").value;
	if(username == ""){
		genModal("Error!", "Username cannot be blank!")
	} else {
		load(true);
		if(password == password2){
			$.ajax({
				method:'post',
				url:'./app/users.php',
				data:{
					type:'add',
					username:username,
					password:password
				},
				success:function(result) {
					genModal("Results", "<pre>" + result + "</pre>");
					load(false);
					$("#newUserModal").modal('hide');
					pageLoad('users');
				}
				}).fail(function(e) {
					document.getElementById("pageContent").innerHTML = "Loading the page failed. Please try again.";
					load(false);
				});
		} else {
			genModal("Error", "Passwords do not match, try again!");
			load(false);
		}
	}
}
function deleteUser(username){
	$("#delUserModal").modal('hide');
		load(true);
		$.ajax({
			method:'post',
			url:'./app/users.php',
			data:{
				type:'del',
				username:username
			},
			success:function(result) {
				genModal("Results", "<pre>" + result + "</pre>");
				load(false);
				pageLoad('users');
			}
			}).fail(function(e) {
				document.getElementById("pageContent").innerHTML = "Loading the page failed. Please try again.";
				load(false);
			});
}
function changePasswd(){
	load(true);
	var username = document.getElementById("changeUserPasswd").innerHTML;
	var password = document.getElementById("newPasswd3").value;
	var password2 = document.getElementById("newPasswd4").value;
	if(password == password2){
		$("#changePwdModal").modal('hide');
		$.ajax({
			method:'post',
			url:'./app/users.php',
			data:{
				type:'change',
				username:username,
				password:password
			},
			success:function(result) {
				genModal("Results", "<pre>" + result + "</pre>");
				load(false);
				pageLoad('users');
			}
			}).fail(function(e) {
				document.getElementById("pageContent").innerHTML = "Loading the page failed. Please try again.";
				load(false);
			});
	} else {
		genModal("Error", "Passwords do not match, try again!");
		load(false);
	}


}
function cronSave(){
	var jobcontent = document.getElementById("cronContent").value;
	var jobtype = document.getElementById("cronType").value;
	var jobname = document.getElementById("cronNewName").value;
		load(true);
		$.ajax({
			method:'post',
			url:'./app/cron.php',
			data:{
				type:jobtype,
				name:jobname,
				content:jobcontent
			},
			success:function(result) {
				$("#cronModal").modal('hide');
				genModal("Results", "<pre>" + result + "</pre>");
				load(false);
				pageLoad('cron');
			}
			}).fail(function(e) {
				genModal("Results", "<pre>" + e + "</pre>");
				load(false);
			});
}
function genModal(head, body){
	document.getElementById("genModalHeader").innerHTML = head;
	document.getElementById("genModalBody").innerHTML = body;
	$("#genModal").modal('show');
}
function capitalizeFirstLetter(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}
function apt_update(){
    $('#pageContent > div.row > div.col-lg-12 > h1 > small > button.btn.btn-raised.btn-info').removeClass('btn-info').addClass('btn-outline-info disabled');
    $('#pageContent > div.row > div.col-lg-12 > h1 > small > button.btn.btn-raised.btn-warning').removeClass('btn-warning').addClass('btn-outline-warning disabled');
    $('#pageContent > div.row > div.col-lg-12 > table.table').hide();
    var contentrow = document.createElement('div'),
        contentcol = document.createElement('div'),
        contentpre = document.createElement('textarea');
    var winheight = $( window ).height(),
        navheight = $('nav.navbar.navbar-default').outerHeight(),
        footnavheight = $('nav.navbar.navbar-inverse.navbar-fixed-bottom').outerHeight(),
        navheadheight = $('#pageContent > div > div > h1.page-header').outerHeight() + 30,
        viscontheight = ( winheight - (navheight + footnavheight + navheadheight) - 180 );
        contentpre.setAttribute('id', 'updatestreamcnt');
        contentpre.setAttribute('rows', '1');
        contentpre.setAttribute('cols', '160');
        contentpre.setAttribute('readonly', true);
        contentpre.style.maxHeight = viscontheight + 'px';
        contentpre.style.height = viscontheight + 'px';
        contentrow.className = 'row';
        contentcol.className = 'col-lg-12';
        contentcol.appendChild(contentpre);
        contentrow.appendChild(contentcol);
        $('#pageContent').append(contentrow);
    var pkgbutton = document.createElement('button');
        pkgbutton.setAttribute('onClick','pageLoad(\'packages\');');
        pkgbutton.innerHTML = 'reload Package Updates';
        pkgbutton.className = 'btn btn-raised btn-success';
    var lastResponseLength = false;
    var ajaxRequest = $.ajax({
        type: 'post',
        url: './app/packages.php',
        data:{
            type:'updatestream'
        },
        xhrFields: {
            onprogress: function(e)
            {
                var progressResponse;
                var response = e.currentTarget.response;
                if(lastResponseLength === false)
                {
                    progressResponse = response;
                    lastResponseLength = response.length;
                }
                else
                {
                    progressResponse = response.substring(lastResponseLength);
                    lastResponseLength = response.length;
                }
                $('#updatestreamcnt').val( $('#updatestreamcnt').val() + progressResponse);
                contentpre.scrollTop = contentpre.scrollHeight;
            }
        }
    });
    ajaxRequest.done(function(data)
    {
        $('#updatestreamcnt').after(pkgbutton);
        console.log('Response Complete');
    });
    ajaxRequest.fail(function(error){
        $('#updatestreamcnt').after(pkgbutton);
        console.log('Error: ', error);
    });
    console.log('Request Sent');
}
function apt_upgrade(){
    $('#pageContent > div.row > div.col-lg-12 > h1 > small > button.btn.btn-raised.btn-info').removeClass('btn-info').addClass('btn-outline-info disabled');
    $('#pageContent > div.row > div.col-lg-12 > h1 > small > button.btn.btn-raised.btn-warning').removeClass('btn-warning').addClass('btn-outline-warning disabled');
    $('#pageContent > div.row > div.col-lg-12 > table.table').hide();
    var contentrow = document.createElement('div'),
        contentcol = document.createElement('div'),
        contentpre = document.createElement('textarea');
    var winheight = $( window ).height(),
        navheight = $('nav.navbar.navbar-default').outerHeight(),
        footnavheight = $('nav.navbar.navbar-inverse.navbar-fixed-bottom').outerHeight(),
        navheadheight = $('#pageContent > div > div > h1.page-header').outerHeight() + 30,
        viscontheight = ( winheight - (navheight + footnavheight + navheadheight) - 180 );
        contentpre.setAttribute('id', 'upgradestreamcnt');
        contentpre.setAttribute('rows', '1');
        contentpre.setAttribute('cols', '160');
        contentpre.setAttribute('readonly', true);
        contentpre.style.maxHeight = viscontheight + 'px';
        contentpre.style.height = viscontheight + 'px';
        contentrow.className = 'row';
        contentcol.className = 'col-lg-12';
        contentcol.appendChild(contentpre);
        contentrow.appendChild(contentcol);
        $('#pageContent').append(contentrow);
    var pkgbutton = document.createElement('button');
        pkgbutton.setAttribute('onClick','pageLoad(\'packages\');');
        pkgbutton.innerHTML = 'reload Package Updates';
        pkgbutton.className = 'btn btn-raised btn-success';
    var lastResponseLength = false;
    var ajaxRequest = $.ajax({
        type: 'post',
        url: './app/packages.php',
        data:{
            type:'upgradestream'
        },
        xhrFields: {
            onprogress: function(e)
            {
                var progressResponse;
                var response = e.currentTarget.response;
                if(lastResponseLength === false)
                {
                    progressResponse = response;
                    lastResponseLength = response.length;
                }
                else
                {
                    progressResponse = response.substring(lastResponseLength);
                    lastResponseLength = response.length;
                }
                $('#upgradestreamcnt').val( $('#upgradestreamcnt').val() + progressResponse);
                contentpre.scrollTop = contentpre.scrollHeight;
            }
        }
    });
    ajaxRequest.done(function(data)
    {
        $('#upgradestreamcnt').after(pkgbutton);
        console.log('Response Complete');
    });
    ajaxRequest.fail(function(error){
        $('#upgradestreamcnt').after(pkgbutton);
        console.log('Error: ', error);
    });
    console.log('Request Sent');
}
function serviceAction(name, type){
	load(true);
	$.ajax({
		method:'post',
		url:'./app/services.php',
		data:{
			service:name,
			type:type
		},
		success:function(result) {
			genModal("Results:", result);
			load(false);
			pageLoad("services");
		}
		}).fail(function(e) {
			genModal("Error", "Due to the timeout configured on the server, or your browser, this request timed out. The command is still running on the server though. SSH to check upgrade status is recommended.");
			load(false);
		});
}
function configSave(){
	load(true);
	$.ajax({
		method:'post',
		url:'./app/rpiconfig.php',
		data:{
			content:document.getElementById("rpiConfigFile").value
		},
		success:function(result) {
			genModal("Results:", result);
			load(false);
			pageLoad("rpiconfig");
		}
		}).fail(function(e) {
			genModal("Error?", "Seems I cannot contact the RPi - It may be shutdown, rebooting, or halted.");
			load(false);
		});
}
function smbGet(option){
	load(true);
	$.ajax({
		method:'post',
		url:'./app/smbconfig.php',
		dataType: 'json',
		data:{
			func:"get",
			share:option
		},
		success:function(result) {
			console.log(result);
			//Generate table:
			var table = '<table class="table" id="' + option + '" name="' + option + '">';
			for(var e in result){
				console.log(e);
				table += "<tr><td><b>" + e + "</b></td>" + '<td><input type="text" class="form-control" id="' + e +'" name="' + e +'" value="' + result[e] + '"></td></tr>';
			}
			table += '</table>';
			genModal("<b>" + option + "</b> Share Options:", table);
			load(false);
			//pageLoad("Samba");
		}
		}).fail(function(e) {
			genModal("Error?", "Seems I cannot contact the RPi - It may be shutdown, rebooting, or halted.");
			load(false);
		});
}
function arrayToTable(tableData) {
	console.info(tableData);
    var table = $('<table class="table"></table>');
    $(tableData).each(function (i, rowData) {
        var row = $('<tr></tr>');
        $(rowData).each(function (j, cellData) {
            row.append($('<td>'+cellData+'</td>'));
        });
        table.append(row);
    });
    console.info(table);
    console.log(table);
    return table;
}
function power(type){
	$.ajax({
		method:'post',
		url:'./app/power.php',
		data:{
			power:type
		},
		success:function(result) {
			document.getElementById("pageContent").innerHTML = result;
		}
		}).fail(function(e) {
			document.getElementById("pageContent").innerHTML = "Seems I cannot contact the RPi - It may be shutdown, rebooting, or halted.";
			genModal("Error?", "Seems I cannot contact the RPi - It may be shutdown, rebooting, or halted.");
		});
}
function status(pageStatus){
	//document.getElementById(pageStatus).innerHTML = "Loading...";
	$.post("./app/post.php", {div: pageStatus}, function(result){
		document.getElementById(pageStatus).innerHTML = result;
	});
}
function startUpload(){
	document.getElementById('uploadProcess').style.visibility = 'visible';
	document.getElementById('uploadForm').style.visibility = 'hidden';
	return true;
}
function stopUpload(success,uploadedFile){
	var result = '';
	if (success == 1){
		result = '<span class="sucess-msg">The file was uploaded successfully!<\/span><br/><br/>';
	} else {
		result = '<span class="error-msg">There was an error during file upload!<\/span><br/><br/>';
    }
	document.getElementById('uploadProcess').style.visibility = 'hidden';
	document.getElementById('uploadForm').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><br /><label><input type="submit" name="submitBtn" class="btn btn-raised btn-primary" value="Upload" /><\/label>';
	document.getElementById('uploadForm').style.visibility = 'visible';
	window.setTimeout(function(){pageLoad('apps')}, 2000);
		return true;   
}
function load(type){
	if(type === true){
		$("#coverlay").show();
		document.getElementById("loadAnim").style.display = '';
	} else {
		$("#coverlay").hide();
		document.getElementById("loadAnim").style.display = 'none';
	}
}
function cronDelete(name, type3){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/cron.php',
		data:{
			type:'delete',
			type2:type3,
			name2:name
		},
		success:function(result) {
			load(false);
			genModal("Results", "<pre>" + result + "</pre>");
			pageLoad('cron');
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
			pageLoad('cron');
		});
}
function cronEdit(name, type3){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/cron.php',
		data:{
			type:'edit',
			type2:type3,
			name2:name
		},
		success:function(result) {
			load(false);
			document.getElementById("cronContent").value = result;
			document.getElementById("cronType").value = type3;
			document.getElementById("cronNewName").value = name;
			$("#cronModal").modal('show');
			//pageLoad('cron');
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
			pageLoad('cron');
		});
}
function clearCron(){
	document.getElementById("cronContent").value = "";
	document.getElementById("cronNewName").value = "";
}
function runScript(filename){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/apps.php',
		data:{
			script:filename,
			type:'run'
		},
		success:function(result) {
			load(false);
			genModal("Script \"" + filename + "\" run results:", "<pre>" + result + "</pre>");
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
function oProfile(){
	load(true)
	user = document.getElementById("profile_name").value;
	$.ajax({
		method:'post',
		url:'./app/profile.php',
		data:{
			profile:user
		},
		success:function(result) {
			load(false);
			genModal("Profile creation status (" + user + "):", '<pre style="overscroll-y:scroll; max-height:400px;">' + result + "</pre>");
			pageLoad('PiVPN');
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
function rProfile(user){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/profile-revoke.php',
		data:{
			profile:user
		},
		success:function(result) {
			load(false);
			genModal("Profile revoke status (" + user + "):", '<pre style="overscroll-y:scroll; max-height:400px;">' + result + "</pre>");
			pageLoad('PiVPN');
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
function createProfile(){
	profileForm = '<input class="form-control" type="text" placeholder="Profile Name" name="profile_name" id="profile_name">';
	profileForm += '<br /><br /> <button class="btn btn-sm btn-raised btn-info pull-right" onclick="oProfile();">Create Profile</button><br /><br />';
	genModal("Create new PiVPN Profile", profileForm);

}
function displayLog(filename){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/logs.php',
		data:{
			log:filename
		},
		success:function(result) {
			load(false);
			genModal("Log \"" + filename + "\" content:", "<pre class=\"ativa-scroll\">" + result + "</pre>");
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
function displayProfile(filename){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/logs.php',
		data:{
			log:filename
		},
		success:function(result) {
			load(false);
			genModal("OpenVPN Profile \"" + filename + "\" content:<br><small>Copy and paste into an OVPN file to use</small>", "<pre class=\"ativa-scroll\">" + result + "</pre>");
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
function delScript(filename){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/apps.php',
		data:{
			script:filename,
			type:'delete'
		},
		success:function(result) {
			load(false);
			genModal("Results", "<pre>" + result + "</pre>");
			pageLoad('apps');
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
function unblock(ip){
	load(true)
	$.ajax({
		method:'post',
		url:'./app/block.php',
		data:{
			ip:ip
		},
		success:function(result) {
			load(false);
			if(result == ""){
				genModal("Results", "<pre>IP has been unblocked!</pre>");
				pageLoad('block');
			} else {
				genModal("Results", "<pre>" + result + "</pre>");
				pageLoad('block');
			}
		}
		}).fail(function(e) {
			load(false);
			genModal("Error", e);
		});
}
//Prototypes
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function resize_frame(){
    var window_height = ( $(document).height() * 7 / 10 );
    $('#shellinaboxdiv').css('height',window_height+'px');
}
