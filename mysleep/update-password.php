<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li, Wo-Tak Wu
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Update Password</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
			<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
			<li class="active">Update Password</li>
		    </ol>
		    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1cm;">
			<h4 class="description">
			    <div class="row" style="color:black">
				Update Password
			    </div>
			</h4>
			<h4 class="description">
			    <span class="row" style="color:red" id="alert">
				
			    </span>
			</h4>
		    </div>
		    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
			<form id="passwordForm">
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="password0"><h4 style="color:black">Current Password:</h4></label>
				    <input class="form-control"; type="password" name="password0" id="password0" </input>
				</div>
			    </div>
			    <div class="checkbox">
				<label>
				    <input type="checkbox" name="showPassword" id="showPassword0">
				    Show Current Password
				</label>
			    </div> 
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="password1"><h4 style="color:black">New Password:</h4></label>
				    <input class="form-control"; type="password" name="password1" id="password1" </input>
				</div>
			    </div>
			    <div class="checkbox">
				<label>
				    <input type="checkbox" name="showPassword" id="showPassword1">
				    Show New Password
				</label>
			    </div> 
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="password2"><h4 style="color:black">Re-enter New Password:</h4></label>
				    <input class="form-control"; type="password" name="password2" id="password2" </input>
				</div>
			    </div>
			    <div class="checkbox">
				<label>
				    <input type="checkbox" name="showPassword" id="showPassword2">
				    Show Re-enter New Password
				</label>
			    </div> 
			    <div class="row" style="padding-top: 1cm">
				<input class='btn btn-danger btn-large btn-block' type='submit' name='submit' value='Submit' /> 
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php'?>
	<script>
	 $('input').on('click',function () {
	     if($("#showPassword0").is(':checked')) {
		 $("#password0").attr('type','text');
	     } else {
		 $("#password0").attr('type','password');
	     }
	     if($("#showPassword1").is(':checked')) {
		 $("#password1").attr('type','text');
	     } else {
		 $("#password1").attr('type','password');
	     }
	     if($("#showPassword2").is(':checked')) {
		 $("#password2").attr('type','text');
	     } else {
		 $("#password2").attr('type','password');
	     }
	 });
	 
	 $(function () {
             $('form').on('submit', function (e) {
		 
		 e.preventDefault();

		 $.ajax({
		     type: 'post',
		     url: 'update-password-done',
		     data: $('form').serialize(),
		     success: function (response) {
			 $('#alert').text(response);
			 $('#password0').val('');
			 $('#password1').val('');
			 $('#password2').val('');
			 var reply = response.replace(/\s+/, ""); //remove any trailing white spaces from returned string
			 if(reply == 'Success'){
			     alert("Suceess, You will now be redirected to Log in page.");
			     window.location.href = "./login";
			 }
		     }
		 });

             });

	 });
	</script>
    </body>
</html>
