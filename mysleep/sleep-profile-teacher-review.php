<!DOCTYPE html>
<?php   
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#           Ao Li                                                           #
#                                                                           #
#                                                                           #
# Filename: SleepProfileTeacherReview.php                                   #
#                                                                           #
# Purpose: Teacher Review for Sleep Profile, G5 L2 A3                       #
#                                                                           #
#############################################################################

require_once('utilities.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

if ($userType == "teacher"){
    $classId = $_SESSION['classId'];
}
include 'connectdb.php';
$grade = getClassGrade($classId);
$showToClass = 0;
$showToClass = $_GET['showToClass'];
mysql_close($con);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Sleep Profile</title>
    </head>
    
<body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <ol class="breadcrumb">
                                    <li><a href="main-page">Home</a></li>
                                    <li><a href="sleep-lesson">Lessons</a></li>
				    <?php if($grade==4){ ?>
				    <li><a href="fourth-grade-lesson-menu?lesson=4">Lesson Four</a></li>
				    <li><a href="fourth-grade-lesson-activity-menu?lesson=4&activity=1">How Do I Sleep</a></li>
				    <?php }else{  ?>
				    <li><a href="fifth-grade-lesson-menu?lesson=4">Lesson Four</a></li>
				    <li><a href="fifth-grade-lesson-activity-menu?lesson=4&activity=1">How Do I Sleep</a></li>
				    <?php } ?>
                                    <li class="active">Review: Sleep Profile</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered">

			    <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true"  class="table table-striped">
				<?php if($showToClass != 1){ ?>
				<thead>
                                    <tr>
                                        <th data-field="firstName" >First Name</th>
                                        <th data-field="lastName" >Last Name</th>
                                        <th data-field="response" >Response</th>
                                        <th data-field="submitted" >Submitted</th>
                                    </tr>
                                </thead>
				<?php }else{ ?>
				    <thead>
					<tr>
                                            <th data-field="id" data-sortable="true">ID</th>
                                            <th data-field="response" data-sortable="true">Response</th>
                                            <th data-field="submitted" data-sortable="true">Submitted</th>
					</tr>
                                    </thead>
				<?php } ?>
                                <tbody>
                                    <?php
				    include 'connectdb.php';
                                    if(($userType == 'teacher') || ($userType == 'parent')) {
                                        if($userType == 'teacher') {
                                            $resultLink = getUserIdsInClass($classId);
					    debugToConsole('link', $resultLink);
                                        }else {
                                            $resultLink = getLinkedUserIds($userId);
                                        }
                                        if($showToClass != 1){
					    foreach($resultLink as $studentId) {
	    	  				list($firstname, $lastname) = getUserFirstLastNames($studentId);
	    	  				$result = mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$studentId' and submit='1' and grade='$grade'");
						echo "<tr>";
	    	  				echo "<td>".$firstname."</td><td>".$lastname."</td>";
	    	  				echo "</tr>";
	    	  				while($row = mysql_fetch_array($result)) {
	    	  				    echo "<tr>";
	    	  				    echo "<td></td>";
	    	  				    echo "<td></td>";
						    echo "<td>".$row['response']."</td><td>".$row['submitTime']."</td>";
						    echo "</tr>";
		             			}            	
	       				    }
					}else{
					    $id = 0;
					    foreach($resultLink as $studentId) {
	    	  				$result = mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$studentId' and submit='1' and grade='$grade' order by id desc LIMIT 1");
						while($row = mysql_fetch_array($result)) {
	        				    echo "<tr>";
						    $id += 1;
	    	  				    echo "<td>".$id."</td>";
		            			    echo "<td>".$row['response']."</td><td>".$row['submitTime']."</td>";  	
						    echo "</tr>";
						}
					    }
					}
					mysql_close($con);
				    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <?php include 'partials/footer.php' ?>
            </div>
</body>
<?php include 'partials/scripts.php' ?>
</html>
