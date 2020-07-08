<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#           Siteng Chen    <sitengchen@email.arizona.edu>                   #
#                                                                           #
# Filename: InterviewAdultDone.php                                          #
#                                                                           #
# Purpose:  To recieve and handle form input from InterviewAdult.php        #
#                                                                           #
#############################################################################

require_once('utilities.php');
require_once('connectdb.php');
checkAuth();

# VARIABLES
$classId = $_SESSION['classId'];
$userId             = $_SESSION['userId'];
$config = $_SESSION['current_config'];
$iS                 = mysql_real_escape_string($_POST['iS']);
$oS                 = mysql_real_escape_string($_POST['oS']);
$A1                 = mysql_real_escape_string($_POST['A1']);
$A1Exp              = mysql_real_escape_string($_POST['A1Exp']);
$A2                 = mysql_real_escape_string($_POST['A2']);
$A3                 = mysql_real_escape_string($_POST['A3']);
$query = $_POST['query'];

if (isset($_POST['btnSubmit'])) {
        # Mark the interview as completed
        $isSubmitted = 1;
    } else {
        # Mark the interview as still in progress
        $isSubmitted = 0;
    }


    $interviewId        = $_POST['interviewId'];

    $uniqueId           = $_POST['uniqueId'];

    $question           = $_POST['question'];
    $response           = $_POST['response'];

# SQL QUERIES

# Determine what query to make

if(isset($interviewId)){
    $responseArray = array("","","","","");
    $questionArray = array("","","","","");
    foreach ($response as $key => $value) {
      $responseArray[$key] = mysql_real_escape_string($value);
    }
    foreach ($question as $key => $value) {
      $questionArray[$key] = mysql_real_escape_string($value);
    }
    $interviewQuery = "UPDATE fourthGradeLessonOneAdultInterview SET interviewSubject = '$iS', otherSubject = '$oS', A1 = '$A1', A1Exp = '$A1Exp', A2 = '$A2', A3 = '$A3', submit = '$isSubmitted', A4 = '$responseArray[0]', A5 = '$responseArray[1]', A6 = '$responseArray[2]', A7 = '$responseArray[3]', A8 = '$responseArray[4]', Q4 = '$questionArray[0]', Q5 = '$questionArray[1]', Q6 = '$questionArray[2]', Q7 = '$questionArray[3]', Q8 = '$questionArray[4]' WHERE resultRow = '$interviewId'";
    $interviewResult = mysql_query($interviewQuery) or die(mysql_error());
}
else{
  $result =mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterviewQuestions WHERE userId='$userId'");
 	$numRow = mysql_num_rows($result);
  $questionArray = array("","","","","");
  if ($numRow>0) {
    $row = mysql_fetch_array($result);
  	$count = 0;

		for ($i=4; $i<9 ; $i++) {
			$name = "Q" . trim($i);
			$ques = $row[$name];
			if (strlen($ques)) {
        $questionArray[$count] = mysql_real_escape_string($ques);
        $count ++;
			}
		}
	}
    $emp = " ";
    $interviewQuery = "INSERT INTO fourthGradeLessonOneAdultInterview (userId, interviewSubject, otherSubject, A1, A1Exp, A2, A3, submit, Q4, A4, Q5, A5, Q6, A6, Q7, A7, Q8, A8, contributors, classId) VALUES ('$userId','$iS','$oS','$A1','$A1Exp','$A2','$A3','$isSubmitted','$questionArray[0]','$emp','$questionArray[1]','$emp','$questionArray[2]','$emp','$questionArray[3]','$emp','$questionArray[4]','$emp', '$userId', '$classId')";

    $status = mysql_query($interviewQuery);
    if (!$status) {
      $message = 'Could not enter answers to the database: ' . mysql_error();
      error_exit($message);
    }
}

if($isSubmitted == 1){
    header("Location: ".$config['parent_id']."?lesson=".$config['lesson_num']);
}
