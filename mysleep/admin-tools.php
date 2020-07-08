<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#

// Miscellaneous tools for development and admin purposes
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
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Settings</title>
    </head>

    <body>
    <?php include 'partials/nav.php' ; ?>
    <div class="wrapper" >
		<div class="main main-raised">
			<div class="container">
                <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                        <ol class="breadcrumb">
                                            <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                            <li class="active">Settings</li>
                                        </ol>
                            </div>
                        </div>
        <?php  if ($userType == 'researcher') { ?>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>School Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-school-info'">
                            <span>
                                <i class="material-icons">school</i>
                            </span>
                            <p>Manage Schools</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='set-class-info'">
                            <span>
                                <i class="material-icons">class</i>
                            </span>
                            <p>Manage Classes</p>
                        </div>
                    </div>
                </div>
		<div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='researcher-link-teacher-class'">
                            <span>
                                <i class="material-icons">people_outline</i>
                            </span>
                            <p>Link Teacher with Classes</p>
                        </div>
                    </div>
		</div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>User Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='show-all-users'">
                            <span>
                                <i class="material-icons">people_outline</i>
                            </span>
                            <p>Show All Users</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
					<div class="lesson lesson-primary" onclick="location.href='registration'">
                            <span>
                                <i class="material-icons">add_circle_outline</i>
                            </span>
                            <p>Create User Account</p>
                        </div>
                    </div>
                </div>
		<div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='bundle-create-parent-account'">
                            <span>
                                <i class="material-icons">add_circle_outline</i>
                            </span>
                            <p>Bundle Create Parent Account</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>Your Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-email-address'">
                            <span>
                                <i class="material-icons">mail_outline</i>
                            </span>
                            <p>Update E-Mail Address</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='update-password'">
                            <span>
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <p>Update Password</p>
                        </div>
                    </div>
                </div>
        <?php }
        else if ($userType == 'student') { ?>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-email-address'">
                            <span>
                                <i class="material-icons">mail_outline</i>
                            </span>
                            <p>Update E-Mail Address</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='update-password'">
                            <span>
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <p>Update Password</p>
                        </div>
                    </div>
                </div>
                <div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='invitation-email'">
                            <span>
                                <i class="material-icons">mail_outline</i>
                            </span>
                            <p>Send Invitation E-Mail to Your Parents</p>
                        </div>
                    </div>
		    <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='generate-random-code'">
                            <span>
                                <i class="material-icons">people_outline</i>
                            </span>
                            <p>Generate Verification Code</p>
                        </div>
                    </div>
                </div>
		<div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='my-info'">
                            <span>
                                <i class="material-icons">info</i>
                            </span>
                            <p>My Information</p>
                        </div>
                    </div>
                    <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-8 col-sm-offset-2">
                         <div class="lesson lesson-primary" onclick="location.href='registration'">
                         <span>
                         <i class="material-icons">add_circle_outline</i>
                         </span>
                         <p>Create User Account</p>
                         </div>
			 </div> -->
                </div> 
       <?php }
        else if ($userType == 'parent') { ?>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-email-address'">
                            <span>
                                <i class="material-icons">mail_outline</i>
                            </span>
                            <p>Update E-Mail Address</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='update-password'">
                            <span>
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <p>Update Password</p>
                        </div>
                    </div>
                </div>
		<div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='parent-set-school'">
                            <span>
                                <i class="material-icons">school</i>
                            </span>
                            <p>Set School</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='parent-link-student'">
                            <span>
                                <i class="material-icons">people_outline</i>
                            </span>
                            <p>Link Your Children</p>
                        </div>
                    </div>
                </div>
		<!--<div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='my-info'">
                            <span>
                                <i class="material-icons">info</i>
                            </span>
                            <p>My Information</p>
                        </div>
                    </div>
                </div>-->
        <?php }
        else if ($userType == 'teacher') { ?>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>Lesson Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-class-info'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Manage Classes</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='set-lesson-status'">
                            <span>
                                <i class="material-icons">lock_open</i>
                            </span>
                            <p>Lock/Unlock Lessons</p>
                        </div>
                    </div>
                </div>
		<div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='link-teacher-class'">
                            <span>
                                <i class="material-icons">people_outline</i>
                            </span>
                            <p>Link Teachers to This Class</p>
                        </div>
                    </div>
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='set-reminder-status'">
                            <span>
                                <i class="material-icons">lock_open</i>
                            </span>
                            <p>Turn On/Off Reminder</p>
                        </div>
                    </div>
                </div>
		<div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>Dairy Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-diary-date'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Set Sleep Diary Date</p>
                        </div>
                    </div>
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='set-activity-date'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Set Activity Diary Date</p>
                        </div>
                    </div>
                </div>
		<div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='delete-diary?diary=sleep'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Delete Students' Sleep Diary</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='delete-diary?diary=activity'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Delete Students' Activity Diary</p>
                        </div>
                    </div>
		</div>
		<div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='switch-diary?diary=sleep'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Change Students' Sleep Diary Date</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='switch-diary?diary=activity'">
                            <span>
                                <i class="material-icons">bookmark_border</i>
                            </span>
                            <p>Change Students' Activity Diary Date</p>
                        </div>
                    </div>
		</div>
		<?php
		$classId = $_SESSION['classId'];
		include 'connectdb.php';
		$grade = getClassGrade($classId);
		mysql_close($con);
		if($grade == '4'){
		?>
		<div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
			<div class="lesson lesson-primary" onclick="location.href='set-diary-computation'">
                            <span>
				<i class="material-icons">lock_open</i>
                            </span>
                            <p>Lock/Unlock Sleep Diary Computation</p>
			</div>
                    </div>
		</div>
		<?php } ?>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>Student Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-user-link'">
                            <span>
                                <i class="material-icons">face</i>
                            </span>
                            <p>Link Students</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='set-class'">
                            <span>
                                <i class="material-icons">class</i>
                            </span>
                            <p>Set Student Class</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-semester'">
                            <span>
                                <i class="material-icons">date_range</i>
                            </span>
                            <p>Set Student Semester</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='show-students-info'">
                            <span>
                                <i class="material-icons">people_outline</i>
                            </span>
                            <p>Show Student Information</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='reset-password'">
                            <span>
                                <i class="material-icons">refresh</i>
                            </span>
                            <p>Reset Student Passwords</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='registration'">
                            <span>
                                <i class="material-icons">add_circle_outline</i>
                            </span>
                            <p>Create Student Account</p>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='bundle-create-student-account'">
                            <span>
                                <i class="material-icons">add_circle_outline</i>
                            </span>
                            <p>Bundle Create Student Accounts (Create Student Accounts by .csv file)</p>
                        </div>
                    </div>
		    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='change-username'">
                            <span>
                                <i class="material-icons">refresh</i>
                            </span>
                            <p>Change Student Username</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <h3>Your Settings</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-2">
                        <div class="lesson lesson-primary" onclick="location.href='set-email-address'">
                            <span>
                                <i class="material-icons">mail_outline</i>
                            </span>
                            <p>Update E-Mail Address</p>
                        </div>
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-4 col-sm-offset-0">
                        <div class="lesson lesson-primary" onclick="location.href='update-password'">
                            <span>
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <p>Update Password</p>
                        </div>
                    </div>
                </div>
        <?php } ?>
            </div>
        </div>
        <?php include 'partials/footer.php' ?>
    </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
