<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId = $_SESSION['classId'];
	$config = $_SESSION['current_config'];
	$query = $_POST['query'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["enoughSleepVote"])) {
		header("Location:enough-sleep-vote.php");
		exit;
   }

   include 'connectdb.php';
	$enoughSleepVote = $_POST["enoughSleepVote"];
	$result = mysql_query("SELECT * FROM fourthGradeLessonOneSleepVote WHERE userId='$userId'");
	//$row = mysql_fetch_array($result);
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE fourthGradeLessonOneSleepVote SET vote = '$enoughSleepVote' WHERE userId='$userId'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO fourthGradeLessonOneSleepVote(userId, vote, contributors, classId) VALUES ('$userId', '$enoughSleepVote', '$userId', '$classId')");

    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);
	// header("Location: ".$config['parent_id']."?lesson=".$config['lesson_num']);
	// exit;
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
                <h2>Your answer has been submitted. Wait and your teacher will show you the results from your class.</h2>
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
