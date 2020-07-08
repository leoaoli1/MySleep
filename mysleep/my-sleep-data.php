<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#
# Author:   Ao Li <aoli1@email.arizona.edu>
#           Siteng Chen <sitengchen@email.arizona.edu>
#

require_once('utilities.php');
require_once('utilities-diary.php');
require_once('diary-data.php');
require_once('utilities-actogram.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = getCurrentGrade($userId);
$classId = $_SESSION['classId'];
$lessonId = $_GET['lesson'];
$lessonNameArray = array('','One','Two','Three','Four');
$backFlag = 0;
if(isset($_GET['back'])){
    $backFlag = $_GET['back'];
}

$currentGrade = getCurrentGrade($userId);
include 'connectdb.php';

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

if ($config) {
  $result = mysql_query("SELECT * FROM mySleepData WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
}else {
  $result = mysql_query("SELECT * FROM mySleepData WHERE userId='$userId' order by resultRow DESC LIMIT 1");
}
$row = mysql_fetch_array($result);
unset($_SESSION['current_work']);
$_SESSION['current_work'] = $row;
$d1y = mysql_num_rows($result)>0 ? $row["D1"] : null;
$d2y = mysql_num_rows($result)>0 ? $row["D2"] : null;
$d3y = mysql_num_rows($result)>0 ? $row["D3"] : null;
$d4y = mysql_num_rows($result)>0 ? $row["D4"] : null;
$d5y = mysql_num_rows($result)>0 ? $row["D5"] : null;
$d6y = mysql_num_rows($result)>0 ? $row["D6"] : null;
$watch1 = $row["watch1"];
$watch2 = $row["watch2"];
$watch3 = $row["watch3"];
$diary1 = $row["diary1"];
$diary2 = $row["diary2"];
$diary3 = $row["diary3"];
$answer1 = $row["A1"];
$answer2 = $row["A2"];
$answer3 = $row["A3"];
$answer4 = $row["A4"];
$answer5 = $row["A5"];
$answer6 = $row["A6"];
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
    <?php include 'partials/scripts.php' ?>
    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php
                        if ($config) {
                          require_once('partials/nav-links.php');
                          navigationLink($config,$userType);
                        } else {
                     ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a  class="exit" data-location="main-page">Home</a></li>
                                <li><a  class="exit" data-location="sleep-lesson">Lessons</a></li>
                                <?php if($grade==4){?>
                        				    <li><a  class="exit" data-location="fourth-grade-lesson-menu?lesson=<?php echo $lessonId; ?>">Lesson <?php echo $lessonNameArray[$lessonId]; ?></a></li>
                        				<?php }else{?>
                        				    <li><a  class="exit" data-location="fifth-grade-lesson-menu?lesson=2">Lesson Two</a></li>
                        				<?php }?>
                                    <li><a  class="exit" data-location="fourth-grade-lesson-activity-menu?lesson=<?php echo $lessonId; ?>&activity=2">Activity Two</a></li>
                                    <?php if($userType=='teacher' && $lessonId == 2){?>
                                        <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=<?php echo $lessonId; ?>&activity=2&name=sleepdata">Part 2</a></li>
                                    <?php }?>

                                <?php if($lessonId == 2){ ?>
                                  <li class="active">How Do I Sleep?</li>
                                <?php }elseif($lessonId == 3){ ?>
                                  <li class="active">How Consistent do I Sleep?</li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <div>
                        <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                            <div>
                              <?php include 'add-group-member-button.php' ?>
                                <!-- Nav tabs -->
                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                                    <li role="presentation" <?php if($backFlag == 0) echo 'class="active"';?>><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Sleep Graph</a></li>
                                    <li role="presentation"><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Actogram</a></li>
				                            <li role="presentation"><a href="#sleepWatch" aria-controls="sleepWatch" role="tab" data-toggle="tab">Watch Statistics</a></li>
                                    <li role="presentation"><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
									                  <li role="presentation"><a href="#activityDiary" aria-controls="activityDiary" role="tab" data-toggle="tab">Activity Diary</a></li>
                                    <li role="presentation"><a href="#analysis" aria-controls="analysis" role="tab" data-toggle="tab">Analysis</a></li>
                                    <li role="presentation" <?php if($backFlag == 1) echo 'class="active"';?>><a href="#response" aria-controls="response" role="tab" data-toggle="tab" id="profileTab">Sleep Profile</a></li>

								                </ul>


                                <!-- Tab panes -->
                                <div class="tab-content" style="margin-top: 2em;">

                                  <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane active" id="datagraphs">
                                        <h3 class="text-center">Sleep Graph</h3>
                                        <h4>
                                          Use the tabs to see your actogram and/or diary information to graph your nightly sleep, analyze your sleep pattern and edit your sleep profile.
                                          <br><br>
                                          1. Find the data you need to graph your nightly sleep. If you wore an Actiwatch, use the data from the Actogram or the Watch Statistics tab. Otherwise, use the data contained in the Sleep Diary tab.  To graph your data, pull the bars up to the hours of sleep you got each day.
                                          <br><br>
                                          2.  Next, click “Analysis” to assess your sleep duration, consistency and quality.
                                        </h4>
                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-12 col-md-12">
                                            <div id="chart-slide-a"></div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">

                                                <button type="button" class="btn btn-gradbg btn-roundBold" data-toggle="modal" data-target=".dataGraphSaveModal" style="width:100%;">Save</button>
                                                <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".dataGraphModal" style="width:100%;">Save and Submit</button>

                                          </div>
                                        </div>
		                                 </div>

                                  <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="actigraphy">
                                        <h3 class="text-center">Actogram</h3>
                                  					<?php
                                  					$currentGrade = getCurrentGrade($userId);
                                  					include 'connectdb.php';
                                  					$result = mysql_query("SELECT * FROM my_actogram WHERE userId='$userId' and grade='$currentGrade' order by resultRow DESC LIMIT 1");
                                  					$row = mysql_fetch_array($result);
                                  					if(mysql_num_rows($result)>0) {
                                  						$imgSrc='data:image/png;base64,'.$row['imgSrc'];
                                  					}else{
                                              $imgSrc='images/fifthgrade-lessontwo/acti-case-one.png'; ?>
                                              <div class="row">
                                    					    <div class="col-xs-11 col-md-11">
                                                    <h4 class="text">Your data is not available. The following actogram is a template!</h4>
                                                  </div>
                                              </div>
                                              <?php
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
                                  					<?php
                                  					mysql_close($con);
                                  					?>
				                                 </div>

                      				    <!-- Tab panes -->
                      				    <div role="tabpanel" class="tab-pane" id="sleepWatch">
                                    <?php if(mysql_num_rows($result)<=0) { ?>
                                      <div class="row">
                                          <div class="col-xs-11 col-md-11">
                                            <h4 class="text">Your data is not available. The following data is a data template!</h4>
                                          </div>
                                      </div>
                                    <?php } ?>
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
                                							<th>#Awak._Actigraphy</th>
                                							<th>Awak. Time(min)_Actigraphy</th>
                                                                                    </tr>
                                						</thead>
                                						<tbody>
                                                <?php

                                                if(mysql_num_rows($result)>0) {
                                  						    for($i = 0; $i < (count($arrEndDate)-1); $i++){
                                      							echo "<tr>";
                                      							echo "<td>".$arrEndDay[$i]." ".$arrEndDate[$i]."</td><td>".$arrBedTime[$i]."</td><td>".$arrGetUpTime[$i]."</td><td>". gmdate('H:i', floor($arrTimeInBed[$i]*60))."</td><td>". gmdate('H:i', floor($arrTotalSleepTime[$i]*60))."</td><td>".$arrTimeItTookToFallAsleep[$i]."</td><td>".$arrAverageSleepQuality[$i]."</td><td>".$arrNumberOfAwak[$i]."</td><td>".$arrAwakeTime[$i]."</td>";
                                      							echo "</tr>";
                                  						    }
                                                }else {
                                                    echo "<tr><td>Tue 2/3/2015</td><td>11:39:00 PM</td><td>6:56:00 AM</td><td>07:17</td><td>06:07</td><td>27.50</td><td>83.98</td><td>42</td><td>32.50</td></tr>
                                                    <tr><td>Wed 2/4/2015</td><td>1:43:30 AM</td><td>9:25:30 AM</td><td>07:42</td><td>06:40</td><td>16.50</td><td>86.69</td><td>60</td><td>42.50</td></tr>
                                                    <tr><td>Thu 2/5/2015</td><td>12:33:00 AM</td><td>10:03:30 AM</td><td>09:30</td><td>07:54</td><td>19.00</td><td>83.09</td><td>47</td><td>34.50</td></tr>
                                                    <tr><td>Fri 2/6/2015</td><td>1:17:00 AM</td><td>7:57:00 AM</td><td>06:40</td><td>05:42</td><td>18.50</td><td>85.63</td><td>48</td><td>31.00</td></tr>
                                                    <tr><td>Sat 2/7/2015</td><td>5:17:30 AM</td><td>12:22:30 PM</td><td>07:05</td><td>06:33</td><td>13.50</td><td>92.47</td><td>20</td><td>12.00</td></tr>
                                                    <tr><td>Sun 2/8/2015</td><td>10:02:30 PM</td><td>8:26:30 AM</td><td>10:24</td><td>06:37</td><td>196.00</td><td>63.62</td><td>33</td><td>30.00</td></tr>";
                                                } ?>
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
                                            if(mysql_num_rows($result)>0) {
                              							displayActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime);
                                            }else {
                                              echo "<td>10:02:30 PM</td>
                                							<td>5:17:30 AM</td>
                                							<td>1:05:25 AM</td>
                                							<td>6:56:00 AM</td>
                                							<td>12:22:30 PM</td>
                                							<td>9:11:50 AM</td>
                                							<td>5:42:30</td>
                                							<td>7:54:00</td>
                                							<td>6:35:40</td>
                                              <td>41.67</td>
                                              <td>30.42</td>";
                                            }
                                            ?>
                              						    </tr>
                              						</tbody>
                              					</table>
                                    </div>
                                    <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
                      				    </div>

				    <!-- Tab panes -->
				    <div role="tabpanel" class="tab-pane" id="sleepDiary">
              <?php if(mysql_num_rows($result)<=0) { ?>
                <div class="row">
                    <div class="col-xs-11 col-md-11">
                      <h4 class="text">Your data is not available. The following data is a data template!</h4>
                    </div>
                </div>
              <?php } ?>
					    <h3>Sleep Diary Daily Statistics</h3>
					<?php
					require_once('sleep-diary-data-table.php');
					include 'connectdb.php';
					$includeUnsubmitted = false;
					list($startingDiaryEntryDate, $endingDiaryEntryDate) = getDiarySelection($userId, $grade);


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
					$queryCommandSleep = "SELECT * FROM diary_data_table WHERE userId='$userId' AND diaryGrade = '$grade'" . $queryOptionsDiary . " ORDER BY diaryDate";
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
            if(mysql_num_rows($result)>0) {
						    while ($rowSleepDiaryToShow = mysql_fetch_array($resultsSleepDiaryToShow)) {
    							echo "<tr>";
    							displaySleepCommonData($rowSleepDiaryToShow, 'sleep', $grade);
    							echo "</tr>";
    							accumulateSleepData($rowSleepDiaryToShow, $statsSleep);
    						    }
    						    computeSleepStats($statsSleep);

              }else {
                echo "
                <tr>
    							<td>Monday, March 8, 2016</td>
    							<td>Computer, Shower, Play with people</td>
    							<td>10:00 PM</td>
    							<td>06:00 AM</td>
    							<td>60</td>
    							<td>0</td>
    							<td>0</td>
    							<td>7:00</td>
    							<td>8:00</td>
    							<td>Nothing</td>
    							<td>1</td>
    							<td>Tired</td>
    							<td>4</td>
    							<td>Sound</td>
    						    </tr>
    						    <tr>
    							<td>Tuesday, March 9, 2016</td>
    							<td>Video game, Texting</td>
    							<td>01:00 AM</td>
    							<td>09:00 AM</td>
    							<td>0</td>
    							<td>0</td>
    							<td>0</td>
    							<td>8:00</td>
    							<td>8:00</td>
    							<td>Nothing</td>
    							<td>2</td>
    							<td>Somewhat Refreshed</td>
    							<td>3</td>
    							<td>Average</td>
    						    </tr>
    						    <tr>
    							<td>Wednesday, March 10, 2016</td>
    							<td>Phoning</td>
    							<td>12:00 AM</td>
    							<td>09:00 AM</td>
    							<td>0</td>
    							<td>2</td>
    							<td>5</td>
    							<td>8:55</td>
    							<td>9:00</td>
    							<td>Pet</td>
    							<td>3</td>
    							<td>Refreshed</td>
    							<td>3</td>
    							<td>Average</td>
    						    </tr>
    						    <tr>
    							<td>Thursday, March 11, 2016</td>
    							<td>Music, Phoning</td>
    							<td>01:00 AM</td>
    							<td>06:45 AM</td>
    							<td>0</td>
    							<td>0</td>
    							<td>0</td>
    							<td>5:45</td>
    							<td>5:45</td>
    							<td>Nothing</td>
    							<td>1</td>
    							<td>Tired</td>
    							<td>2</td>
    							<td>Restless</td>
    						    </tr>
    						    <tr>
    							<td>Friday, March 12, 2016</td>
    							<td>Reading, Play with people, Texting</td>
    							<td>04:00 AM</td>
    							<td>12:00 PM</td>
    							<td>60</td>
    							<td>2</td>
    							<td>7</td>
    							<td>6:53</td>
    							<td>8:00</td>
    							<td>Unknown</td>
    							<td>1</td>
    							<td>Tired</td>
    							<td>3</td>
    							<td>Average</td>
    						    </tr>
    						    <tr>
    							<td>Saturday, March 13, 2016</td>
    							<td>Video game, Computer, Snack</td>
    							<td>10:00 PM</td>
    							<td>08:00 AM</td>
    							<td>0</td>
    							<td>0</td>
    							<td>0</td>
    							<td>10:00</td>
    							<td>10:00</td>
    							<td>Nothing</td>
    							<td>3</td>
    							<td>Refreshed</td>
    							<td>3</td>
    							<td>Average</td>
    						    </tr>";
              }
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
              if(mysql_num_rows($result)>0) {
  			         displaySleepStatsSummaryData($statsSleep, $grade);
               }else {
                 echo "<td>10:00 PM</td>
   							<td>04:00 AM</td>
   							<td>12:20 AM</td>
   							<td>06:00 AM</td>
   							<td>12:00 PM</td>
   							<td>08:27 AM</td>
   							<td>5:45</td>
   							<td>10:00</td>
   							<td>7:45</td>
   							<td>8:07</td>
   							<td>20</td>
   							<td>.67</td>
   							<td>2</td>
   							<td>1.83</td>
   							<td>3</td>";
               }
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
                                      <?php if(mysql_num_rows($result)<=0) { ?>
                                        <div class="row">
                                            <div class="col-xs-11 col-md-11">
                                              <h4 class="text">Your data is not available. The following data is a data template!</h4>
                                            </div>
                                        </div>
                                      <?php } ?>
          <h3>Activity Diary Daily Statistics</h3>
					<?php
					include 'connectdb.php';
					list($startingActivityEntryDate, $endingActivityEntryDate) = getActivitySelection($userId, $grade);
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
					$queryCommandActivity = "SELECT * FROM activity_diary_data_table WHERE userId='$userId'  AND diaryGrade = '$grade'" . $queryOptionsActivity . " ORDER BY diaryDate";
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
              if(mysql_num_rows($result)>0) {
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
              }else {
                echo "<tr>
							<td>Monday, March 8, 2016</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>3</td>
							<td>Sometimes Pleasant</td>
							<td>3</td>
							<td>Sleepy</td>
							<td>1</td>
							<td>Couldn’t focus</td>
						    </tr>
						    <tr>
							<td>Tuesday, March 9, 2016</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>0</td>
							<td>30</td>
							<td>1</td>
							<td>3</td>
							<td>Sometimes Pleasant</td>
							<td>2</td>
							<td>Somewhat Sleepy</td>
							<td>4</td>
							<td>Focus most of the day</td>
						    </tr>
						    <tr>
							<td>Wednesday, March 10, 2016</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>0</td>
							<td>45</td>
							<td>2</td>
							<td>4</td>
							<td>Pleasant</td>
							<td>2</td>
							<td>Somewhat Sleepy</td>
							<td>3</td>
							<td>Focus about half of the time</td>
						    </tr>
						    <tr>
							<td>Thursday, March 11, 2016</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>0</td>
							<td>45</td>
							<td>1</td>
							<td>1</td>
							<td>Very Unpleasant</td>
							<td>4</td>
							<td>Very Sleepy</td>
							<td>1</td>
							<td>Couldn’t focus</td>
						    </tr>
						    <tr>
							<td>Friday, March 12, 2016</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>0</td>
							<td>30</td>
							<td>2</td>
							<td>2</td>
							<td>Unpleasant</td>
							<td>4</td>
							<td>Very Sleepy</td>
							<td>1</td>
							<td>Couldn’t focus</td>
						    </tr>
						    <tr>
							<td>Saturday, March 13, 2016</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>0</td>
							<td>25</td>
							<td>1</td>
							<td>5</td>
							<td>Very Pleasant</td>
							<td>2</td>
							<td>Somewhat sleepy</td>
							<td>4</td>
							<td>Focus most of the day</td>
						    </tr>";
              }
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
              if(mysql_num_rows($result)>0) {
  							displayActivityStatsSummaryData($statsActivity, $grade);
  							if(!empty($dayCount)){
  							    echo "<td>".number_format($symptomCount/$dayCount, 2, '.', ',')."</td>"; //compute for symptoms
  							}else{
  							    echo "<td></td>";
  							}
              }else {
                echo "<td>0</td>
  							<td>1.17</td>
  							<td>29</td>
  							<td>3</td>
  							<td>Sometimes Pleasant, Very Unpleasant</td>
  							<td>2.83</td>
  							<td>Somewhat Sleepy</td>
  							<td>2.33</td>
  							<td>Little</td>";
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
                                   <div role="tabpanel" <?php if($backFlag == 1){ echo 'class="tab-pane active"';}else{echo 'class="tab-pane "';}?>  id="analysis">
                                      <?php
                                      // If data has already been saved for this student, place it in the body.
                                      include 'connectdb.php';
                                      $classGrade = getClassGrade($classId);
                                      $result =mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$userId' and grade='$classGrade' Order by id Desc Limit 1");
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
                                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <h3 class="text-center">Analyze Your Own Sleep Data</h3>
                                          <h4>
                                            Directions: You have analyzed other students’ sleep. Now, use the data from your sleep watch or diary and activity diary.
                                          </h4>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <h4><small>1. Find if you are getting the RECOMMENDED 9-11 hours of sleep.</small></h4>
                                					<div class="table-responsive" style="margin-top: 1.5em;">
                                					  <table class="table">
                                  						<thead>
                                                <tr class="info">
                                    							<th>Sleep Duration Variables</th>
                                    							<th>Sleep Watch Data</th>
                                    							<th>Sleep Diary Data</th>
                                                </tr>
                                  						</thead>
                                      						<tbody>
                                                    <tr><td>How many nights did you get at least 9 hours of sleep?</td><td><textarea name="watch11" id="watch11" class="form-control" rows="1"><?php echo htmlspecialchars($watch1);?></textarea></td><td><textarea name="diary11" id="diary11" class="form-control" rows="1"><?php echo htmlspecialchars($diary1);?></textarea></td></tr>
                                                    <tr><td>What was your average sleep duration (hours: minutes)?</td><td><textarea name="watch12" id="watch12" class="form-control" rows="1"><?php echo htmlspecialchars($watch2);?></textarea></td><td><textarea name="diary12" id="diary12" class="form-control" rows="1"><?php echo htmlspecialchars($diary2);?></textarea></td></tr>
                                      						</tbody>
                                              </table>
                                					</div>
                                        </div>
                                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <h4><small>2. Find out if you have a CONSISTENT sleep pattern.</small></h4>
                                          <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
                                              <thead>
                                                <tr class="success">
                                                  <th>Sleep Consistency Variables</th>
                                                  <th>Sleep Watch Data</th>
                                                  <th>Sleep Diary Data</th>
                                                </tr>
                                              </thead>
                                                  <tbody>
                                                    <tr><td>a. What is the difference between your earliest and latest bedtime? (The difference between your earliest and latest bedtime should be 1 hour or less.) </td><td><textarea name="watch21" id="watch21" class="form-control" rows="1"><?php echo htmlspecialchars($watch3);?></textarea></td><td><textarea name="diary21" id="diary21" class="form-control" rows="1"><?php echo htmlspecialchars($diary3);?></textarea></td></tr>
                                                  </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <h4><small>3. Use the Sleep Diary to find out about your SLEEP QUALITY. </small></h4>
                                          <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
                                              <thead>
                                                <tr class="warning">
                                                  <th>Sleep Quality Variables </th>
                                                  <th>Sleep Watch Data</th>
                                                  <th>Sleep Diary Data</th>
                                                </tr>
                                              </thead>
                                                  <tbody>
                                                    <tr><td>a. How many nights was your Sleep Quality Descriptor “sound” (4) or “very sound” (5)? </td><td> <h3 class="text-center">X</h3> </td><td><textarea name="diary31" id="diary31" class="form-control" rows="1"><?php echo htmlspecialchars($answer1);?></textarea></td></tr>
                                                    <tr><td>b. What was your Average Wake Up State Rating?  Tired (1), Somewhat Tired (2), Somewhat Refreshed (3), Refreshed (4) </td><td>  <h3 class="text-center">X</h3>  </td><td><textarea name="diary32" id="diary32" class="form-control" rows="1"><?php echo htmlspecialchars($answer2);?></textarea></td></tr>
                                                    <tr><td>c. What was your Average Sleep Quality  (percentage of time in bed asleep - >90% is good quality) </td><td> <textarea name="watch33" id="watch33" class="form-control" rows="1"><?php echo htmlspecialchars($answer3);?></textarea> </td><td> <h3 class="text-center">X</h3> </td></tr>
                                                  </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <h4><small>4. Use the ACTIVITY DIARY data to look for connections between your sleep habits and your activities and feelings during the day.</small></h4>
                                          <div class="table-responsive" style="margin-top: 1.5em;">
                                            <table class="table">
                                              <thead>
                                                <tr class="info">
                                                  <th>Sleep Effects Variables</th>
                                                  <th>Activity Diary Data</th>
                                                </tr>
                                              </thead>
                                                  <tbody>
                                                    <tr><td>a. How many days was your  Sleepiness Descriptor “not sleepy”? </td><td><textarea name="activity41" id="activity41" class="form-control" rows="1"><?php echo htmlspecialchars($answer4);?></textarea></td></tr>
                                                    <tr><td>b. How many days was your Mood Descriptor “pleasant” or “very pleasant”? </td><td><textarea name="activity42" id="activity42" class="form-control" rows="1"><?php echo htmlspecialchars($answer5);?></textarea></td></tr>
                                                    <tr><td>c. What was your Average Attention Rating? Couldn’t focus today (1), Focus occasionally (2), Focus about half of the time (3), Focus most of the day (4), Focus all day (5)</td><td><textarea name="activity43" id="activity43" class="form-control" rows="1"><?php echo htmlspecialchars($answer6);?></textarea></td></tr>
                                                  </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>

                                    <?php if($userType == 'student'){ ?>
                                    <div class="row">
                                        <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                                      <a class="btn btn-success btn-large btn-block" data-toggle="modal" data-target=".analysisModal">Save &amp; Submit</a>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                        <div class="row">
                                      <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                                          <a class="btn btn-success btn-large btn-block"  name="submit" id="submit">Save &amp; Submit</a>
                                      </div>
                                        </div>
                                        <?php } ?>
                                      </form>
                                   </div>

				    <!-- Tab panes -->
					<div role="tabpanel" <?php if($backFlag == 1){ echo 'class="tab-pane active"';}else{echo 'class="tab-pane "';}?>  id="response">
					    <?php
					    // If data has already been saved for this student, place it in the body.
					    include 'connectdb.php';
					    $classGrade = getClassGrade($classId);
					    $result =mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$userId' and grade='$classGrade' Order by id Desc Limit 1");
					    $numRow = mysql_num_rows ($result);
					    if ($numRow>0) {
    						$row = mysql_fetch_array($result);
    						if (isset($row['response'])) {
    						    $content = $row['response'];
    						}
                $revision = $row['revisionResponse'];
                $resultRow = $row['id'];
					    }else {
						    $content = "";
                $revision = "";
					    }
					    mysql_close($con);
					    ?>
					    <form action="predict-sleep-profile-revision-done" method="post">
                <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                <input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
						<div class="row">
						    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
    							<!-- <h4>Write your own sleep profile. This profile is a written description about your sleep habits.<br><small>Please use Google Docs to draft it. <a href="https://www.google.com/docs" target="_blank">Google Docs</a></small></h4> -->
                  <h4>Reread the SLEEP PROFILE you drafted in Lesson 3.</h4>
                  <textarea disabled class="form-control"  rows="10"><?php echo htmlspecialchars($content);?></textarea>
                  <h4>
                    In the box below, revise your personal sleep profile using the analysis you performed in the Analysis tab on your own sleep data. Refer back to the Analysis tab as necessary.
                    <br><br>
                    Does your current sleep pattern match one of the sleep patterns we identified in Lesson 3?
                    <br>
                    <small>
                      Raul – Consistent recommended sleep nightly
                      <br>
                      Mike – Late nights and daily deficient sleep
                      <br>
                      Mary – Weekend catch up sleep for weekday short sleep
                      <br>
                      Ricardo - Late nights and sleep loss on weekends
                    </small>
                    <br><br>
                    If so, include that information in your revised sleep profile.
                  </h4>
                  <textarea name="sleepProfileResponse" id="sleepProfileResponse" class="form-control" rows="10"><?php echo htmlspecialchars($revision);?></textarea>
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
      <div class="modal fade dataGraphSaveModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Save the data graphs</h4>
            </div>
            <div class="modal-body">
              Are you ready to save your work?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
              <button id="submit-activity" type="button" onclick="dgsubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Save</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade dataGraphModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Submit the data graphs</h4>
            </div>
            <div class="modal-body">
              Are you ready to submit your work to your teacher?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
              <button id="submit-activity" type="button" onclick="dgsubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade analysisModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Submit the analysis answer</h4>
            </div>
            <div class="modal-body">
              Are you ready to submit your work to your teacher?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
              <button id="submit-activity" type="button" onclick="analysisSubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade diaryGraphModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Submit the sleep diary graphs</h4>
            </div>
            <div class="modal-body">
              Are you ready to submit your work to your teacher?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
              <button id="submit-activity" type="button" onclick="diarysubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade diaryGraphSaveModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Save the sleep diary graphs</h4>
            </div>
            <div class="modal-body">
              Are you ready to save your work?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
              <button id="submit-activity" type="button" onclick="diarysubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Save</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="next-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Submit Successful</h4>
            </div>
            <div class="modal-body">
              Next, click “Analysis” to assess your sleep duration, consistency and quality.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Ok</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="next-modal2" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="submit-modal-label">Submit Successful</h4>
            </div>
            <div class="modal-body">
              Select “Sleep Profile” to edit or confirm the information in the sleep profile you previously drafted.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Ok</button>
            </div>
          </div>
        </div>
      </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </body>

    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
    <script type="text/javascript">
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
     function analysisSubmit(){
       var watch1 = $('#watch11').val();
       var watch2 = $('#watch12').val();
       var watch3 = $('#watch21').val();
       var diary1 = $('#diary11').val();
       var diary2 = $('#diary12').val();
       var diary3 = $('#diary21').val();
       var d1 = $('#diary31').val();
       var d2 = $('#diary32').val();
       var d3 = $('#watch33').val();
       var d4 = $('#activity41').val();
       var d5 = $('#activity42').val();
       var d6 = $('#activity43').val();
       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "my-sleep-data-done",
            data: {type:'analysis', watch1:watch1,watch2:watch2,watch3:watch3,diary1:diary1,diary2:diary2,diary3:diary3,d1:d1, d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,contributors:contributors}
           })
       .done(function(respond){
         console.log("done: "+respond);
         $('#next-modal2').modal('show');
         // $('#profileTab').trigger('click')
       })
     }

     function dgsubmit(){
       var d1 = chartSlideA.get("day1").y;
       var d2 = chartSlideA.get("day2").y;
       var d3 = chartSlideA.get("day3").y;
       var d4 = chartSlideA.get("day4").y;
       var d5 = chartSlideA.get("day5").y;
       var d6 = chartSlideA.get("day6").y;
       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "my-sleep-data-done",
            data: {type:'drag', d1:d1, d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,contributors:contributors}
           })
       .done(function(respond){
         console.log("done: "+respond);
         $('#next-modal').modal('show');
         // $('#profileTab').trigger('click')
       })
     }
     function pad(d) {
         return (d < 10) ? '0' + d.toString() : d.toString();
     }
     var chartXAxis = {
         categories: ["Day1", "Day2", "Day3", "Day4","Day5","Day6"]
     };
     var chartYAxis = {
         title: {
             text: 'Hours of Sleep',
         },
         min: 0,
         max: 820,
         tickPositions: [0, 120, 240, 360, 480, 600, 720, 840],
         labels: {
           formatter: function() {
             return pad(Math.floor(this.value/60)) + ':' + pad(Math.floor(this.value%60));
           },
         },
         plotBands: [{
           color: "rgba(155, 200, 255, 0.3)",
           from: 540,
           to: 660,
           label: {
             text: 'Ideal Sleep Time',
             align: 'center',
             style: {
               fontSize: 30,
               color: "rgba(255, 255, 255, 1)",
             },
           },
         }],

     };

     var chartPlotOptions = {
         column: {
             stacking: 'normal',
         },
         line: {
             cursor: 'ns-resize'
         }
     };

     var chartTooltip = {
         animation: false,
         valueDecimals: 0,
         split: false,
         formatter: function() {
         return pad(Math.floor(this.y/60)) + ':' + pad(Math.floor(this.y%60));
         },
      };
     var d1o = <?php if($d1y > 0 ){ echo $d1y; } else { echo 10; }?>;
     var d2o = <?php if($d2y > 0 ){ echo $d2y; } else { echo 10; }?>;
     var d3o = <?php if($d3y > 0 ){ echo $d3y; } else { echo 10; }?>;
     var d4o = <?php if($d4y > 0 ){ echo $d4y; } else { echo 10; }?>;
     var d5o = <?php if($d5y > 0 ){ echo $d5y; } else { echo 10; }?>;
     var d6o = <?php if($d6y > 0 ){ echo $d6y; } else { echo 10; }?>;
     var dso = <?php if($dsy > 0 ){ echo $dsy; } else { echo 10; }?>;
    var chartSlideA = new Highcharts.Chart({
    chart: {
        renderTo: 'chart-slide-a',
        height: 600,
        animation: false,
    },

    title: {
        text: 'Total Sleep Time'
    },

    xAxis: chartXAxis,
    yAxis: chartYAxis,
    plotOptions: chartPlotOptions,
    tooltip: chartTooltip,

    series: [{
        name: " ",//legend name
        data: [
          {
          name: 'Day 1',
          id: 'day1',
          y: d1o
        },{
          name: 'Day 2',
          id: 'day2',
          y: d2o
        },{
          name: '111Day 3',
          id: 'day3',
          y: d3o
        },{
          name: 'Day 4',
          id: 'day4',
          y: d4o
        },{
          name: 'Day 5',
          id: 'day5',
          y: d5o
        },{
          name: 'Day 6',
          id: 'day6',
          y: d6o
        }
        ],
        draggableY: true,
        dragMinY: 10,
        dragMaxY: 870,
        dragPrecisionY: 1,
        type: 'column',
        dragHandleFill: '#BC0016',
        color: '#DAF7A6',
    }],
    exporting: {
        buttons: {
          contextButton: {
            height: 40,
            width: 100,
              symbol: 'menu',
              symbolStrokeWidth: 1,
              symbolFill: '#a4edba',
              symbolStroke: '#330033',
              text: 'Download',
              fontSize: "22px",
              align: 'right',
          }
        }
    }

  });
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
