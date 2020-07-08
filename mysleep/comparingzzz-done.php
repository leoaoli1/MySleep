<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#

  $databaseName = 'fourthGradeComparingzzz';
  $homePage = 'comparingzzz';

	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["answer1"])) {
		header("Location:".$homePage.".php");
		exit;
   }
	 $query = $_POST['query'];
	 $resultRow = $_POST['resultRow'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
   $submit = 0;
   if (isset($_POST['btnSave'])) {
       // return the user to the page
       $location = "Location:".$homePage."?".$query;
   } else {
       $submit = 1;
       //return the user to the activity selector
       $location = "Location:".$homePage."?".$query;
   }

   include 'connectdb.php';
  	$answer1 ="";
  	$answer1 = mysql_real_escape_string($_POST["answer1"]);
    $answer2 ="";
  	$answer2 = mysql_real_escape_string($_POST["answer2"]);
    $answer3 ="";
  	$answer3 = mysql_real_escape_string($_POST["answer3"]);
    $answer4 ="";
  	$answer4 = mysql_real_escape_string($_POST["answer4"]);

	$result = mysql_query("SELECT * FROM $databaseName WHERE resultRow='$resultRow'");
	$numRow = mysql_num_rows ($result);

	if ($numRow>0) {
    $row = mysql_fetch_array($result);
    $submit = $row['submit'] || $submit;
    	$status = mysql_query("UPDATE $databaseName SET answer1='$answer1', answer2='$answer2', answer3='$answer3', answer4='$answer4', contributors='$contributors', submit = '$submit'  WHERE resultRow='$resultRow'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO $databaseName(userId, answer1, answer2, answer3, answer4, contributors, classId, submit) VALUES ('$userId', '$answer1', '$answer2', '$answer3', '$answer4', '$contributors', '$classId', '$submit')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);

	header($location);
	exit;
?>
