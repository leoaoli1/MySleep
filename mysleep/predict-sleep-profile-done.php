<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];
  $grade = getCurrentGrade($userId);
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	 $query = $_POST['query'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
   $submision = 0;
	 if (isset($_POST['btnSave'])) {
	         // return the user to the page
	         $location = "Location:predict-sleep-profile?".$query;
	 } else {
	         //return the user to the activity selector
           $submision = 1;
	         $location = "Location:predict-sleep-profile?".$query;
	 }
   include 'connectdb.php';
	$prediction ="";

	$prediction = mysql_real_escape_string($_POST["prediction"]);

	$result = mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$userId'");
	//$row = mysql_fetch_array($result);
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE fifthGradeLessonTwoProfile SET response='$prediction', submit='$submision'  WHERE userId='$userId'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO fifthGradeLessonTwoProfile(userId, response, submit, grade) VALUES ('$userId', '$prediction', '$submision', '$grade')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);
	header($location);
	exit;
?>
