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
$diaryId = $_SESSION['diaryEntryId'];
if ($userId == ""){
    header("Location: login.php");
    exit;
}
//if (isset($_POST['quit'])) {
//    header("Location: MainPage.php");
//    exit;
//}
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
		    $time_12hr = $_POST['napStart_hour'] . ":" . $_POST['napStart_min'] . " " . $_POST['napStart_ampm'];
		    $napStart = date("H:i", strtotime($time_12hr));

		    $time_12hr = $_POST['napEnd_hour'] . ":" . $_POST['napEnd_min'] . " " . $_POST['napEnd_ampm'];
		    $napEnd = date("H:i", strtotime($time_12hr));

		    $nappedToday = isset($_POST['nappedToday']) ? true : false;

		    //$caffDrinkMorning = isset($_POST['caffDrinkMorning']) ? true : false;
		    //$caffDrinkAfternoon = isset($_POST['caffDrinkAfternoon']) ? true : false;
		    //$caffDrinkWithinBedtime = isset($_POST['caffDrinkWithinBedtime']) ? true : false;

		    //$exercisedMorning = isset($_POST['exercisedMorning']) ? true : false;
		    //$exercisedAfternoon = isset($_POST['exercisedAfternoon']) ? true : false;
		    //$exercisedWithinBedtime = isset($_POST['exercisedWithinBedtime']) ? true : false;

		    //$actBefSleepTV = isset($_POST['actBefSleepTV']) ? true : false;
		    //$actBefSleepMusic = isset($_POST['actBefSleepMusic']) ? true : false;
		    //$actBefSleepVideoGame = isset($_POST['actBefSleepVideoGame']) ? true : false;
		    //$actBefSleepComp = isset($_POST['actBefSleepComp']) ? true : false;
		    //$actBefSleepRead = isset($_POST['actBefSleepRead']) ? true : false;
		    //$actBefSleepHomework = isset($_POST['actBefSleepHomework']) ? true : false;

		    $minExercised = $_POST["numExercised"];
		    $numCaffeinatedDrinks = $_POST["numCaffeinatedDrinks"];
		    $feltDuringDay = $_POST['feltDuringDay'];
		    $howSleepy = $_POST['howSleepy'];
		    //$howAttentive = $_POST['howAttentive'];

		    /*New*/
		    $minVideoGame =  $_POST['minVideoGame'];
		    $minComputer = $_POST['minComputer'];
		    $minTechnology = $_POST['minTechnology'];
		    $attention = $_POST['attention'];
		    $behavior = $_POST['behavior'];
		    $interaction = $_POST['interaction'];

		    $symptomRunnyNose = isset($_POST['symptomRunnyNose']) ? true : false;
		    $symptomSoreThroat = isset($_POST['symptomSoreThroat']) ? true : false;
		    $symptomStuffyNose = isset($_POST['symptomStuffyNose']) ? true : false;
		    $symptomItchyEyes = isset($_POST['symptomItchyEyes']) ? true : false;
		    $symptomHeadache = isset($_POST['symptomHeadache']) ? true : false;
		    $symptomFever = isset($_POST['symptomFever']) ? true : false;
		    $symptomSneezing = isset($_POST['symptomSneezing']) ? true : false;
		    $symptomCoughing = isset($_POST['symptomCoughing']) ? true : false;
		    $symptomBodyAches = isset($_POST['symptomBodyAches']) ? true : false;
		    $symptomStomach = isset($_POST['symptomStomach']) ? true : false;
		    $symptomUnknown = isset($_POST['symptomUnknown']) ? true : false;

		    $timeCompleted = get_localtime("Y-m-d H:i:s");

		    include 'connectdb.php';
		    $status = mysql_query("UPDATE activity_diary_data_table SET " .
					  "napStart='$napStart'," .
					  "napEnd='$napEnd'," .
					  "minExercised='$minExercised'," .
					  "numCaffeinatedDrinks='$numCaffeinatedDrinks'," .
					  "feltDuringDay='$feltDuringDay'," .
					  "howSleepy='$howSleepy'," .
					  "timeCompleted='$timeCompleted', " .
					  "diaryGrade='$currentGrade', " .
					  "minVideoGame='$minVideoGame', ".
					  "minComputer='$minComputer', ".
					  "minTechnology='$minTechnology', ".
					  "attention='$attention', ".
					  "behavior='$behavior', ".
					  "interaction='$interaction', ".
					  "symptomRunnyNose='$symptomRunnyNose', ".
					  "symptomSoreThroat='$symptomSoreThroat', ".
					  "symptomStuffyNose='$symptomStuffyNose', ".
					  "symptomItchyEyes='$symptomItchyEyes', ".
					  "symptomHeadache='$symptomHeadache', ".
					  "symptomFever='$symptomFever', ".
					  "symptomSneezing='$symptomSneezing', ".
					  "symptomCoughing='$symptomCoughing', ".
					  "symptomBodyAches='$symptomBodyAches', ".
					  "symptomStomach='$symptomStomach', ".
					  "symptomUnknown='$symptomUnknown' ".
					  "WHERE diaryId='$diaryId'");
		    if (!$status) {
			$message = 'Could not add activity diary to the database: ' . mysql_error();
			error_exit($message);
		    }
		    // Special handling to indicate no nap was taken
		    if (!$nappedToday)
			$status = mysql_query("UPDATE activity_diary_data_table SET napStart=NULL,napEnd=NULL WHERE diaryId='$diaryId'");
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
