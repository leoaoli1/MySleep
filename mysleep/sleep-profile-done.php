<!DOCTYPE html>
<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           James Geiger                                                    #
#           Ao Li                                                           #
#                                                                           #
#                                                                           #
# Filename: SleepProfile.php                                                #
#                                                                           #
# Purpose: G5 L2 A3                                                         #
# This is a part of How Do I Sleep                                          #
#                                                                           #
#############################################################################
require_once('utilities.php'); 
session_start();
$userId= $_SESSION['userId'];
if ($userId == ""){
    header("Location: login.php");
    exit;
   }
   include 'connectdb.php';
$grade = getGrade($userId);
if(empty($_POST["sleepProfileResponse"])) {
    if($grade == 4){
	header("Location:how-do-i-sleep?grade=4&back=1");
    }else{
	header("Location:how-do-i-sleep?grade=5&back=1");
    }
    exit;
}

$submitFlag = false;
$submit = 0;
if (isset($_POST['btnSave'])) {
    // return the user to the page
    if($grade == 4){
	$location = "how-do-i-sleep?grade=4&back=1";
    }else{
	$location = "how-do-i-sleep?grade=5&back=1";
    }
} else {
    $submitFlag = ture;
    $submit = 1;
    //return the user to the activity selector
    if($grade == 4){
	$location = "fourth-grade-lesson-menu.php?lesson=4";
    }else{
	$location = "fifth-grade-lesson-menu.php?lesson=4";
    }
}


$sleepProfile ="";

$sleepProfile = mysql_real_escape_string($_POST["sleepProfileResponse"]);

/*$result = mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$userId'");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    $status = mysql_query("UPDATE fifthGradeLessonTwoProfile SET response='$sleepProfile' WHERE userId='$userId'"); 
    if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
    }
}
else {
    $status = mysql_query("INSERT INTO fifthGradeLessonTwoProfile(userId, response) VALUES ('$userId', '$sleepProfile')"); 
    if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
    }
   }*/
$status = mysql_query("INSERT INTO fifthGradeLessonTwoProfile(userId, grade, response, submit) VALUES ('$userId', '$grade', '$sleepProfile', '$submit')"); 
if (!$status) {
    $message = 'Could not enter answers to the database: ' . mysql_error();
    error_exit($message);
}
mysql_close($con);


//header($location);
//exit;
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
			    if(!$submitFlag){
				echo '<h2>You Saved it</h2>';
			    }else{
				echo '<h2>You Submitted it</h2>';
			    }
			    
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <a class="btn btn-large btn-block"  name="Done" href= "<?php echo $location ?>" >Done</a>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
