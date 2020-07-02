<?php

#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#           Wo-Tak Wu       <wotakwu@email.arizona.edu>                     #
#                                                                           #
# Filename: WorksheetFifthOneDone.php                                       #
#                                                                           #
# Purpose:  Receive input from G5 L1 A1 Worksheet                           #
#                                                                           #
#############################################################################

require_once 'utilities.php';
require_once 'connectdb.php';

checkauth();

$userId         = $_SESSION['userId'];
$classId=$_SESSION['classId'];
$databaseName = 'fifthGradeLessonOneWorksheet';
# SET POST VARIABLES
$story = $_POST['story'];
$happen = mysql_escape_string($_POST['happen']);
$factor = mysql_escape_string($_POST['factor']);
$affect = mysql_escape_string($_POST['affect']);
$query = $_POST['query'];
$resultRow = $_POST['resultRow'];
$contributor = $_POST["contributor"];
$contributors = join(",", $contributor);
/*$Q1             = mysql_escape_string($_POST['Q1']);
$Q2             = mysql_escape_string($_POST['Q2']);
$Q3             = mysql_escape_string($_POST['Q3']);
$Q4             = mysql_escape_string($_POST['Q4']);
$Q5             = mysql_escape_string($_POST['Q5']);
$Q6             = mysql_escape_string($_POST['Q6']);
$Q7             = mysql_escape_string($_POST['Q7']);
$Q8             = mysql_escape_string($_POST['Q8']);
$groupMember = mysql_escape_string($_POST['groupMember']);*/

if(isset($_POST['btnSubmit'])){
    $isSubmitted = 1;
    //$location = "fifth-grade-lesson-activity-menu?lesson=1&activity=1";
}
else {
    $isSubmitted = 0;
}
$result = mysql_query("SELECT * FROM $databaseName WHERE resultRow='$resultRow' and story='$story'");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    $status = mysql_query("UPDATE $databaseName SET happen='$happen', factor='$factor', affect='$affect', contributors='$contributors' WHERE resultRow='$resultRow'");
    if (!$status) {
      $message = 'Could not update answers to the database: ' . mysql_error();
      error_exit($message);
   }
}
else {
    $status = mysql_query("INSERT INTO $databaseName(userId,story,happen,factor,affect,isSubmitted, contributors, classId) VALUES ('$userId','$story','$happen', '$factor', '$affect', '$isSubmitted', '$contributors', '$classId')");
    if (!$status) {
      $message = 'Could not enter answers to the database: ' . mysql_error();
      error_exit($message);
  }
}

if (mysql_error()){
    header('HTTP/1.1 500 INSERT ERROR');
}
mysql_close($con);
/*if(isset($location)){
    header('Location: ' . $location);
}*/
/*if(isset($_POST['btnSubmit'])){
    $arrLesson = array(
	"lesson" => "1",
	"activity" => "2",
	"tab" => "g5l1worksheet"
    );
    $_SESSION['lessonInfo'] = $arrLesson;
    header("Location: group-selection.php");
    exit;
}*/
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
			    <?php
			    if($isSubmitted == 1){
				echo '<h2>You Submitted it</h2>';
			    }

			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    if($isSubmitted == 1){
				echo '<a class="btn btn-large btn-block"  name="Done" href="story-list?'.$query.'">Continue</a>';
			    }

			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
