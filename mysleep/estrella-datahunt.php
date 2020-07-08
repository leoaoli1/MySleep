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
$grade = $_GET['grade'];
$lessonId = $_GET['lesson'];
$classId = $_SESSION['classId'];
$backFlag = 0;
$lessonNameArray = array('','One','Two','Three','Four');
if(isset($_GET['back'])){
    $backFlag = $_GET['back'];
}

/*flexible framework section*/
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
/* end */

$currentGrade = getCurrentGrade($userId);
include 'connectdb.php';
$status = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$statusResult = mysql_fetch_array($status);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Estrella's Actogram</title>
      	<style>
      	 #id_actigraphy{
      	     cursor: pointer;
      	 }
      	</style>
        <?php include 'partials/scripts.php' ?>
    </head>

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
                                    <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=<?php echo $lessonId; ?>&activity=2&name=datahunt">Part 1</a></li>
                                <?php }?>

                                <?php if($lessonId == 2){ ?>
                                  <li class="active">Estrella's Data Hunt</li>
                                <?php }elseif($lessonId == 3){ ?>
                                  <li class="active">Estrella's Sleep Consistency</li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <div>
                        <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                                    <li role="presentation" <?php if($backFlag == 0) echo 'class="active"';?>><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Estrella's Actogram</a></li>
                                    <li role="presentation" ><a href="#watchData" aria-controls="watchData" role="tab" data-toggle="tab">Watch</a></li>
                                    <?php
                                        if ($config) {
                                          ?>
                                            <li role="presentation" ><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Watch Graph</a></li>
                                            <li role="presentation" ><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
                                          <?php
                                        } else {
                                     ?>
                                      <?php if($userType=='teacher'||($statusResult['EstrellaDataHuntBar']&&$lessonId==2)){?> <li role="presentation" ><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Watch Graph</a></li> <?php }?>
                                      <!-- <li role="presentation" ><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
                                      <?php if($userType=='teacher'||($statusResult['EstrellaDataHuntBar']&&$lessonId==2)){?> <li role="presentation" ><a href="#diarygraphs" aria-controls="diarygraphs" role="tab" data-toggle="tab">Sleep Diary Graph</a></li> <?php }?> -->
                                      <?php if($lessonId==3){?> <li role="presentation" ><a href="#sleepPattern" aria-controls="sleepPattern" role="tab" data-toggle="tab">Estrella's Sleep Pattern</a></li> <?php }?>
                                    <?php } ?>
								                 </ul>



                                <?php
                                if ($config) {
                                  $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE contributors LIKE '%$userId%' order by recordRow DESC LIMIT 1");
                                }else {
                                  $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE userId='$userId' order by recordRow DESC LIMIT 1");
                                }
                                $row = mysql_fetch_array($result);
                                unset($_SESSION['current_work']);
                                $_SESSION['current_work'] = $row;

                                if(mysql_num_rows($result)>0){
                                    if ($row['D1'] != null && $lessonId==2) {
                                        $graphSubmit = true;
                                        $d1y = $row["D1"] ? $row["D1"] : null;
                                        $d2y = $row["D2"] ? $row["D2"] : null;
                                        $d3y = $row["D3"] ? $row["D3"] : null;
                                        $d4y = $row["D4"] ? $row["D4"] : null;
                                        $d5y = $row["D5"] ? $row["D5"] : null;
                                        $d6y = $row["D6"] ? $row["D6"] : null;
                                        $dsy = $row["DS"] ? $row["DS"] : null;
                                    }else {
                                      $graphSubmit = false;
                                      $d1y = null;
                                      $d2y = null;
                                      $d3y = null;
                                      $d4y = null;
                                      $d5y = null;
                                      $d6y = null;
                                      $dsy = null;
                                    }
                                    if ($row['S1'] != null && $lessonId==2) {
                                        $diarySubmit = true;
                                        $s1y = $row["S1"] ? $row["S1"] : null;
                                        $s2y = $row["S2"] ? $row["S2"] : null;
                                        $s3y = $row["S3"] ? $row["S3"] : null;
                                        $s4y = $row["S4"] ? $row["S4"] : null;
                                        $s5y = $row["S5"] ? $row["S5"] : null;
                                        $s6y = $row["S6"] ? $row["S6"] : null;
                                        $ssy = $row["SS"] ? $row["SS"] : null;
                                    }else {
                                      $diarySubmit = false;
                                      $s1y = null;
                                      $s2y = null;
                                      $s3y = null;
                                      $s4y = null;
                                      $s5y = null;
                                      $s6y = null;
                                      $ssy = null;
                                    }
                                }
                                else{
                                    $submitted = 'Submit';
                                    $graphSubmit = false;
                                    $d1y = null;
                                    $d2y = null;
                                    $d3y = null;
                                    $d4y = null;
                                    $d5y = null;
                                    $d6y = null;
                                    $dsy = null;
                                    $diarySubmit = false;
                                    $s1y = null;
                                    $s2y = null;
                                    $s3y = null;
                                    $s4y = null;
                                    $s5y = null;
                                    $s6y = null;
                                    $ssy = null;
                                }
                                mysql_close($con);
                                ?>
                                <?php include 'add-group-member-button.php' ?>


                                <!-- Tab panes -->
                                <div class="tab-content" style="margin-top: 2em;margin-bottom: 1.5em;">

		                                <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="datagraphs">
                                      <div class="card" style="width: 100%; margin-bottom: 1.5em;">
                                          <div class="card-body">
                                              <h4 class="card-title">Estrella’s Watch Data Graphs</h4>
                                              <p class="card-text">Plot the data in <b>Watch</b> on the sleep graph. The data is in <b>(hour:min)</b> format, each bar will represent the number of hours each day that Estrella slept.<br> </p>
                                    			</div>
                                        </div>
                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-12 col-md-12">
                                            <div id="chart-slide-a">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
                                            <?php //if($graphSubmit == false){ ?>
                                                <button type="button" class="btn btn-gradbg btn-roundBold" data-toggle="modal" data-target=".dataGraphSaveModal" style="width:100%;">Save</button>
                                                <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".dataGraphModal" style="width:100%;">Save and Submit</button>
                                            <?php //} ?>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="diarygraphs">
                                      <div class="card" style="width: 100%; margin-bottom: 1.5em;">
                                          <div class="card-body">
                                              <h4 class="card-title">Estrella’s Sleep Diary Graphs</h4>
                                              <p class="card-text">Plot the data in <b>Sleep Diary</b> on the sleep graph. The data is in <b>(hour:min)</b> format, each bar will represent the number of hours each day that Estrella slept.<br> </p>
                                    			</div>
                                        </div>
                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-12 col-md-12">
                                            <div id="chart-slide-b">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
                                            <?php //if($diarySubmit == false){ ?>
                                                <button type="button" class="btn btn-gradbg btn-roundBold" data-toggle="modal" data-target=".diaryGraphSaveModal" style="width:100%;">Save</button>
                                                <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".diaryGraphModal" style="width:100%;">Save and Submit</button>
                                            <?php //} ?>
                                          </div>
                                        </div>
                                    </div>
                                    <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="sleepPattern">
                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-10 col-md-10">
                                            <div id="chart-slide-c">
                                            </div>
                                          </div>
                                          <!-- <div class="col-xs-10 col-md-6"> -->
                                            <div id="chart-slide-d" style="display:none"></div>
                                          <!-- </div> -->
                                        </div>
                                    </div>

                                    <!-- Tab panes -->
                                    <div role="tabpanel" <?php if($backFlag == 0){ echo 'class="tab-pane active"';}else{echo 'class="tab-pane "';}?>  id="actigraphy">
                                      <div class="card-body">
                                          <h4 class="card-title">Estrella’s Actogram</h4>
                                      </div>
                                      <div class="row">
                                        <img id="id_actibackground" name="actibackground" src="images/fourthgrade-lessontwo/estrellasactogram.png" style="width:100%" />
                                      </div>


                            				    </div>

                                        <!-- Tab panes -->
                                        <div role="tabpanel" class="tab-pane" id="watchData">
                                        <h3>Sleep Watch Daily Statistics</h3>
                                        <div id="toolbarWatchData">
                                          <button id="hide-watchWatchData" class="btn btn-sm btn-default">Unselect All Variables</button>
                                          <button id="show-watchWatchData" class="btn btn-sm btn-default">Select All Variables</button>
                                        </div>
                                        <table id="table-watchWatchData" class="table" data-toggle="table" data-toolbar="#toolbarWatchData" data-search="true" data-icons-prefix="fa"  data-show-columns="true">
                                          <colgroup>
                                            <?php if($lessonId==2){?>
                                              <col span="4" class="background-color:clear"></col>
                                              <col class="bg-success"></col>
                                            <?php } ?>
                                          </colgroup>
                                        <thead>
                                          <tr>
                                            <th data-field="end-date-a">End Date_Sleep_Watch</th>
                                            <th data-field="bed-time-a">Bed Time_Sleep_Watch</th>
                                            <th data-field="wake-up-time-a">Wake Up Time_Sleep_Watch</th>
                                            <th data-field="time-in-bed-a">Time in Bed (hours:min)_Sleep_Watch</th>
                                            <th data-field="total-sleep-time-a">Total Sleep Time (hours:min)_Sleep_Watch</th>
                                            <th data-field="time-it-took-to-fall-asleep-a">Time It Took to Fall Asleep (min)_Sleep_Watch</th>
                                            <th data-field="average-sleep-quality-a">Average Sleep Quality (precent)_Sleep_Watch</th>
                                            <th data-field="num-awak-a">#Awak._Sleep_Watch</th>
                                            <th data-field="awak-time-a">Awak. Time(min)_Sleep_Watch</th>
                                          </tr>
                                        </thead>
                                          <tbody>
                                        <tr>
                                          <tr><td>Tue (Day 1))</td><td>2:08:00 AM</td><td>7:02:00 AM</td><td>04:54</td><td>04:10</td><td>3.50</td><td>85.20</td><td>29</td><td>35.00</td></tr>
                                          <tr><td>Wed (Day 2)</td><td>1:21:00 AM</td><td>7:13:30 AM</td><td>05:52</td><td>05:06</td><td>8.50</td><td>86.81</td><td>24</td><td>20.00</td></tr>
                                          <tr><td>Thu (day 3)</td><td>10:08:30 PM</td><td>2:05:30 PM</td><td>15:57</td><td>13:36</td><td>14.00</td><td>85.54</td><td>72</td><td>85.50</td></tr>
                                          <tr><td>Fri (Day 4)</td><td>11:13:30 PM</td><td>7:08:00 AM</td><td>07:54</td><td>07:00</td><td>14.50</td><td>88.62</td><td>49</td><td>39.00</td></tr>
                                          <tr><td>Sat (Day 5)</td><td>2:47:00 AM</td><td>12:57:00 PM</td><td>10:10</td><td>09:01</td><td>12.50</td><td>89.14</td><td>46</td><td>53.00</td></tr>
                                          <tr><td>Sun (Day 6)</td><td>2:59:30 AM</td><td>8:57:30 AM</td><td>05:58</td><td>05:01</td><td>23.00</td><td>84.22</td><td>32</td><td>33.00</td></tr>
                                        </tr>
                                          </tbody>
                                        </table>

                                        <h3>Sleep Watch Summary Statistics</h3>
                                        <div id="toolbar">
                                          <button id="hide-watch" class="btn btn-sm btn-default">Unselect All Variables</button>
                                          <button id="show-watch" class="btn btn-sm btn-default">Select All Variables</button>
                                        </div>
                                        <table id="table-watch" class="table" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-icons-prefix="fa"  data-show-columns="true">
                                          <colgroup>
                                            <?php if($lessonId==2){?>
                                              <col span="8" class="background-color:clear"></col>
                                              <col class="bg-success"></col>
                                            <?php }elseif($lessonId==3){ ?>
                                              <col span="2" class="bg-success"></col>
                                              <col class="bg-warning"></col>
                                              <col span="3" class="background-color:clear"></col>
                                              <col span="2" class="bg-info"></col>
                                            <?php } ?>
                                          </colgroup>
                                          <thead>
                                        <tr>
                                          <th>Earliest Bed Time</th>
                                          <th>Latest Bed Time_Actigraphy</th>
                                          <th>Average Bed Time_Actigraphy</th>
                                          <th>Earliest Wake Up Time_Actigraphy</th>
                                          <th>Latest Wake Up Time_Actigraphy</th>
                                          <th>Average Wake Up Time_Actigraphy</th>
                                          <th>Shortest Total Sleep Time (hours:Min)_Actigraphy</th>
                                          <th>Longest Total Sleep Time (hours:Min)_Actigraphy</th>
                                          <th>Average Total Sleep Time (hours:Min)_Actigraphy</th>
                                          <th>Average Time in Bed (hours)_Actigraphy</th>
                                          <th>Average Time it Took to Fall Asleep (min)_Actigraphy</th>
                                          <th>Average Sleep Quality (percent)_Actigraphy</th>
                                          <th>Average #Awak._Actigraphy</th>
                                          <th>Average Awak. Time (min)_Actigraphy</th>
                                        </tr>
                                          </thead>
                                          <tbody>
                                        <tr>
                                          <td>10:08:30 PM</td>
                                          <td>02:59:30 AM</td>
                                          <td>01:06:15 AM</td>
                                          <td>07:02:00 AM</td>
                                          <td>02:05:30 PM</td>
                                          <td>09:33:55 AM</td>
                                          <td>04:10</td>
                                          <td>13:36</td>
                                          <td>07:19</td>
                                          <td>08:27</td>
                                          <td>12.67</td>
                                          <td>86.59</td>
                                          <td>42.00</td>
                                          <td>44.25</td>

                                        </tr>
                                          </tbody>
                                        </table>
                                        <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
                                        </div>


                                        <!-- Tab panes -->
                                        <div role="tabpanel" class="tab-pane" id="sleepDiary">
                            					<h3>Sleep Diary Daily Statistics</h3>
                                                                    <div id="toolbar2">
                            					    <button id="hide-diary-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
                            					    <button id="show-diary-daily" class="btn btn-sm btn-default">Select All Variables</button>
                            					</div>
                            					<table id="table-diary-daily" class="table" data-toggle="table" data-toolbar="#toolbar2" data-search="true" data-icons-prefix="fa"  data-show-columns="true">
                                        <colgroup>
                                          <?php if($lessonId==2){?>
                                            <col span="7" class="background-color:clear"></col>
                                            <col class="bg-success"></col>
                                          <?php } ?>
                                        </colgroup>
                                          <thead>
                            						<tr class="success">
                            						    <th data-field="diary-date">Diary Date</th>
                            						    <th data-field="activities-before">Activities Before Sleep_Sleep Diary</th>
                            						    <th data-field="bed-time">Bed Time_Sleep Diary</th>
                            						    <th data-field="wake">Wake-up Time_Sleep Diary</th>
                            						    <th data-field="fall">Time It Took to Fall Asleep(min)_Sleep Diary</th>
                            						    <th data-field="awak"># Awake._Sleep Diary</th>
                            						    <th data-field="awak-time">Awake Time<br>(min)_Sleep Diary</th>
                            						    <th data-field="total">Total Sleep Time<br>(hours:min)_Sleep Diary</th>
                            						    <th data-field="total-bed">Total Time in Bed<br>(hours:min)_Sleep Diary</th>
                            						    <th data-field="sleep-interrupt">Sleep Interrupted By_Sleep Diary</th>
                            						    <th data-field="state-rate">Wake-up State Rating_Sleep Diary</th>
                            						    <th data-field="state-descriptor">Wake-up State Descriptor_Sleep Diary</th>
                            						    <th data-field="quality-rate">Sleep Quality (last night) Rating_Sleep Diary</th>
                            						    <th data-field="quality-descriptor">Sleep Quality (last night) Descriptor_Sleep Diary</th>
                            						</tr>
                            					    </thead>
                            					    <tbody>
                            						    <tr>
                                							<td>Tuesday</td>
                                							<td>Computer, Shower, Play with people</td>
                                							<td>01:08 AM</td>
                                							<td>07:08 AM</td>
                                							<td>60</td>
                                							<td>0</td>
                                							<td>0</td>
                                							<td>5:58</td>
                                							<td>6:58</td>
                                							<td>Nothing</td>
                                							<td>1</td>
                                							<td>Tired</td>
                                							<td>4</td>
                                							<td>Sound</td>
                            						    </tr>
                            						    <tr>
                                							<td>Wednesday</td>
                                							<td>Video game, Texting</td>
                                							<td>01:00 AM</td>
                                							<td>07:20 AM</td>
                                							<td>15</td>
                                							<td>0</td>
                                							<td>0</td>
                                							<td>7:05</td>
                                							<td>7:20</td>
                                							<td>Nothing</td>
                                							<td>2</td>
                                							<td>Somewhat Refreshed</td>
                                							<td>3</td>
                                							<td>Average</td>
                            						    </tr>
                            						    <tr>
                                							<td>Thursday</td>
                                							<td>Phoning</td>
                                							<td>09:30 PM</td>
                                							<td>02:45 PM</td>
                                							<td>90</td>
                                							<td>2</td>
                                							<td>10</td>
                                							<td>14:35</td>
                                							<td>16:15</td>
                                							<td>Pet</td>
                                							<td>3</td>
                                							<td>Refreshed</td>
                                							<td>3</td>
                                							<td>Average</td>
                            						    </tr>
                            						    <tr>
                                							<td>Friday</td>
                                							<td>Music, Phoning</td>
                                							<td>10:45 PM</td>
                                							<td>07:22 AM</td>
                                							<td>20</td>
                                							<td>0</td>
                                							<td>0</td>
                                							<td>8:17</td>
                                							<td>8:37</td>
                                							<td>Nothing</td>
                                							<td>1</td>
                                							<td>Tired</td>
                                							<td>2</td>
                                							<td>Restless</td>
                            						    </tr>
                            						    <tr>
                                							<td>Saturday</td>
                                							<td>Reading, Play with people, Texting</td>
                                							<td>02:30 AM</td>
                                							<td>01:00 PM</td>
                                							<td>60</td>
                                							<td>2</td>
                                							<td>7</td>
                                							<td>9:30</td>
                                							<td>10:30</td>
                                							<td>Unknown</td>
                                							<td>1</td>
                                							<td>Tired</td>
                                							<td>3</td>
                                							<td>Average</td>
                            						    </tr>
                            						    <tr>
                                							<td>Sunday</td>
                                							<td>Video game, Computer, Snack</td>
                                							<td>02:30 AM</td>
                                							<td>09:00 AM</td>
                                							<td>15</td>
                                							<td>0</td>
                                							<td>0</td>
                                							<td>6:15</td>
                                							<td>6:30</td>
                                							<td>Nothing</td>
                                							<td>3</td>
                                							<td>Refreshed</td>
                                							<td>3</td>
                                							<td>Average</td>
                            						    </tr>

                            					    </tbody>
                            					</table>
                                                                    <h3>Sleep Diary Summary Statistics</h3>
                            					<div id="toolbar3" style="margin-top: 1.5em;">
                            					    <button id="hide-diary-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
                            					    <button id="show-diary-summary" class="btn btn-sm btn-default">Select All Variables</button>
                            					</div>
                            					<table id="table-diary-summary" class="table" data-toggle="table" data-toolbar="#toolbar3" data-search="true" data-icons-prefix="fa"  data-show-columns="true">
                                        <colgroup>
                                          <?php if($lessonId==2){?>
                                            <col span="8" class="background-color:clear"></col>
                                            <col class="bg-success"></col>
                                          <?php }elseif($lessonId==3){ ?>
                                            <col span="2" class="bg-success"></col>
                                            <col class="bg-warning"></col>
                                            <col span="3" class="background-color:clear"></col>
                                            <col span="2" class="bg-info"></col>
                                          <?php } ?>
                                        </colgroup>
                                          <thead>
                            						<tr class="success">
                            						    <th data-field="early-bed">Earliest Bed Time_Sleep Diary</th>
                            						    <th data-field="last-bed">Latest Bed Time_Sleep Diary</th>
                            						    <th data-field="ave-bed">Average Bed Time_Sleep Diary</th>
                            						    <th data-field="early-wake">Earliest Wake Up time_Sleep Diary</th>
                            						    <th data-field="last-wake">Latest Wake Up Time_Sleep Diary</th>
                            						    <th data-field="ave-wake">Average Wake Up Time_Sleep Diary</th>
                            						    <th data-field="short-total">Shortest Total Sleep Time<br>(hours:min)_Sleep Diary</th>
                            						    <th data-field="long-total">Longest Total Sleep Time<br>(hours:min)_Sleep Diary</th>
                            						    <th data-field="ave-total">Average Total Sleep Time<br>(hours:min)_Sleep Diary</th>
                            						    <th data-field="ave-inBed">Average Time in Bed<br>(hours:min)_Sleep Diary</th>
                            						    <th data-field="ave-fall">Average Time it Took to Fall Asleep<br>(min)_Sleep Diary</th>
                            						    <th data-field="ave-awak">Average #Awak.</th>
                            						    <th data-field="ave-awakeTime">Average Awake Time(min)_Sleep Diary</th>
                            						    <th data-field="ave-wakeUp">Average Wake Up State Rating_Sleep Diary</th>
                            						    <th data-field="ave-quality">Average Sleep Quality (last night) Rating_Sleep Diary</th>
                            						</tr>
                            					    </thead>
                            					    <tbody>
                            						<tr>

                            							<td>09:30 PM</td>
                            							<td>02:30 AM</td>
                            							<td>12:20 AM</td>
                            							<td>07:08 AM</td>
                            							<td>12:00 PM</td>
                            							<td>08:27 AM</td>
                            							<td>5:45</td>
                            							<td>10:00</td>
                            							<td>8:35</td>
                            							<td>9:25</td>
                            							<td>20</td>
                            							<td>.67</td>
                            							<td>2</td>
                            							<td>1.83</td>
                            							<td>3</td>

                            						</tr>
                            					    </tbody>
                            					</table>
                                                                    <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
                            					<p>Wake Up State Ratings: (1) Tired, (2) Somewhat Refreshed, (3) Refreshed</p>
                            					<p>Sleep Quality (last night) Ratings: (1) Very Restless, (2) Restless, (3) Average, (4) Sound, (5) Very Sound</p>
                            				    </div>

                                      </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    <div class="modal fade dataHuntModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title" id="submit-modal-label">Submit the data hunt?</h4>
			</div>
			<div class="modal-body">
			    Are you ready to submit your work to your teacher?
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			    <button id="submit-activity" type="button" onclick="submit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
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
        <?php include 'partials/footer.php' ?>
        </div>
    </body>


<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
<script type="text/javascript">
     var huntcanvas;
     var datacanvas;
     var color = "red";
     var questionIndex = 0;

    partialImage = new Image();
    questionIcon = new Image();
     questionIcon.src = './assets/img/number/question1icon.png';
//     var offsetTop;
     $(function () {
         $("#submit-activity").click(function() {
	     $( "form" ).submit();
        });
    $('#rootwizard').bootstrapWizard({
        'nextSelector': '.next',
        'previousSelector': '.previous',

        onTabShow: function(tab, navigation, index) {
            var total = navigation.find('li').length;
            var current = index + 1;
            saveImage();
            questionIcon.src = './assets/img/number/question'+current+'icon.png';

            // If it's the last tab then hide the last button and show the finish instead
            if (current >= total) {
                $('#rootwizard').find('.pager .next').hide();
                $('#rootwizard').find('.pager .finish').show();
                $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
                $('#rootwizard').find('.pager .next').show();
                $('#rootwizard').find('.pager .finish').hide();
            }
        },

    });
    $('#rootwizard .finish').click(function(event) {
        event.preventDefault();
        var type = "<?php echo $_SESSION["userType"]?>";
        if(type == "student"){
            $('#submit-modal').modal();
          }

    });



     });

    //data hunt
     var bkimage = document.getElementById('id_actibackground');
     if (bkimage !== null){
         bkimage.style.width ='100%'; //style size is the CSS size
         bkimage.style.height='600px';
     }
     huntcanvas = document.getElementById('id_actigraphy');
     if (huntcanvas !== null){
	 huntcanvas.style.width ='100%'; //style size is the CSS size
	 huntcanvas.style.height='600px';
	 //then set the internal size to match
	 huntcanvas.width  = huntcanvas.offsetWidth; //need to set canvas size
	 huntcanvas.height = huntcanvas.offsetHeight;



     }

     function submit(){
       var img = huntcanvas.toDataURL('image/png');
       $.ajax({
        type: "POST",
        url: "upload-estrellasactogram",
              data: {image: img,type:'hunt'}
      })
      .done(function(respond){console.log("done: "+respond);})
     }




 //    var theChart = document.getElementById('chart-slide-a');
 //     if (theChart !== null){
 //  theChart.style.width ='100%'; //style size is the CSS size
 //  theChart.style.height='600px';
 //  //then set the internal size to match
 //  theChart.width  = theChart.offsetWidth; //need to set canvas size
 //  theChart.height = theChart.offsetHeight;
 // }
     function dgsubmit(){
       var d1 = chartSlideA.get("day1").y;
       var d2 = chartSlideA.get("day2").y;
       var d3 = chartSlideA.get("day3").y;
       var d4 = chartSlideA.get("day4").y;
       var d5 = chartSlideA.get("day5").y;
       var d6 = chartSlideA.get("day6").y;
       var ds = chartSlideA.get("average").y;
       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "estrella-datahunt-done",
            data: {d1:d1, d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,ds:ds,type:'data',contributors:contributors}
           })
     .done(function(respond){console.log("done: "+respond);})
     }
     function diarysubmit(){
       var d1 = chartSlideB.get("day1").y;
       var d2 = chartSlideB.get("day2").y;
       var d3 = chartSlideB.get("day3").y;
       var d4 = chartSlideB.get("day4").y;
       var d5 = chartSlideB.get("day5").y;
       var d6 = chartSlideB.get("day6").y;
       var ds = chartSlideB.get("average").y;
       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "estrella-datahunt-done",
            data: {d1:d1, d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,ds:ds,type:'diary',contributors:contributors}
           })
     .done(function(respond){console.log("done: "+respond);})
     }


     function pad(d) {
         return (d < 10) ? '0' + d.toString() : d.toString();
     }
     var chartXAxis = {
         categories: ["Day1", "Day2", "Day3", "Day4","Day5","Day6","Average"]
     };
     var chartYAxis = {
         title: {
             text: 'Hours of Sleep',
         },
         min: 0,
         max: 820,
         tickPositions: [0, 120, 240, 360, 480, 600, 720, 840, 960],
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
     var s1o = <?php if($s1y > 0 ){ echo $s1y; } else { echo 10; }?>;
     var s2o = <?php if($s2y > 0 ){ echo $s2y; } else { echo 10; }?>;
     var s3o = <?php if($s3y > 0 ){ echo $s3y; } else { echo 10; }?>;
     var s4o = <?php if($s4y > 0 ){ echo $s4y; } else { echo 10; }?>;
     var s5o = <?php if($s5y > 0 ){ echo $s5y; } else { echo 10; }?>;
     var s6o = <?php if($s6y > 0 ){ echo $s6y; } else { echo 10; }?>;
     var sso = <?php if($ssy > 0 ){ echo $ssy; } else { echo 10; }?>;
    var chartSlideA = new Highcharts.Chart({
    chart: {
        renderTo: 'chart-slide-a',
        height: 600,
        animation: false,
    },

    title: {
        text: 'Sleep Watch Total Sleep Time'
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
        },
        {
          name: 'Average',
          id: 'average',
          y: dso
        }
        ],
        draggableY: true,
        dragMinY: 10,
        dragMaxY: 870,
        dragPrecisionY: 30,
        type: 'column',
        dragHandleFill: '#BC0016',
        color: '#DAF7A6',
    }]

  });
  var chartSlideB = new Highcharts.Chart({
  chart: {
      renderTo: 'chart-slide-b',
      height: 600,
      animation: false,
  },
  title: {
      text: 'Sleep Diary Total Sleep Time'
  },
  xAxis: chartXAxis,
  yAxis: chartYAxis,
  plotOptions: chartPlotOptions,
  tooltip: chartTooltip,

  series: [{
      name: " ",
      data: [
        {
        name: 'Day 1',
        id: 'day1',
        y: s1o
      },{
        name: 'Day 2',
        id: 'day2',
        y: s2o
      },{
        name: '111Day 3',
        id: 'day3',
        y: s3o
      },{
        name: 'Day 4',
        id: 'day4',
        y: s4o
      },{
        name: 'Day 5',
        id: 'day5',
        y: s5o
      },{
        name: 'Day 6',
        id: 'day6',
        y: s6o
      },
      {
        name: 'Average',
        id: 'average',
        y: sso
      }
      ],
      draggableY: true,
      dragMinY: 10,
      dragMaxY: 870,
      dragPrecisionY: 30,
      type: 'column',
      dragHandleFill: '#BC0016',
      color: '#DAF7A6',
  }]

});
var chartSlideC = new Highcharts.Chart({
chart: {
    renderTo: 'chart-slide-c',
    height: 600,
    animation: false,
},
title: {
    text: 'Sleep Watch Total Sleep Time'
},
xAxis: chartXAxis,
yAxis: chartYAxis,
plotOptions: chartPlotOptions,
tooltip: chartTooltip,

series: [{
    name: " ",
    data: [
      {
      name: 'Day 1',
      id: 'day1',
      y: 240
    },{
      name: 'Day 2',
      id: 'day2',
      y: 300
    },{
      name: '111Day 3',
      id: 'day3',
      y: 810
    },{
      name: 'Day 4',
      id: 'day4',
      y: 420
    },{
      name: 'Day 5',
      id: 'day5',
      y: 540
    },{
      name: 'Day 6',
      id: 'day6',
      y: 300
    },
    {
      name: 'Average',
      id: 'average',
      y: 420
    }
    ],
    draggableY: false,
    dragMinY: 10,
    dragMaxY: 840,
    dragPrecisionY: 30,
    type: 'column',
    dragHandleFill: '#BC0016',
    color: '#DAF7A6',
}]

});

var chartSlideD = new Highcharts.Chart({
chart: {
  renderTo: 'chart-slide-d',
  height: 600,
  animation: false,
},
title: {
  text: 'Sleep Diary Total Sleep Time'
},
xAxis: chartXAxis,
yAxis: chartYAxis,
plotOptions: chartPlotOptions,
tooltip: chartTooltip,

series: [{
  name: " ",
  data: [
    {
    name: 'Day 1',
    id: 'day1',
    y: 360
  },{
    name: 'Day 2',
    id: 'day2',
    y: 420
  },{
    name: '111Day 3',
    id: 'day3',
    y: 870
  },{
    name: 'Day 4',
    id: 'day4',
    y: 480
  },{
    name: 'Day 5',
    id: 'day5',
    y: 590
  },{
    name: 'Day 6',
    id: 'day6',
    y: 360
  },
  {
    name: 'Average',
    id: 'average',
    y: 510
  }
  ],
  draggableY: false,
  dragMinY: 10,
  dragMaxY: 870,
  dragPrecisionY: 30,
  type: 'column',
  dragHandleFill: '#BC0016',
  color: '#DAF7A6',
}]

});
    </script>
</html>
