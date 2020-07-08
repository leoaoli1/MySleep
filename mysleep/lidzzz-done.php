<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#

  $databaseName = 'lidzzz';
  $homePage = 'lidzzz';
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	// if(empty($_POST["d1"])) {
	// 	header("Location:".$homePage.".php");
	// 	exit;
  //  }
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
   $type = $_POST['type'];
   $d1 = $_POST['d1'];
   $d2 = $_POST['d2'];
   $d3 = $_POST['d3'];
   $d4 = $_POST['d4'];
   $d5 = $_POST['d5'];
   $reasons = $_POST['reasons'];
   $selectedPattern = $_POST['selectedPattern'];

  	$result = mysql_query("SELECT * FROM $databaseName WHERE resultRow='$resultRow'");
  	$numRow = mysql_num_rows ($result);

	if ($numRow>0) {
    $row = mysql_fetch_array($result);
    $submit = $row['submit'] || $submit;
    if ($type == 'sleepiness') {
      $status = mysql_query("UPDATE $databaseName SET sleepiness1='$d1', sleepiness2='$d2', sleepiness3='$d3', sleepiness4='$d4', sleepiness5='$d5', contributors='$contributors', submit = '$submit'  WHERE resultRow='$resultRow'");
    }else {
      $status = mysql_query("UPDATE $databaseName SET selectedPattern='$selectedPattern', reasons='$reasons', contributors='$contributors', submit = '$submit'  WHERE resultRow='$resultRow'");
    }
  	if (!$status) {
      $message = 'Could not update answers to the database: ' . mysql_error();
      error_exit($message);
 	  }
	}
	else {
    if ($type == 'sleepiness') {
      $status = mysql_query("INSERT INTO $databaseName(userId, sleepiness1, sleepiness2, sleepiness3, sleepiness4, sleepiness5, contributors, classId, submit) VALUES ('$userId', '$d1', '$d2', '$d3', '$d4', '$d5', '$contributors', '$classId', '$submit')");
    }else {
      $status = mysql_query("INSERT INTO $databaseName(userId, selectedPattern, reasons, contributors, classId, submit) VALUES ('$userId', '$selectedPattern', '$reasons', '$contributors', '$classId', '$submit')");
    }

  	if (!$status) {
      $message = 'Could not enter answers to the database: ' . mysql_error();
      error_exit($message);
   	}
	}
	mysql_close($con);

	header($location);
	exit;
?>
