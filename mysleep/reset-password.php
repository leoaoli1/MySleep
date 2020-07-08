<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
/*$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];*/
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if($userType==='teacher') {
	$classId = $_SESSION['classId'];
}
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Reset Password</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
			<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
			<li class="active">Reset Password</li>
		    </ol>
		    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em;">
			<h4 class="description">
			    <div class="row" style="color:black">
				
			    </div>
			</h4>
		    </div>
		    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
			<form id="resetPasswordForm" action="reset-password-done" method="post">
			    <div class='row'>
				<?php    
				echo "<label class='control-label' for='targetUserId'><h4 style='color:black'>Student Name:</h4></label>";
				if($userType==="researcher") {
	    			    echo "<input class='entry'; name='targetUserId' </input>";
				}else {
	    			    include 'connectdb.php';
	    			    echo "<select style='font-size:inherit' name='targetUserId' id='targetUserId' class='form-control input-lg'>";
				    echo "<option value='null'>Please Choose A Student</option>";
         			    $studentUserIds = getUserIdsInClass($classId);
				    foreach ($studentUserIds as $user) {
        				list($firstName, $lastName) = getUserFirstLastNames($user);
        				echo "<option value='$user'>" . $firstName ." ". $lastName. "</option>";
    				    }
				    echo "</select>";
				    mysql_close($con);
				}
				?>
			    </div>
			    <div class="row">
				<input class="btn btn-danger btn-large btn-block"; type="submit" value="Reset"/>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php'?>
    </body>
</html>
