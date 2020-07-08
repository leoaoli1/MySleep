<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
$lessonInfo = $_SESSION['lessonInfo'];
$lesson = $lessonInfo["lesson"];
$activity = $lessonInfo["activity"];
$tab = $lessonInfo["tab"];
if ($userId == ""){
    header("Location: login.php");
    exit;
}

$groupMember = $_POST['groupMember'];
$memberList=explode(',',$groupMember);
//print_r($memberList);

/*-----------------------------------------------*/
/*				Save to MySQL                    */
/*-----------------------------------------------*/
include 'connectdb.php';
foreach($memberList as $member){
    $status = mysql_query("INSERT INTO student_group (userId, linkUserId, classId, lesson, activity, tab) VALUES ('$member', '$userId', '$classId', '$lesson', '$activity', '$tab')"); 
    if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
    }
}

?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
	<style type="text/css">
	 .top{
	     margin-top: 200px;
	 }
	</style>
    </head>
    <body>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
		    <div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php

			    echo '<h2>You Submitted it</h2>';
			    
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    $classGrade = getClassGrade($classId);
			    if($classGrade == '5'){
				if($lesson == '3'){
				    if($activity == '1'){
					if($tab == 'gameChanger'){
					    echo '<a class="btn btn-large btn-block"  name="Done" href="basketball-tests-review">Done</a>';
					}
				    }
				}elseif($lesson == '1'){
				    if($activity == '2'){
					if($tab == 'g5l1worksheet'){
					    echo '<a class="btn btn-large btn-block"  name="Done" href="fifth-grade-lesson-activity-menu?lesson=1&activity=2">Done</a>';
					}elseif($tab == 'g5l1summary'){
					    echo '<a class="btn btn-large btn-block"  name="Done" href="fifth-grade-lesson-activity-menu?lesson=1&activity=2">Done</a>';
					}
					
				    }
				}
			    }
			    mysql_close($con);
			    unset($_SESSION['lessonInfo']);
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>



