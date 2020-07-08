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
checkauth();
$userId= $_SESSION['userId'];
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
$userType = $_SESSION['userType'];
if (isset($_POST['quit'])) {
    header("Location: fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep");
    exit;
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
		    <?php 
		    if(isset($_POST)){
			include 'connectdb.php';
			$resultLink = getUserIdsInClass($classId);
			$submitFlag =TRUE;

			$countFacilitor = $_POST['countFacilitor'];
			$facilitators = [];
			for($count = 0; $count<=$countFacilitor; $count++){
			    if($_POST['checkboxFacilitators'.$count] == 'on'){
				array_push($facilitators, $_POST['facilitators'.$count]);
			    }
			}


			$countCompetitor = $_POST['countCompetitor'];
			$competitors = [];
			for($count = 0; $count<=$countCompetitor; $count++){
			    if($_POST['checkboxCompetitors'.$count] == 'on'){
				array_push($competitors, $_POST['competitors'.$count]);
			    }
			}

			//print_r($facilitators);
			//print_r($competitors);

			$facilitatorAnswers= base64_encode(serialize($facilitators));
			$competitorAnswers = base64_encode(serialize($competitors));

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
			    <h2>You Submitted it</h2>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <a class="btn btn-large btn-block"  name="Done" href="fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep">Done</a>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>

