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
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if ($userType == "teacher"){
   $classId = $_SESSION['classId'];
}
$showToClass = 1;
$showToClass = $_GET['showToClass'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
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
					<?php
					require_once('partials/nav-links.php');
					navigationLinkReview($config,$userType);
					?>
					<div class="row">
						<div class="col-xs-offset-1 col-xs-10 col-sm-10">
							<h4>Black or Red</h4>
						</div>
						<div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
							<div class="table-responsive" style="margin-top: 1.5em;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>ID</th><th>Average Recation Time (ms)</th><th>Score</th>
										</tr>
									</thead>
									<tbody>
										<?php
											include 'connectdb.php';
											$targetUserIds = getUserIdsInClass($classId);
											$id = 0;
											$classAverage = 0;
											$classAccuracy = 0;
											foreach($targetUserIds as $studentId){
												$result = mysql_query("SELECT MAX(turn) AS turn FROM identificationTaskResults WHERE userId='$studentId' ORDER BY id");
												while($row= mysql_fetch_array($result)){
													$turn = $row['turn'];
													if($turn != 0){
														$id += 1;
														//debugToConsole('turn', $turn);
														//debugToConsole('submitTime', $submitTime);
														$resultDetial = mysql_query("SELECT turn, time, response, submitTime FROM identificationTaskResults WHERE userId='$studentId' AND turn='$turn'");
														$sum = 0;
														$j = 0;
														$average = 0;
														$accurate = 0;
														while($rowDetail = mysql_fetch_array($resultDetial)){
															$j += 1;
															$sum += $rowDetail['time'];
															$submitTime = $rowDetail['submitTime'];
															if ($rowDetail['response']=='Correct') {
																$accurate += 1;
															}
														}
															
														$average = $sum / $j;
														$accurate = $accurate / $j;
														$classAverage += $average;
														$classAccuracy += $accurate;
														if ($showToClass == 1) {
															echo "<tr><td>".$id."</td><td>".ceil($average)."</td><td>".sprintf("%.2f", $accurate)."</td></tr>";
														} else {
															echo "<tr><td>".getUserFullNames($studentId)."</td><td>".ceil($average)."</td><td>".sprintf("%.2f", $accurate)."</td></tr>";
														}
														
													}
												}
											}
											echo "<tr><td>Class Average</td><td>".ceil($classAverage/$id)."</td><td>".sprintf("%.2f", $classAccuracy/$id)."</td></tr>";
											mysql_close($con);
										?>
									</tbody>
								</table>
								<p>
									1. Score = number of correct responses/ number of responses
								</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-offset-1 col-xs-10 col-sm-10">
							<h4>Remember It</h4>
						</div>
						<div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
							<div class="table-responsive" style="margin-top: 1.5em;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>ID</th><th>Average Recation Time (ms)</th><th>Score</th>
										</tr>
									</thead>
									<tbody>
										<?php
											include 'connectdb.php';
											$targetUserIds = getUserIdsInClass($classId);
											$id = 0;
											$classAverage = 0;
											$classAccuracy = 0;
											foreach($targetUserIds as $studentId){
												$result = mysql_query("SELECT MAX(turn) AS turn FROM memoryTaskResults WHERE userId='$studentId' ORDER BY id");
												while($row= mysql_fetch_array($result)){
													$turn = $row['turn'];
													if($turn != 0){
														$id += 1;
														//debugToConsole('turn', $turn);
														//debugToConsole('submitTime', $submitTime);
														$resultDetial = mysql_query("SELECT turn, time, response, submitTime FROM memoryTaskResults WHERE userId='$studentId' AND turn='$turn'");
														$sum = 0;
														$j = 0;
														$average = 0;
														$accurate = 0;
														while($rowDetail = mysql_fetch_array($resultDetial)){
															$j += 1;
															$sum += $rowDetail['time'];
															$submitTime = $rowDetail['submitTime'];
															if ($rowDetail['response']=='Correct') {
																$accurate += 1;
															}
														}
															
														$average = $sum / $j;
														$accurate = $accurate / $j;
														$classAverage += $average;
														$classAccuracy += $accurate;
														if ($showToClass == 1) {
															echo "<tr><td>".$id."</td><td>".ceil($average)."</td><td>".sprintf("%.2f", $accurate)."</td></tr>";
														} else {
															echo "<tr><td>".getUserFullNames($studentId)."</td><td>".ceil($average)."</td><td>".sprintf("%.2f", $accurate)."</td></tr>";
														}
													}
												}
											}
											echo "<tr><td>Class Average</td><td>".ceil($classAverage/$id)."</td><td>".sprintf("%.2f", $classAccuracy/$id)."</td></tr>";
											mysql_close($con);
										?>
									</tbody>
								</table>
								<p>
									1. Score = number of correct responses/ number of responses
								</p>
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
