<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#


require 'utilities.php';
checkAuth();
/* ***Flexible Framework Request Start*** */
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if ($userId == ""){
    header("Location: login");
    exit;
}
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
/* ***Flexible Framework Request end*** */

if ($config) {
  $case = 1;
}else {
  $case = $_GET['case'];
}


?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Sleep Detective</title>
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
                      } else { ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page';">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
				                        <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=2';">Lessons Two</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=2&activity=3';">Activity Three</a></li>
                                <li class="active">
                                <?php
                        		       if($case == 1){
                        		        echo "Case 1";
                        		       }elseif($case == 2){
                                    echo "Case 2";
                        		       }elseif($case ==3) {
                        		        echo "Case 3";
                        		       }
                        		     ?>
				                        </li>
                            </ol>
                        </div>
                    </div>
                  <?php } ?>
                  <!-- Nav tabs -->
        <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none;">
          <li role="presentation" class="active"><a href="#coverpage" aria-controls="datagraphs" role="tab" data-toggle="tab" id = "firstTab">1</a></li>
          <li role="presentation" ><a href="#case1" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">2</a></li>
          <li role="presentation" ><a href="#case2" aria-controls="instruction" role="tab" data-toggle="tab" id = "thirdTab">3</a></li>
          <li role="presentation" ><a href="#case3" aria-controls="instruction" role="tab" data-toggle="tab" id = "forthTab">4</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content" style="">
          <!-- Tab pane 1 -->
          <div role="tabpanel" class="tab-pane active" id="coverpage">
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="selection selection-gradorange" onclick="selectPage(1)" style="cursor: pointer;text-align: center;">
                    <label class="selectionFont">Case 1</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3"  style="margin-top: 25px;">
                  <div class="selection selection-gradbb" onclick="selectPage(2)" style="cursor: pointer;text-align: center;">
                      <label class="selectionFont">Case 2</label>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3"  style="margin-top: 25px;">
                  <div class="selection selection-gradop" onclick="selectPage(3)" style="cursor: pointer;text-align: center;">
                      <label class="selectionFont">Case 3</label>
                  </div>
              </div>
            </div>
          </div>


          <!-- Tab pane 2 -->
        <div role="tabpanel" class="tab-pane" id="case1">

          <div class="row">
              <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                  <div>
                      <!-- Nav tabs -->
                      <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">

                          <li role="presentation" class="active"><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Actogram</a></li>
                          <li role="presentation"><a href="#watchData" aria-controls="watchData" role="tab" data-toggle="tab">Watch Data</a></li>
                          <li role="presentation"><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
                          <li role="presentation"><a href="#activityDiary" aria-controls="activityDiary" role="tab" data-toggle="tab">Activity Diary</a></li>
                          <!--<li role="presentation"><a href="#worksheet" aria-controls="worksheet" role="tab" data-toggle="tab">Worksheet</a></li>-->
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content" style="margin-top: 2em;">
                          <div role="tabpanel" class="tab-pane active" id="actigraphy">
                            <h3 class="text-center">Actogram</h3>
          <div class="row">
          <div class="col-xs-11 col-md-11">
                                <img class="img-responsive" src="<?php if($case==1){ echo "images/fifthgrade-lessontwo/acti-case-one.png";} elseif($case==2){echo "images/fifthgrade-lessontwo/acti-case-two.png";} elseif($case==3){echo "images/fifthgrade-lessontwo/acti-case-three.png";} ?>">
          </div>
          <div class="col-xs-1 col-md-1">
          <button id="black" type="button" class="btn btn-sm" style="background-color: black"></button><label for="black">Activity</label>
          <button id="blue" type="button" class="btn btn-sm" style="background-color: blue"></button><label for="black">Blue Light</label>
          <button id="yellow" type="button" class="btn btn-sm" style="background-color: yellow"></button><label for="black">Yellow Light</label>
          </div>
          </div>
                          </div>
          <div role="tabpanel" class="tab-pane" id="watchData">
          <h3>Watch Daily Statistics</h3>
          <div id="toolbarWatchData">
          <button id="hide-watchWatchData" class="btn btn-sm btn-default">Unselect All Variables</button>
          <button id="show-watchWatchData" class="btn btn-sm btn-default">Select All Variables</button>
          </div>
          <table id="table-watchWatchData" class="table" data-toggle="table" data-toolbar="#toolbarWatchData"  data-icons-prefix="fa"  data-show-columns="true">
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
          <?php if($case==1){ ?>
          <tr><td>Tue 2/3/2015</td><td>11:39:00 PM</td><td>6:56:00 AM</td><td>07:17</td><td>06:07</td><td>27.50</td><td>83.98</td><td>42</td><td>32.50</td></tr>
          <tr><td>Wed 2/4/2015</td><td>1:43:30 AM</td><td>9:25:30 AM</td><td>07:42</td><td>06:40</td><td>16.50</td><td>86.69</td><td>60</td><td>42.50</td></tr>
          <tr><td>Thu 2/5/2015</td><td>12:33:00 AM</td><td>10:03:30 AM</td><td>09:30</td><td>07:54</td><td>19.00</td><td>83.09</td><td>47</td><td>34.50</td></tr>
          <tr><td>Fri 2/6/2015</td><td>1:17:00 AM</td><td>7:57:00 AM</td><td>06:40</td><td>05:42</td><td>18.50</td><td>85.63</td><td>48</td><td>31.00</td></tr>
          <tr><td>Sat 2/7/2015</td><td>5:17:30 AM</td><td>12:22:30 PM</td><td>07:05</td><td>06:33</td><td>13.50</td><td>92.47</td><td>20</td><td>12.00</td></tr>
          <tr><td>Sun 2/8/2015</td><td>10:02:30 PM</td><td>8:26:30 AM</td><td>10:24</td><td>06:37</td><td>196.00</td><td>63.62</td><td>33</td><td>30.00</td></tr>
                                      <?php } elseif($case==2){ ?>
          <tr><td>Tue 1/21/2014</td><td>1:05:00 AM</td><td>7:02:30 AM</td><td>05:57</td><td>05:31</td><td>2.00</td><td>92.73</td><td>12</td><td>16.50</td></tr>
          <tr><td>Wed 1/22/2014</td><td>1:44:00 AM</td><td>6:58:30 AM</td><td>05:14</td><td>04:58</td><td>15.50</td><td>94.91</td><td>0</td><td>0.00</td></tr>
          <tr><td>Thu 1/23/2014</td><td>1:09:00 AM</td><td>7:05:30 AM</td><td>05:56</td><td>05:06</td><td>13.00</td><td>85.97</td><td>11</td><td>15.50</td></tr>
          <tr><td>Fri 1/24/2014</td><td>2:48:30 AM</td><td>6:58:30 AM</td><td>04:10</td><td>03:56</td><td>0.00</td><td>94.60</td><td>8</td><td>12.50</td></tr>
          <tr><td>Sat 1/25/2014</td><td>10:37:30 PM</td><td>8:40:00 AM</td><td>10:02</td><td>09:28</td><td>7.00</td><td>94.36</td><td>25</td><td>26.00</td></tr>
          <tr><td>Sun 1/26/2014</td><td>12:17:00 AM</td><td>10:29:00 AM</td><td>10:12</td><td>09:26</td><td>6.00</td><td>92.48</td><td>35</td><td>39.50</td></tr>
                                      <?php } elseif($case==3){ ?>
          <tr><td>Tue 3/24/2015</td><td>9:37:00 PM</td><td>7:04:30 AM</td><td>09:27</td><td>08:41</td><td>4.50</td><td>91.81</td><td>38</td><td>28.00</td></tr>
          <tr><td>Wed 3/25/2015</td><td>8:45:30 PM</td><td>7:00:30 AM</td><td>10:15</td><td>09:38</td><td>0.00</td><td>93.98</td><td>43</td><td>35.50</td></tr>
          <tr><td>Thu 3/26/2015</td><td>8:54:00 PM</td><td>7:14:00 AM</td><td>10:20</td><td>09:48</td><td>0.00</td><td>94.92</td><td>28</td><td>19.00</td></tr>
          <tr><td>Fri 3/27/2015</td><td>8:58:30 PM</td><td>7:27:30 AM</td><td>10:29</td><td>09:52</td><td>0.00</td><td>94.20</td><td>36</td><td>30.50</td></tr>
          <tr><td>Sat 3/28/2015</td><td>9:16:00 PM</td><td>7:31:00 AM</td><td>10:15</td><td>09:51</td><td>1.00</td><td>96.10</td><td>33</td><td>19.50</td></tr>
          <?php } ?>
          </tr>
          </tbody>
          </table>

          <h3>Watch Summary Statistics</h3>
          <div id="toolbar">
          <button id="hide-watch" class="btn btn-sm btn-default">Unselect All Variables</button>
          <button id="show-watch" class="btn btn-sm btn-default">Select All Variables</button>
          </div>
          <table id="table-watch" class="table" data-toggle="table" data-toolbar="#toolbar"  data-icons-prefix="fa"  data-show-columns="true">
          <thead>
          <tr>
          <th data-field="early-bed-a">Earliest Bedtime_Sleep_Watch</th>
          <th data-field="last-bed-a">Latest Bedtime_Sleep_Watch</th>
          <th data-field="ave-bed-a">Average Bedtime_Sleep_Watch</th>
          <th data-field="early-wake-a">Earliest Get Up Time_Sleep_Watch</th>
          <th data-field="last-wake-a">Latest Get Up Time_Sleep_Watch</th>
          <th data-field="ave-wake-a">Average Get Up Time_Sleep_Watch</th>
          <th data-field="short-total-a">Shortest Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
          <th data-field="long-total-a">Longest Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
          <th data-field="ave-total-a">Average Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
          <th data-field="ave-num-awak-a">Average <br>#Awak._Sleep_Watch</th>
          <th data-field="ave-awak-time-a">Average <br>Awake Time_Sleep_Watch</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <?php if($case==1){ ?>
          <td>10:02:30 PM</td>
          <td>5:17:30 AM</td>
          <td>1:05:25 AM</td>
          <td>6:56:00 AM</td>
          <td>12:22:30 PM</td>
          <td>9:11:50 AM</td>
          <td>5:42:30</td>
          <td>7:54:00</td>
          <td>6:35:40</td>
          <td>41.67</td>
          <td>30.42</td>
                                      <?php } elseif($case==2){ ?>
          <td>10:37:30 PM</td>
          <td>2:48:30 AM</td>
          <td>12:56:50 AM</td>
          <td>6:58:30 AM</td>
          <td>10:29:00 AM</td>
          <td>7:52:20 AM</td>
          <td>3:56:30</td>
          <td>9:28:30</td>
          <td>6:24:30</td>
          <td>15.17</td>
          <td>18.33</td>
                                      <?php } elseif($case==3){ ?>
          <td>8:45:30 PM</td>
          <td>9:37:00 PM</td>
          <td>9:06:12 PM</td>
          <td>7:00:30 AM</td>
          <td>7:31:00 AM</td>
          <td>7:15:30 AM</td>
          <td>8:41:00</td>
          <td>9:52:30</td>
          <td>9:37:17</td>
          <td>35.60</td>
          <td>26.50</td>
          <?php } ?>
          </tr>
          </tbody>
          </table>
          <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
          </div>
          <div role="tabpanel" class="tab-pane" id="sleepDiary">
          <h3>Sleep Diary Daily Statistics</h3>
                              <div id="toolbar2">
          <button id="hide-diary-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
          <button id="show-diary-daily" class="btn btn-sm btn-default">Select All Variables</button>
          </div>
          <table id="table-diary-daily" class="table" data-toggle="table" data-toolbar="#toolbar2"  data-icons-prefix="fa"  data-show-columns="true">
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
          <?php if($case==1){ ?>
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
          </tr>
                                      <?php } elseif($case==2){ ?>
          <tr>
          <td>Monday, March 8,2016</td>
          <td>Computer, Reading</td>
          <td>12:50AM</td>
          <td>07:05AM</td>
          <td>15</td>
          <td>0</td>
          <td>0</td>
          <td>6:00</td>
          <td>6:15</td>
          <td>Nothing</td>
          <td>2</td>
          <td>Somewhat Refreshed</td>
          <td>3</td>
          <td>Average</td>
          </tr>
          <tr>
          <td>Tuesday, March 9, 2016</td>
          <td>Exercised</td>
          <td>01:30 AM</td>
          <td>07:10 AM</td>
          <td>20</td>
          <td>0</td>
          <td>0</td>
          <td>5:20</td>
          <td>5:50</td>
          <td>Nothing</td>
          <td>1</td>
          <td>Tired</td>
          <td>3</td>
          <td>Average</td>
          </tr>
          <tr>
          <td>Wednesday, March 10, 2016</td>
          <td>Music, Exercised</td>
          <td>01:05 AM</td>
          <td>07:15 AM</td>
          <td>15</td>
          <td>1</td>
          <td>3</td>
          <td>5:52</td>
          <td>6:10</td>
          <td>Bathroom Need</td>
          <td>1</td>
          <td>Tired</td>
          <td>2</td>
          <td>Restless</td>
          </tr>
          <tr>
          <td>Thursday, March 11, 2016</td>
          <td>Computer, Phoning</td>
          <td>02:40 AM</td>
          <td>08:30 AM</td>
          <td>5</td>
          <td>0</td>
          <td>0</td>
          <td>5:45</td>
          <td>5:50</td>
          <td>Nothing</td>
          <td>1</td>
          <td>Tired</td>
          <td>5</td>
          <td>Very Sound</td>
          </tr>
          <tr>
          <td>Friday, March 12, 2016</td>
          <td>Computer, Texting</td>
          <td>10:25 PM</td>
          <td>08:55 AM</td>
          <td>15</td>
          <td>1</td>
          <td>3</td>
          <td>10:12</td>
          <td>10:30</td>
          <td>Unknown</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
          <tr>
          <td>Saturday, March 13, 2016</td>
          <td>Play with People, Texting</td>
          <td>12:20 AM</td>
          <td>10:30 AM</td>
          <td>10</td>
          <td>2</td>
          <td>11</td>
          <td>09:49</td>
          <td>10:10</td>
          <td>Noise, Family</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
                                      <?php } elseif($case==3){ ?>
          <tr>
          <td>Monday, March 8, 2016</td>
          <td>Music</td>
          <td>09:50 PM</td>
          <td>07:00 AM</td>
          <td>20</td>
          <td>1</td>
          <td>5</td>
          <td>8:50</td>
          <td>9:15</td>
          <td>Family</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>3</td>
          <td>Average</td>
          </tr>
          <tr>
          <td>Tuesday, March 9, 2016</td>
          <td>Reading</td>
          <td>09:05 PM</td>
          <td>07:25 AM</td>
          <td>50</td>
          <td>0</td>
          <td>0</td>
          <td>9:30</td>
          <td>10:20</td>
          <td>Nothing</td>
          <td>2</td>
          <td>Somewhat Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
          <tr>
          <td>Wednesday, March 10, 2016</td>
          <td>Video Game</td>
          <td>08:30 PM</td>
          <td>06:55 AM</td>
          <td>20</td>
          <td>0</td>
          <td>0</td>
          <td>10:05</td>
          <td>10:25</td>
          <td>Nothing</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
          <tr>
          <td>Thursday, March 11, 2016</td>
          <td>Homework, Shower</td>
          <td>08:30 PM</td>
          <td>06:45 AM</td>
          <td>30</td>
          <td>1</td>
          <td>3</td>
          <td>09:42</td>
          <td>10:15</td>
          <td>Bodyily Pain</td>
          <td>2</td>
          <td>Somewhat Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
          <tr>
          <td>Friday, March 12, 2016</td>
          <td>TV, Video Game</td>
          <td>10:00 PM</td>
          <td>08:30 AM</td>
          <td>0</td>
          <td>1</td>
          <td>3</td>
          <td>10:27</td>
          <td>10:30</td>
          <td>Pet</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
          <tr>
          <td>Saturday, March 13, 2016</td>
          <td>Computer</td>
          <td>09:10 PM</td>
          <td>07:20 AM</td>
          <td>20</td>
          <td>0</td>
          <td>0</td>
          <td>09:50</td>
          <td>10:10</td>
          <td>Nothing</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
          </tr>
          <?php } ?>
          </tbody>
          </table>
                              <h3>Sleep Diary Summary Statistics</h3>
          <div id="toolbar3" style="margin-top: 1.5em;">
          <button id="hide-diary-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
          <button id="show-diary-summary" class="btn btn-sm btn-default">Select All Variables</button>
          </div>
          <table id="table-diary-summary" class="table" data-toggle="table" data-toolbar="#toolbar3"  data-icons-prefix="fa"  data-show-columns="true">
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
          <th data-field="ave-wakeUp">Averate Wake Up State Rating_Sleep Diary</th>
          <th data-field="ave-quality">Average Sleep Quality (last night) Rating_Sleep Diary</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <?php if($case==1){ ?>
          <td>10:00 PM</td>
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
          <td>3</td>
                                      <?php } elseif($case==2){ ?>
          <td>10:25 PM</td>
          <td>02:40 AM</td>
          <td>12:48 AM</td>
          <td>07:05 AM</td>
          <td>10:30 AM</td>
          <td>8:14 AM</td>
          <td>5:20</td>
          <td>10:12</td>
          <td>7:10</td>
          <td>7:27</td>
          <td>13</td>
          <td>.67</td>
          <td>2.83</td>
          <td>1.83</td>
          <td>3.5</td>
                                      <?php } elseif($case==3){ ?>
          <td>8:30 PM</td>
          <td>10:00 PM</td>
          <td>9:11 PM</td>
          <td>06:45 AM</td>
          <td>08:30 AM</td>
          <td>07:19 AM</td>
          <td>8:50</td>
          <td>10:27</td>
          <td>9:44</td>
          <td>10:09</td>
          <td>23</td>
          <td>0.5</td>
          <td>1.83</td>
          <td>2.67</td>
          <td>3.83</td>
          <?php } ?>
          </tr>
          </tbody>
          </table>
                              <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
          <p>Wake Up State Ratings: (1) Tired, (2) Somewhat Refreshed, (3) Refreshed</p>
          <p>Sleep Quality (last night) Ratings: (1) Very Restless, (2) Restless, (3) Average, (4) Sound, (5) Very Sound</p>
          </div>
          <div role="tabpanel" class="tab-pane" id="activityDiary">
          <h3>Activity Diary Daily Statistics</h3>
                              <div id="toolbar4" style="margin-top: 1.5em;">
          <button id="hide-activity-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
          <button id="show-activity-daily" class="btn btn-sm btn-default">Select All Variables</button>
          </div>
          <table id="table-activity-daily" class="table" data-toggle="table" data-toolbar="#toolbar4"  data-icons-prefix="fa"  data-show-columns="true">
                                  <thead>
          <tr class="info">
                                          <th data-field="diary-date">Diary Date</th>
                                          <th data-field="nap-start">Nap Start Time_Activity Diary</th>
                                          <th data-field="nap-end">Nap End Time_Activity Diary</th>
                                          <th data-field="data-duration">Nap Duration<br>(hrs.)_Activity Diary</th>
                                          <th data-field="exercised">Time Exercised<br>(min)_Activity Diary</th>
                                          <th data-field="caffeinated"># of Caffeinated Drinks_Activity Diary</th>
                                          <th data-field="mood-rating">Mood Rating_Activity Diary</th>
                                          <th data-field="mood-descriptor">Mood Descriptor_Activity Diary</th>
                                          <th data-field="sleepiness-rating">Sleepiness Rating_Activity Diary</th>
                                          <th data-field="sleepiness-descriptor">Sleepiness Descriptor_Activity Diary</th>
                                          <th data-field="attentiveness-rating">Attentiveness Rating_Activity Diary</th>
                                          <th data-field="attentiveness-descriptor">Attentiveness Descriptor_Activity Diary</th>
          </tr>
                                  </thead>
                                  <tbody>
          <?php if($case==1){ ?>
          <tr>
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
          </tr>
                                      <?php } elseif($case==2){ ?>
          <tr>
          <td>Monday, March 8, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>45</td>
          <td>0</td>
          <td>3</td>
          <td>Sometimes Pleasant</td>
          <td>3</td>
          <td>Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
          </tr>
          <tr>
          <td>Tuesday, March 9, 2016</td>
          <td>9:50 PM</td>
          <td>12:05 AM</td>
          <td>2:15</td>
          <td>30</td>
          <td>2</td>
          <td>2</td>
          <td>Unpleasant</td>
          <td>2</td>
          <td>Somewhat Sleepy</td>
          <td>1</td>
          <td>Couldn’t focus</td>
          </tr>
          <tr>
          <td>Wednesday, March 10, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>30</td>
          <td>2</td>
          <td>2</td>
          <td>Unpleasant</td>
          <td>2</td>
          <td>Somewhat Sleepy</td>
          <td>1</td>
          <td>Couldn’t focus</td>
          </tr>
          <tr>
          <td>Thursday, March 11, 2016</td>
          <td>12:15 AM</td>
          <td>01:45 AM</td>
          <td>1:30</td>
          <td>45</td>
          <td>3</td>
          <td>2</td>
          <td>Unpleasant</td>
          <td>2</td>
          <td>Somewhat Sleepy</td>
          <td>1</td>
          <td>Couldn’t focus</td>
          </tr>
          <tr>
          <td>Friday, March 12, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>40</td>
          <td>2</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>3</td>
          <td>Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
          </tr>
          <tr>
          <td>Saturday, March 13, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>25</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>2</td>
          <td>Somewhat sleepy</td>
          <td>3</td>
          <td>Focus about half of the time</td>
          </tr>
                                      <?php } elseif($case==3){ ?>
          <tr>
          <td>Monday, March 8, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>45</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
          </tr>
          <tr>
          <td>Tuesday, March 9, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>70</td>
          <td>1</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>2</td>
          <td>Somewhat Sleepy</td>
          <td>5</td>
          <td>Focus all day</td>
          </tr>
          <tr>
          <td>Wednesday, March 10, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>60</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
          </tr>
          <tr>
          <td>Thursday, March 11, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>50</td>
          <td>1</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
          </tr>
          <tr>
          <td>Friday, March 12, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>30</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>5</td>
          <td>Focus all day</td>
          </tr>
          <tr>
          <td>Saturday, March 13, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>20</td>
          <td>0</td>
          <td>5</td>
          <td>Very Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
          </tr>
          <?php } ?>
                                  </tbody>
          </table>
                              <h3>Activity Diary Summary Statistics</h3>
                              <div id="toolbar5" style="margin-top: 1.5em;">
          <button id="hide-activity-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
          <button id="show-activity-summary" class="btn btn-sm btn-default">Select All Variables</button>
          </div>
          <table id="table-activity-summary" class="table" data-toggle="table" data-toolbar="#toolbar5"  data-icons-prefix="fa"  data-show-columns="true">
                                  <thead>
          <tr class="info">
                                          <th data-field="nap">Number of Days Napped_Activity Diary</th>
                                          <th data-field="ave-nape">Average Number of Caffeinated Drinks_Activity Diary</th>
                                          <th data-field="ave-exerc">Averate Number of Minutes Exercised_Activity Diary</th>
                                          <th data-field="ave-mood">Average Mood Rating_Activity Diary</th>
                                          <th data-field="ave-moodDesc">Mood Descriptor Most Often Selected_Activity Diary</th>
                                          <th data-field="ave-sleepness">Average Sleepiness Rating_Activity Diary</th>
                                          <th data-field="sleepness">Sleepiness Descriptor Most Often Selected_Activity Diary</th>
                                          <th data-field="ave-attention">Average Attention Rating_Activity Diary</th>
                                          <th data-field="attention">Attention Descriptor Most Often Selected_Activity Diary</th>
          </tr>
                                  </thead>
                                  <tbody>
          <tr>
          <?php if($case==1){ ?>
          <td>0</td>
          <td>1.17</td>
          <td>29</td>
          <td>3</td>
          <td>Sometimes Pleasant, Very Unpleasant</td>
          <td>2.83</td>
          <td>Somewhat Sleepy</td>
          <td>2.33</td>
          <td>Little</td>
                                          <?php } elseif($case==2){ ?>
          <td>2</td>
          <td>1.5</td>
          <td>35</td>
          <td>2.83</td>
          <td>Unpleasant</td>
          <td>2.33</td>
          <td>Somewhat Sleepy</td>
          <td>2.33</td>
          <td>Little</td>
                                          <?php } elseif($case==3){ ?>
          <td>0</td>
          <td>.33</td>
          <td>45.83</td>
          <td>4.17</td>
          <td>Pleasant</td>
          <td>1.17</td>
          <td>Not Sleepy</td>
          <td>4.33</td>
          <td>Mostly</td>
          <?php } ?>
          </tr>
                                  </tbody>
          </table>
          <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
          <p>Mood Ratings: (1) Very Unpleasant, (2) Unpleasant, (3) Sometimes Pleasant, (4) Pleasant, (5) Very Pleasant</p>
          <p>Sleepiness Ratings: (1) Not Sleepy, (2) Somewhat Sleepy, (3) Sleepy, (4) Very Sleepy</p>
          <p>Attentiveness Ratings: (1)couldn’t focus, (2)focus occasionally, (3)focus about half of the time, (4)focus most of the day, (5)focus all day</p>
          </div>
                      </div>
          </div>
              </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectPage(0)" style="cursor: pointer;text-align: center;">
                  <label class="info-title" style="color: #fafafa">Back</label>
              </div>
            </div>
          </div>
        </div>


        <!-- Tab pane 3 -->
      <div role="tabpanel" class="tab-pane" id="case2">

        <div class="row">
            <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">

                        <li role="presentation" class="active"><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Actogram</a></li>
                        <li role="presentation"><a href="#watchData" aria-controls="watchData" role="tab" data-toggle="tab">Watch Data</a></li>
                        <li role="presentation"><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
                        <li role="presentation"><a href="#activityDiary" aria-controls="activityDiary" role="tab" data-toggle="tab">Activity Diary</a></li>
                        <!--<li role="presentation"><a href="#worksheet" aria-controls="worksheet" role="tab" data-toggle="tab">Worksheet</a></li>-->
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" style="margin-top: 2em;">
                        <div role="tabpanel" class="tab-pane active" id="actigraphy">
                          <h3 class="text-center">Actogram</h3>
        <div class="row">
        <div class="col-xs-11 col-md-11">
                              <img class="img-responsive" src="images/fifthgrade-lessontwo/acti-case-two.png">
        </div>
        <div class="col-xs-1 col-md-1">
        <button id="black" type="button" class="btn btn-sm" style="background-color: black"></button><label for="black">Activity</label>
        <button id="blue" type="button" class="btn btn-sm" style="background-color: blue"></button><label for="black">Blue Light</label>
        <button id="yellow" type="button" class="btn btn-sm" style="background-color: yellow"></button><label for="black">Yellow Light</label>
        </div>
        </div>
                        </div>
        <div role="tabpanel" class="tab-pane" id="watchData">
        <h3>Watch Daily Statistics</h3>
        <div id="toolbarWatchData">
        <button id="hide-watchWatchData" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-watchWatchData" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-watchWatchData" class="table" data-toggle="table" data-toolbar="#toolbarWatchData"  data-icons-prefix="fa"  data-show-columns="true">
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
        <tr><td>Tue 1/21/2014</td><td>1:05:00 AM</td><td>7:02:30 AM</td><td>05:57</td><td>05:31</td><td>2.00</td><td>92.73</td><td>12</td><td>16.50</td></tr>
        <tr><td>Wed 1/22/2014</td><td>1:44:00 AM</td><td>6:58:30 AM</td><td>05:14</td><td>04:58</td><td>15.50</td><td>94.91</td><td>0</td><td>0.00</td></tr>
        <tr><td>Thu 1/23/2014</td><td>1:09:00 AM</td><td>7:05:30 AM</td><td>05:56</td><td>05:06</td><td>13.00</td><td>85.97</td><td>11</td><td>15.50</td></tr>
        <tr><td>Fri 1/24/2014</td><td>2:48:30 AM</td><td>6:58:30 AM</td><td>04:10</td><td>03:56</td><td>0.00</td><td>94.60</td><td>8</td><td>12.50</td></tr>
        <tr><td>Sat 1/25/2014</td><td>10:37:30 PM</td><td>8:40:00 AM</td><td>10:02</td><td>09:28</td><td>7.00</td><td>94.36</td><td>25</td><td>26.00</td></tr>
        <tr><td>Sun 1/26/2014</td><td>12:17:00 AM</td><td>10:29:00 AM</td><td>10:12</td><td>09:26</td><td>6.00</td><td>92.48</td><td>35</td><td>39.50</td></tr>

        </tr>
        </tbody>
        </table>

        <h3>Watch Summary Statistics</h3>
        <div id="toolbar">
        <button id="hide-watch" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-watch" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-watch" class="table" data-toggle="table" data-toolbar="#toolbar"  data-icons-prefix="fa"  data-show-columns="true">
        <thead>
        <tr>
        <th data-field="early-bed-a">Earliest Bedtime_Sleep_Watch</th>
        <th data-field="last-bed-a">Latest Bedtime_Sleep_Watch</th>
        <th data-field="ave-bed-a">Average Bedtime_Sleep_Watch</th>
        <th data-field="early-wake-a">Earliest Get Up Time_Sleep_Watch</th>
        <th data-field="last-wake-a">Latest Get Up Time_Sleep_Watch</th>
        <th data-field="ave-wake-a">Average Get Up Time_Sleep_Watch</th>
        <th data-field="short-total-a">Shortest Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
        <th data-field="long-total-a">Longest Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
        <th data-field="ave-total-a">Average Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
        <th data-field="ave-num-awak-a">Average <br>#Awak._Sleep_Watch</th>
        <th data-field="ave-awak-time-a">Average <br>Awake Time_Sleep_Watch</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td>10:37:30 PM</td>
        <td>2:48:30 AM</td>
        <td>12:56:50 AM</td>
        <td>6:58:30 AM</td>
        <td>10:29:00 AM</td>
        <td>7:52:20 AM</td>
        <td>3:56:30</td>
        <td>9:28:30</td>
        <td>6:24:30</td>
        <td>15.17</td>
        <td>18.33</td>
        </tr>
        </tbody>
        </table>
        <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="sleepDiary">
        <h3>Sleep Diary Daily Statistics</h3>
                            <div id="toolbar2">
        <button id="hide-diary-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-diary-daily" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-diary-daily" class="table" data-toggle="table" data-toolbar="#toolbar2"  data-icons-prefix="fa"  data-show-columns="true">
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
        <td>Monday, March 8,2016</td>
        <td>Computer, Reading</td>
        <td>12:50AM</td>
        <td>07:05AM</td>
        <td>15</td>
        <td>0</td>
        <td>0</td>
        <td>6:00</td>
        <td>6:15</td>
        <td>Nothing</td>
        <td>2</td>
        <td>Somewhat Refreshed</td>
        <td>3</td>
        <td>Average</td>
        </tr>
        <tr>
        <td>Tuesday, March 9, 2016</td>
        <td>Exercised</td>
        <td>01:30 AM</td>
        <td>07:10 AM</td>
        <td>20</td>
        <td>0</td>
        <td>0</td>
        <td>5:20</td>
        <td>5:50</td>
        <td>Nothing</td>
        <td>1</td>
        <td>Tired</td>
        <td>3</td>
        <td>Average</td>
        </tr>
        <tr>
        <td>Wednesday, March 10, 2016</td>
        <td>Music, Exercised</td>
        <td>01:05 AM</td>
        <td>07:15 AM</td>
        <td>15</td>
        <td>1</td>
        <td>3</td>
        <td>5:52</td>
        <td>6:10</td>
        <td>Bathroom Need</td>
        <td>1</td>
        <td>Tired</td>
        <td>2</td>
        <td>Restless</td>
        </tr>
        <tr>
        <td>Thursday, March 11, 2016</td>
        <td>Computer, Phoning</td>
        <td>02:40 AM</td>
        <td>08:30 AM</td>
        <td>5</td>
        <td>0</td>
        <td>0</td>
        <td>5:45</td>
        <td>5:50</td>
        <td>Nothing</td>
        <td>1</td>
        <td>Tired</td>
        <td>5</td>
        <td>Very Sound</td>
        </tr>
        <tr>
        <td>Friday, March 12, 2016</td>
        <td>Computer, Texting</td>
        <td>10:25 PM</td>
        <td>08:55 AM</td>
        <td>15</td>
        <td>1</td>
        <td>3</td>
        <td>10:12</td>
        <td>10:30</td>
        <td>Unknown</td>
        <td>3</td>
        <td>Refreshed</td>
        <td>4</td>
        <td>Sound</td>
        </tr>
        <tr>
        <td>Saturday, March 13, 2016</td>
        <td>Play with People, Texting</td>
        <td>12:20 AM</td>
        <td>10:30 AM</td>
        <td>10</td>
        <td>2</td>
        <td>11</td>
        <td>09:49</td>
        <td>10:10</td>
        <td>Noise, Family</td>
        <td>3</td>
        <td>Refreshed</td>
        <td>4</td>
        <td>Sound</td>
        </tr>

        </tbody>
        </table>
                            <h3>Sleep Diary Summary Statistics</h3>
        <div id="toolbar3" style="margin-top: 1.5em;">
        <button id="hide-diary-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-diary-summary" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-diary-summary" class="table" data-toggle="table" data-toolbar="#toolbar3"  data-icons-prefix="fa"  data-show-columns="true">
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
        <th data-field="ave-wakeUp">Averate Wake Up State Rating_Sleep Diary</th>
        <th data-field="ave-quality">Average Sleep Quality (last night) Rating_Sleep Diary</th>
        </tr>
        </thead>
        <tbody>
        <tr>

        <td>10:25 PM</td>
        <td>02:40 AM</td>
        <td>12:48 AM</td>
        <td>07:05 AM</td>
        <td>10:30 AM</td>
        <td>8:14 AM</td>
        <td>5:20</td>
        <td>10:12</td>
        <td>7:10</td>
        <td>7:27</td>
        <td>13</td>
        <td>.67</td>
        <td>2.83</td>
        <td>1.83</td>
        <td>3.5</td>

        </tr>
        </tbody>
        </table>
                            <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
        <p>Wake Up State Ratings: (1) Tired, (2) Somewhat Refreshed, (3) Refreshed</p>
        <p>Sleep Quality (last night) Ratings: (1) Very Restless, (2) Restless, (3) Average, (4) Sound, (5) Very Sound</p>
        </div>
        <div role="tabpanel" class="tab-pane" id="activityDiary">
        <h3>Activity Diary Daily Statistics</h3>
                            <div id="toolbar4" style="margin-top: 1.5em;">
        <button id="hide-activity-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-activity-daily" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-activity-daily" class="table" data-toggle="table" data-toolbar="#toolbar4"  data-icons-prefix="fa"  data-show-columns="true">
                                <thead>
        <tr class="info">
                                        <th data-field="diary-date">Diary Date</th>
                                        <th data-field="nap-start">Nap Start Time_Activity Diary</th>
                                        <th data-field="nap-end">Nap End Time_Activity Diary</th>
                                        <th data-field="data-duration">Nap Duration<br>(hrs.)_Activity Diary</th>
                                        <th data-field="exercised">Time Exercised<br>(min)_Activity Diary</th>
                                        <th data-field="caffeinated"># of Caffeinated Drinks_Activity Diary</th>
                                        <th data-field="mood-rating">Mood Rating_Activity Diary</th>
                                        <th data-field="mood-descriptor">Mood Descriptor_Activity Diary</th>
                                        <th data-field="sleepiness-rating">Sleepiness Rating_Activity Diary</th>
                                        <th data-field="sleepiness-descriptor">Sleepiness Descriptor_Activity Diary</th>
                                        <th data-field="attentiveness-rating">Attentiveness Rating_Activity Diary</th>
                                        <th data-field="attentiveness-descriptor">Attentiveness Descriptor_Activity Diary</th>
        </tr>
                                </thead>
                                <tbody>

        <tr>
        <td>Monday, March 8, 2016</td>
        <td>N/A</td>
        <td>N/A</td>
        <td>0</td>
        <td>45</td>
        <td>0</td>
        <td>3</td>
        <td>Sometimes Pleasant</td>
        <td>3</td>
        <td>Sleepy</td>
        <td>4</td>
        <td>Focus most of the day</td>
        </tr>
        <tr>
        <td>Tuesday, March 9, 2016</td>
        <td>9:50 PM</td>
        <td>12:05 AM</td>
        <td>2:15</td>
        <td>30</td>
        <td>2</td>
        <td>2</td>
        <td>Unpleasant</td>
        <td>2</td>
        <td>Somewhat Sleepy</td>
        <td>1</td>
        <td>Couldn’t focus</td>
        </tr>
        <tr>
        <td>Wednesday, March 10, 2016</td>
        <td>N/A</td>
        <td>N/A</td>
        <td>0</td>
        <td>30</td>
        <td>2</td>
        <td>2</td>
        <td>Unpleasant</td>
        <td>2</td>
        <td>Somewhat Sleepy</td>
        <td>1</td>
        <td>Couldn’t focus</td>
        </tr>
        <tr>
        <td>Thursday, March 11, 2016</td>
        <td>12:15 AM</td>
        <td>01:45 AM</td>
        <td>1:30</td>
        <td>45</td>
        <td>3</td>
        <td>2</td>
        <td>Unpleasant</td>
        <td>2</td>
        <td>Somewhat Sleepy</td>
        <td>1</td>
        <td>Couldn’t focus</td>
        </tr>
        <tr>
        <td>Friday, March 12, 2016</td>
        <td>N/A</td>
        <td>N/A</td>
        <td>0</td>
        <td>40</td>
        <td>2</td>
        <td>4</td>
        <td>Pleasant</td>
        <td>3</td>
        <td>Sleepy</td>
        <td>4</td>
        <td>Focus most of the day</td>
        </tr>
        <tr>
        <td>Saturday, March 13, 2016</td>
        <td>N/A</td>
        <td>N/A</td>
        <td>0</td>
        <td>25</td>
        <td>0</td>
        <td>4</td>
        <td>Pleasant</td>
        <td>2</td>
        <td>Somewhat sleepy</td>
        <td>3</td>
        <td>Focus about half of the time</td>
        </tr>

                                </tbody>
        </table>
                            <h3>Activity Diary Summary Statistics</h3>
                            <div id="toolbar5" style="margin-top: 1.5em;">
        <button id="hide-activity-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-activity-summary" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-activity-summary" class="table" data-toggle="table" data-toolbar="#toolbar5"  data-icons-prefix="fa"  data-show-columns="true">
                                <thead>
        <tr class="info">
                                        <th data-field="nap">Number of Days Napped_Activity Diary</th>
                                        <th data-field="ave-nape">Average Number of Caffeinated Drinks_Activity Diary</th>
                                        <th data-field="ave-exerc">Averate Number of Minutes Exercised_Activity Diary</th>
                                        <th data-field="ave-mood">Average Mood Rating_Activity Diary</th>
                                        <th data-field="ave-moodDesc">Mood Descriptor Most Often Selected_Activity Diary</th>
                                        <th data-field="ave-sleepness">Average Sleepiness Rating_Activity Diary</th>
                                        <th data-field="sleepness">Sleepiness Descriptor Most Often Selected_Activity Diary</th>
                                        <th data-field="ave-attention">Average Attention Rating_Activity Diary</th>
                                        <th data-field="attention">Attention Descriptor Most Often Selected_Activity Diary</th>
        </tr>
                                </thead>
                                <tbody>
        <tr>

        <td>2</td>
        <td>1.5</td>
        <td>35</td>
        <td>2.83</td>
        <td>Unpleasant</td>
        <td>2.33</td>
        <td>Somewhat Sleepy</td>
        <td>2.33</td>
        <td>Little</td>

        </tr>
                                </tbody>
        </table>
        <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
        <p>Mood Ratings: (1) Very Unpleasant, (2) Unpleasant, (3) Sometimes Pleasant, (4) Pleasant, (5) Very Pleasant</p>
        <p>Sleepiness Ratings: (1) Not Sleepy, (2) Somewhat Sleepy, (3) Sleepy, (4) Very Sleepy</p>
        <p>Attentiveness Ratings: (1)couldn’t focus, (2)focus occasionally, (3)focus about half of the time, (4)focus most of the day, (5)focus all day</p>
        </div>
                    </div>
        </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectPage(0)" style="cursor: pointer;text-align: center;">
                <label class="info-title" style="color: #fafafa">Back</label>
            </div>
          </div>
        </div>
      </div>


      <!-- Tab pane 4 -->
    <div role="tabpanel" class="tab-pane" id="case3">
      <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
              <div>
                  <!-- Nav tabs -->
                  <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">

                      <li role="presentation" class="active"><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">Actogram</a></li>
                      <li role="presentation"><a href="#watchData" aria-controls="watchData" role="tab" data-toggle="tab">Watch Data</a></li>
                      <li role="presentation"><a href="#sleepDiary" aria-controls="sleepDiary" role="tab" data-toggle="tab">Sleep Diary</a></li>
                      <li role="presentation"><a href="#activityDiary" aria-controls="activityDiary" role="tab" data-toggle="tab">Activity Diary</a></li>
                      <!--<li role="presentation"><a href="#worksheet" aria-controls="worksheet" role="tab" data-toggle="tab">Worksheet</a></li>-->
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content" style="margin-top: 2em;">
                      <div role="tabpanel" class="tab-pane active" id="actigraphy">
                        <h3 class="text-center">Actogram</h3>
        <div class="row">
        <div class="col-xs-11 col-md-11">
                                    <img class="img-responsive" src="images/fifthgrade-lessontwo/acti-case-three.png">
        </div>
        <div class="col-xs-1 col-md-1">
        <button id="black" type="button" class="btn btn-sm" style="background-color: black"></button><label for="black">Activity</label>
        <button id="blue" type="button" class="btn btn-sm" style="background-color: blue"></button><label for="black">Blue Light</label>
        <button id="yellow" type="button" class="btn btn-sm" style="background-color: yellow"></button><label for="black">Yellow Light</label>
        </div>
        </div>
                              </div>
        <div role="tabpanel" class="tab-pane" id="watchData">
        <h3>Watch Daily Statistics</h3>
        <div id="toolbarWatchData">
        <button id="hide-watchWatchData" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-watchWatchData" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-watchWatchData" class="table" data-toggle="table" data-toolbar="#toolbarWatchData"  data-icons-prefix="fa"  data-show-columns="true">
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
        <tr><td>Tue 3/24/2015</td><td>9:37:00 PM</td><td>7:04:30 AM</td><td>09:27</td><td>08:41</td><td>4.50</td><td>91.81</td><td>38</td><td>28.00</td></tr>
        <tr><td>Wed 3/25/2015</td><td>8:45:30 PM</td><td>7:00:30 AM</td><td>10:15</td><td>09:38</td><td>0.00</td><td>93.98</td><td>43</td><td>35.50</td></tr>
        <tr><td>Thu 3/26/2015</td><td>8:54:00 PM</td><td>7:14:00 AM</td><td>10:20</td><td>09:48</td><td>0.00</td><td>94.92</td><td>28</td><td>19.00</td></tr>
        <tr><td>Fri 3/27/2015</td><td>8:58:30 PM</td><td>7:27:30 AM</td><td>10:29</td><td>09:52</td><td>0.00</td><td>94.20</td><td>36</td><td>30.50</td></tr>
        <tr><td>Sat 3/28/2015</td><td>9:16:00 PM</td><td>7:31:00 AM</td><td>10:15</td><td>09:51</td><td>1.00</td><td>96.10</td><td>33</td><td>19.50</td></tr>
        </tr>
        </tbody>
        </table>

        <h3>Watch Summary Statistics</h3>
        <div id="toolbar">
        <button id="hide-watch" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-watch" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-watch" class="table" data-toggle="table" data-toolbar="#toolbar"  data-icons-prefix="fa"  data-show-columns="true">
        <thead>
        <tr>
          <th data-field="early-bed-a">Earliest Bedtime_Sleep_Watch</th>
          <th data-field="last-bed-a">Latest Bedtime_Sleep_Watch</th>
          <th data-field="ave-bed-a">Average Bedtime_Sleep_Watch</th>
          <th data-field="early-wake-a">Earliest Get Up Time_Sleep_Watch</th>
          <th data-field="last-wake-a">Latest Get Up Time_Sleep_Watch</th>
          <th data-field="ave-wake-a">Average Get Up Time_Sleep_Watch</th>
          <th data-field="short-total-a">Shortest Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
          <th data-field="long-total-a">Longest Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
          <th data-field="ave-total-a">Average Sleep Time<br>(hh:mm:ss)_Sleep_Watch</th>
          <th data-field="ave-num-awak-a">Average <br>#Awak._Sleep_Watch</th>
              <th data-field="ave-awak-time-a">Average <br>Awake Time_Sleep_Watch</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>8:45:30 PM</td>
          <td>9:37:00 PM</td>
          <td>9:06:12 PM</td>
          <td>7:00:30 AM</td>
          <td>7:31:00 AM</td>
          <td>7:15:30 AM</td>
          <td>8:41:00</td>
          <td>9:52:30</td>
          <td>9:37:17</td>
          <td>35.60</td>
          <td>26.50</td>
        </tr>
        </tbody>
        </table>
        <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="sleepDiary">
        <h3>Sleep Diary Daily Statistics</h3>
                                  <div id="toolbar2">
        <button id="hide-diary-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-diary-daily" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-diary-daily" class="table" data-toggle="table" data-toolbar="#toolbar2"  data-icons-prefix="fa"  data-show-columns="true">
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
          <td>Monday, March 8, 2016</td>
          <td>Music</td>
          <td>09:50 PM</td>
          <td>07:00 AM</td>
          <td>20</td>
          <td>1</td>
          <td>5</td>
          <td>8:50</td>
          <td>9:15</td>
          <td>Family</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>3</td>
          <td>Average</td>
            </tr>
            <tr>
          <td>Tuesday, March 9, 2016</td>
          <td>Reading</td>
          <td>09:05 PM</td>
          <td>07:25 AM</td>
          <td>50</td>
          <td>0</td>
          <td>0</td>
          <td>9:30</td>
          <td>10:20</td>
          <td>Nothing</td>
          <td>2</td>
          <td>Somewhat Refreshed</td>
          <td>4</td>
          <td>Sound</td>
            </tr>
            <tr>
          <td>Wednesday, March 10, 2016</td>
          <td>Video Game</td>
          <td>08:30 PM</td>
          <td>06:55 AM</td>
          <td>20</td>
          <td>0</td>
          <td>0</td>
          <td>10:05</td>
          <td>10:25</td>
          <td>Nothing</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
            </tr>
            <tr>
          <td>Thursday, March 11, 2016</td>
          <td>Homework, Shower</td>
          <td>08:30 PM</td>
          <td>06:45 AM</td>
          <td>30</td>
          <td>1</td>
          <td>3</td>
          <td>09:42</td>
          <td>10:15</td>
          <td>Bodyily Pain</td>
          <td>2</td>
          <td>Somewhat Refreshed</td>
          <td>4</td>
          <td>Sound</td>
            </tr>
            <tr>
          <td>Friday, March 12, 2016</td>
          <td>TV, Video Game</td>
          <td>10:00 PM</td>
          <td>08:30 AM</td>
          <td>0</td>
          <td>1</td>
          <td>3</td>
          <td>10:27</td>
          <td>10:30</td>
          <td>Pet</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
            </tr>
            <tr>
          <td>Saturday, March 13, 2016</td>
          <td>Computer</td>
          <td>09:10 PM</td>
          <td>07:20 AM</td>
          <td>20</td>
          <td>0</td>
          <td>0</td>
          <td>09:50</td>
          <td>10:10</td>
          <td>Nothing</td>
          <td>3</td>
          <td>Refreshed</td>
          <td>4</td>
          <td>Sound</td>
            </tr>
        </tbody>
        </table>
                                  <h3>Sleep Diary Summary Statistics</h3>
        <div id="toolbar3" style="margin-top: 1.5em;">
        <button id="hide-diary-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-diary-summary" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-diary-summary" class="table" data-toggle="table" data-toolbar="#toolbar3"  data-icons-prefix="fa"  data-show-columns="true">
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
          <th data-field="ave-wakeUp">Averate Wake Up State Rating_Sleep Diary</th>
          <th data-field="ave-quality">Average Sleep Quality (last night) Rating_Sleep Diary</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>8:30 PM</td>
          <td>10:00 PM</td>
          <td>9:11 PM</td>
          <td>06:45 AM</td>
          <td>08:30 AM</td>
          <td>07:19 AM</td>
          <td>8:50</td>
          <td>10:27</td>
          <td>9:44</td>
          <td>10:09</td>
          <td>23</td>
          <td>0.5</td>
          <td>1.83</td>
          <td>2.67</td>
          <td>3.83</td>
        </tr>
        </tbody>
        </table>
                                  <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
        <p>Wake Up State Ratings: (1) Tired, (2) Somewhat Refreshed, (3) Refreshed</p>
        <p>Sleep Quality (last night) Ratings: (1) Very Restless, (2) Restless, (3) Average, (4) Sound, (5) Very Sound</p>
        </div>
        <div role="tabpanel" class="tab-pane" id="activityDiary">
        <h3>Activity Diary Daily Statistics</h3>
                                  <div id="toolbar4" style="margin-top: 1.5em;">
        <button id="hide-activity-daily" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-activity-daily" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-activity-daily" class="table" data-toggle="table" data-toolbar="#toolbar4"  data-icons-prefix="fa"  data-show-columns="true">
                                      <thead>
        <tr class="info">
                                              <th data-field="diary-date">Diary Date</th>
                                              <th data-field="nap-start">Nap Start Time_Activity Diary</th>
                                              <th data-field="nap-end">Nap End Time_Activity Diary</th>
                                              <th data-field="data-duration">Nap Duration<br>(hrs.)_Activity Diary</th>
                                              <th data-field="exercised">Time Exercised<br>(min)_Activity Diary</th>
                                              <th data-field="caffeinated"># of Caffeinated Drinks_Activity Diary</th>
                                              <th data-field="mood-rating">Mood Rating_Activity Diary</th>
                                              <th data-field="mood-descriptor">Mood Descriptor_Activity Diary</th>
                                              <th data-field="sleepiness-rating">Sleepiness Rating_Activity Diary</th>
                                              <th data-field="sleepiness-descriptor">Sleepiness Descriptor_Activity Diary</th>
                                              <th data-field="attentiveness-rating">Attentiveness Rating_Activity Diary</th>
                                              <th data-field="attentiveness-descriptor">Attentiveness Descriptor_Activity Diary</th>
        </tr>
                                      </thead>
                                      <tbody>

            <tr>
          <td>Monday, March 8, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>45</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
            </tr>
            <tr>
          <td>Tuesday, March 9, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>70</td>
          <td>1</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>2</td>
          <td>Somewhat Sleepy</td>
          <td>5</td>
          <td>Focus all day</td>
            </tr>
            <tr>
          <td>Wednesday, March 10, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>60</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
            </tr>
            <tr>
          <td>Thursday, March 11, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>50</td>
          <td>1</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
            </tr>
            <tr>
          <td>Friday, March 12, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>30</td>
          <td>0</td>
          <td>4</td>
          <td>Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>5</td>
          <td>Focus all day</td>
            </tr>
            <tr>
          <td>Saturday, March 13, 2016</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>0</td>
          <td>20</td>
          <td>0</td>
          <td>5</td>
          <td>Very Pleasant</td>
          <td>1</td>
          <td>Not Sleepy</td>
          <td>4</td>
          <td>Focus most of the day</td>
            </tr>
                                      </tbody>
        </table>
                                  <h3>Activity Diary Summary Statistics</h3>
                                  <div id="toolbar5" style="margin-top: 1.5em;">
        <button id="hide-activity-summary" class="btn btn-sm btn-default">Unselect All Variables</button>
        <button id="show-activity-summary" class="btn btn-sm btn-default">Select All Variables</button>
        </div>
        <table id="table-activity-summary" class="table" data-toggle="table" data-toolbar="#toolbar5"  data-icons-prefix="fa"  data-show-columns="true">
                                      <thead>
        <tr class="info">
                                              <th data-field="nap">Number of Days Napped_Activity Diary</th>
                                              <th data-field="ave-nape">Average Number of Caffeinated Drinks_Activity Diary</th>
                                              <th data-field="ave-exerc">Averate Number of Minutes Exercised_Activity Diary</th>
                                              <th data-field="ave-mood">Average Mood Rating_Activity Diary</th>
                                              <th data-field="ave-moodDesc">Mood Descriptor Most Often Selected_Activity Diary</th>
                                              <th data-field="ave-sleepness">Average Sleepiness Rating_Activity Diary</th>
                                              <th data-field="sleepness">Sleepiness Descriptor Most Often Selected_Activity Diary</th>
                                              <th data-field="ave-attention">Average Attention Rating_Activity Diary</th>
                                              <th data-field="attention">Attention Descriptor Most Often Selected_Activity Diary</th>
        </tr>
                                      </thead>
                                      <tbody>
        <tr>

          <td>0</td>
          <td>.33</td>
          <td>45.83</td>
          <td>4.17</td>
          <td>Pleasant</td>
          <td>1.17</td>
          <td>Not Sleepy</td>
          <td>4.33</td>
          <td>Mostly</td>

        </tr>
                                      </tbody>
        </table>
        <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
        <p>Mood Ratings: (1) Very Unpleasant, (2) Unpleasant, (3) Sometimes Pleasant, (4) Pleasant, (5) Very Pleasant</p>
        <p>Sleepiness Ratings: (1) Not Sleepy, (2) Somewhat Sleepy, (3) Sleepy, (4) Very Sleepy</p>
        <p>Attentiveness Ratings: (1)couldn’t focus, (2)focus occasionally, (3)focus about half of the time, (4)focus most of the day, (5)focus all day</p>
        </div>
                          </div>
        </div>
                  </div>
        </div>

      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectPage(0)" style="cursor: pointer;text-align: center;">
              <label class="info-title" style="color: #fafafa">Back</label>
          </div>
        </div>
      </div>
    </div>



                </div>
	    </div>
        </div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
    <script>

    var  tableWatchWatchData = $('#table-watchWatchData'),
    hideWatchWatchData = $('#hide-watchWatchData'),
    showWatchWatchData = $('#show-watchWatchData');
    var  watchFieldWatchData = ['end-date-a', 'bed-time-a', 'wake-up-time-a', 'time-in-bed-a', 'total-sleep-time-a', 'time-it-took-to-fall-asleep-a', 'average-sleep-quality-a', 'num-awak-a', 'awak-time-a'];
    $(function () {
    hideWatchWatchData.click(function () {
      $.each(watchFieldWatchData, function(index, value){
    tableWatchWatchData.bootstrapTable('hideColumn', value);
      });
    });
    });
    $(function () {
    showWatchWatchData.click(function () {
      $.each(watchFieldWatchData, function(index, value){
    tableWatchWatchData.bootstrapTable('showColumn', value);
      });
    });
    });

     var  tableWatch = $('#table-watch'),
	  hideWatch = $('#hide-watch'),
	  showWatch = $('#show-watch');
     var  watchField = ['early-bed-a', 'last-bed-a', 'ave-bed-a', 'early-wake-a', 'last-wake-a', 'ave-wake-a', 'short-total-a', 'long-total-a', 'ave-total-a', "ave-num-awak-a", "ave-awak-time-a"];
     $(function () {
	 hideWatch.click(function () {
	     $.each(watchField, function(index, value){
		 tableWatch.bootstrapTable('hideColumn', value);
	     });
	     /*$('#table-watch').find('th').each(function(){
		fieldName = $(this).data('field');
		//tableWatch.bootstrapTable('hideColumn', fieldName);
		//console.log(fieldName);
		});*/
	 });
     });
     $(function () {
	 showWatch.click(function () {
	     $.each(watchField, function(index, value){
		 tableWatch.bootstrapTable('showColumn', value);
	     });
	 });
     });


     var  tableDiaryDaily = $('#table-diary-daily'),
	  hideDiaryDaily = $('#hide-diary-daily'),
	  showDiaryDaily = $('#show-diary-daily');
     var  diaryDailyField = ["diary-date", "activities-before", "bed-time", "wake", "fall", "awak", "awak-time", "total", "total-bed", "sleep-interrupt", "state-rate", "state-descriptor", "quality-rate", "quality-descriptor"];
     $(function () {
	 hideDiaryDaily.click(function () {
	     $.each(diaryDailyField, function(index, value){
		 tableDiaryDaily.bootstrapTable('hideColumn', value);
	     });
	 });
     });
     $(function () {
	 showDiaryDaily.click(function () {
	     $.each(diaryDailyField, function(index, value){
		 tableDiaryDaily.bootstrapTable('showColumn', value);
	     });
	 });
     });


     var  tableDiarySummary = $('#table-diary-summary'),
	  hideDiarySummary = $('#hide-diary-summary'),
	  showDiarySummary = $('#show-diary-summary');
     var  diarySummaryField = ["early-bed", "last-bed", "ave-bed", "early-wake", "last-wake", "ave-wake", "short-total", "long-total", "ave-total", "ave-inBed",
			       "ave-fall", "ave-awak", "ave-awakeTime", "ave-wakeUp", "ave-quality"];
     $(function () {
	 hideDiarySummary.click(function () {
	     $.each(diarySummaryField, function(index, value){
		 tableDiarySummary.bootstrapTable('hideColumn', value);
	     });
	 });
     });
     $(function () {
	 showDiarySummary.click(function () {
	     $.each(diarySummaryField, function(index, value){
		 tableDiarySummary.bootstrapTable('showColumn', value);
	     });
	 });
     });



     var  tableActivityDaily = $('#table-activity-daily'),
	  hideActivityDaily = $('#hide-activity-daily'),
	  showActivityDaily = $('#show-activity-daily');
     var  activityDailyField = ["diary-date", "nap-start", "nap-end", "data-duration", "exercised", "caffeinated", "mood-rating", "mood-descriptor", "sleepiness-rating", "sleepiness-descriptor", "attentiveness-rating", "attentiveness-descriptor"];
     $(function () {
	 hideActivityDaily.click(function () {
	     $.each(activityDailyField, function(index, value){
		 tableActivityDaily.bootstrapTable('hideColumn', value);
	     });
	 });
     });
     $(function () {
	 showActivityDaily.click(function () {
	     $.each(activityDailyField, function(index, value){
		 tableActivityDaily.bootstrapTable('showColumn', value);
	     });
	 });
     });


     var  tableActivitySummary = $('#table-activity-summary'),
	  hideActivitySummary = $('#hide-activity-summary'),
	  showActivitySummary = $('#show-activity-summary');
     var  activitySummaryField = ["nap", "ave-nape", "ave-exerc", "ave-mood", "ave-moodDesc", "ave-sleepness", "sleepness", "ave-attention", "attention"];
     $(function () {
	 hideActivitySummary.click(function () {
	     $.each(activitySummaryField, function(index, value){
		 tableActivitySummary.bootstrapTable('hideColumn', value);
	     });
	 });
     });
     $(function () {
	 showActivitySummary.click(function () {
	     $.each(activitySummaryField, function(index, value){
		 tableActivitySummary.bootstrapTable('showColumn', value);
	     });
	 });
     });

     $( document ).ready(function() {
	 $("button").each(function() {
	     if($(this).hasClass("dropdown-toggle")) {
		 $(this).html("Variable Selection");
	     }
	 });
     });
     function selectPage(page){
       if (page==1) {
         $('#secondTab').trigger('click')
       }
       if (page==2) {
         $('#thirdTab').trigger('click')
       }
       if (page==3) {
         $('#forthTab').trigger('click')
       }
       if (page==0) {
         $('#firstTab').trigger('click')
       }
       window.scrollTo({ top: 100, behavior: 'smooth' });
     }
    </script>
</html>
