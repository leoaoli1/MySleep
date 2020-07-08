<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
checkauth();
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
$showToClass = 0;
$showToClass = $_GET['showToClass'];
?>
<html style="background-image: url('assets/img/bkg-lgjpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // </title>
    </head>

    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
                    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page';">Home</a></li>
				<li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
				<li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep';">I Can Use A Good Night's Sleep</a></li>
				<li class="active">Part Three Review</li>
                            </ol>
			</div>
                    </div>
		</div>
		<div class="row">
		    <div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			<h4 class="description"></h4>
		    </div>
		</div>
		<div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                                <li role="presentation" class="active"><a href="#familyRoutines" aria-controls="familyRoutines" role="tab" data-toggle="tab">Family behavior, activity and routines</a></li>
                                <li role="presentation"><a href="#activities" aria-controls="activities" role="tab" data-toggle="tab">Student behavior, activity and routines</a></li>
                                <li role="presentation"><a href="#environment" aria-controls="environment" role="tab" data-toggle="tab">Environment and Community</a></li>
                            </ul>
			    
			    <div class="tab-content" style="margin-top: 2em;">
				
				<div role="tabpanel" class="tab-pane active" id="familyRoutines">
				    <table class="table">
					
					<tr>
					    <?php
					    if($showToClass != 1){
						echo '<th>First Name</th><th>Last Name</th><th>Hard Change or Achieve</th><th>Easy Change or Achieve</th>';
					    }else{
						echo '<th>ID</th><th>Hard Change or Achieve</th><th>Easy Change or Achieve</th>';
						$count = 1;
					    }
					    ?>
					</tr>
					<?php
					include 'connectdb.php';
					$resultLink = getUserIdsInClass($classId);
					foreach ($resultLink as $studentId){
					    $result = mysql_query("SELECT familyRoutinesHardChange, familyRoutinesEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$studentId' AND submit='1' AND familyRoutinesEasyChange IS NOT NULL order by recordId DESC Limit 1");
					    $row = mysql_fetch_array($result);
					    $arrfamilyRoutinesHardChange = $row['familyRoutinesHardChange'];
					    $arrfamilyRoutinesEasyChange = $row['familyRoutinesEasyChange'];
					    $fRHardChangeList = unserialize(base64_decode($arrfamilyRoutinesHardChange));
					    $fREasyChangeList = unserialize(base64_decode($arrfamilyRoutinesEasyChange));
					    if(isset($arrfamilyRoutinesEasyChange) || isset($arrfamilyRoutinesHardChange)){
						list($firstName, $lastName) = getUserFirstLastNames($studentId);
						echo "<tr>";
						if($showToClass != 1){
						    echo "<td>".$firstName."</td><td>".$lastName."</td><td>".$fRHardChangeList[0].";".$fRHardChangeList[1].";".$fRHardChangeList[2]."</td><td>".$fREasyChangeList[0].";".$fREasyChangeList[1].";".$fREasyChangeList[2]."</td>";
						}else{
						    echo "<td>".$count."</td><td>".$fRHardChangeList[0].";".$fRHardChangeList[1].";".$fRHardChangeList[2]."</td><td>".$fREasyChangeList[0].";".$fREasyChangeList[1].";".$fREasyChangeList[2]."</td>";
						    $count += 1;
						}
						
						echo "</tr>";
					    }else{
						if($showToClass != 1){
						    list($firstName, $lastName) = getUserFirstLastNames($studentId);
						    echo "<tr>";
						    echo "<td>".$firstName."</td><td>".$lastName."</td><td>&nbsp</td><td>&nbsp</td>";
						    echo "</tr>";
						}
					    }
					}
					?>
				    </table>
				</div>

				
				
				<div role="tabpanel" class="tab-pane" id="activities">
				    <table class="table">
					<tr>
					    <?php
					    if($showToClass != 1){
						echo '<th>First Name</th><th>Last Name</th><th>Hard Change or Achieve</th><th>Easy Change or Achieve</th>';
					    }else{
						echo '<th>ID</th><th>Hard Change or Achieve</th><th>Easy Change or Achieve</th>';
						$count = 1;
					    }
					    ?>
					</tr>
					<?php
					foreach ($resultLink as $studentId){
					    $result = mysql_query("SELECT activitiesHardChange, activitiesEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$studentId' AND submit='1' AND activitiesEasyChange IS NOT NULL order by recordId DESC Limit 1");
					    $row = mysql_fetch_array($result);
					    $arrActivitiesHardChange = $row['activitiesHardChange'];
					    $arrActivitiesEasyChange = $row['activitiesEasyChange'];
					    $actHardChangeList = unserialize(base64_decode($arrActivitiesHardChange));
					    $actEasyChangeList = unserialize(base64_decode($arrActivitiesEasyChange));
					    if(isset($arrActivitiesEasyChange) || isset($arrActivitiesHardChange)){
						list($firstName, $lastName) = getUserFirstLastNames($studentId);
						echo "<tr>";
						if($showToClass != 1){
						    echo "<td>".$firstName."</td><td>".$lastName."</td><td>".$actHardChangeList[0].";".$actHardChangeList[1].";".$actHardChangeList[2]."</td><td>".$actEasyChangeList[0].";".$actEasyChangeList[1].";".$actEasyChangeList[2]."</td>";
						}else{
						    echo "<td>".$count."</td><td>".$actHardChangeList[0].";".$actHardChangeList[1].";".$actHardChangeList[2]."</td><td>".$actEasyChangeList[0].";".$actEasyChangeList[1].";".$actEasyChangeList[2]."</td>";
						}
						echo "</tr>";
					    }else{
						if($showToClass != 1){
						    list($firstName, $lastName) = getUserFirstLastNames($studentId);
						    echo "<tr>";
						    echo "<td>".$firstName."</td><td>".$lastName."</td><td>&nbsp</td><td>&nbsp</td>";
						    echo "</tr>";
						}
					    }
					}
					?>
				    </table>
				</div>
				
				
				<div role="tabpanel" class="tab-pane" id="environment">
				    <table class="table">
					<tr>
					    <?php
					    if($showToClass != 1){
						echo '<th>First Name</th><th>Last Name</th><th>Hard Change or Achieve</th><th>Easy Change or Achieve</th>';
					    }else{
						echo '<th>ID</th><th>Hard Change or Achieve</th><th>Easy Change or Achieve</th>';
						$count = 1;
					    }
					    ?>
					</tr>
					<?php
					foreach ($resultLink as $studentId){
					    $result = mysql_query("SELECT environmentHardChange, environmentEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$studentId' AND submit='1' AND environmentEasyChange IS NOT NULL order by recordId DESC Limit 1");
					    $row = mysql_fetch_array($result);
					    $arrEnvironmentHardChange = $row['environmentHardChange'];
					    $arrEnvironmentEasyChange = $row['environmentEasyChange'];
					    $envHardChangeList = unserialize(base64_decode($arrEnvironmentHardChange));
					    $envEasyChangeList = unserialize(base64_decode($arrEnvironmentEasyChange));
					    if(isset($arrEnvironemntEasyChange) || isset($arrEnvironmentHardChange)){
						list($firstName, $lastName) = getUserFirstLastNames($studentId);
						echo "<tr>";
						if($showToClass != 1){
						    echo "<td>".$firstName."</td><td>".$lastName."</td><td>".$envHardChangeList[0].";".$envHardChangeList[1].";".$envHardChangeList[2]."</td><td>".$envEasyChangeList[0].";".$envEasyChangeList[1].";".$envEasyChangeList[2]."</td>";
						}else{
						    echo "<td>".$count."</td><td>".$envHardChangeList[0].";".$envHardChangeList[1].";".$envHardChangeList[2]."</td><td>".$envEasyChangeList[0].";".$envEasyChangeList[1].";".$envEasyChangeList[2]."</td>";
						}
						echo "</tr>";
					    }else{
						if($showToClass != 1){
						    list($firstName, $lastName) = getUserFirstLastNames($studentId);
						    echo "<tr>";
						    echo "<td>".$firstName."</td><td>".$lastName."</td><td>&nbsp</td><td>&nbsp</td>";
						    echo "</tr>";
						}
					    }
					}
					mysql_close($con);
					?>
				    </table>
				</div>
				
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	    <?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>

