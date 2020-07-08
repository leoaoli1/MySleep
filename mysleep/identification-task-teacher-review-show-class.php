<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# (C) 2016 University of Arizona, College of Education, STEPS Team
# 
# Author:   Ao Li <aoli1@email.arizona.edu>
#           James Geiger <jamesgeiger@email.arizona.edu>
#

require_once('utilities.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$classId = $_SESSION['classId'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Task One Review</title>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
	    h            <div class="main main-raised">
            <div class="container">
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                        <ol class="breadcrumb">
                            <li><a class = "exit" data-location="main-page">Home</a></li>
                            <li><a class = "exit" data-location="sleep-lesson">Lessons</a></li>
                            <li><a class = "exit" data-location="fifth-grade-lesson-menu?lesson=3">Lesson Three</a></li>
			    <li><a class = "exit" data-location="fifth-grade-lesson-activity-menu?lesson=3&activity=1">Activity One</a></li>
                            <li class="active">Task One Review</li>
                        </ol>
                    </div>
                </div>

		
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
			<div style="padding-top: 1cm">
                            <div class="table-responsive" style="margin-top: 1.5em;">
				<table class="table table-bordered">
				    <thead>
					<tr>
					    <th>ID</th><th>Average Recation Time (ms)</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					include 'connectdb.php';
					$targetUserIds = getUserIdsInClass($classId);
					   $id = 0;
					   $classAverage = 0;
					foreach($targetUserIds as $studentId){
					    $result = mysql_query("SELECT MAX(turn) AS turn FROM identificationTaskResults WHERE userId='$studentId' ORDER BY id");
					    while($row= mysql_fetch_array($result)){
						
						$turn = $row['turn'];
					   if($turn != 0){
					   $id += 1;
						    //debugToConsole('turn', $turn);
						    //debugToConsole('submitTime', $submitTime);
						    $resultDetial = mysql_query("SELECT turn, time, submitTime FROM identificationTaskResults WHERE userId='$studentId' AND turn='$turn'");
						    $sum = 0;
						    $j = 0;
						    $average = 0;
						    while($rowDetail = mysql_fetch_array($resultDetial)){
							$j += 1;
					   $sum += $rowDetail['time'];
					   $submitTime = $rowDetail['submitTime'];
						    }
						    
					   $average = $sum / $j;
					   $classAverage += $average;
						    echo "<tr><td>".$id."</td><td>".ceil($average)."</td></tr>";
						}
					    }
					   }
					   echo "<tr><td>Class Average</td><td>".ceil($classAverage/$id)."</td></tr>";
					mysql_close($con);
					?>
				    </tbody>
				</table>
                            </div>
			</div>
                    </div>
                </div>
            </div>
            </div>
            <?php include 'partials/footer.php' ?>    
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
