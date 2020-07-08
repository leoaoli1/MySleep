<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu> James Michael Geiger<jamesgeiger@email.arizona.edu >
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
} 
if($userType!="teacher" && $userType!="researcher"){
    header("Location: login");
    exit;
} 
?>

<html>
    <head>
		<?php include 'partials/header.php' ?>
        <title>MySleep //Bundle Create Account</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
		<link href="./assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
		<script src="./assets/js/jquery.min.js"></script>
		<script src="./assets/js/canvas-to-blob.min.js" type="text/javascript"></script>
		<script src="./assets/js/sortable.min.js" type="text/javascript"></script>
		<script src="./assets//js/purify.min.js" type="text/javascript"></script>
		<!-- the main fileinput plugin file -->
		<script src="./assets/js/fileinput.min.js"></script>
		<script src="./assets/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
            <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
			<li class="active">Bundle Create Parent Accounts</li>
		    </ol>
		    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em;">
			<h4 class="description">
			    <div class="row" style="color:black">
				Create Parent accounts by a .csv file
			    </div>
			    <div class="row" style="color:black">
				<li><a href="docs/createParentsAccountsTemplate.csv" download>Template
				</a></li>
			    </div>
			</h4>
		    </div>
			
			<div class="row col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				<form name="inputForm" action="bundle-create-parent-account-done" enctype="multipart/form-data"  method="post"  id="uploadedFile">
					<label class="control-label">Select File</label>
					<input id="input" type="file" name="createParentAccounts" class="file">
				</form>
			</div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<script>
	  $('#input').fileinput({
		fileActionSettings: {
			showZoom: false
		},
		
	    allowedFileExtensions: ['csv']
	});
	</script>
	<?php include 'partials/scripts.php' ?>
    </body>
</html>
