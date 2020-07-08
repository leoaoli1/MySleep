<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#					Siteng Chen <sitengchen@email.arizona.edu>
#
	$homePage = 'adult-pre-interview';
	require_once('utilities.php');
	session_start();
	$classId = $_SESSION['classId'];
	$userId= $_SESSION['userId'];
	$query = $_POST['query'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["prepInterviewSubject"]) | empty($_POST["prepInterviewSubjectSleep"])) {
		$location = "Location:".$homePage."?".$query;
		header($location);
		exit;
	}
   include 'connectdb.php';
	$prepInterviewSubject = $_POST["prepInterviewSubject"];
    $prepInterviewSubjectOther = mysql_real_escape_string($_POST["prepInterviewSubjectOther"]);
    $prepInterviewSubjectSleep = $_POST["prepInterviewSubjectSleep"];
		$question = $_POST['question'];

	$result = mysql_query("SELECT * FROM fourthGradeLessonOnePreInterview WHERE userId='$userId'");
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE fourthGradeLessonOnePreInterview SET interviewSubject = '$prepInterviewSubject', interviewSubjectOther = '$prepInterviewSubjectOther', subjectResponse = '$prepInterviewSubjectSleep' WHERE userId='$userId'");

			if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO fourthGradeLessonOnePreInterview(userId, interviewSubject, interviewSubjectOther, subjectResponse, contributors, classId) VALUES ('$userId', '$prepInterviewSubject', '$prepInterviewSubjectOther', '$prepInterviewSubjectSleep', '$userId', '$classId')");
			if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	$questionArray = array("","","","","");
	$count = 0;
	foreach ($question as $k => $q){
		if (strlen($q)) {
			$questionArray[$count] = mysql_real_escape_string($q);
			$count ++;
		}
	}
	$result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterviewQuestions WHERE userId='$userId'");
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
		$status = mysql_query("UPDATE fourthGradeLessonOneAdultInterviewQuestions SET Q4 = '$questionArray[0]', Q5 = '$questionArray[1]', Q6 = '$questionArray[2]', Q7 = '$questionArray[3]', Q8 = '$questionArray[4]' WHERE userId='$userId'");

		if (!$status) {
			$message = 'Could not update answers to the database: ' . mysql_error();
			error_exit($message);
		}
	}else {
				$questionQuery = "INSERT INTO fourthGradeLessonOneAdultInterviewQuestions (userId, Q4, Q5, Q6, Q7, Q8) VALUES ('$userId', '" . mysql_real_escape_string($questionArray[0]) . "', '" . mysql_real_escape_string($questionArray[1]) . "', '" . mysql_real_escape_string($questionArray[2]) . "', '" . mysql_real_escape_string($questionArray[3]) . "', '" . mysql_real_escape_string($questionArray[4]) . "')";
				$status = mysql_query($questionQuery);
				if (!$status) {
	        $message = 'Could not enter answers to the database: ' . mysql_error();
	        error_exit($message);
	   	}
	}


	mysql_close($con);
	$location = "Location:".$homePage."?".$query;
	// header($location);
	// exit;
	// header("Location: ".$config['parent_id']."?lesson=".$config['lesson_num']);
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
                <a class="btn btn-large btn-block"  name="Continue" href="<?php echo "lesson-menu?".$query; ?>">Continue</a>
      			</div>
		    </div>
		</div>
	    </div>
	</div>
</body>
</html>
