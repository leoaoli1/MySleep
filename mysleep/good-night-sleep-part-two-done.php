web mode<!DOCTYPE html>
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
			/*if (isset($_POST['save'])) {
			    $submitFlag = FALSE;
			}else {
			    $submitFlag =TRUE;
			}*/
			$submitFlag =TRUE;
			
                        $familyRoutines = [];
			$activities = [];
			$environment = [];
			
			$countFacilitor = $_POST['countFacilitor'];
			for($count = 0; $count<=$countFacilitor; $count++){
			    $category = $_POST['facilitatorsOption'.$count];
			    if($category == '1'){
				array_push($familyRoutines, $_POST['facilitators'.$count]);
			    }elseif($category == '2'){
				array_push($activities, $_POST['facilitators'.$count]);
			    }elseif($category == '3'){
				array_push($environment, $_POST['facilitators'.$count]);
			    }
			}


			$countCompetitor = $_POST['countCompetitor'];
			
			for($count = 0; $count<=$countCompetitor; $count++){
			    $category = $_POST['competitorsOption'.$count];
			    if($category == '1'){
				array_push($familyRoutines, $_POST['competitors'.$count]);
			    }elseif($category == '2'){
				array_push($activities, $_POST['competitors'.$count]);
			    }elseif($category == '3'){
				array_push($environment, $_POST['competitors'.$count]);
			    }
			}

			//print_r($facilitators);
			//print_r($competitors);
                        //print_r($familyRoutines);
			//print_r($activities);
			//print_r($environment);
			$familyRoutinesAnswer =  base64_encode(serialize($familyRoutines));
			$activitiesAnswer =  base64_encode(serialize($activities));
			$environmentAnswer =  base64_encode(serialize($environment));

			$status = mysql_query("INSERT INTO fourthGradeLessonThreeTableTwo(userId, familyRoutines, activities, environment, submit) VALUES ('$userId', '$familyRoutinesAnswer', '$activitiesAnswer', '$environmentAnswer', '$submitFlag')"); 
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
				echo '<a class="btn btn-large btn-block"  name="Continue" href="good-night-sleep-part-two">Continue</a>';
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

