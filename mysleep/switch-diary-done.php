<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li , Wo-Tak Wu 
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
$fromDiaryId=$_POST['fromDiaryId'];
$toDiaryId=$_POST['toDiaryId'];
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
    $status = mysql_query("UPDATE diary_data_table t, (".
			  "SELECT ". 
			  "roomDarkness, ". 
			  "roomQuietness, ".
			  "roomWarmness, " .
			  "timeLightsOff, " .
			  "timeFellAsleep," .
			  " minFallAsleep," .
			  " timeWakeup," .
			  " numWokeup," .
			  " minWokeup," .
			  " disturbedByNoise," .
			  " disturbedBypets," .
			  " disturbedByElectronics," .
			  " disturbedByFamily," .
			  " disturbedByDream," .
			  " disturbedByBathroomNeed," .
			  " disturbedByTemperature," .
			  " disturbedByIllness," .
			  "disturbedByBodilyPain," .
			  " disturbedByWorries," .
			  " disturbedByBusyMinds," .
			  " disturbedByLighting," .
			  " disturbedByUnknown," .
			  " disturbedByNothing," .
			  " disturbedByOther," .
			  " disturbedByOtherContent," .
			  " hourSlept," .
			  " actBefSleepTV," .
			  " actBefSleepMusic," .
			  " actBefSleepVideoGame," .
			  " actBefSleepComp," .
			  " actBefSleepRead," .
			  " actBefSleepHomework," .
			  " actBefSleepShower," .
			  " actBefSleepPlayWithPeople," .
			  " actBefSleepSnack," .
			  " actBefSleepText," .
			  " actBefSleepPhone," .
			  " actBefSleepDrinkCaff," .
			  " actBefSleepExercise," .
			  " actBefSleepMeal," .
			  " actBefSleepOther," .
			  " actBefSleepOtherContent," .
			  " wokeupState," .
			  " sleepQuality," .
			  " sleepCompare," .
			  " timeCompleted," .
			  " diaryGrade " .
			  "FROM diary_data_table " .
			  "WHERE diaryId='$fromDiaryId') fromData SET " .
			  "t.timeCompleted = fromData.timeCompleted,".
			  "t.alertSent = 1,".
			  "t.roomDarkness=fromData.roomDarkness," .
			  "t.roomQuietness=fromData.roomQuietness," .
			  "t.roomWarmness=fromData.roomWarmness," .
			  "t.timeLightsOff=fromData.timeLightsOff," .
			  "t.timeFellAsleep=fromData.timeFellAsleep," .
			  "t.minFallAsleep=fromData.minFallAsleep,".
			  "t.timeWakeup=fromData.timeWakeup," .
			  "t.numWokeup=fromData.numWokeup," .
			  "t.minWokeup=fromData.minWokeup," .
			  "t.disturbedByNoise=fromData.disturbedByNoise," .
			  "t.disturbedBypets=fromData.disturbedBypets," .
			  "t.disturbedByElectronics=fromData.disturbedByElectronics," .
			  "t.disturbedByFamily=fromData.disturbedByFamily," .
			  "t.disturbedByDream=fromData.disturbedByDream," .
			  "t.disturbedByBathroomNeed=fromData.disturbedByBathroomNeed," .
			  "t.disturbedByTemperature=fromData.disturbedByTemperature," .
			  "t.disturbedByIllness=fromData.disturbedByIllness," .
			  "t.disturbedByBodilyPain=fromData.disturbedByBodilyPain," .
			  "t.disturbedByWorries=fromData.disturbedByWorries," .
			  "t.disturbedByBusyMinds=fromData.disturbedByBusyMinds," .
			  "t.disturbedByLighting=fromData.disturbedByLighting," .
			  "t.disturbedByUnknown=fromData.disturbedByUnknown," .
			  "t.disturbedByNothing=fromData.disturbedByNothing," .
			  "t.disturbedByOther=fromData.disturbedByOther," .
			  "t.disturbedByOtherContent=fromData.disturbedByOtherContent," .
			  "t.hourSlept=fromData.hourSlept," .
			  "t.actBefSleepTV=fromData.actBefSleepTV," .
			  "t.actBefSleepMusic=fromData.actBefSleepMusic," .
			  "t.actBefSleepVideoGame=fromData.actBefSleepVideoGame," .
			  "t.actBefSleepComp=fromData.actBefSleepComp," .
			  "t.actBefSleepRead=fromData.actBefSleepRead," .
			  "t.actBefSleepHomework=fromData.actBefSleepHomework," .
			  "t.actBefSleepShower=fromData.actBefSleepShower," .
			  "t.actBefSleepPlayWithPeople=fromData.actBefSleepPlayWithPeople," .
			  "t.actBefSleepSnack=fromData.actBefSleepSnack," .
			  "t.actBefSleepText=fromData.actBefSleepText," .
			  "t.actBefSleepPhone=fromData.actBefSleepPhone," .
			  "t.actBefSleepDrinkCaff=fromData.actBefSleepDrinkCaff," .
			  "t.actBefSleepExercise=fromData.actBefSleepExercise," .
			  "t.actBefSleepMeal=fromData.actBefSleepMeal," .
			  "t.actBefSleepOther=fromData.actBefSleepOther," .
			  "t.actBefSleepOtherContent=fromData.actBefSleepOtherContent," .
			  "t.wokeupState=fromData.wokeupState," .
			  "t.sleepQuality=fromData.sleepQuality," .
			  "t.sleepCompare=fromData.sleepCompare," .
			  "t.timeCompleted=fromData.timeCompleted," .
			  "t.diaryGrade=fromData.diaryGrade " .
			  "WHERE diaryId='$toDiaryId'");
    mysql_query("UPDATE diary_data_table SET " .
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
		"WHERE diaryId='$fromDiaryId'");
}else{
    $status = mysql_query("UPDATE activity_diary_data_table t, (SELECT ".
			  "napStart,".
			  "napEnd,".
			  "minExercised,".
			  "numCaffeinatedDrinks,".
			  "feltDuringDay,".
			  "howSleepy,".
			  "howAttentive,".
			  "timeCompleted,".
			  "diaryGrade ".
			  "FROM activity_diary_data_table WHERE diaryId='$fromDiaryId') fromData SET " .
			  "t.alertSent = 1,".
			  "t.napStart=fromData.napStart," .
			  "t.napEnd=fromData.napEnd," .
			  "t.minExercised=fromData.minExercised," .
			  "t.numCaffeinatedDrinks=fromData.numCaffeinatedDrinks," .
			  "t.feltDuringDay=fromData.feltDuringDay," .
			  "t.howSleepy=fromData.howSleepy," .
			  "t.howAttentive=fromData.howAttentive," .
			  "t.timeCompleted=fromData.timeCompleted, " .
			  "t.diaryGrade=fromData.diaryGrade " .
			  "WHERE diaryId='$toDiaryId'");
    
   mysql_query("UPDATE activity_diary_data_table SET " .
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
			  "WHERE diaryId='$fromDiaryId'"); 
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
	
				echo '<h2>You switched them</h2>';
			 
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
                            if($diary=='sleep'){
				echo '<a class="btn btn-large btn-block"  name="Done" href="switch-diary?diary=sleep">Done</a>';
			    }else{
				echo '<a class="btn btn-large btn-block"  name="Done" href="switch-diary?diary=activity">Done</a>';
				}
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
