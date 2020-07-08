<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li, Wo-Tak Wu
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$diaryId = $_SESSION['diaryEntryId'];
if ($userId=="") {
    header("Location: login.php");
    exit;
}
$currentGrade = getCurrentGrade($userId);
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
$time_12hr = $_POST['lights_off_hour'] . ":" . $_POST['lights_off_min'] . " " . $_POST['lights_off_ampm'];
$timeLightsOff = date("H:i", strtotime($time_12hr));
$minFallAsleep = $_POST["minFallAsleep"];
$timeFellAsleep = strtotime($time_12hr)+$minFallAsleep*60;
$timeFellAsleep = date("H:i", $timeFellAsleep);
//$time_12hr = $_POST['fell_asleep_hour'] . ":" . $_POST['fell_asleep_min'] . " " . $_POST['fell_asleep_ampm'];
//$timeFellAsleep = date("H:i", strtotime($time_12hr));

$time_12hr = $_POST["wakeuptime_hour"] . ":" . $_POST["wakeuptime_min"] . " " . $_POST["wakeuptime_ampm"];
$timeWakeup = date("H:i", strtotime($time_12hr));

//$time_12hr = $_POST['off_bed_hour'] . ":" . $_POST['off_bed_min'] . " " . $_POST['off_bed_ampm'];
//$timeOutOfBed = date("H:i", strtotime($time_12hr));

$numWokeup = $_POST["numWokeup"];
$minWokeup = $_POST["minIntertupt"];

//$time_12hr = $_POST['bedtime_hour'] . ":" . $_POST['bedtime_min'] . " " . $_POST['bedtime_ampm'];
//$timeToBed = date("H:i", strtotime($time_12hr));
//$medTaken = $_POST["medTaken"] == 'true' ? true : false;
//$time_12hr = $_POST['electronics_off_hour'] . ":" . $_POST['electronics_off_min'] . " " . $_POST['electronics_off_ampm'];
//$timeElectronicsOff = date("H:i", strtotime($time_12hr));

$disturbedByNoise = isset($_POST['disturbedByNoise']) ? true : false;
$disturbedBypets = isset($_POST['disturbedBypets']) ? true : false;
$disturbedByElectronics = isset($_POST['disturbedByElectronics']) ? true : false;
$disturbedByFamily = isset($_POST['disturbedByFamily']) ? true : false;
$disturbedByDream = isset($_POST['disturbedByDream']) ? true : false;
$disturbedByBathroomNeed = isset($_POST['disturbedByBathroomNeed']) ? true : false;
$disturbedByTemperature = isset($_POST['disturbedByTemperature']) ? true : false;
$disturbedByIllness = isset($_POST['disturbedByIllness']) ? true : false;
$disturbedByBodilyPain = isset($_POST['disturbedByBodilyPain']) ? true : false;
$disturbedByUnknown = isset($_POST['disturbedByUnknown']) ? true : false;
$disturbedByWorries = isset($_POST['disturbedByWorries']) ? true : false;
$disturbedByBusyMinds = isset($_POST['disturbedByBusyMinds']) ? true : false;
$disturbedByLighting = isset($_POST['disturbedByLighting']) ? true : false;
$disturbedByNothing = isset($_POST['disturbedByNothing']) ? true : false;
$disturbedByOther = isset($_POST['disturbedByOther']) ? true : false;
if($_POST['disturbedByOtherContent']) {
		$disturbedByOtherContent = mysql_real_escape_string($_POST['disturbedByOtherContent']);
	}

$actBefSleepTV = isset($_POST['actBefSleepTV']) ? true : false;
$actBefSleepMusic = isset($_POST['actBefSleepMusic']) ? true : false;
$actBefSleepVideoGame = isset($_POST['actBefSleepVideoGame']) ? true : false;
$actBefSleepComp = isset($_POST['actBefSleepComp']) ? true : false;
$actBefSleepRead = isset($_POST['actBefSleepRead']) ? true : false;
$actBefSleepHomework = isset($_POST['actBefSleepHomework']) ? true : false;
$actBefSleepShower = isset($_POST['actBefSleepShower']) ? true : false;
$actBefSleepPlayWithPeople = isset($_POST['actBefSleepPlayWithPeople']) ? true : false;
$actBefSleepSnack = isset($_POST['actBefSleepSnack']) ? true : false;
$actBefSleepText = isset($_POST['actBefSleepText']) ? true : false;
$actBefSleepPhone = isset($_POST['actBefSleepPhone']) ? true : false;
$actBefSleepDrinkCaff = isset($_POST['actBefSleepDrinkCaff']) ? true : false;
$actBefSleepExercise = isset($_POST['actBefSleepExercise']) ? true : false;
$actBefSleepMeal = isset($_POST['actBefSleepMeal']) ? true : false;
$actBefSleepOther = isset($_POST['actBefSleepOther']) ? true : false;
if($_POST['actBefSleepOtherContent']) {
		$actBefSleepOtherContent = mysql_real_escape_string($_POST['actBefSleepOtherContent']);
}

