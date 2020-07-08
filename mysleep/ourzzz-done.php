<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#

  $databaseName = 'ourzzz';
  $homePage = 'ourzzz';

	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];
	if ($userId == ""){
	    header("Location: login.php");
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
       $sender = 'Your answer has been saved';
   } else {
       $submit = 1;
       //return the user to the activity selector
       $location = "Location:".$homePage."?".$query;
       $sender = 'Your answer has been submitted';
       if (isset($_POST['durationSubmit'])) {
         $sender = 'Your answer has been submitted, click on the Sleep Consistency tab at the top of the page.';
       }elseif (isset($_POST['consistencySubmit'])) {
         $sender = 'Your answer has been submitted, click on the Sleep Quality tab at the top of the page.';
       }elseif (isset($_POST['qualitySubmit'])) {
         $sender = 'Your answer has been submitted. Wait for your teacher to give you further instructions.';
       }
   }

   include 'connectdb.php';
    $durationCount = implode(",", [$_POST['answer11'],$_POST['answer12'],$_POST['answer13'],$_POST['answer14'],$_POST['answer15']]);
  	$durationDiscript ="";
  	$durationDiscript = mysql_real_escape_string($_POST["answer1d"]);
    $consistCount = implode(",", [$_POST['answer21'],$_POST['answer22'],$_POST['answer23'],$_POST['answer24'],$_POST['answer25']]);
  	$consistDiscript ="";
  	$consistDiscript = mysql_real_escape_string($_POST["answer2d"]);
    $qualityCount = implode(",", [$_POST['answer31'],$_POST['answer32'],$_POST['answer33'],$_POST['answer34'],$_POST['answer35']]);
  	$qualityDiscript ="";
  	$qualityDiscript = mysql_real_escape_string($_POST["answer3d"]);

	$result = mysql_query("SELECT * FROM $databaseName WHERE resultRow='$resultRow'");
	$numRow = mysql_num_rows ($result);

	if ($numRow>0) {
    $row = mysql_fetch_array($result);
    $submit = $row['submit'] || $submit;
    	$status = mysql_query("UPDATE $databaseName SET durationCount='$durationCount', durationDescript='$durationDiscript',
        consistencyCount='$consistCount', consistencyDescript='$consistDiscript',
        qualityCount='$qualityCount', qualityDescript='$qualityDiscript', contributors='$contributors', submit = '$submit'  WHERE resultRow='$resultRow'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO $databaseName(userId, durationCount, durationDescript, consistencyCount, consistencyDescript, qualityCount, qualityDescript, contributors, classId, submit)
                VALUES ('$userId', '$durationCount', '$durationDiscript', '$consistCount', '$consistDiscript', '$qualityCount', '$qualityDiscript', '$contributors', '$classId', '$submit')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);
  if ($submit == 0) {
    header($location);
  	exit;
  }
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
                <h2><?php echo $sender ?></h2>
      			</div>
      			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
                <a class="btn btn-large btn-block"  name="Continue" href="<?php echo $homePage."?".$query; ?>">Continue</a>
      			</div>
		    </div>
		</div>
	    </div>
	</div>
</body>
</html>
