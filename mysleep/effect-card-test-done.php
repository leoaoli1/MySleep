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
if ($userId == ""){
    header("Location: login");
    exit;
}
if (isset($_POST['save'])) {
    $submitFlag = FALSE;
}else {
    $submitFlag =TRUE;
}
include 'connectdb.php';

$tag = $_GET['tag'];

$classId = $_SESSION['classId'];
$query = $_POST['query'];
$resultRow = $_POST['resultRow'];
$contributor = $_POST["contributor"];
$contributors = join(",", $contributor);

if ($tag == "1"){
    $text1 ="";
    $text2 ="";
    $text1 = mysql_real_escape_string($_POST["effect_1"]);
    $text2 = mysql_real_escape_string($_POST["effect_2"]);
    $status = mysql_query("INSERT INTO effect_card_test_table(userId, tag, preSchoolPos, preSchoolNeg, submit) VALUES ('$userId', '$tag', '$text1', '$text2', '$submitFlag')");
    if (!$status) {
	$message = 'Could not enter answers to the database: ' . mysql_error();
	error_exit($message);
    }
    mysql_close($con);
}elseif($tag == "2"){
    $text3 ="";
    $text4 ="";
    $text3 = mysql_real_escape_string($_POST["effect_3"]);
    $text4 = mysql_real_escape_string($_POST["effect_4"]);
    $status = mysql_query("INSERT INTO effect_card_test_table(userId, tag, schoolAgePos, schoolAgeNeg, submit) VALUES ('$userId', '$tag', '$text3', '$text4', '$submitFlag')");
    if (!$status) {
	$message = 'Could not enter answers to the database: ' . mysql_error();
	error_exit($message);
    }
    mysql_close($con);
}elseif($tag == "3"){
    $text5 ="";
    $text6 ="";
    $text5 = mysql_real_escape_string($_POST["effect_5"]);
    $text6 = mysql_real_escape_string($_POST["effect_6"]);
    $status = mysql_query("INSERT INTO effect_card_test_table(userId, tag, adultPos, adultNeg, submit) VALUES ('$userId', '$tag', '$text5', '$text6', '$submitFlag')");
    if (!$status) {
	$message = 'Could not enter answers to the database: ' . mysql_error();
	error_exit($message);
    }
    mysql_close($con);
}
?>
<?php if($tag == "3"){ ?>
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
			    <?php
	if(!$submitFlag){
	echo '<h2>You Saved it</h2>';
	}else{
				echo '<h2>You Finished it</h2>';
	}

			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
if(!$submitFlag){
	 echo '<a class="btn btn-large btn-block"  name="Done" href="effect-card-test'.$query.'>Done</a>';
	}else{
    ?>
    <a class="btn btn-gradbb btn-roundThin btn-large btn-block"  name="Continue" href="<?php echo "lesson-menu?".$query; ?>">Continue</a>
    <?php
	} ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
<?php }
exit;
?>