//student computed total sleep time
$stTotalSleep = $_POST["sleep_hours"] . ":" . $_POST["sleep_mins"];
$arrStSleepTimeHour = explode(':', $stTotalSleep);
$stSleepTimeHour = $arrStSleepTimeHour[0] + $arrStSleepTimeHour[1]/60;

//js computed total sleep time
$sleepTimeHour = $_POST['computedSleepHours'];
$arrSleepTimeHour = explode(':', $sleepTimeHour);
$sleepTimeHour = $arrSleepTimeHour[0] + $arrSleepTimeHour[1]/60;

$wokeupState = $_POST['wokeup_type'];
$sleepQuality = $_POST['sleepQuality'];
$sleepCompare = $_POST['sleepCompare'];


if($currentGrade == 4){
	$roomDarkness = $_POST['roomDarkness'];
	$roomQuietness = $_POST['roomQuietness'];
    $roomWarmness = $_POST['roomWarmness'];
    $parentSetBedTime = $_POST['parentSetBedTime'];
    $wakeUpWay = $_POST['wakeUpWay'];
	$status = mysql_query("UPDATE diary_data_table SET " .
	"roomDarkness='$roomDarkness'," .
    "roomQuietness='$roomQuietness'," .
			      "roomWarmness='$roomWarmness', " .
			      "parentSetBedTime='$parentSetBedTime', " .
			      "wakeUpWay='$wakeUpWay' " .
    "WHERE diaryId='$diaryId'");
}

$timeCompleted = get_localtime("Y-m-d H:i:s");


$status = mysql_query("UPDATE diary_data_table SET " .
    "timeLightsOff='$timeLightsOff'," .
    "minFallAsleep='$minFallAsleep'," .
    "timeWakeup='$timeWakeup'," .
	"timeFellAsleep='$timeFellAsleep',".
    "numWokeup='$numWokeup'," .
    "minWokeup='$minWokeup'," .
        "disturbedByNoise='$disturbedByNoise'," .
        "disturbedBypets='$disturbedBypets'," .
        "disturbedByElectronics='$disturbedByElectronics'," .
        "disturbedByFamily='$disturbedByFamily'," .
        "disturbedByDream='$disturbedByDream'," .
        "disturbedByBathroomNeed='$disturbedByBathroomNeed'," .
        "disturbedByTemperature='$disturbedByTemperature'," .
        "disturbedByIllness='$disturbedByIllness'," .
        "disturbedByBodilyPain='$disturbedByBodilyPain'," .
        "disturbedByWorries='$disturbedByWorries'," .
        "disturbedByBusyMinds='$disturbedByBusyMinds'," .
        "disturbedByLighting='$disturbedByLighting'," .
        "disturbedByUnknown='$disturbedByUnknown'," .
        "disturbedByNothing='$disturbedByNothing'," .
        "disturbedByOther='$disturbedByOther'," .
        "disturbedByOtherContent='$disturbedByOtherContent'," .
		      "hourSlept='$sleepTimeHour'," .
		      "hourSleptStudentCompute='$stSleepTimeHour'," .
        "actBefSleepTV='$actBefSleepTV'," .
        "actBefSleepMusic='$actBefSleepMusic'," .
        "actBefSleepVideoGame='$actBefSleepVideoGame'," .
        "actBefSleepComp='$actBefSleepComp'," .
        "actBefSleepRead='$actBefSleepRead'," .
        "actBefSleepHomework='$actBefSleepHomework'," .
        "actBefSleepShower='$actBefSleepShower'," .
        "actBefSleepPlayWithPeople='$actBefSleepPlayWithPeople'," .
        "actBefSleepSnack='$actBefSleepSnack'," .
        "actBefSleepText='$actBefSleepText'," .
        "actBefSleepPhone='$actBefSleepPhone'," .
        "actBefSleepDrinkCaff='$actBefSleepDrinkCaff'," .
        "actBefSleepExercise='$actBefSleepExercise'," .
        "actBefSleepMeal='$actBefSleepMeal'," .
        "actBefSleepOther='$actBefSleepOther'," .
        "actBefSleepOtherContent='$actBefSleepOtherContent'," .
    "wokeupState='$wokeupState'," .
    "sleepQuality='$sleepQuality'," .
    "sleepCompare='$sleepCompare'," .
    "timeCompleted='$timeCompleted'," .
    "diaryGrade='$currentGrade' " .
    "WHERE diaryId='$diaryId'");
if (!$status) {
    $message = 'Could not add diary to the database: ' . mysql_error();
    error_exit($message);
}
// Special handling to indicate no computation on sleep time is done by the user
if ($sleepTimeHour == "")
    $status = mysql_query("UPDATE diary_data_table SET hourSlept=NULL WHERE diaryId='$diaryId'");

mysql_close($con);

//header("Location: MainPage.php");
//exit;
?>

<div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php

				echo '<h2>You Submitted it</h2>';

			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
          $query = $_POST['query'];
          echo '<a class="btn btn-gradbg btn-roundBold btn-large btn-block"  name="Done" href="diary-menu?'.$query.'">Done</a>';
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
