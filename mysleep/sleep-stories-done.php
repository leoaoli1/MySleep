<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
if ($userId == ""){
    header("Location: login.php");
    exit;
   }
if (isset($_POST['quit'])) {
    header("Location: fourth-grade-lesson-activity-menu?lesson=2&activity=3");
    //header("Location: FourthGradeLessonActivitySubMenu?lesson=3&activity=1&name=story");
    exit;
}
$sleepStoryId = $_SESSION['sleepStoryId'];

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
include 'connectdb.php';
if(isset($_POST['highlightOrder'])) {
	$highlightOrder = $_POST['highlightOrder'];
	$spanName = $_POST['spanName'];
}else {
	$highlightOrder = '';
	$spanName = '';
}
if(empty($_POST['storyNotes'])) {
    $storyNotes = "";
}else{
    $storyNotes = mysql_real_escape_string($_POST['storyNotes']);
}

if (isset($_POST['save'])) {
   $submitFlag = FALSE;
}else {
	$submitFlag =TRUE;
}
/*-----------------------------------------------*/
/*				Save to MySQL                    */
/*-----------------------------------------------*/
$contributor = $_POST["contributor"];
$contributors = join(",", $contributor);
 $status = mysql_query("INSERT INTO fourth_grade_lesson_three_story(userId, highlightWord, storyNotes, storyId, highlightWordSpanName, submit, contributors, classId) VALUES ('$userId', '$highlightOrder', '$storyNotes', '$sleepStoryId', '$spanName', '$submitFlag', '$contributors', '$classId')");
 if (!$status) {
     $message = 'Could not enter answers to the database: ' . mysql_error();
     error_exit($message);
 }


mysql_close($con);
?>
		<div class="row top">
		    <div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			<?php
			if (!$submitFlag) {

			    echo '<h2>Your answer has been saved.</h2>';

			}else {

			    echo '<h2>Your answer has been submitted. Your teacher will now show you your class results.</h2>';
			}
			?>
		    </div>
		    <div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
    			<?php
          $query = $_POST['query'];
          if (!$submitFlag) {
              echo '<a class="btn btn-gradbg btn-roundBold btn-large btn-block"  name="Done" href="sleep-stories?'.$query.'">Continue</a>';
    			}else {
              echo '<a class="btn btn-gradbg btn-roundBold btn-large btn-block"  name="Done" href="lesson-menu?'.$query.'">Continue</a>';
    			}
          ?>
		    </div>
		</div>
	    </div>
	</div>
    </div>
    <?php unset($_SESSION['sleepStoryId']); ?>
</body>
</html>
