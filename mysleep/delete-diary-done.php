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
if ($userId=="") {
    header("Location: login.php");
    exit;
}
$diary = $_SESSION['diary'];
unset( $_SESSION['diary']);
    $diaryId=$_POST['diaryId'];
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
include 'connectdb.php';
if($diary=='sleep'){
    $status = mysql_query("UPDATE diary_data_table SET " .
			  "alertSent = 0,".
		      "roomDarkness=NULL," .
		      "roomQuietness=NULL," .
		      "roomWarmness=NULL," .
		      "timeLightsOff=NULL," .
		      "timeFellAsleep=NULL," .
			  "minFallAsleep=NULL,".
		      "timeWakeup=NULL," .
		      "numWokeup=NULL," .
		      "minWokeup=NULL," .
		      "disturbedByNoise=NULL," .
		      "disturbedBypets=NULL," .
		      "disturbedByElectronics=NULL," .
		      "disturbedByFamily=NULL," .
		      "disturbedByDream=NULL," .
		      "disturbedByBathroomNeed=NULL," .
		      "disturbedByTemperature=NULL," .
		      "disturbedByIllness=NULL," .
		      "disturbedByBodilyPain=NULL," .
		      "disturbedByWorries=NULL," .
		      "disturbedByBusyMinds=NULL," .
		      "disturbedByLighting=NULL," .
		      "disturbedByUnknown=NULL," .
		      "disturbedByNothing=NULL," .
		      "disturbedByOther=NULL," .
		      "disturbedByOtherContent=NULL," .
		      "hourSlept=NULL," .
		      "actBefSleepTV=NULL," .
		      "actBefSleepMusic=NULL," .
		      "actBefSleepVideoGame=NULL," .
		      "actBefSleepComp=NULL," .
		      "actBefSleepRead=NULL," .
		      "actBefSleepHomework=NULL," .
		      "actBefSleepShower=NULL," .
		      "actBefSleepPlayWithPeople=NULL," .
		      "actBefSleepSnack=NULL," .
		      "actBefSleepText=NULL," .
		      "actBefSleepPhone=NULL," .
		      "actBefSleepDrinkCaff=NULL," .
		      "actBefSleepExercise=NULL," .
		      "actBefSleepMeal=NULL," .
		      "actBefSleepOther=NULL," .
		      "actBefSleepOtherContent=NULL," .
		      "wokeupState=NULL," .
		      "sleepQuality=NULL," .
		      "sleepCompare=NULL," .
		      "timeCompleted=NULL," .
		      "diaryGrade=NULL " .
		      "WHERE diaryId='$diaryId'");
}else{
    $status = mysql_query("UPDATE activity_diary_data_table SET " .
			  "alertSent = 0,".
			  "napStart=NULL," .
			  "napEnd=NULL," .
			  "minExercised=NULL," .
			  "numCaffeinatedDrinks=NULL," .
			  "feltDuringDay=NULL," .
			  "howSleepy=NULL," .
			  "howAttentive=NULL," .
			  "timeCompleted=NULL, " .
			  "diaryGrade=NULL " .
			  "WHERE diaryId='$diaryId'"); 
    }
if (!$status) {
    $message = 'Could not add diary to the database: ' . mysql_error();
    error_exit($message);
}

mysql_close($con);

//header("Location: main-page.php");
//exit;
?>

<div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php
	
				echo '<h2>You deleted it</h2>';
			 
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
                            if($diary=='sleep'){
				echo '<a class="btn btn-large btn-block"  name="Done" href="delete-diary?diary=sleep">Done</a>';
			    }else{
				echo '<a class="btn btn-large btn-block"  name="Done" href="delete-diary?diary=activity">Done</a>';
				}
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>

