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
# Purpose:  Receive input from G5 L3 A3 Worksheet                           #
#                                                                           #
#############################################################################

require_once 'utilities.php';
require_once 'connectdb.php';

checkauth();

$userId         = $_SESSION['userId'];

# SET POST VARIABLES
$endocrine = mysql_escape_string($_POST['endocrine']);
$immune = mysql_escape_string($_POST['immune']);
$cardiovascular = mysql_escape_string($_POST['cardiovascular']);
$nervous = mysql_escape_string($_POST['nervous']);


if(isset($_POST['btnSubmit'])){
    $isSubmitted = 1;
    //$location = "fifth-grade-lesson-activity-menu?lesson=1&activity=1";
}
else {
    $isSubmitted = 0;
}

$sql = "INSERT INTO bodyChanger (userId, endocrine, immune, cardiovascular, nervous, submit) VALUES ('$userId','$endocrine','$immune', '$cardiovascular', '$nervous', '$isSubmitted');";
    
$result = mysql_query($sql);

if (mysql_error()){
    header('HTTP/1.1 500 INSERT ERROR');
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
			    <?php
			    if($isSubmitted == 1){
				echo '<h2>You Submitted it</h2>';
			    }
			    
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    if($isSubmitted == 1){
				echo '<a class="btn btn-large btn-block"  name="Done" href="fifth-grade-lesson-activity-menu?lesson=3&activity=4">Done</a>';
			    }
			    
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
