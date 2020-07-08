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
$w1y = mysql_num_rows($result)>0 ? $row["W1"] : null;
$w2y = mysql_num_rows($result)>0 ? $row["W2"] : null;
$w3y = mysql_num_rows($result)>0 ? $row["W3"] : null;
$w4y = mysql_num_rows($result)>0 ? $row["W4"] : null;
$w5y = mysql_num_rows($result)>0 ? $row["W5"] : null;
$w6y = mysql_num_rows($result)>0 ? $row["W6"] : null;
$answer11 = mysql_num_rows($result)>0 ? $row["A1"] : null;
$answer12 = mysql_num_rows($result)>0 ? $row["A2"] : null;
$answer13 = mysql_num_rows($result)>0 ? $row["A3"] : null;
$answer14 = mysql_num_rows($result)>0 ? $row["A4"] : null;
$answer21 = mysql_num_rows($result)>0 ? $row["A5"] : null;
$answer22 = mysql_num_rows($result)>0 ? $row["A6"] : null;
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
                              <!-- Nav tabs Main-->
                              <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none">
                                  <li role="presentation" class="active"><a href="#homeTag" aria-controls="datagraphs" role="tab" data-toggle="tab" id='tab0'>Home</a></li>
                                  <li role="presentation"><a href="#watchTag" aria-controls="actigraphy" role="tab" data-toggle="tab" id='tab1'>watch</a></li>
                                  <li role="presentation"><a href="#diaryTag" aria-controls="sleepWatch" role="tab" data-toggle="tab" id='tab2'>diary</a></li>
                                  <li role="presentation"><a href="#questionTag" aria-controls="sleepDiary" role="tab" data-toggle="tab" id='tab3'>question</a></li>
                              </ul>

                                                              <!-- Tab panes -->
                                                              <div class="tab-content" style="margin-top: 2em;">

                                                                <!-- Tab panes main 1 -->
                                                                <div role="tabpanel" class="tab-pane active" id="homeTag">
                          			                                  <h4>Graphing your Zzz<br><small>Now you are ready to analyze your own sleep data. Click the Sleep Watch box to graph your sleep watch data. Click the Sleep Diary Box to graph your sleep diary data.</small><br></h4>
                          																				<div class="row">
                          																	        <div class="col-md-offset-3 col-md-6">
                          																	  				<div class="info info-gradorange" onclick="selectPage(1)" style="cursor: pointer;text-align: center;">
                          																			          <h3 class="info-title info-title-white">Sleep Watch</h3>
                          																	  				</div>
                          																	        </div>
                          																	        <div class="col-md-offset-3 col-md-6">
                          																	            <div class="info info-gradbb" onclick="selectPage(2)" style="cursor: pointer;text-align: center;">
                          																	  		          <h3 class="info-title info-title-white">Sleep Diary</h3>
                          																	    				</div>
                          																	        </div>
                          																	        <div class="col-md-offset-3 col-md-6">
                          																	  				<div class="info info-gradbg" onclick="selectPage(3)" style="cursor: pointer;text-align: center;">
                          																			          <h3 class="info-title info-title-white">Questions</h3>
                          																	  				</div>
                          																	        </div>
                          																	      </div>
                                                                </div>

                                                                <!-- Tab panes main 2 -->
                                                                <div role="tabpanel" class="tab-pane" id="watchTag">
                                                                  <!-- Nav tabs -->
                                                                  <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                                                                      <li role="presentation" <?php if($backFlag == 0) echo 'class="active"';?>><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Sleep Watch Graph</a></li>
                                                                      <li role="presentation"><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Actogram</a></li>
                                  				                            <li role="presentation"><a href="#sleepWatch" aria-controls="sleepWatch" role="tab" data-toggle="tab">Watch Statistics</a></li>
                                  				                            <?php if($grade == 5){?>
                                  					                                 <li role="presentation" <?php if($backFlag == 1) echo 'class="active"';?>><a href="#response" aria-controls="response" role="tab" data-toggle="tab">Sleep Profile</a></li>
                                                                      <?php }?>
                                  								                </ul>
                                                                  <!-- sub-tab-content -->
                                                                  <div class="tab-content" style="margin-top: 2em;">

                                                                    <!-- Tab panes -->
                                                                    <div role="tabpanel" class="tab-pane active" id="datagraphs">
                                                                          <h3 class="text-center">Sleep Watch Graph</h3>
                                                                          <h4>
                                                                            Use the Actogram or Watch Statistics tabs to find the data you need to graph your nightly sleep. To graph your data, pull the bars up to the hours of sleep you got each day.
                                                                          </h4>
                                                                          <div class="row" style="margin-top:2em;">
                                                                            <div class="col-xs-12 col-md-12">
                                                                              <div id="chart-slide-a"></div>
                                                                            </div>
                                                                          </div>
                                                                          <div class="row">
                                                                            <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
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
                                                                                        <h4 class="text">Your data are not available. The following actogram is a template!</h4>
                                                                                      </div>
                                                                                  </div>
                                                                                  <?php
                                                                                }
                                                                    					?>
                                                                    					<div class="row">
                                                                    					    <div class="col-xs-11 col-md-11">
                                                                    						    <img id="id_actigraphy" name="actigraphy" src="<?php echo $imgSrc ?>"></img>
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
                                                                              <h4 class="text">Your data are not available. The following content is a template!</h4>
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
                                                                  </div>
                                                                </div>

                                                                <!-- Tab panes main 3 -->
                                                                <div role="tabpanel" class="tab-pane" id="diaryTag">
                                                                        <!-- Nav tabs -->
                                                                        <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                                                                            <li role="presentation" class="active"><a href="#diarygraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Sleep Diary Graph</a></li>
                                                                            <li role="presentation"><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
                                        								                </ul>
                                                                        <!-- Tab panes -->
                                                                        <div class="tab-content" style="margin-top: 2em;">

                                                                          <!-- Tab panes -->
                                                                            <div role="tabpanel" class="tab-pane active" id="diarygraphs">
                                                                                <h3 class="text-center">Sleep Diary Graph</h3>
                                                                                <h4>
                                                                                  Now you are ready to analyze your own sleep data.  Use the tabs to see your actogram and/or diary information.   Find the data you need to graph your nightly sleep and answer the questions about your sleep. To graph your data, pull the bars up to the hours of sleep you got each day.
                                                                                </h4>
                                                                                <div class="row" style="margin-top:2em;">
                                                                                  <div class="col-xs-12 col-md-12">
                                                                                    <div id="chart-slide-b"></div>
                                                                                  </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                  <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
                                                                                    <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".diaryGraphModal" style="width:100%;">Save and Submit</button>
                                                                                  </div>
                                                                                </div>
                                        		                                 </div>

                                                              				    <!-- Tab panes -->
                                                              				    <div role="tabpanel" class="tab-pane" id="sleepDiary">
                                                                            <?php if(mysql_num_rows($result)<=0) { ?>
                                                                              <div class="row">
                                                                                  <div class="col-xs-11 col-md-11">
                                                                                    <h4 class="text">Your data are not available. The following content is a template!</h4>
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
                                                                          <div class="center-block text-center" style="display: block;">
                                                                            <p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p>
                                                                          </div>
                                                                					<?php
                                                                					showSleepLegends($grade);
                                                                					mysql_close($con);
                                                                					?>
                                                                        </div>
                                                                  </div>
                                                                </div>

                                                                <!-- Tab panes main 4 -->
                                                                <div role="tabpanel" class="tab-pane" id="questionTag">
                                                                  <h4>Sleep Consistency and Sleep Quality: Just as important as Sleep Duration<br><small>Follow your teacher’s instructions on how to find your sleep consistency and sleep quality.</small><br></h4>
                          																				<div class="row">
                          																	        <div class="col-md-offset-1 col-md-10">
                                                                      <h4>Sleep Consistency</h4>
                                                                      <h5>1. What is the longest time you were asleep at night?</h5>
                                                                      <textarea name="answer11" id="answer11" class="form-control" rows="1"><?php echo $answer11; ?></textarea>
                                                                      <h5>2. What is the shortest time you were asleep at night?</h5>
                                                                      <textarea name="answer12" id="answer12" class="form-control" rows="1"><?php echo $answer12; ?></textarea>
                                                                      <h5>3. What is the difference between the longest and shortest time you were asleep?</h5>
                                                                      <textarea name="answer13" id="answer13" class="form-control" rows="1"><?php echo $answer13; ?></textarea>
                                                                      <h5>4. Was your sleep consistent? If not, what factors made it inconsistent?</h5>
                                                                      <textarea name="answer14" id="answer14" class="form-control" rows="1"><?php echo $answer14; ?></textarea>

                                                                      <h4>Sleep Quality</h4>
                                                                      <h5>1. What was your average sleep quality rating?</h5>
                                                                      <textarea name="answer21" id="answer21" class="form-control" rows="1"><?php echo $answer21; ?></textarea>
                                                                      <h5>2. Was your sleep quality sound or very sound? If not, what factors reduced your sleep quality?</h5>
                                                                      <textarea name="answer22" id="answer22" class="form-control" rows="1"><?php echo $answer22; ?></textarea>

                                                                      <div class="row">
                                                                        <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
                                                                          <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".questionGraphModal" style="width:100%;">Save and Submit</button>
                                                                        </div>
                                                                      </div>

                          																	        </div>
                          																	      </div>
                                                                </div>
                                                              </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($userType != 'teacher') { ?>
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
                      <button id="submit-activity" type="button" onclick="watchsubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade diaryGraphModal" id="submit-diary" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
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
                      <button id="submit-activity" type="button" onclick="diarysubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade questionGraphModal" id="submit-diary" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
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
                      <button id="submit-activity" type="button" onclick="questionsubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="submit-success" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="submit-modal-label">Successfully Submitted</h4>
                    </div>
                    <div class="modal-body">
                      You are now going back to the beginning of this activity, wait there for further instructions from your teacher.
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="submit-success-final" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="submit-modal-label">Successfully Submitted</h4>
                    </div>
                    <div class="modal-body">
                      Your answers have been submitted. Your teacher will give you further instructions.
                    </div>
                    <div class="modal-footer">
                      <a class="btn btn-success btn-simple"  name="Continue" href="<?php echo "lesson-menu?".$query; ?>">Continue</a>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
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
     function selectPage(page){
       $('#tab'+page).trigger('click');
       window.scrollTo({ top: 100, behavior: 'smooth' });
     }
     $(function () {
         $("#submit-activity").click(function() {
      	     $( "form" ).submit();
      	 });
     });

     function questionsubmit(){
       var a11 = $('textarea#answer11').val();
       var a12 = $('textarea#answer12').val();
       var a13 = $('textarea#answer13').val();
       var a14 = $('textarea#answer14').val();
       var a21 = $('textarea#answer21').val();
       var a22 = $('textarea#answer22').val();
       var type = 'question';
       console.log("question a11:"+a11);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
       $.ajax({
             type: "POST",
             url: "graph-my-zzz-done",
              data: {type:type,d1:a11,d2:a12,d3:a13,d4:a14,d5:a21,d6:a22,contributors:contributors}
             })
       .done(function(respond){
         console.log("watch done: "+respond);
         $('#submit-success-final').modal();
       })
     }

     function watchsubmit(){
       var d1 = chartSlideA.get("day1").y;
       var d2 = chartSlideA.get("day2").y;
       var d3 = chartSlideA.get("day3").y;
       var d4 = chartSlideA.get("day4").y;
       var d5 = chartSlideA.get("day5").y;
       var d6 = chartSlideA.get("day6").y;
       var type = 'watch';
       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
       $.ajax({
             type: "POST",
             url: "graph-my-zzz-done",
              data: {type:type, d1:d1, d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,contributors:contributors}
             })
       .done(function(respond){
         console.log("watch done: "+respond);
         $('#submit-success').modal();
         selectPage(0);
       })
     }
     function diarysubmit(){
       var d1 = chartSlideB.get("day1").y;
       var d2 = chartSlideB.get("day2").y;
       var d3 = chartSlideB.get("day3").y;
       var d4 = chartSlideB.get("day4").y;
       var d5 = chartSlideB.get("day5").y;
       var d6 = chartSlideB.get("day6").y;
       var type = 'diary';
       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "graph-my-zzz-done",
            data: {type:type, d1:d1, d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,contributors:contributors}
           })
     .done(function(respond){
       console.log("DIARY done: "+respond);
       $('#submit-success').modal();
       selectPage(0);
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

     var w1o = <?php if($w1y > 0 ){ echo $w1y; } else { echo 10; }?>;
     var w2o = <?php if($w2y > 0 ){ echo $w2y; } else { echo 10; }?>;
     var w3o = <?php if($w3y > 0 ){ echo $w3y; } else { echo 10; }?>;
     var w4o = <?php if($w4y > 0 ){ echo $w4y; } else { echo 10; }?>;
     var w5o = <?php if($w5y > 0 ){ echo $w5y; } else { echo 10; }?>;
     var w6o = <?php if($w6y > 0 ){ echo $w6y; } else { echo 10; }?>;
     var wso = <?php if($wsy > 0 ){ echo $wsy; } else { echo 10; }?>;
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
              y: w1o
            },{
              name: 'Day 2',
              id: 'day2',
              y: w2o
            },{
              name: '111Day 3',
              id: 'day3',
              y: w3o
            },{
              name: 'Day 4',
              id: 'day4',
              y: w4o
            },{
              name: 'Day 5',
              id: 'day5',
              y: w5o
            },{
              name: 'Day 6',
              id: 'day6',
              y: w6o
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
                  align: 'right'
              }
            }
        }
      });

    var chartSlideB = new Highcharts.Chart({
        chart: {
            renderTo: 'chart-slide-b',
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
            dragPrecisionY: 30,
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
                  align: 'right'
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
