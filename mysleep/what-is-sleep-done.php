<?php

	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["whatIsSleep"])) {
		header("Location:WhatIsSleep.php");
		exit;
   }
	 $query = $_POST['query'];
	 $resultRow = $_POST['resultRow'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
	 $submit = 0;
	 if (isset($_POST['btnSave'])) {
	         // return the user to the page
	         $location = "Location:what-is-sleep?".$query;
	 } else {
	         //return the user to the activity selector
	         $location = "Location:what-is-sleep-student-review?".$query;
					 $submit = 1;
	 }
   include 'connectdb.php';
	$whatIsSleep ="";

	$whatIsSleep = mysql_real_escape_string($_POST["whatIsSleep"]);

	$result = mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE resultRow='$resultRow'");
	//$row = mysql_fetch_array($result);
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE fourthGradeLessonOneWhatSleep SET response='$whatIsSleep', contributors='$contributors'  WHERE resultRow='$resultRow'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO fourthGradeLessonOneWhatSleep(userId, response, contributors, classId) VALUES ('$userId', '$whatIsSleep', '$contributors', '$classId')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);
	// if ($submit == 0) {
  //   header($location);
  // 	exit;
  // }
	header($location);
	exit;
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
		    <div class="row top">
      			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
                <h2>Your answer has been submitted. Your teacher will give you further instructions.</h2>
      			</div>
      			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
                <a class="btn btn-large btn-block"  name="Continue" href="<?php echo "what-is-sleep?".$query; ?>">Continue</a>
      			</div>
		    </div>
		</div>
	    </div>
	</div>
</body>
</html>
