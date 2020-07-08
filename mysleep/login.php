<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
session_start();
unset($_SESSION['userId']);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>MySleep // Log In</title>
    </head>

    <body class="signup-page">
	<nav class="navbar navbar-transparent navbar-absolute">
    	    <div class="container">
        	<!-- Brand and toggle get grouped for better mobile display -->
        	<div class="navbar-header">
        	    <a class="navbar-brand" href="#">MySleep</a>
        	</div>
    	    </div>
	</nav>

	<div class="wrapper">
	    <div class="header header-filter">
		<div class="container">
		    <div class="row">
			<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			    <div class="card card-signup">
				<form class="form" method="post" action="login-done">
				    <div class="header header-gradpr text-center">
					<h4>Log In to MySleep</h4>
				    </div>
				    <div class="content">
					<div class="input-group">
					    <span class="input-group-addon">
						<i class="material-icons">face</i>
					    </span>
					    <input type="text" class="form-control input-lg" name="username" placeholder="Username...">
					</div>

					<div class="input-group">
					    <span class="input-group-addon">
						<i class="material-icons">lock_outline</i>
					    </span>
					    <input type="password" placeholder="Password..." name="password" id="password" class="form-control input-lg" value="" autocomplete="off" />
					</div>


					<div class="checkbox">
					    <label>
						<input type="checkbox" name="showPassword" id="showPassword">
						Show Password
					    </label>
					</div>
				    </div>
				    <div class="footer text-center">
					<button class="btn btn-simple btn-primary btn-lg" type="submit">Sign In</button>
				    </div>
				</form>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<?php require 'partials/scripts.php' ?>
	<script>
	 $('input').on('click',function () {
	 if($("#showPassword").is(':checked')) {
	     $("#password").attr('type','text');
	 } else {
	     $("#password").attr('type','password');
	 }
	 });
	</script>
    </body>

</html>
