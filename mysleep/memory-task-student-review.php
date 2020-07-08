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
$config = $_SESSION['current_config'];
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
                  <?php if ($config) {
		                    require_once('partials/nav-links.php');
		                    navigationLink($config,$userType,['linkable' => true]);
		                  } else {?>
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
                    <?php } ?>
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
                      					<tbody>
                      					    <?php
                      					    $resultTable = "";
                      						include 'connectdb.php';
                      						$result = mysql_query("SELECT DISTINCT turn FROM memoryTaskResults WHERE userId='$userId' ORDER BY id");
                      						while($row= mysql_fetch_array($result)){
                      						    $turn = $row['turn'];
                      						    //debugToConsole('submitTime', $submitTime);
                      						    $resultDetial = mysql_query("SELECT turn, trialType, response, time, letterShown, letterTwoBack, submitTime FROM memoryTaskResults WHERE userId='$userId' AND turn='$turn'");
                      						    $correct = 0;
                      						    $incorrect = 0;
                      						    $score = 0;
                      						    while($rowDetial = mysql_fetch_array($resultDetial)){
                          							$main = "<td>".$rowDetial["turn"]."</td><td>".$rowDetial["trialType"]."</td><td>".$rowDetial["response"]."</td><td>".$rowDetial["time"]."</td><td>".$rowDetial["letterShown"]."</td><td>".$rowDetial["letterTwoBack"]."</td><td>".$rowDetial["submitTime"]."</td>";
                          							$append = "<tr>".$main."</tr>";
                          							$resultTable .= $append;

                          							if($rowDetial['response'] == 'Correct'){
                          							    $correct += 1;
                          							}else{
                          							    $incorrect += 1;
                          							}
                      						    }

                      						    $score = $correct / 30;
                      						    $resultTable .= '<tr><td>Score<sup>1</sup></td><td colspan="5">'.number_format($score, 2, '.', ',').'</td></tr>';
                      						}

                      						echo $resultTable;
                      						mysql_close($con);

                      					    ?>
                      					</tbody>
                  				    </table>
                  				    <p>
                  				        1. Score = number of correct responses/ number of incorrect responses
                  				    </p>
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
