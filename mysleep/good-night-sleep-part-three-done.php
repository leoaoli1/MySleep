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
			if (isset($_POST['save'])) {
			    $submitFlag = FALSE;
			}else {
			    $submitFlag =TRUE;
			}
			
                        $arrHardChange = array($_POST['hardOne'], $_POST['hardTwo'], $_POST['hardThree']);
			$arrEasyChange = array($_POST['easyOne'], $_POST['easyTwo'], $_POST['easyThree']);
			
			$hardChange =  base64_encode(serialize($arrHardChange));
			$easyChnage =  base64_encode(serialize($arrEasyChange));

			if($_POST['categories'] == "1"){
			    $status = mysql_query("INSERT INTO fourthGradeLessonThreeTableThree(userId, familyRoutinesHardChange, familyRoutinesEasyChange, submit) VALUES ('$userId', '$hardChange', '$easyChnage', '$submitFlag')");
			}elseif($_POST['categories'] == "2"){
			    $status = mysql_query("INSERT INTO fourthGradeLessonThreeTableThree(userId, activitiesHardChange, activitiesEasyChange, submit) VALUES ('$userId', '$hardChange', '$easyChnage', '$submitFlag')");
			}elseif($_POST['categories'] == "3"){
			    $status = mysql_query("INSERT INTO fourthGradeLessonThreeTableThree(userId, environmentHardChange, environmentEasyChange, submit) VALUES ('$userId', '$hardChange', '$easyChnage', '$submitFlag')");
			}
			
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
				echo '<a class="btn btn-large btn-block"  name="Continue" href="good-night-sleep-part-three">Continue</a>';
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



