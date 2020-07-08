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
	$success = false;
	$error = false;
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["evidence"])) {
		$error = true;
		header("Location:big-question.php");
		exit;
   }
	 $query = $_POST['query'];
	 $resultRow = $_POST['resultRow'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);

if (!$error) {
		include 'connectdb.php';
		 $hypothesis ="";
		 $hypothesis = mysql_real_escape_string($_POST["hypothesis"]);
		 $evidence ="";
		 $evidence = mysql_real_escape_string($_POST["evidence"]);

		 $result = mysql_query("SELECT * FROM bigQuestions WHERE resultRow='$resultRow'");
		 //$row = mysql_fetch_array($result);
		 $numRow = mysql_num_rows ($result);
		 if ($numRow>0) {
				 $status = mysql_query("UPDATE bigQuestions SET hypothesis='$hypothesis', evidence='$evidence', contributors='$contributors'  WHERE resultRow='$resultRow'");
				 if (!$status) {
					 $message = 'Could not update answers to the database: ' . mysql_error();
					 error_exit($message);
				} else {
					$success = true;
				}
		 }
		 else {
				 $status = mysql_query("INSERT INTO bigQuestions(userId, hypothesis, evidence, contributors, classId) VALUES ('$userId', '$hypothesis', '$evidence', '$contributors', '$classId')");
				 if (!$status) {
					 $message = 'Could not enter answers to the database: ' . mysql_error();
					 error_exit($message);
			 } else {
				 $success = true;
			 }
		 }
		 mysql_close($con);
}

	echo json_encode(
	    array(
	      "success" => $success,
	      "error" => $error
	    )
	);
?>
