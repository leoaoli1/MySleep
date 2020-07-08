<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
# Will delete this file in the future
// Establish link from one user to another
// Currently, user can be linked to other student users so that he/she can access the students' data,
//   for example, sleep and activity diaries.
// This concept can be expanded to build, for example, groups within a class, so that
//   a group of students may share each other's lesson data.
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
unset($_SESSION['addLink']);
unset($_SESSION['deleteLink']);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Delete Diary</title>
    </head>
    

    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                        <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
                        <li class="active">Link Students</li>
		    </ol>

		    <!-- For deleting link -->
		    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
<form action="set-user-link-done" method="post"> 
    <div class="row">
        <select class="form-control input-lg" name='updateUserId'>
		<option value='null' disabled selected>Please choose a student to break link</option>
            <?php
                include 'connectdb.php';
                $targetUserIds = getLinkedUserIds($userId);
                showUserOptionList($targetUserIds);
                mysql_close($con);
            ?>
        </select>
	<button class='btn btn-danger btn-large btn-block' type="submit" name='deleteLink'>Break Link</button>
    </div>
</form>

<!-- For adding link -->
<form action="set-user-link-done" method="post"> 
    <div class="row">
        <select class="form-control input-lg" name='updateUserId'>
		<option value='null' disabled selected>Please choose a student to link</option>
            <?php
                include 'connectdb.php';
                $currentLinkUserIds = getLinkedUserIds($userId);
                $allStudentUserIds = getStudentUserIds();
                $targetUserIds = array_diff($allStudentUserIds, $currentLinkUserIds);
                showUserOptionList($targetUserIds);
                mysql_close($con);
            ?>
        </select>
	<button class='btn btn-danger btn-large btn-block' type="submit" name='addLink'>Add Link</button>
    </div>
</form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/scripts.php' ?>
    </body>
    <?php include 'partials/footer.php' ?>
</html>
