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
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	 $query = $_POST['query'];
	 $note = $_POST['note'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
	 if (isset($_POST['btnSave'])) {
	         // return the user to the page
	         $location = "Location:practice-diary-menu?".$query;
	 } else {
	         //return the user to the activity selector
	         $location = "Location:practice-diary-menu?".$query;
	 }
   include 'connectdb.php';
	$whatIsSleep ="";

	$whatIsSleep = mysql_real_escape_string($_POST["whatIsSleep"]);

	$result = mysql_query("SELECT * FROM practiceDiaryNote WHERE userId='$userId'");
	//$row = mysql_fetch_array($result);
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE practiceDiaryNote SET note='$note'  WHERE userId='$userId'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO practiceDiaryNote(userId, note, classId) VALUES ('$userId', '$note', '$classId')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);
	header($location);
	exit;
?>
