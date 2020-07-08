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
        <title>MySleep // Task One Review</title>
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
                                    <li class="active">Task One Review</li>
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
						<th>Turn</th><th>Suit</th><th>Card</th><th>Response</th><th>Time (ms)</th><th>Submit Time</th>
					    </tr>
					</thead>
					<tbody id="result">
					    <?php
					    $resultTable = "";
						include 'connectdb.php';
						$result = mysql_query("SELECT DISTINCT turn FROM identificationTaskResults WHERE userId='$userId' ORDER BY id");
						while($row= mysql_fetch_array($result)){
						    $turn = $row['turn'];
						    $resultDetial = mysql_query("SELECT turn, suit, card, response, time, submitTime FROM identificationTaskResults WHERE userId='$userId' AND turn='$turn'");
						    $sum = 0;
						    $j = 0;
						    $average = 0;
						    while($rowDetial = mysql_fetch_array($resultDetial)){
							$main = "<td>".$rowDetial["turn"]."</td><td>".$rowDetial["suit"]."</td><td>".$rowDetial["card"]."</td><td>".$rowDetial["response"]."</td><td>".$rowDetial["time"]."</td><td>".$rowDetial["submitTime"]."</td>";
							$append = "<tr>".$main."</tr>";
							$resultTable .= $append;
							//$count += 1;

							$j += 1;
							//debugToConsole('time', $row['time']);
							$sum += $rowDetial['time'];
						    }

						    $average = $sum / $j;
						    $resultTable .= "<tr><td>Average</td><td></td><td></td><td></td><td>".ceil($average)."</td><td></td></tr>";
						}

						echo $resultTable;
					    ?>
					</tbody>
				    </table>
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
</html>
