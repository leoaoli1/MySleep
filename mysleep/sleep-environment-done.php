<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if ($userId == ""){
    header("Location: login.php");
    exit;
}
$classId = $_SESSION['classId'];
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
		    <?php
            if (isset($_POST['save'])) {
			$submitFlag = FALSE;
		    }else {
			$submitFlag =TRUE;
		    }

		    if(isset($_POST)){
			include 'connectdb.php';
      $contributor = $_POST["contributor"];
      $pictureId = $_POST['pictureId'];
			$promoteGoodSleep = mysql_real_escape_string($_POST["promoteGoodSleep"]);
			$preventGoodSleep = mysql_real_escape_string($_POST["preventGoodSleep"]);
			$groupMember = join(",", $contributor);//mysql_real_escape_string($_POST["groupMember"]);


		    /*-----------------------------------------------*/
		    /*				Save to MySQL        */
		    /*-----------------------------------------------*/
		    $status = mysql_query("INSERT INTO sleepEnvironment(userId, pictureId, promoteGoodSleep, preventGoodSleep, contributors, submit) VALUES ('$userId', '$pictureId', '$promoteGoodSleep', '$preventGoodSleep', '$groupMember', '$submitFlag')");
		    if (!$status) {
			$message = 'Could not enter answers to the database: ' . mysql_error();
			error_exit($message);
		    }
		    mysql_close($con);
                    }
		    ?>
		    <div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php
			    if (!$submitFlag) {
				      echo '<h2>You Saved it</h2>';
			    }else {
				      echo '<h2>You Submitted it</h2>';
			    }
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    if(!$submitFlag){
				        echo '<a class="btn btn-large btn-block"  name="Continue" href="sleep-environment">Continue</a>';
			    }else{
				        echo '<a class="btn btn-large btn-block"  name="Done" href="fourth-grade-lesson-activity-menu?lesson=4&activity=1">Done</a>';
			    }
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
