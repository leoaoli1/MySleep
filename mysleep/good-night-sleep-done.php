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
$userType = $_SESSION['userType'];
if ($userId == ""){
    header("Location: login.php");
    exit;
}
if (isset($_POST['quit'])) {
    header("Location: fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep");
    exit;
}
$classId = $_SESSION['classId'];
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
		    <?php
            if (isset($_POST['save'])) {
			$submitFlag = FALSE;
		    }else {
			$submitFlag =TRUE;
		    }
			
		    if(isset($_POST)){
		    include 'connectdb.php';
			$facilitators = [];
		    array_push($facilitators, $_POST['facilitators_1']);
		    array_push($facilitators, $_POST['facilitators_2']);
			array_push($facilitators, $_POST['facilitators_3']);
			$competitors = [];
			array_push($competitors, $_POST['competitors_1']);
			array_push($competitors, $_POST['competitors_2']);
			array_push($competitors, $_POST['competitors_3']);
			
			$facilitatorAnswers= base64_encode(serialize($facilitators));
			$competitorAnswers = base64_encode(serialize($competitors));

		    /*-----------------------------------------------*/
		    /*				Save to MySQL        */
		    /*-----------------------------------------------*/
		    $status = mysql_query("INSERT INTO fourthGradeLessonThreeTableOne(userId, classId, userType, facilitatorAnswers, competitorAnswers, submit) VALUES ('$userId', '$classId', '$userType', '$facilitatorAnswers', '$competitorAnswers', '$submitFlag')"); 
		    if (!$status) {
			$message = 'Could not enter answers to the database: ' . mysql_error();
			error_exit($message);
		    }
		    mysql_close($con);
                    }
		    ?>
		    <div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php
			    if (!$submitFlag) {

				echo '<h2>You Saved it</h2>';

			    }else {

				echo '<h2>You Submitted it</h2>';
			    }
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    if(!$submitFlag){
				echo '<a class="btn btn-large btn-block"  name="Continue" href="good-night-sleep">Continue</a>';
			    }else{
			    echo '<a class="btn btn-large btn-block"  name="Done" href="fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep">Done</a>';
			    }
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
