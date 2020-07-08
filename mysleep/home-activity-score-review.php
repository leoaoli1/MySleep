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
        <title>MySleep // Task Three Review</title>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a class = "exit" data-location="main-page">Home</a></li>
                                    <li><a class = "exit" data-location="sleep-lesson">Lessons</a></li>
                                    <li><a class = "exit" data-location="fifth-grade-lesson-menu?lesson=3">Lesson Three</a></li>
				    <li><a class = "exit" data-location="fifth-grade-lesson-activity-menu?lesson=3&activity=1">Activity One</a></li>
                                <li class="active">Task Three Review</li>
				<li class="pull-right"><a href="#" onClick="studentView()">Student View</a></li>
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
						<th>First Name</th><th>Last Name</th><th>Score</th><th>Submit Time</th>
					    </tr>
					</thead>
					<tbody>
					    <?php
					    include 'connectdb.php';
					    $targetUserIds = getUserIdsInClass($classId);
					    foreach($targetUserIds as $studentId){
						$result = mysql_query("SELECT * FROM fifthGradeLessonThreeTakeHome WHERE userID='$studentId' ORDER BY record DESC limit 1");
						list($firstName, $lastName) = getUserFirstLastNames($studentId);
						while($row= mysql_fetch_array($result)){
							echo '<tr><td>'.$firstName.'</td><td>'.$lastName.'</td><td>'.$row['score'].'</td><td>'.$row['submitTime'].'</td></tr>';
						}
					    }
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
     <script>
     function studentView(){
         window.open("./home-activity-score");
     }
    </script>
</html>
