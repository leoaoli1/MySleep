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
require_once('utilities-diary.php');
require_once('diary-data.php');
require_once('utilities-actogram.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$classId = $_SESSION['classId'];
$backFlag = 0;
if(isset($_GET['back'])){
    $backFlag = $_GET['back'];
}
if($grade == 4){
    $fakeuserId = 10018;
}else{
    $fakeuserId = 10018;
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // How Do I Sleep</title>
	<style>
	 #id_actigraphy{
	     cursor: pointer;
	 }
	</style>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a  class="exit" data-location="main-page">Home</a></li>
                                <li><a  class="exit" data-location="sleep-lesson">Lessons</a></li>
                                <?php if($grade==4){?>
				    <li><a  class="exit" data-location="fourth-grade-lesson-menu?lesson=4">Lesson Four</a></li>
				<?php }else{?>
				    <li><a  class="exit" data-location="fifth-grade-lesson-menu?lesson=4">Lesson Four</a></li>
				<?php }?>
                                <li class="active">How Do I Sleep?</li>
                            </ol>
                        </div>
                    </div>
                    <div>
                        <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                                    <li role="presentation" <?php if($backFlag == 0) echo 'class="active"';?>><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Actigram</a></li>
				    <li role="presentation"><a href="#sleepWatch" aria-controls="sleepWatch" role="tab" data-toggle="tab">Sleep Watch</a></li>
                                    <li role="presentation"><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
				    <li role="presentation"><a href="#activityDiary" aria-controls="activityDiary" role="tab" data-toggle="tab">Activity Diary</a></li>
				    <?php if($grade == 5){?>
					<li role="presentation" <?php if($backFlag == 1) echo 'class="active"';?>><a href="#response" aria-controls="response" role="tab" data-toggle="tab">Sleep Profile</a></li>
                                    <?php }?>
				</ul>

                                <!-- Tab panes -->
                                <div class="tab-content" style="margin-top: 2em;">
                                    <div role="tabpanel" <?php if($backFlag == 0){ echo 'class="tab-pane active"';}else{echo 'class="tab-pane "';}?>  id="actigraphy">
                                        <h3 class="text-center">Actogram</h3>
					<?php
					$currentGrade = getCurrentGrade($fakeuserId);
					include 'connectdb.php';
					$result = mysql_query("SELECT * FROM my_actogram WHERE userId='$fakeuserId' and grade='$currentGrade' order by resultRow DESC LIMIT 1");
					$row = mysql_fetch_array($result);
					if(mysql_num_rows($result)>0) {
					    $imgSrc='data:image/png;base64,'.$row['imgSrc'];
					}
					?>
					<div class="row">
					    <div class="col-xs-11 col-md-11">
						<canvas id="id_actigraphy" name="actigraphy" style="border:1px solid #d3d3d3; background: url(<?php echo $imgSrc ?>); background-size: 100% 100%;"></canvas>
					    </div>
					    <div class="col-xs-1 col-md-1">
						<button id="black" type="button" class="btn btn-sm" style="background-color: black"></button><label for="black">Activity</label>
						<button id="blue" type="button" class="btn btn-sm" style="background-color: blue"></button><label for="black">Blue Light</label>
						<button id="yellow" type="button" class="btn btn-sm" style="background-color: yellow"></button><label for="black">Yellow Light</label>
					    </div>
					</div>
					<!--<div>
					    <button type="button" class="btn btn-sm" style="background-color: red" onclick="changeColor('red');"></button>
					    <button type="button" class="btn btn-sm" style="background-color: black" onclick="changeColor('black');;"></button>
					    <button type="button" class="btn btn-sm" style="background-color: blue" onclick="changeColor('blue');;"></button>
					    <button type="button" class="btn btn-sm" style="background-color: yellow" onclick="changeColor('yellow');;"></button>
					    <button type="button" class="btn btn-sm" style="background-color: purple" onclick="changeColor('purple');;"></button>
					    <button type="button" class="btn btn-danger btn-sm" onclick="redraw();" style="float: right;">Clear</button>
					</div>-->
                                        <!-- <img class="img-responsive" src="<?php echo $imgSrc ?>">-->
                                        
					<?php
					mysql_close($con);
					?>
				    </div>

				    <div role="tabpanel" class="tab-pane" id="sleepWatch">
					<h3 class="text-center">Watch Daily Statistics</h3>
					<div class="table-responsive" style="margin-top: 1.5em;">
					    <?php
					    if(mysql_num_rows($result)>0) {
						list($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime) = extractActigraphData($row);
					    }
					    ?>
                                            <table class="table">
						<thead>
                                                    <tr>
							<th>End Date_Sleep_Watch</th>
							<th>Bed Time_Sleep_Watch</th>
							<th>Wake Up Time_Sleep_Watch</th>
							<th>Time in Bed (hours:min)_Sleep_Watch</th>
							<th>Total Sleep Time (hours:min)_Sleep_Watch</th>
							<th>Time It Took to Fall Asleep (min)_Sleep_Watch</th>
							<th>Average Sleep Quality (precent)_Sleep_Watch</th>
							<th>#Awak._Sleep_Watch</th>
							<th>Awak. Time(min)_Sleep_Watch</th>
                                                    </tr>
						</thead>
						<tbody>
                                                    <?php
						    
						    for($i = 0; $i < (count($arrEndDate)-1); $i++){
							echo "<tr>";
							echo "<td>".$arrEndDay[$i]." ".$arrEndDate[$i]."</td><td>".$arrBedTime[$i]."</td><td>".$arrGetUpTime[$i]."</td><td>". gmdate('H:i', floor($arrTimeInBed[$i]*60))."</td><td>". gmdate('H:i', floor($arrTotalSleepTime[$i]*60))."</td><td>".$arrTimeItTookToFallAsleep[$i]."</td><td>".$arrAverageSleepQuality[$i]."</td><td>".$arrNumberOfAwak[$i]."</td><td>".$arrAwakeTime[$i]."</td>";
							echo "</tr>";
						    }
						    ?>
						</tbody>
                                            </table>
					</div>
					<div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
					<h3 class="text-center">Watch Summary Statistic</h3>
					<div class="table-responsive" style="margin-top: 1.5em;">
					    <table class="table">
						<thead>
						    <tr>
							<?php displayActographSummaryHeader();?>
						    </tr>
						</thead>
						<tbody>
						    <tr>
							<?php
							displayActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime);
							?>
						    </tr>
						</tbody>
					    </table>
					</div>
					<div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
				    </div>

				
				    <!-- Tab panes -->
				    <div role="tabpanel" class="tab-pane" id="sleepDiary">
					<h3>Sleep Diary Daily Statistics</h3>
					<?php
					require_once('sleep-diary-data-table.php');
					include 'connectdb.php';
					$includeUnsubmitted = false;
					list($startingDiaryEntryDate, $endingDiaryEntryDate) = getDiarySelection($fakeuserId, $grade);
					

					$statsSleep = array
					(
					    'timeLightsOff' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'timeFellAsleep' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'timeWakeup' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'timeOutOfBed' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'numWokeup' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'minWokeup' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'hourSlept' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					    'wokeupState' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'sleepQuality' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'sleepCompare' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'roomDarkness' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'roomQuietness' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'roomWarmness' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
					);
					
					$queryOptionsDiary = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "AND");
					$queryCommandSleep = "SELECT * FROM diary_data_table WHERE userId='$fakeuserId' AND diaryGrade = '$grade'" . $queryOptionsDiary . " ORDER BY diaryDate";
					$resultsSleepDiaryToShow = mysql_query($queryCommandSleep);

					?>
                                        <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
						<thead>
                                                    <tr class="success">
							<?php
							displaySleepCommonTableHeader($grade, 'sleep')
							?>
                                                    </tr>
						</thead>
						<tbody>
                                                    <?php
						    while ($rowSleepDiaryToShow = mysql_fetch_array($resultsSleepDiaryToShow)) {
							echo "<tr>";
							displaySleepCommonData($rowSleepDiaryToShow, 'sleep', $grade);
							echo "</tr>";
							accumulateSleepData($rowSleepDiaryToShow, $statsSleep);
						    }
						    computeSleepStats($statsSleep);
						    ?>
						</tbody>
                                            </table>
                                        </div>
					<div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
                                        <h3>Sleep Diary Summary Statistics</h3>
                                        <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
						<thead>
                                                    <tr class="success">
							<?php
							sleepStatsSummaryHeader($grade);
							?>
                                                    </tr>
						</thead>
						<tbody>
                                                    <tr>
							<?php
							displaySleepStatsSummaryData($statsSleep, $grade);
							?>
                                                    </tr>
						</tbody>
                                            </table>
                                        </div>
                                        <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
					<?php
					showSleepLegends($grade);
					mysql_close($con);
					?>
                                    </div>

				    <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="activityDiary">
					<h3>Activity Diary Daily Statistics</h3>
					<?php
					include 'connectdb.php';
					list($startingActivityEntryDate, $endingActivityEntryDate) = getActivitySelection($fakeuserId, $grade);
					require_once('activity-diary-data-table.php');
					$statsActivity = array
					(
					    'napStart' =>             array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'napEnd' =>               array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'napDuration' =>          array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'minExercised' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'numCaffeinatedDrinks' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'feltDuringDay' =>        array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'howSleepy' =>            array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'minVideoGame' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'minComputer' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'minTechnology' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'attention' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'behavior' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					    'interaction' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
					);
					$queryOptionsActivity = getQueryOptionsByDate($includeUnsubmitted, $startingActivityEntryDate, $endingActivityEntryDate, "AND");
					$queryCommandActivity = "SELECT * FROM activity_diary_data_table WHERE userId='$fakeuserId'  AND diaryGrade = '$grade'" . $queryOptionsActivity . " ORDER BY diaryDate";
					$resultsActivityDiaryToShow = mysql_query($queryCommandActivity);
					?>
                                        <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
                                                <thead>
                                                    <tr class="info">
                                                        <?php
							displaySleepCommonTableHeader($grade, 'activity');
							?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
						    $dayCount = 0;
						    $symptomCount = 0;
						    while ($rowActivityDiaryToShow = mysql_fetch_array($resultsActivityDiaryToShow)) {
							echo "<tr>";
							displaySleepCommonData($rowActivityDiaryToShow, 'activity', $grade);
							echo "</tr>";
							accumulateActivityData($rowActivityDiaryToShow, $statsActivity);
							$symptomCount += computeSymptom($rowActivityDiaryToShow);
							$dayCount += 1;
						    }
						    computeActivityStats($statsActivity);
						    ?>
                                                </tbody>
                                            </table>
                                        </div>
					<div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
                                        <h3>Activity Diary Summary Statistics</h3>
                                        <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
                                                <thead>
                                                    <tr class="info">
							<?php 
							activityStatsSummaryHeader($grade);
							?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
							<?php
							displayActivityStatsSummaryData($statsActivity, $grade);
							if(!empty($dayCount)){
							    echo "<td>".number_format($symptomCount/$dayCount, 2, '.', ',')."</td>"; //compute for symptoms
							}else{
							    echo "<td></td>";
							}
							?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
					<div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
					<?php
					showActivityLegends($grade);
					mysql_close($con);
					?>
                                    </div>

				    
				    <!-- Tab panes -->
				    <?php if($grade == 5){ ?>
					<div role="tabpanel" <?php if($backFlag == 1){ echo 'class="tab-pane active"';}else{echo 'class="tab-pane "';}?>  id="response">
					    <?php
					    // If data has already been saved for this student, place it in the body.
					    include 'connectdb.php';
					    $result =mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$fakeuserId' Order by id Desc Limit 1");
					    $numRow = mysql_num_rows ($result);
					    if ($numRow>0) {
						$row = mysql_fetch_array($result);
						if (isset($row['response'])) {
						    $content = $row['response'];
						}
					    }else {
						$content = "";
					    }
					    mysql_close($con);
					    ?>
					    <form action="sleep-profile-done" method="post">
						<div class="row">
						    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
							<h4>Write your own sleep profile. This profile is a written description about your sleep habits.<br><small>Please use Google Docs to draft it. <a href="https://www.google.com/docs" target="_blank">Google Docs</a></small></h4>
							<textarea name="sleepProfileResponse" id="sleepProfileResponse" class="form-control" rows="10"><?php echo htmlspecialchars($content);?></textarea>
						    </div>
						</div>
						<?php if($userType == 'student'){ ?>
						    <div class="row">
							<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
							    <button class="btn btn-info btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
							</div>
						    </div>
						    <div class="row">
							<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
							    <a class="btn btn-success btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
							</div>
						    </div>
						<?php }else{ ?>
						    <div class="row">
							<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
							    <a class="btn btn-info btn-large btn-block">Save</a>
							</div>
						    </div>
						    <div class="row">
							<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
							    <a class="btn btn-success btn-large btn-block"  name="submit" id="submit">Save &amp; Submit</a>
							</div>
						    </div>
						<?php } ?>
					    </form>
					</div>
				    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    <div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
			</div>
			<div class="modal-body">
			    Are you ready to submit your work to your teacher?
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			    <button id="submit-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
			</div>
		    </div>
		</div>
	    </div>
            <?php include 'partials/footer.php' ?>    
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     var canvas;
     var color = "black";
     var offsetTop;
     $(function () {
         $("#submit-activity").click(function() {
	     $( "form" ).submit();
	 });
         
     });

     canvas = document.getElementById('id_actigraphy');
     if (canvas !== null){
	 canvas.style.width ='100%'; //style size is the CSS size
	 canvas.style.height='600px';
	 //then set the internal size to match
	 canvas.width  = canvas.offsetWidth; //need to set canvas size
	 canvas.height = canvas.offsetHeight;
	 var ctx = canvas.getContext('2d');
	 click = false;
	 
	 
	 /*$(window).mousedown(function(){
	     click = true;
	 });
	 
	 $(window).mouseup(function(){
	     click = false;
	 });
	 
	 $('canvas').mousedown(function(e){
	     draw(e.pageX, e.pageY);   //should use page X, Y, not client X, Y. After scolling, the client X, Y will change, but the canvas offset is fixed. It will cause problem. 
	 });
	 
	 $('canvas').mouseup(function(e){
	     draw(e.pageX, e.pageY);
	 });
	 
	 $('canvas').mousemove(function(e){
	     if(click === true){
		 draw(e.pageX, e.pageY);
	     }
	 });*/
     }
     
     function draw(xPos, yPos){
	 ctx.beginPath();
	 ctx.fillStyle = color;
	 console.log($('canvas').offset().top);
	 ctx.arc(xPos - $('canvas').offset().left, yPos - $('canvas').offset().top, 4, 0, 1 * Math.PI);
	 ctx.fill();
	 ctx.closePath();
     }

     function redraw(){
	 ctx.clearRect(0, 0, canvas.width, canvas.height);
     }

     function changeColor(fillColor){
	 color = fillColor;
     }
    </script>
</html>
<?php
function getDiarySelection($userId, $grade)
{
    $result = mysql_query("SELECT diaryStartDateFour, diaryEndDateFour, diaryStartDateFive, diaryEndDateFive FROM user_table where userId='$userId'");
    $row= mysql_fetch_array($result);
    if($grade==4){
	$startDate = $row['diaryStartDateFour'];
	$endDate =  $row['diaryEndDateFour'];
    }else{
	$startDate = $row['diaryStartDateFive'];
	$endDate =  $row['diaryEndDateFive'];
    }
    return array($startDate, $endDate);
}

function getActivitySelection($userId, $grade)
{
    $result = mysql_query("SELECT activityStartDateFour, activityEndDateFour, activityStartDateFive, activityEndDateFive FROM user_table where userId='$userId'");
    $row= mysql_fetch_array($result);
    if($grade==4){
	$startDate = $row['activityStartDateFour'];
	$endDate =  $row['activityEndDateFour'];
    }else{
	$startDate = $row['activityStartDateFive'];
	$endDate =  $row['activityEndDateFive'];
    }
    return array($startDate, $endDate);
}

function displaySleepCommonTableHeader($grade, $table)
{
    echo   "<th>Diary Date</th>";
    if($table=='sleep'){
	displayCommonHeaderSleep($grade);
    }else{
	displayCommonHeaderActivity($grade);
    }
}

function displaySleepCommonData($row, $table, $grade)
{
    echo "<td>" . getDisplayDate($row['diaryDate']) . "</td>";
    if($table=='sleep'){
	displayCommonDataSleep($row);
    }else{
	displayCommonDataActivity($row, $grade);
    }
}


function sleepStatsSummaryHeader($grade){
    
    echo   "<th data-field='early-bed'>Earliest Bed Time_Sleep Diary</th>";
    echo   "<th data-field='last-bed'>Latest Bed Time_Sleep Diary</th>";
    echo   "<th data-field='ave-bed'>Average Bed Time_Sleep Diary</th>";
    echo   "<th data-field='early-wake'>Earliest Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='last-wake'>Latest Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='ave-wake'>Average Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='short-total'>Shortest Total Sleep Time_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='long-total'>Longest Total Sleep Time_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='ave-total'>Average Total Sleep Time_Sleep Diary (hourse:min)</th>";
    echo   "<th data-field='ave-inBed'>Average Time in Bed_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='ave-fall'>Average Time it Took to Fall Asleep_Sleep Diary (min)</th>";
    echo   "<th data-field='ave-awak'>Average #Awak._Sleep Diary</th>";
    echo   "<th data-field='ave-awakeTime'>Average Awake Time_Sleep Diary (min)</th>";
    if($grade==4){
        echo   "<th data-field='ave-bedroomLight'>Average Bedroom Lighting Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-noise'>Average Bedroom Noise Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-temperature'>Average Bedroom Temperature Rating_Sleep Diary</th>";
    }
    echo   "<th data-field='ave-wakeUp'>Average Wake Up State Rating_Sleep Diary</th>";
    echo   "<th data-field='ave-quality'>Average Sleep Quality (last night) Rating_Sleep Diary</th>";
    //echo   "<th>Average Sleep Quality (compared to usual) Rating_Sleep Diary</th>";
    
}

function activityStatsSummaryHeader($grade){
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }

    echo   "<th data-field='nap'>Number of Days Napped_Activity Diary</th>";
    echo   "<th data-field='ave-caffe'>Average Number of Caffeinated Drinks_Activity Diary</th>";
    echo   "<th data-field='ave-exerc'>Average Number of Minutes Exercised_Activity Diary</th>";
    if($grade==4 || $grade ==0){
	echo   "<th data-field='ave-game'>Average Number of Minutes Played Video Games_Activity Diary</th>";
	echo   "<th data-field='ave-computer'>Average Number of Minutes Spent Using a Computer_Activity Diary</th>";
	echo   "<th data-field='ave-tech'>Average Number of Minutes Using Other Technology_Activity Diary</th>";
    }
    if($grade == 5 || $grade ==0){
        echo   "<th data-field='ave-mood'>Average Mood Rating_Activity Diary</th>";
        echo   "<th data-field='ave-moodDesc'>Mood Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='ave-sleepness'>Average Sleepiness Rating_Activity Diary</th>";
    echo   "<th data-field='sleepness'>Sleepiness Descriptor Most Often Selected_Activity Diary</th>";
    if($grade == 5 || $grade ==0){
        echo   "<th data-field='ave-attention'>Average Attention Rating_Activity Diary</th>";
        echo   "<th data-field='attention'>Attention Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th data-field='ave-behavior'>Average Behavior Rating_Activity Diary</th>";
	echo   "<th data-field='behavior'>Behavior Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th data-field='ave-interactions'>Average Interactions Rating_Activity Diary</th>";
	echo   "<th data-field='interactions'>Interactions Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='symptoms'>Physical Symptoms_Activity Diary</th>";
}

function actographSummaryHeader(){
    echo '<th>Earliest Bed Time_Sleep_Watch</th>
		  <th>Latest Bed Time_Sleep_Watch</th>
		  <th>Average Bed Time_Sleep_Watch</th>
		  <th>Earliest Wake Time_Sleep_Watch</th>
		  <th>Latest Wake Time_Sleep_Watch</th>
		  <th>Average Wake Time_Sleep_Watch</th>
		  <th>Shortest Total Sleep Time_Sleep_Watch (hours:Min)</th>
		  <th>Longest Total Sleep Time_Sleep_Watch (hours:Min)</th>
		  <th>Average Total Sleep Time_Sleep_Watch (hours:Min)</th>
		  <th>Average Time in Bed_Sleep_Watch (hours)</th>
		  <th>Average Time it Took to Fall Asleep_Sleep_Watch (min)</th>
		  <th>Average Sleep Quality_Sleep_Watch (percent)</th>
		  <th>Average #Awak._Sleep_Watch</th>
		  <th>Average Average Awake Time_Sleep_Watch</th>';
}
?>
