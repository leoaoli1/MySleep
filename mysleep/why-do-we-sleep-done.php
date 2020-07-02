<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li 
#
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["whyDoWeSleep"])) {
		header("Location:why-do-we-sleep.php");
		exit;
   }
	 $query = $_POST['query'];
	 $resultRow = $_POST['resultRow'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
    if (isset($_POST['btnSave'])) {
        // return the user to the page
        $location = "Location:why-do-we-sleep?".$query;
    } else {
        //return the user to the activity selector
        $location = "Location:why-do-we-sleep-student-review?".$query;
    }

   include 'connectdb.php';
	$whyDoWeSleep ="";
	$whyDoWeSleep = mysql_real_escape_string($_POST["whyDoWeSleep"]);

	$result = mysql_query("SELECT * FROM fourthGradeLessonOneWhySleep WHERE resultRow='$resultRow'");
	//$row = mysql_fetch_array($result);
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE fourthGradeLessonOneWhySleep SET response='$whyDoWeSleep', contributors='$contributors'  WHERE resultRow='$resultRow'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO fourthGradeLessonOneWhySleep(userId, response, contributors, classId) VALUES ('$userId', '$whyDoWeSleep', '$contributors', '$classId')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);

	header($location);
	exit;
?>
