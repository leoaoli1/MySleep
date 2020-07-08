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
        <title>MySleep // Task Two Review</title>
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
                                    <li class="active">Task Two Review</li>
                            </ol>
                        </div>
                    </div>
		    
		    <form>
			<div class="col-xs-offset-1 col-xs-6 col-md-offset-1 col-md-6 ">
			    <select class="input-lg" name='studentId' id="studentId">
				<option value='null' disabled selected>Please choose a student</option>
				<?php
				include 'connectdb.php';
				$targetUserIds = getUserIdsInClass($classId);
				showUserOptionList($targetUserIds);
				mysql_close($con);
				?>
			    </select>
			</div>
		   </form>
		    
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
			    <div style="padding-top: 1cm">
                                <div class="table-responsive" style="margin-top: 1.5em;">
				    <table class="table table-bordered">
					<thead>
					    <tr>
						<th>Turn</th><th>Trail Type</th><th>Response</th><th>Response Time</th><th>Letter Shown</th><th>Letter Two-Back</th><th>Submit Time</th>
					    </tr>
					</thead>
					<tbody id="result">
					</tbody>
				    </table>
				    <p>
				        1. Score = number of correct responses/ number of responses
				    </p>
                                </div>
			    </div>
				<?php
				mysql_close($con);
				?>
                        </div>
                    </div>
                </div>
            </div>
        <?php include 'partials/footer.php' ?>    
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     $('#studentId').change( function (e) {
	 
	 e.preventDefault();

	 $.ajax({
	     type: 'post',
	     url: 'memory-task-content',
	     data: {id: $('#studentId').val()},
	     dataType: 'json',
	     success: function (response) {
		 $("#result").html(response.resultTable);
	     }
	 });

     });
    </script>
</html>
