<?php   
// Show Student's Information
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
if($userId==""){
    header("Location: login");
    exit;
}
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];
$schoolId = $_SESSION['schoolId'];
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep //Information.</title>
	<style>
	 caption { 
	     display: table-caption;
	     text-align: center;
	 }
	</style>
    </head>

    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
                    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
				<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
				<li class="active">My Information</li>
                            </ol>
			</div>
                    </div>

		    <?php
		    include 'connectdb.php';
		    if($userType == 'student'){
			$gender = getUserGender($userId);
			$grade = getGrade($userId);
			$className = getClassName($classId);
			$semester = getStudentSemesterYear($userId);
			$schoolName = getSchoolName($schoolId);
		    }
		    ?>
		    <?php if($userType == 'student'){ ?>
		    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
			<table class="table table-striped" style="padding-top: 1cm">
			    <caption><h2>My Information</h2></caption>
			    <tbody>
				<!-- <tr>
				    <td>User ID</td><td><?php echo $userId; ?></td>
				     </tr> -->
				<tr>
				    <td>Gender</td><td><?php echo $gender; ?></td>
				</tr>
				<tr>
				    <td>Grade</td><td><?php echo $grade; ?></td>
				</tr>
				<tr>
				    <td>Class</td><td><?php echo $className; ?></td>
				</tr>
				<tr>
				    <td>Semester</td><td><?php echo $semester; ?></td>
				</tr>
				<tr>
				    <td>School</td><td><?php echo $schoolName; ?></td>
				</tr>
			    </tbody>
			</table>
		    </div>
		    <?php }elseif($userType == 'parent'){ ?>
			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
			    <table class="table table-striped" style="padding-top: 1cm">
				<caption><h2>My Information</h2></caption>
				<tbody>
				    <tr>
					<td>User ID</td><td><?php echo $userId; ?></td>
				    </tr>
				</tbody>
			    </table>
			</div>
		    <?php } ?>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
