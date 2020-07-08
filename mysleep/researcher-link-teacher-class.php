
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
$classId = $_SESSION['classId'];
$schoolId = $_SESSION['schoolId'];
if($userId==""){
    header("Location: login");
    exit;
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Link Teachers</title>
    </head>


    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                        <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
                        <li class="active">Link Teachers and Classes</li>
		    </ol>

		    <div class="content" style="padding: 1cm">
			<form action="researcher-link-teacher-class-done" method="post" id="nameForm" enctype="multipart/form-data">
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>Class Name</h2></label>
				    <select class="form-control input-lg" name='classId'>
					<option value='null' disabled selected>Please choose a teacher to link</option>
					<?php
					include 'connectdb.php';
					$result = mysql_query("SELECT classId, className FROM class_info_table");
					while($row=mysql_fetch_array($result)){
					    echo "<option value='".$row['classId']."'>".$row['className']."</option>";
					}
					mysql_close($con);
					?>
				    </select>
				</div>
			    </div>
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>Teacher Name</h2></label>
				    <select class="form-control input-lg" name='linkUserId'>
					<option value='null' disabled selected>Please choose a teacher to link</option>
					<?php
					include 'connectdb.php';
					$result = mysql_query("SELECT userId, firstName, lastName FROM user_table WHERE type='teacher'");
					while($row=mysql_fetch_array($result)){
					    echo "<option value='".$row['userId']."'>".$row['firstName']." ".$row['lastName']."</option>";
					}
					mysql_close($con);
					?>
				    </select>
				</div>
				<button class="btn btn-primary btn-large btn-block" type="submit" onclick="return confirm('Are you sure you want to link?')">Link</button>
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
