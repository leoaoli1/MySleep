<!DOCTYPE html>
<?php
/*Main*/
require_once('utilities.php');
require_once('utilities-diary.php');
require_once('activity-diary-data-table.php');
require_once('sleep-diary-data-table.php');
require_once('utilities-actogram.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];
$schoolId = $_SESSION['schoolId'];

if($userId==""){
    header("Location: login");
    exit;
}

/*flexible framework section*/
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
/* end */

# check the demo mode for Science-City-2018
list($schoolId, $classId, $demoMode) = getDemoMode();

include 'connectdb.php';
$grade = 5;
$studentList = getUserIdsInSchoolWithSameGradeAndSemester($grade, $schoolId, 2017, 'F');
$dataArray = [[]];
$i = 0;
foreach ($studentList as $studentId){
    //debugToConsole("ID", $studentId);
    $includeUnsubmitted = false;
    /*Sleep Diary*/
    list($startingDiaryEntryDate, $endingDiaryEntryDate) = getDiarySelection($studentId, $grade);
    $statsSleep = array
    (
	'hourSlept' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
	'wokeupState' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
	'sleepQuality' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
    );

    $queryOptionsDiary = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "AND");
    $queryCommandSleep = "SELECT wokeupState, sleepQuality, hourSlept FROM diary_data_table WHERE userId='$studentId' AND diaryGrade = '$grade'" . $queryOptionsDiary . " ORDER BY diaryDate";
    $resultsSleepDiaryToShow = mysql_query($queryCommandSleep);

    while ($rowSleepDiaryToShow = mysql_fetch_array($resultsSleepDiaryToShow)) {
	accumulateSleepData($rowSleepDiaryToShow, $statsSleep);
    }
    computeSleepStats($statsSleep);
    /*End Sleep Diary*/


    /*Activity Diary*/
    list($startingActivityEntryDate, $endingActivityEntryDate) = getActivitySelection($studentId, $grade);
    $statsActivity = array
    (
	'minExercised' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
	'feltDuringDay' =>        array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
	'howSleepy' =>            array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
	'attention' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
	'behavior' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
	'interaction' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
    );
    $queryOptionsActivity = getQueryOptionsByDate($includeUnsubmitted, $startingActivityEntryDate, $endingActivityEntryDate, "AND");
    $queryCommandActivity = "SELECT minExercised, feltDuringDay, howSleepy, attention, behavior, interaction, symptomRunnyNose, symptomSoreThroat, symptomStuffyNose, symptomItchyEyes, symptomHeadache, symptomFever, symptomSneezing, symptomCoughing, symptomBodyAches, symptomStomach, symptomUnknown FROM activity_diary_data_table WHERE userId='$studentId'  AND diaryGrade = '$grade'" . $queryOptionsActivity . " ORDER BY diaryDate";
    $resultsActivityDiaryToShow = mysql_query($queryCommandActivity);

    $dayCount = 0; //compute for symptoms
    $symptomCount = 0;
    while ($rowActivityDiaryToShow = mysql_fetch_array($resultsActivityDiaryToShow)) {
	accumulateActivityData($rowActivityDiaryToShow, $statsActivity);

	$symptomCount += computeSymptom($rowActivityDiaryToShow); //compute for symptoms
	$dayCount += 1;
    }
    $averageSymptom = floor($symptomCount/$dayCount);
    computeActivityStats($statsActivity);
    /*End Activity Diary*/

    /*Sleep Watch*/
    $arrBedTime  = "0";
    $arrTotalSleepTime = "0";
    $arrTimeItTookToFallAsleep = "0";
    $arrAverageSleepQuality = "0";
    $arrNumberOfAwak = "0";

    $diffBedTime = null;
    $diffTotalSleepTime = null;
    $meanTotalSleepTime = null;
    $meanTimeItTookToFallAsleep = null;
    $meanAverageSleepQuality = null;
    $meanNumberOfAwak = null;
    //get Actograph data
    $result = mysql_query("SELECT bedTime, totalSleepTime, timeItTookToFallAsleep, averageSleepQuality, numberOfAwak FROM my_actogram WHERE userId='$studentId' and grade='$grade' order by resultRow DESC LIMIT 1");
    $row = mysql_fetch_array($result);
    if(mysql_num_rows($result)>0) {
	list($arrBedTime, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak) = extractSleepWatchData($row);
	list($diffBedTime, $diffTotalSleepTime,  $meanTotalSleepTime, $meanTimeItTookToFallAsleep, $meanAverageSleepQuality, $meanNumberOfAwak) = computeSleepWatch($arrBedTime, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak);
    }
    /*End Sleep Watch*/

    /*Reaction and Memroy*/
    $reactionScore = null;
    $reactionScore = computeReactionScore($studentId);

    $memoryScore = null;
    list($memoryScore, $memoryFlag) = computeMemoryScore($studentId);
    /*End Reaction and Memory*/

    /*Save to array*/
    /*0Average Total Sleep Time, 1Average Sleep Quality, 2Average Wokeup State, 3Average Attention, 4Average Exercised Time, 5Average Sleepiness, 6Average Number of Physical Symptoms, 7Average Mood, 8Average Behavior, 9Average Interaction, 10Difference between  shortest and longest sleep time, 11Difference between earliest and latest bedtimes, 12Average Totoal Sleep Time, 13Average time to fall asleep, 14Average sleep quality percent, 15Average Awakenings, 16Reaction, 17Memory */
    if(!is_null($statsSleep['hourSlept']['mean'])&&!is_null($statsSleep['sleepQuality']['mean'])&&!is_null($statsSleep['wokeupState']['mean'])&&!is_null($statsActivity['attention']['mean'])&&!is_null($statsActivity['howSleepy']['mean'])&&!is_null($statsActivity['feltDuringDay']['mean'])&&!is_null($statsActivity['behavior']['mean'])&&!is_null($statsActivity['interaction']['mean'])&&!is_null($diffBedTime)&&!is_null($diffTotalSleepTime)&&!is_null($meanTotalSleepTime)&&!is_null($meanTimeItTookToFallAsleep)&&!is_null($meanAverageSleepQuality)&&!is_null($meanNumberOfAwak)&&!is_null($statsActivity['minExercised']['mean'])){ // &&!empty($reactionScore)&&!empty($memoryScore)
	$tmparray = array((float)floor($statsSleep['hourSlept']['mean']*60),
  (float)getDisplayNumber($statsSleep['sleepQuality']['mean'], 2),
  (float)getDisplayNumber($statsSleep['wokeupState']['mean'], 2),
  (float)getDisplayNumber($statsActivity['attention']['mean'], 2),
  (float)getDisplayNumber($statsActivity['minExercised']['mean'], 0),
  (float)getDisplayNumber($statsActivity['howSleepy']['mean'], 2),
  (float)$averageSymptom,
  (float)getDisplayNumber($statsActivity['feltDuringDay']['mean'], 2),
  (float)getDisplayNumber($statsActivity['behavior']['mean'], 2),
  (float)getDisplayNumber($statsActivity['interaction']['mean'], 2),
  (float)floor($diffBedTime/60),
  (float)floor($diffTotalSleepTime/60),
  (float)floor($meanTotalSleepTime/60),
  (float)$meanTimeItTookToFallAsleep,
  (float)$meanAverageSleepQuality,
  (float)$meanNumberOfAwak,
  (float)floor($reactionScore),
  (float)number_format((float)$memoryScore, 2, '.', ''));
	/*echo $i;
	   print_r($tmparray);
	   echo "<br>";*/
	$dataArray[$i] = $tmparray;
	$i++;
    }
    /*End Save to array*/
}
debugToConsole("total", count($studentList));
debugToConsole("id", $i);
if(empty($dataArray[0])){
    $dataArray[0] = array_fill(0, 17, 0);
    //debugToConsole("array", $dataArray[0]);
}
//debugToConsole("array", $dataArray[0]);

/*Funcations*/
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
    /*debugToConsole("ID", $userIdIn);
       echo mysql_error();
       debugToConsole("Flag", mysql_num_rows($row));
       debugToConsole("StartDate", $startDate);*/
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

/*Sleep Diary and Activity Diary Functions*/
function accumulateSleepData($row, &$stats)
{
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    addData($stats['wokeupState'], $enumWokeupState[$row['wokeupState']]);
    addData($stats['sleepQuality'], $enumSleepQuality[$row['sleepQuality']]);
    addData($stats['hourSlept'], $row['hourSlept']);
}

// Function to convert a 24-hr time string to timestamp in seconds
// If the time is in the morning (00:00:00 to 11:59:59), an extra day is added,
//   indicating that the time is in the next day
function get2DayTimeStamp($time)
{
    if (is_null($time))
        return NULL;
    if ($time == "")
        return NULL;
    $timestamp = strtotime($time);          // Convert to timestamp in seconds
    if ($time <= '12:00:00')        // Time is in the morning or very early morning
        $timestamp += 24 * 60 * 60;     // Add an extra day
    return $timestamp;
}

// Function to add valid data to the data structure for later processing
function addData(&$storage, $data)
{
    if (is_null($data))
        return;
    if ($data == "")
        return;
    $storage['data'][] = $data;
}

// Function to compute the statistics of sleep diary data
function computeSleepStats(&$stats)
{
    computeDataStats($stats['wokeupState']);
    computeDataStats($stats['sleepQuality']);
    computeDataStats($stats['hourSlept']);
}

// Function to accumulate data from selected activity diaries in the database
function accumulateActivityData($row, &$stats)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;

    addData($stats['minExercised'], $row['minExercised']);
    addData($stats['feltDuringDay'], $enumFeltDuringDay[$row['feltDuringDay']]);
    addData($stats['howSleepy'], $enumHowSleepy[$row['howSleepy']]);
    addData($stats['attention'], $enumAttention[$row['attention']]);
    addData($stats['behavior'], $enumBehavior[$row['behavior']]);
    addData($stats['interaction'], $enumInteraction[$row['interaction']]);
}

// Function to compute the statistics of activity diary data
function computeActivityStats(&$stats)
{
    computeDataStats($stats['minExercised']);
    computeDataStats($stats['feltDuringDay']);
    computeDataStats($stats['howSleepy']);
    computeDataStats($stats['attention']);
    computeDataStats($stats['behavior']);
    computeDataStats($stats['interaction']);
}

// Function to compute statistics for a data item
function computeDataStats(&$storage)
{
    $count = count($storage['data']);
    if ($count == 0)
    {
        $storage['min'] = NULL;     // To indicate no data is available
        $storage['max'] = NULL;
        $storage['mean'] = NULL;
        return;
    }

    $data = array_values($storage['data']);     // Extract the data
    $sum = array_sum($data);
    //$storage['sum'] = $sum;
    $storage['mean'] = $sum / $count;
    //echo "+" . $storage['mean'] . "+";
    //if ($storage['mean'] == 0) $storage['mean'] = 0.1;
    sort($data);
    $storage['min'] = $data[0];
    rsort($data);           // Sort in the reverse order; max on top
    $storage['max'] = $data[0];

    // Compute mode, which can be more than one value
    $hist = array_count_values($data);  // Kind of compute the histogram
    arsort($hist);      // Most at top
    $mode = array();
    $max = 0;
    foreach($hist as $key => $value)
    {
        if (count($mode) == 0)  // Get the very first one
        {
            array_push($mode, $key);
            $max = $value;
            continue;
        }
        if ($value != $max)     // No more modes
            break;
        array_push($mode, $key);
    }
    $storage['mode'] = $mode;
}

// Function to count how many data points are greater than a number
function getNumDataGreaterThan($data, $threshold)
{
    $count = 0;
    foreach($data as $key => $value)
    if ($value > $threshold)
        $count++;
    return $count;
}
/*End Sleep Diary And Activity Diary Functions*/

/*Sleep Watch Fucnations*/
function extractSleepWatchData($row){
    $strBedTime = $row['bedTime'];
    $strTotalSleepTime = $row['totalSleepTime'];
    $strTimeItTookToFallAsleep = $row['timeItTookToFallAsleep'];
    $strAverageSleepQuality = $row['averageSleepQuality'];
    $strNumberOfAwak = $row['numberOfAwak'];

    $arrBedTime = explode(",", $strBedTime);
    $arrTotalSleepTime = explode(",", $strTotalSleepTime);
    $arrTimeItTookToFallAsleep = explode(",", $strTimeItTookToFallAsleep);
    $arrAverageSleepQuality = explode(",", $strAverageSleepQuality);
    $arrNumberOfAwak = explode(",", $strNumberOfAwak);


    #check nap date by bed time
    $earlyTime = strtotime("9:00:00");
    $lateTime = strtotime("18:00:00");
    $duration = 300;  # unit is min
    for($i=0; $i<count($arrBedTime)-1; $i++){
	$checkTime = strtotime($arrBedTime[$i]);
	$totalDuration = floatval($arrTotalSleepTime[$i]);
	if($earlyTime<$checkTime&&$checkTime<$lateTime&&$totalDuration<$duration){
	    array_splice($arrBedTime, $i, 1);
	    array_splice($arrTotalSleepTime, $i, 1);
	    array_splice($arrTimeItTookToFallAsleep, $i, 1);
	    array_splice($arrAverageSleepQuality, $i, 1);
	    array_splice($arrNumberOfAwak, $i, 1);
	    $i--;
	}
    }
    return array($arrBedTime, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak);
}

function computeSleepWatch($arrBedTime, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak){
    $diffBedTime = null;
    $diffTotalSleepTime = null;
    $meanTotalSleepTime = null;
    $meanTimeItTookToFallAsleep = null;
    $meanAverageSleepQuality = null;
    $meanNumberOfAwak = null;
    $noonSecond = strtotime("12:00:00");
    $midNight = strtotime("00:00:00");
    $earliestBed = earliestBedTime($arrBedTime, $noonSecond);
    $lastBed = lastBedTime($arrBedTime, $noonSecond);
    /*
       Mid Night as 0; from noon to midnight is negative;
       from midnight to noon is positive
     */
    $midNight = strtotime("00:00:00");
    $noon = strtotime("12:00:00");
    $earliestBedtime = strtotime($earliestBed);
    $lastBedtime = strtotime($lastBed);
    /*echo $noon."<br>";
    echo $earliestBedtime."<br>";
    echo $lastBedtime."<br>";*/
    if($lastBedtime >= $noon){
	$diffBedTime = $lastBedtime - $earliestBedtime;
    }else{
	if($earliestBedtime >= $noon){
	    $diffBedTime = $lastBedtime - $midNight + strtotime("23:59:59") - $earliestBedtime;
	}else{
	    $diffBedTime = $lastBedtime - $earliestBedtime;
	}
    }

    $shortTotalSleepTime = floor(minValue($arrTotalSleepTime)*60);
    $longTotalSleepTime = floor(maxValue($arrTotalSleepTime)*60);
    $diffTotalSleepTime = $longTotalSleepTime - $shortTotalSleepTime;

    $meanTotalSleepTime = floor(meanValue($arrTotalSleepTime)*60);

    $meanTimeItTookToFallAsleep =number_format(meanValue($arrTimeItTookToFallAsleep), 2, '.', '');

    $meanAverageSleepQuality = number_format(meanValue($arrAverageSleepQuality), 2, '.', '');

    $meanNumberOfAwak = number_format(meanValue($arrNumberOfAwak), 2, '.', '');
    return array($diffBedTime, $diffTotalSleepTime,  $meanTotalSleepTime, $meanTimeItTookToFallAsleep, $meanAverageSleepQuality, $meanNumberOfAwak);
}
/*End Sleep Watch Functions*/

function computeReactionScore($userId)
{
    $result = mysql_query("SELECT turn FROM identificationTaskResults WHERE userId='$userId' ORDER BY id DESC LIMIT 1");
    $row= mysql_fetch_array($result);
    $turn = $row['turn'];
    //debugToConsole('submitTime', $submitTime);
    $result = mysql_query("SELECT time FROM identificationTaskResults WHERE userId='$userId' AND turn = '$turn'");
    $sum = 0;
    $count = 0;
    $average = 0;
    while($row= mysql_fetch_array($result)){
	$count += 1;
	//debugToConsole('time', $row['time']);
	$sum += $row['time'];
    }
    $average = $sum / $count;
    mysql_free_result($result);
    return $average;
}

function computeMemoryScore($userId){
    $result = mysql_query("SELECT DISTINCT turn FROM memoryTaskResults WHERE userId='$userId' ORDER BY id DESC LIMIT 1");
    while($row= mysql_fetch_array($result)){
	$turn = $row['turn'];
	//debugToConsole('submitTime', $submitTime);
	$resultDetial = mysql_query("SELECT response FROM memoryTaskResults WHERE userId='$userId' AND turn='$turn'");
	$correct = 0;
	$incorrect = 0;
	$score = 0;
	while($rowDetial = mysql_fetch_array($resultDetial)){
	    if($rowDetial['response'] == 'Correct'){
		$correct += 1;
	    }else{
		$incorrect += 1;
	    }
	}
	$dataFlag = 0;
	if(($correct != 0) && ($incorrect != 0)){
	    $score = $correct / 30;
	    $dataFlag = 1;
	}
    }
    return array($score, $dataFlag);
}
mysql_close($con);
//exit();
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Analysis Projecy</title>
	<style type="text/css">
	 .disableLink {
	     cursor: default;
	 }

	 .breadcrumbList {
	     list-style: none;
	     overflow: hidden;
	     font: 11px Sans-Serif;
	 }
	 .breadcrumbList li {
	     float: left;
	 }
	 .breadcrumbList li a {
	     color: white;
	     text-decoration: none;
	     padding: 10px 0 10px 65px;
	     background: brown; /* fallback color */
	     background: hsla(34,85%,35%,1);
	     position: relative;
	     display: block;
	     float: left;
	 }
	 .breadcrumbList li a::after {
	     content: " ";
	     display: block;
	     width: 0;
	     height: 0;
	     border-top: 50px solid transparent; /* Go big on the size, and let overflow hide */
	     border-bottom: 50px solid transparent;
	     border-left: 30px solid hsla(34,85%,35%,1);
	     position: absolute;
	     top: 50%;
	     margin-top: -50px;
	     left: 100%;
	     z-index: 2;
	 }
	 .breadcrumbList li a::before {
	     content: " ";
	     display: block;
	     width: 0;
	     height: 0;
	     border-top: 50px solid transparent;
	     border-bottom: 50px solid transparent;
	     border-left: 30px solid white;
	     position: absolute;
	     top: 50%;
	     margin-top: -50px;
	     margin-left: 1px;
	     left: 100%;
	     z-index: 1;
	 }
	 .breadcrumbList li:first-child a {
	     padding-left: 10px;
	 }
	 .breadcrumbList li:nth-child(2) a       { background:        hsla(34,85%,45%,1); }
	 .breadcrumbList li:nth-child(2) a:after { border-left-color: hsla(34,85%,45%,1); }
	 .breadcrumbList li:nth-child(3) a       { background:        hsla(34,85%,55%,1); }
	 .breadcrumbList li:nth-child(3) a:after { border-left-color: hsla(34,85%,55%,1); }
	 .breadcrumbList li:nth-child(4) a       { background:        hsla(34,85%,65%,1); }
	 .breadcrumbList li:nth-child(4) a:after { border-left-color: hsla(34,85%,65%,1); }
	 .breadcrumbList li:nth-child(5) a       { background:        hsla(34,85%,75%,1); }
	 .breadcrumbList li:nth-child(5) a:after { border-left-color: hsla(34,85%,75%,1); }
	</style>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php
          if ($config) {
            require_once('partials/nav-links.php');
            navigationLink($config,$userType);
          } else {
       ?>
		    <ol class="breadcrumb">
    			<li><a href="#" onclick="location.href='main-page';">Home</a></li>
    			<li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
    			<li class="active">Analysis Project</li>
		    </ol>
        <?php } ?>
		    <?php include 'partials/alerts.php' ?>
		    <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
    				<!-- Nav tabs -->
    				<ul id="group" class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display: none">
    				    <li role="presentation" class="active"><a href="#screen1" aria-controls="screen1" role="tab" data-toggle="tab">Screen 1</a></li>
    				    <li role="presentation"><a href="#screen2" aria-controls="screen2" role="tab" data-toggle="tab">Screen 2</a></li>
    				    <li role="presentation"><a href="#screen3" aria-controls="screen3" role="tab" data-toggle="tab">Screen 3</a></li>
    				    <li role="presentation"><a href="#screen4" aria-controls="screen4" role="tab" data-toggle="tab">Screen 4</a></li>
    				    <li role="presentation"><a href="#screen5" aria-controls="screen5" role="tab" data-toggle="tab">Screen 5</a></li>
    				    <li role="presentation"><a href="#screen6" aria-controls="screen6" role="tab" data-toggle="tab">Screen 6</a></li>
    				</ul>
    			</div>
		    </div>
		    <div class="tab-content" style="margin-top: 2em;">
			<!-- Tab One -->
                        <div role="tabpanel" class="tab-pane active" id="screen1">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h3 class="description" style="color: black;">
					<p><strong>Choose an Independent Variable to Investigate:</strong></p>
				    </h3>
				    <h4>
					<strong>Note: </strong>The independent variable is the “cause variable.”
				    </h4>
				</div>
			    </div>
			    <div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen1to2(0)">Sleep Duration</button>
				</div>
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen1to2(1)">Sleep Consistency</button>
				</div>
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen1to2(2)">Sleep Quality</button>
				</div>
			    </div>
			</div>
			<!--Tab Two-->
			<div role="tabpanel" class="tab-pane" id="screen2">
			    <div class="row">
				<ul class="breadcrumbList">
				    <li><a href="#" class="ivcListClass" name="ivcList" id="id_ivcList" class="disableLink"></a></li>
				</ul>
			    </div>
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h3 class="description" style="color: black;">
					<p><strong>Select how your independent variable will be measured:</strong></p>
				    </h3>
				</div>
			    </div>
			    <div name="sd" id="id_sd" style="display: none">
				<div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(0)">Average Total Sleep Time Reported in the Sleep Diary</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(1)">Average Total Sleep Time Recorded by the Sleep Watch </button>
				    </div>
				</div>
			    </div>
			    <div name="sc" id="id_sc" style="display: none">
				<div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(2)">Average Difference between shortest and longest sleep time (Sleep watch)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(3)">Average Difference between earliest and latest bedtimes (sleep watch)</button>
				    </div>
				</div>
			    </div>
			    <div name="sq" id="id_sq" style="display: none">
				<div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(4)">Average sleep quality rating (sleep diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(5)">Average wake up state  (sleep diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(6)">Average # Awakenings (sleep watch)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen2to3(7)">Average sleep quality percent (sleep watch)</button>
				    </div>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(1)">Previous</button>
				</div>
			    </div>
			</div>
			<!--Tab Three-->
			<div role="tabpanel" class="tab-pane" id="screen3">
			    <div class="row">
				<ul class="breadcrumbList">
				    <li><a href="#" class="ivcListClass" name="ivcList" id="id_ivcList" class="disableLink"></a></li>
				    <li><a href="#" class="ivListClass" name="ivList" id="id_ivList" class="disableLink"></a></li>
				</ul>
			    </div>
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h3 class="description" style="color: black;">
					<p><strong>Scroll through the sorted list of your class data for this variable. Think about how to divide the participants into two groups. You may:
					    <ul>
						<li>
						    Divide the group in half with lower values in one group and higher values in the other, or
						</li>
						<li>
						    Choose a cutoff value, so that one group has less than the cut off value and the other group has more.
						</li>
					    </ul>

					</strong></p>
				    </h3>
				</div>
			    </div>
			    <div class="row col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Count</th><th>Mean</th><th>Median</th>
                  </tr>
                </thead>
                      <tbody name="staticBody" id="id_staticBody">
                </tbody>
            </table>
    				<table id="sortedTable" class="table table-striped">
    				    <thead>
    					<tr>
    					    <th name="sortedHeader" id="id_sortedHeader"></th>
    					</tr>
    				    </thead>
    				    <tbody name="sortedTbody" id="id_sortedTbody">
    				    </tbody>
    				</table>
			    </div>
			    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				<div class="row">
				    <h3 class="description" style="color: black;">
					<p><strong>Select your grouping type:</strong></p>
				    </h3>
				</div>
				<div class="row">
				    <select class="selectpicker" name="cutoffType" id="id_cutoffType" data-width="100%" data-style="btn-info" onchange="setMedian()">
					<option value="-1" selected>Select a type</option>
					<option value="0">Divide group in half</option>
					<option value="1">Divide group by cutoff value</option>
				    </select>
				</div>
				<div class="row">
				    <div class="form-group">
					<div class="form-inline">
					    <label class="control-label" for="id_cutoff"><h3 style="color:black">Cutoff value =</h3></label>
					    <input class="form-control"; type="number" name="cutoff" id="id_cutoff" </input>
					</div>
				    </div>
				</div>
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen3to4()">Divide</button>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(2)">Previous</button>
				</div>
			    </div>
			</div>
			<!--Tab Four-->
			<div role="tabpanel" class="tab-pane" id="screen4">
			    <div class="row">
				<ul class="breadcrumbList">
				    <li><a href="#" class="ivcListClass" name="ivcList" id="id_ivcList" class="disableLink"></a></li>
				    <li><a href="#" class="ivListClass" name="ivList" id="id_ivList" class="disableLink"></a></li>
				    <li><a href="#" class="cutoffListClass" name="cutoffList" id="id_cutoffList" class="disableLink"></a></li>
				</ul>
			    </div>
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h3 class="description" style="color: black;">
					<p><strong>Select your dependent variable:</strong></p>
				    </h3>
				    <h4>
					<strong>Note: </strong>The <strong>dependent variable</strong> is the <strong>“effect”</strong> you want to analyze.
				    </h4>
				</div>
			    </div>
			    <div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen4to5(0)">Mental Performance</button>
				</div>
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen4to5(1)">Physical Performance</button>
				</div>
				<div class="row">
				    <button type="button" class="btn btn-primary btn-lg" onClick="screen4to5(2)">Emotional State</button>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(3)">Previous</button>
				</div>
			    </div>
			</div>
			<!--Tab Five-->
			<div role="tabpanel" class="tab-pane" id="screen5">
			    <div class="row">
				<ul class="breadcrumbList">
				    <li><a href="#" class="ivcListClass" name="ivcList" id="id_ivcList" class="disableLink"></a></li>
				    <li><a href="#" class="ivListClass" name="ivList" id="id_ivList" class="disableLink"></a></li>
				    <li><a href="#" class="cutoffListClass" name="cutoffList" id="id_cutoffList" class="disableLink"></a></li>
				    <li><a href="#" class="dvcListClass" name="dvcList" id="id_dvcList" class="disableLink"></a></li>
				</ul>
			    </div>
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h3 class="description" style="color: black;">
					<p><strong>Select how you will measure the dependent variable:</strong></p>
					<p><strong>Note: </strong>Scientists call the effect the “dependent variable.”</p>
				    </h3>
				</div>
			    </div>
			    <div name="mp" id="id_mp" style="display: none">
				<div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(0)">Average Attention Rating (Activity Diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(1)">Reaction score</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(2)">Memory task score</button>
				    </div>
				</div>
			    </div>
			    <div name="pp" id="id_pp" style="display: none">
				<div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(3)">Average Minutes of Exercise (Activity Diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(4)">Average Number of Physical symptoms (Activity Diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(5)">Average Sleepiness rating (Activity Diary)</button>
				    </div>
				</div>
			    </div>
			    <div name="es" id="id_es" style="display: none">
				<div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(6)">Average Mood Rating (Activity Diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(7)">Average Behavior Rating (Activity Diary)</button>
				    </div>
				    <div class="row">
					<button type="button" class="btn btn-primary btn-lg" onClick="screen5to6(8)">Average Interactions Rating  (Activity Diary)</button>
				    </div>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(4)">Previous</button>
				</div>
			    </div>
			</div>
			<!--Tab Six-->
      <div role="tabpanel" class="tab-pane" id="screen6">
			    <div class="row">
    				<ul class="breadcrumbList">
    				    <li><a href="#" class="ivcListClass" name="ivcList" id="id_ivcList" class="disableLink"></a></li>
    				    <li><a href="#" class="ivListClass" name="ivList" id="id_ivList" class="disableLink"></a></li>
    				    <li><a href="#" class="cutoffListClass" name="cutoffList" id="id_cutoffList" class="disableLink"></a></li>
    				    <li><a href="#" class="dvcListClass" name="dvcList" id="id_dvcList" class="disableLink"></a></li>
    				    <li><a href="#" class="dvListClass" name="dvList" id="id_dvList" class="disableLink"></a></li>
    				</ul>
			    </div>
          <!-- Nav tabs -->
          <div>
            <!-- <ul class="nav nav-justified nav-pills nav-pills-warning" role="tablist"> -->
            <div class="row">
              <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10"  style="margin-top: 2em;">
                <h3 class="description" style="color: black;">
                    <p><strong>Please select a graph type or data to analyze</strong></p>
                </h3>
        				<ul id="cards_group" class="nav nav-justified nav-pills nav-pills-info" role="tablist">
        				    <li role="presentation" class="active"><a href="#card1" aria-controls="card1" role="tab" data-toggle="tab">Bar</a></li>
        				    <li role="presentation"><a href="#card2" aria-controls="card2" role="tab" data-toggle="tab">Pie</a></li>
        				    <li role="presentation"><a href="#card3" aria-controls="card3" role="tab" data-toggle="tab">Line</a></li>
        				    <li role="presentation"><a href="#card4" aria-controls="card4" role="tab" data-toggle="tab">Histogram</a></li>
        				    <li role="presentation"><a href="#card5" aria-controls="card5" role="tab" data-toggle="tab">Scatter</a></li>
        				    <li role="presentation"><a href="#card6" aria-controls="card6" role="tab" data-toggle="tab">Data</a></li>
        				</ul>
              </div>
            </div>
  		    </div>
  		    <div class="tab-content" style="margin-top: 2em;">
  			      <!-- Card One -->
              <div role="tabpanel" class="tab-pane active" id="card1">
                <!-- Data Tabel -->
                <div class="row col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                  <table class="table table-bordered">
                      <thead id="id_resultTalbeHead">

                      </thead>
                      <tbody id="id_resultTalbeBody">

                      </tbody>
                  </table>
                </div>
                <!-- Bar Graph -->
                <div class="row col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
                      <div name="bar_graph" id="id_bar_graph" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
                </div>

                <!-- Intruction -->
                <div class="row">
          				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
          				    <h3 class="description" style="color: black;">
          					<p><strong>Download Chart: </strong></p>
          					<ol>
          					    <li>Click "Download (upper-right corner of the chart)"</li>
          					    <li>Click "Download PNG image"</li>
          					</ol>
          				    </h3>
          				</div>
      			    </div>
  			     </div>
  			     <!-- Card One End -->

               <!-- Card Two -->
               <div role="tabpanel" class="tab-pane" id="card2">

                 <!-- Data Tabel -->
                 <div class="row col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                   <table class="table table-bordered">
                       <thead id="id_pieTableHead">

                       </thead>
                       <tbody id="id_pieTableBody">

                       </tbody>
                   </table>
                 </div>
                 <!-- Bar Graph -->
                 <div class="row col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
       				        <div name="pie_graph" id="id_pie_graph" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
       			    </div>
                <!-- Intruction -->
                <div class="row">
                  <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                      <h3 class="description" style="color: black;">
                    <p><strong>Download Chart: </strong></p>
                    <ol>
                        <li>Click "Download (upper-right corner of the chart)"</li>
                        <li>Click "Download PNG image"</li>
                    </ol>
                      </h3>
                  </div>
                </div>
              </div>
              <!-- Card Two End -->

              <!-- Card Three -->
              <div role="tabpanel" class="tab-pane" id="card3">

                <!-- Bar Graph -->
                <div class="row col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
                     <div name="line_graph" id="id_line_graph" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
               </div>
               <!-- Intruction -->
               <div class="row">
                 <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                     <h3 class="description" style="color: black;">
                   <p><strong>Download Chart: </strong></p>
                   <ol>
                       <li>Click "Download (upper-right corner of the chart)"</li>
                       <li>Click "Download PNG image"</li>
                   </ol>
                     </h3>
                 </div>
               </div>

             </div>
             <!-- Card Three End -->

             <!-- Card Four -->
             <div role="tabpanel" class="tab-pane" id="card4">

               <!-- Bar Graph -->
               <div class="row col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
                    <div name="Histogram_graph1" id="id_histogram_graph1" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
              </div>
              <!-- Intruction -->
              <div class="row">
                <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                    <h3 class="description" style="color: black;">
                  <p><strong>Download Chart: </strong></p>
                  <ol>
                      <li>Click "Download (upper-right corner of the chart)"</li>
                      <li>Click "Download PNG image"</li>
                  </ol>
                    </h3>
                </div>
              </div>

            </div>
            <!-- Card Four End -->


              <!-- Card Five -->
              <div role="tabpanel" class="tab-pane" id="card5">
                <!-- Bar Graph -->
                <div class="row col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
                     <div name="scatter_graph" id="id_scatter_graph" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
               </div>
               <!-- Intruction -->
               <div class="row">
                 <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                     <h3 class="description" style="color: black;">
                   <p><strong>Download Chart: </strong></p>
                   <ol>
                       <li>Click "Download (upper-right corner of the chart)"</li>
                       <li>Click "Download PNG image"</li>
                   </ol>
                     </h3>
                 </div>
               </div>
              </div>
              <!-- Card Five End -->
             <!-- Card Six -->
             <div role="tabpanel" class="tab-pane" id="card6">

               <div class="row col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                 <table class="table table-bordered">
                     <thead id="id_dataTableHead">

                     </thead>
                     <tbody id="id_dataTableBody">

                     </tbody>
                 </table>
               </div>

            </div>
            <!-- Card Six End -->


          <span class="row col-xs-offset-2 col-xs-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" id="id_legend">
			    </span>

			    <div class="row col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				        <button type="button" class="btn btn-danger btn-lg" onClick="analyzeMore()">Analyze another variable</button>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
    				<div class="previous">
    				    <button type="button" class="btn btn-default btn-lg" onClick="previous(5)">Previous</button>
    				</div>
			    </div>
			</div>
			<!-- Tab End -->
		    </div>
		</div>
	    </div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="wrong" role="dialog" data-modal-index="1" data-backdrop="static" data-keyboard="false" aria-labelledby="wrong">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4></h4>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
		    </div>
		</div>
	    </div>
	</div>
	<div id="alert" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Alert</h4>
		    </div>
		    <div class="modal-body">
			<p id="alertMessage"></p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="confirm" role="dialog" data-modal-index="1" aria-labelledby="submitLabel">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			Are you sure?
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Yes</button>
			<button type="button" class="btn btn-success btn-simple" data-dismiss="modal">No</button>
		    </div>
		</div>
	    </div>
	</div>
	<!-- End Modals -->
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script src="./assets/js/math.min.js" type="text/javascript"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/histogram-bellcurve.js"></script>
	<script>
	 var dataArray = <?php echo json_encode($dataArray); ?>;
   console.log(dataArray);
	 dataArray = transpose(dataArray); //Transpose 2D array Column: Subject Row: Variables

	 var dataArrayCopy;
	 dataArrayCopy = <?php echo json_encode($dataArray); ?>;
	 dataArrayCopy = transpose(dataArrayCopy); //Transpose 2D array Column: Subject Row: Variables
	 console.log(dataArrayCopy);
	 var idvcSelect; // Selected Independent Variable Category
	 var idvSelect; // Selected Independent Variable
	 var cutoffSelect; //Selected Cutoff Type
	 var dvcSelect; // Selected Dependent Variable Category
	 var dvSelect; // Selected Dependent Variable
   var idvIndex;
   var dvIndex;

   var groupALegendArray = ["More Sleep Time","More Sleep Time","Less Consistency","Less Consistency","High Sleep Quality","Good Wake Up State","More Awakenings","High Sleep Quality"];
   var groupBLegendArray = ["Less Sleep Time","Less Sleep Time","More Consistency","More Consistency","Low Sleep Quality","Poor Wake Up State","Less Awakenings","Low Sleep Quality"];

	 var idvcArray = ["Sleep Duration", "Sleep Consistency", "Sleep Quality"];
	 var idvArray = ["Average Total Sleep Time Reported in the Sleep Diary (min)", "Average Total Sleep Time Recorded by the Sleep Watch (min)", "Average Difference between  shortest and longest sleep time (Sleep watch) (min)", "Average Difference between earliest and latest bedtimes (sleep watch) (min)", "Average sleep quality rating (sleep diary)", "Average wake up state  (sleep diary)", "Average # Awakenings (sleep watch)", "Average sleep quality percent (sleep watch)"];
	 var cutoffArray = ["Divide group in half", "Inputed Cutoff"];
	 var dvcArray = ["Mental Performance", "Physical Performance", "Emotional State"];
	 var dvArray = ["Average Attention Rating (Activity Diary)", "Reaction score (ms)", "Memory task score", "Average Minutes of Exercise (Activity Diary)", "Average Number of Physical symptoms (Activity Diary)", "Average Sleepiness rating (Activity Diary)", "Average Mood Rating (Activity Diary)", "Average Behavior Rating (Activity Diary)", "Average Interactions Rating  (Activity Diary)"];

	 var tmpidvArray;
	 var median;
	 var cutoffValue;

	 var groupA = [];
	 var groupB = [];

	 var averageA;
	 var averageB;

	 function transpose(matrix){
	     return matrix[0].map((col, i) => matrix.map(row => row[i])); //Transpose 2D array
	 }

	 function getCol(matrix, col){
	     var column = [];
	     for(var i=0; i<matrix.length; i++){
		 column.push(matrix[i][col]);
	     }
	     return column;
	 }
   function mergeCol(col1, col2){
	     var column = [];
	     for(var i=0; i<col1.length; i++){
		       column.push([col1[i] ,col2[i]]);
	     }
	     return column;
	 }

	 function updateList(){
	     //Update breadcrumb list
	     $('.ivcListClass').map(function() {
		 $(this).text(idvcArray[idvcSelect]);
	     });
	     $('.ivListClass').map(function() {
		 $(this).text(idvArray[idvSelect]);
	     });
	     $('.cutoffListClass').map(function() {
		 $(this).text(cutoffArray[cutoffSelect]);
	     });
	     $('.dvcListClass').map(function() {
		 $(this).text(dvcArray[dvcSelect]);
	     });
	     $('.dvListClass').map(function() {
		 $(this).text(dvArray[dvSelect]);
	     });
	 }

	 function replace0(array, mean){
	     var newArray = [];
	     for (var t=0; t<array.length; t++){
		 if(array[t] == 0){
		     newArray[t] = Number(mean);
		 }else{
		     newArray[t] = array[t];
		 }
	     }
	     return newArray;
	 }

	 var graphChart;
   var groupAString;
   var groupBString;

   function updateLegend(){
     groupAString = groupALegendArray[idvSelect];
     groupBString = groupBLegendArray[idvSelect];
   }


   function reloadChart(meanA, meanB){
   	     meanA = Number(meanA);
   	     meanB = Number(meanB);
   	     var lower = math.min(meanA,meanB)-math.abs(meanA-meanB)/2;
          lower = math.max(lower,0);
          console.log(lower);
   	     var upper = math.max(meanA,meanB)+math.abs(meanA-meanB)/2;
   	     var meanAArray = [meanA];
   	     var meanBArray = [meanB];
   	     //console.log(meanAArray);
   	     //console.log(meanBArray);
   	     graphChart = new Highcharts.Chart('id_bar_graph', {
   		 chart: {
   		     type: 'column',
   		     height: 600
   		 },

   		 title: {
			text: idvArray[idvSelect]+' by Group (Cutoff='+parseFloat(cutoffValue).toFixed(2)+')',
            // text: 'The Comparison Between '+groupAString+' Group and '+groupBString+' Group on the '+ idvArray[idvSelect] + ' cutoff is ' + parseFloat(cutoffValue).toFixed(2),
            y: 30
   		 },

   		 xAxis: {
   		     categories: [
   			 " "
        ],//idvArray[idvSelect]
   		     crosshair: true
   		 },
   		 yAxis:{
   		     min: 0,//lower,
   		     max: upper,
   		     title: {
   			 text: dvArray[dvSelect]
   		     }
   		 },

   		 plotOptions: {
   		     column: {
   			 dataLabels: {
   			     enabled: true
   			 }
   		     }
   		 },

   		 legend: {
   		     layout: 'vertical',
   		     align: 'right',
   		     verticalAlign: 'top',
   		     x: 0,
   		     y: 100,
   		     floating: true,
   		     borderWidth: 1,
   		     backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
   		     shadow: true
   		 },

   		 series: [{
   		     name: groupAString,
            color: 'rgba(223, 83, 83, .5)',
   		     data: meanAArray
   		 },{
   		     name: groupBString,
            color: 'rgba(119, 152, 191, .5)',
   		     data: meanBArray
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
       			     x: -5,
       			     y: -10
       			 }
   		     }
   		 }
   	     });

   	 }
   function reloadPieChart(countA, countB){
   	     countA = Number(countA);
   	     countB = Number(countB);
   	     graphChart = new Highcharts.Chart('id_pie_graph', {
       		 chart: {
       		     type: 'pie',
       		     height: 600
       		 },
       		 title: {
				text: idvArray[idvSelect]+' by Group (Cutoff='+parseFloat(cutoffValue).toFixed(2)+')',
       		    //  text: 'The Count Number of '+groupAString+' Group and '+groupBString+' Group on the '+ idvArray[idvSelect] + ' cutoff is ' + parseFloat(cutoffValue).toFixed(2),
       		     y: 30
       		 },
            tooltip: {
               pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },

            plotOptions: {
               pie: {
                   allowPointSelect: true,
                   cursor: 'pointer',
                   dataLabels: {
                       enabled: true,
                       format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                       style: {
                           color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                       }
                   }
               }
           },
        series: [{
           name: 'Group',
           colorByPoint: true,
           data: [{
               name: groupAString,
               color: 'rgba(223, 83, 83, .5)',
               y: countA,
               sliced: true,
               selected: true
           }, {
               name: groupBString,
               color: 'rgba(119, 152, 191, .5)',
               y: countB
           }]
       }],
   		 exporting: {
   		     buttons: {
       			 contextButton: {
                height: 80,
                width: 100,
       			     symbol: 'menu',
       			     symbolStrokeWidth: 1,
       			     symbolFill: '#a4edba',
       			     symbolStroke: '#330033',
       			     text: 'Download',
       			     fontSize: "122px",
       			     align: 'right',
       			     x: -5,
       			     y: -10
       			 }
   		     }
   		 }
   	     });
  }
   function reloadLineChart(dA, dB){
   	     graphChart = new Highcharts.Chart('id_line_graph', {
       		 chart: {
       		     type: 'areaspline',
       		     height: 600
       		 },
       		 title: {
				text: idvArray[idvSelect]+' by Group (Cutoff='+parseFloat(cutoffValue).toFixed(2)+')',
       		    //  text: 'The Trend Comparison Between '+groupAString+' Group and '+groupBString+' Group on the '+ idvArray[idvSelect] + ' cutoff is ' + parseFloat(cutoffValue).toFixed(2),
       		     y: 30
       		 },
            legend: {
       		     layout: 'vertical',
       		     align: 'right',
       		     verticalAlign: 'top',
       		     x: 0,
       		     y: 100,
       		     floating: true,
       		     borderWidth: 1,
       		     backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
       		     shadow: true
       		 },
            tooltip: {
              shared:true
            },

            plotOptions: {
               areaspline:{
                 fillOpacity: 0.5
               }
           },
           yAxis: {
             title: {
               text: dvArray[dvSelect]
             }
           },
        series: [{
           name: groupAString + ' Group',
           color: 'rgba(223, 83, 83, .5)',
           data: dA
         },{
           name: groupBString + ' Group',
           color: 'rgba(119, 152, 191, .5)',
           data: dB
         }
       ],
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
       			     x: -5,
       			     y: -10
       			 }
   		     }
   		 }
   	     });
   }
   function reloadHistogram1Chart(independentVars){
        Highcharts.chart('id_histogram_graph1', {
          chart: {
          		     height: 600
          	},
           title: {
     		     text: 'The Histogram on the '+ dvArray[dvSelect],
     		     y: 30
     		 },
           xAxis: [{
               title: { text: idvArray[dvSelect]+' Data' },
               alignTicks: false,
               opposite: true
           }, {
               title: { text: idvArray[dvSelect]+' Histogram' },
               alignTicks: false,
               opposite: false
           }],

           yAxis: [{
               title: { text: 'Data' },
               opposite: true
           }, {
               title: { text: 'Histogram' },
               opposite: false
           }],

           series: [{
               name: 'Histogram',
               type: 'histogram',
               xAxis: 1,
               yAxis: 1,
               baseSeries: 's1',
               color: 'rgba(119, 152, 191, .5)',
               zIndex: -1
           }, {
               name: 'Data',
               type: 'scatter',
               data: independentVars,
               id: 's1',
               color: 'rgba(223, 83, 83, .5)',
               marker: {
                   radius: 1.5
               }
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
           			     x: -5,
           			     y: -10
           			 }
       		     }
       		 }
       });
   	}
   function reloadScatterChart(indA, dA, indB, dB){
        graphChart = new Highcharts.Chart('id_scatter_graph', {
              chart: {
               type: 'scatter',
               zoomType: 'xy',
               height: 600
           },
           title: {
			text: idvArray[idvSelect]+' by Group (Cutoff='+parseFloat(cutoffValue).toFixed(2)+')',
            //    text: 'The Comparison Between '+groupAString+' Group and '+groupBString+' Group on the '+ idvArray[idvSelect] + ' cutoff is ' + parseFloat(cutoffValue).toFixed(2),
           },
           xAxis: {
               title: {
                   enabled: true,
                   text: idvArray[idvSelect]
               },
               startOnTick: true,
               endOnTick: true,
               showLastLabel: true
           },
           yAxis: {
               title: {
                   text: dvArray[dvSelect]
               }
           },
           legend: {
               layout: 'vertical',
               align: 'left',
               verticalAlign: 'top',
               x: 100,
               y: 70,
               floating: true,
               backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
               borderWidth: 1
           },
           plotOptions: {
               scatter: {
                   marker: {
                       radius: 5,
                       states: {
                           hover: {
                               enabled: true,
                               lineColor: 'rgb(100,100,100)'
                           }
                       }
                   },
                   states: {
                       hover: {
                           marker: {
                               enabled: false
                           }
                       }
                   },
               }
           },
           series: [{
               name: groupAString + ' Group',
               color: 'rgba(223, 83, 83, .5)',
               data: mergeCol(indA, dA)

           }, {
               name: groupBString + ' Group',
               color: 'rgba(119, 152, 191, .5)',
               data: mergeCol(indB, dB)
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
                     x: -5,
                     y: -10
                 }
               }
           }
       });
      }


	 function screen1to2(idvc){
	     idvcSelect = idvc;
	     switch (idvc){
		 case 0:
		     $('#id_sd').show();
		     break;
		 case 1:
		     $('#id_sc').show();
		     break;
		 case 2:
		     $('#id_sq').show();
		     break;
	     }
	     updateList();
	     $('#group a[href="#screen2"]').tab('show');
	 }
	 function screen2to3(idv){
	     idvSelect = idv;
       var titleText;
	     switch (idv){
    		 case 0: //0 Average Total Sleep Time Reported in the Sleep Diary (Sleep Diary)
    		     idvIndex = 0;
             titleText = "Average Total Sleep Time Reported in the Sleep Diary (Sleep Diary) (min)";
    		     break;
    		 case 1: //12 Average Total Sleep Time Recorded by the Sleep Watch  (Sleep Watch)
    		     idvIndex = 12;
             titleText = "Average Total Sleep Time Recorded by the Sleep Watch  (Sleep Watch) (min)";
    		     break;
    		 case 2: //10 Difference between  shortest and longest sleep time (Sleep watch)
    		     idvIndex = 11;
             titleText = "Difference between  shortest and longest sleep time (Sleep watch) (min)";
    		     break;
    		 case 3: //11 Difference between earliest and latest bedtimes (sleep watch)
    		     idvIndex = 10;
             titleText = "Difference between earliest and latest bedtimes (sleep watch) (min)";
    		     break;
    		 case 4: //1 Average sleep quality rating (sleep diary)
    		     idvIndex = 1;
             titleText = "Average sleep quality rating (sleep diary)";
    		     break;
    		 case 5: //2 Average wake up state  (sleep diary)
    		     idvIndex = 2;
             titleText = "Average wake up state  (sleep diary)";
    		     break;
    		 case 6: //15 Average # Awakenings (sleep watch)
    		     idvIndex = 15;
             titleText = "Average # Awakenings (sleep watch)";
    		     break;
    		 case 7: //14 Average sleep quality rating (sleep watch)
    		     idvIndex = 14;
             titleText = "Average sleep quality rating (sleep watch)";
    		     break;
  	     }

         tmpidvArray = math.sort(dataArray[idvIndex]);
         fillTable(tmpidvArray, titleText);
         setIndependStatisTabel(tmpidvArray)
         median = math.median(tmpidvArray);

	     $("#id_cutoff").prop("disabled", true);
	     $("#id_cutoff").val("");
	     $('#id_cutoffType').val(-1);
	     $('.selectpicker').selectpicker('refresh');
	     updateList();
	     $('#group a[href="#screen3"]').tab('show');
	 }
   function setIndependStatisTabel(dataArray){
        median = math.median(dataArray);
        mean = math.mean(dataArray);
        count = dataArray.length;

        $("#id_staticBody").empty();
        var tbody = "";
        tbody += "<tr><td>";
        tbody += count;
        tbody += "</td><td>";
        tbody += mean.toFixed(2);
        tbody += "</td><td>";
        tbody += median;
        tbody += "</td></tr>"
        $("#id_staticBody").append(tbody);
   }
	 function fillTable(stock, variable){
	     $("#id_sortedTbody").empty();
	     $("#id_sortedHeader").html(variable);
	     var tbody = "";
	     for (i = 0; i < stock.length; i++) {
		 tbody += "<tr><td>";
		 tbody += stock[i];
		 tbody += "</tr></td>";
	     }
	     $("#id_sortedHead").text(variable);
	     $("#id_sortedTbody").append(tbody);
	 }
	 function setMedian(){
	     //console.log($('#id_cutoffType').val());
	     if($('#id_cutoffType').val() == 0){
		 $("#id_cutoff").val(median);
		 //console.log(median);
	     }else if($('#id_cutoffType').val() == 1){
		 $("#id_cutoff").prop( "disabled", false);
	     }
	 }

	 function screen3to4(){ //Divide to two groups
	     if($("#id_cutoff").val()==""){
		 $("#alertMessage").text("Please input a cutoff value");
		 $("#alert").modal('show');
		 return false;
	     }
	     cutoffValue = $("#id_cutoff").val();
	     //console.log(cutoffValue);
	     cutoffSelect = $("#id_cutoffType").val();
	     var tmpArraySave;
	     var ia = 0;
	     var ib = 0;
	     var i;
	     for(i=0; i<tmpidvArray.length; i++){
		 //console.log(tmpArray[i]);
		 //console.log(Number(tmpidvArray[i]));
		 if(Number(dataArrayCopy[idvIndex][i]) >= cutoffValue){
		     tmpArraySave = getCol(dataArrayCopy, i);
		     //console.log(tmpArraySave);
		     groupA[ia] = tmpArraySave;
		     //console.log(groupA);
		     ia++;
		 }else{
		     tmpArraySave = getCol(dataArrayCopy, i);
		     groupB[ib] = tmpArraySave;
		     ib++;
		 }
	     }

	     //2D array Column: Variable Row: Subject
	     console.log(groupA);
	     console.log(groupB);
	     //Make sure arrays are not empty
	     var initialArray = Array.from(Array(tmpArraySave.length), () => 0);
	     if (groupA.length <=0 ) {
		 groupA[0] = initialArray;
	     }
	     if (groupB.length <= 0) {
		 groupB[0] = initialArray;
	     }
	     updateList();
	     $('#group a[href="#screen4"]').tab('show');
	 }

	 function screen4to5(dvc){
	     dvcSelect = dvc;
	     switch (dvc){
		 case 0:
		     $('#id_mp').show();
		     break;
		 case 1:
		     $('#id_pp').show();
		     break;
		 case 2:
		     $('#id_es').show();
		     break;
	     }
	     updateList();
	     $('#group a[href="#screen5"]').tab('show');
	 }
	 /*0Average Total Sleep Time, 1Average Sleep Quality, 2Average Wokeup State, 3Average Attention, 4Average Exercised Time, 5Average Sleepiness, 6Average Symptoms, 7Average Mood, 8Average Behavior, 9Average Interaction, 10Difference between  shortest and longest sleep time, 11Difference between earliest and latest bedtimes, 12Average Totoal Sleep Time, 13Average time to fall asleep, 14Average sleep quality rating, 15Average Awakenings, 16Reaction, 17Memory */
	 function screen5to6(dv){
	     dvSelect = dv;
	     var averageAArray;
	     var averageBArray;
	     var copyAverageAArray;
	     var copyAverageBArray;
	     var averageAArrayReplaced;
	     var averageBArrayReplaced;
	     var concated;
	     var averageConcat;
       updateLegend();
	     switch (dv){
    		 case 0: //3 Average Attention Rating  (Activity Diary)
    		     averageAArray = getCol(groupA, 3);
    		     averageBArray = getCol(groupB, 3);
             dvIndex = 3;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Attentiveness Ratings: (1) couldn’t focus, (2) focus occasionally, (3) focus about half of the time, (4) focus most of the day, (5) focus all day");
    		     break;
    		 case 1: //16 Reaction score
    		     averageAArray = getCol(groupA, 16);
    		     averageBArray = getCol(groupB, 16);
             dvIndex = 16;
    		     copyAverageAArray = getCol(groupA, 16);
    		     copyAverageBArray = getCol(groupB, 16);
    		     concated = averageAArray.filter(x => x).concat(averageBArray.filter(x => x));
    		     averageConcat = math.mean(concated).toFixed(2);
    		     averageAArrayReplaced = replace0(copyAverageAArray,  averageConcat);
    		     averageBArrayReplaced = replace0(copyAverageBArray,  averageConcat);
    		     console.log(copyAverageAArray);
    		     console.log(averageAArrayReplaced);
    		     //console.log(concated);
    		     averageA = math.mean(averageAArrayReplaced).toFixed(2);
    		     averageB = math.mean(averageBArrayReplaced).toFixed(2);
    		     //console.log(averageAArray.filter(x => x));
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Reaction Score = Average Response Time");
    		     break;
    		 case 2: //17 Memory task score
    		     averageAArray = getCol(groupA, 17);
    		     averageBArray = getCol(groupB, 17);
             dvIndex = 17;
    		     copyAverageAArray = getCol(groupA, 17);
    		     copyAverageBArray = getCol(groupB, 17);
    		     concated = averageAArray.filter(x => x).concat(averageBArray.filter(x => x));
    		     averageConcat = math.mean(concated).toFixed(2);
    		     averageAArrayReplaced = replace0(copyAverageAArray,  averageConcat);
    		     averageBArrayReplaced = replace0(copyAverageBArray,  averageConcat);
    		     console.log(copyAverageAArray);
    		     console.log(averageAArrayReplaced);
    		     //console.log(concated);
    		     averageA = math.mean(averageAArrayReplaced).toFixed(2);
    		     averageB = math.mean(averageBArrayReplaced).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Memory Score = number of correct responses / number of responses");
    		     break;
    		 case 3: //4 Minutes of Exercise (Activity Diary)
    		     averageAArray = getCol(groupA, 4);
    		     averageBArray = getCol(groupB, 4);
             dvIndex = 4;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     break;
    		 case 4: //6 Physical symptoms (Activity Diary)
    		     averageAArray = getCol(groupA, 6);
    		     averageBArray = getCol(groupB, 6);
             dvIndex = 6;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Number of physical symptoms = Total Physical Symptoms/Number of Finished Days");
    		     break;
    		 case 5: //5 Average Sleepiness rating (Activity Diary)
    		     averageAArray = getCol(groupA, 5);
    		     averageBArray = getCol(groupB, 5);
             dvIndex = 5;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Sleepiness Ratings: (1) Very Sleepy, (2) Sleepy, (3) Somewhat Sleepy, (4) Not Sleepy");
    		     break;
    		 case 6: //7 Average Mood Rating (Activity Diary)
    		     averageAArray = getCol(groupA, 7);
    		     averageBArray = getCol(groupB, 7);
             dvIndex = 7;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Mood Ratings: (1) Very Unpleasant, (2) Unpleasant, (3) Sometimes Pleasant, (4) Pleasant, (5) Very Pleasant");
    		     break;
    		 case 7: //8 Average Behavior Rating (Activity Diary)
    		     averageAArray = getCol(groupA, 8);
    		     averageBArray = getCol(groupB, 8);
             dvIndex = 8;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Behavior Ratings: (1) Followed classroom and home rules/never disrupted the activities of others, (2) Mostly followed the classroom rules at home and school/rarely disrupted the activities of others, (3) Sometimes had trouble following the classroom and home rules/occasionally disrupted the activities of others, (4) Had trouble following the classroom and home rules/often disrupted the activities of others");
    		     break;
    		 case 8: //9 Average Interactions Rating  (Activity Diary)
    		     averageAArray = getCol(groupA, 9);
    		     averageBArray = getCol(groupB, 9);
             dvIndex = 9;
    		     averageA = math.mean(averageAArray).toFixed(2);
    		     averageB = math.mean(averageBArray).toFixed(2);
    		     reloadChart(averageA, averageB);
    		     $("#id_legend").text("Interaction Ratings: (1) Excellent, (2) Good, (3) Somewhat Difficult, (4) Challenging");
    		     break;
	     }

       var indA = getCol(groupA,idvIndex);
       var dA = getCol(groupA,dvIndex);
       var indB = getCol(groupB,idvIndex);
       var dB = getCol(groupB,dvIndex);

       //bar
       $("#id_resultTalbeHead").empty();
	     var barHead = "";
	     barHead = "<tr><td></td><td>"+groupAString+"</td><td>"+groupAString+"</td></tr>";
	     $("#id_resultTalbeHead").append(barHead);
	     $("#id_resultTalbeBody").empty();
	     var tbody2 = "";
	     tbody2 = "<tr><td>"+dvArray[dvSelect]+" Average</td><td>"+averageA+"</td><td>"+averageB+"</td></tr>";
	     $("#id_resultTalbeBody").append(tbody2);

       //pie
       $("#id_pieTableHead").empty();
	     var pieHead = "";
	     pieHead = "<tr><td></td><td>"+groupAString+"</td><td>"+groupAString+"</td></tr>";
	     $("#id_pieTableHead").append(pieHead);
	     $("#id_pieTableBody").empty();
	     var pieBody = "";
	     pieBody = "<tr><td>Number of Count</td><td>"+groupA.length+"</td><td>"+groupB.length+"</td></tr>";
	     $("#id_pieTableBody").append(pieBody);
       reloadPieChart(groupA.length, groupB.length);

       //line
       reloadLineChart(dA, dB);
       //histogram
       reloadHistogram1Chart(dataArray[dvIndex]);
       //Scatter
       reloadScatterChart(indA, dA, indB, dB);

       //data
       $("#id_dataTableHead").empty();
	     var dataHead = "";
	     dataHead = "<tr><td></td><td>"+idvArray[idvSelect]+"</td><td>"+dvArray[dvSelect]+"</td></tr>";
	     $("#id_dataTableHead").append(dataHead);
	     $("#id_dataTableBody").empty();
       var dataBody = "<tr><td colspan=3 bgcolor=#EFAAAA>" + groupBString + " Group</td></tr>";
       for (var i = 0; i < groupB.length; i++) {
           dataBody += "<tr><td>" + (i+1) + "</td><td>" + indB[i] + "</td><td>" + dB[i] + "</td></tr>";
       }
	     dataBody += "<tr><td colspan=3 bgcolor=#BBCCDF>"+groupAString+" Group</td></tr>";
       for (var i = 0; i < groupA.length; i++) {
           dataBody += "<tr><td>" + (i+1) + "</td><td>" + indA[i] + "</td><td>" + dA[i] + "</td></tr>";
       }
       $("#id_dataTableBody").append(dataBody);
       //
	     // $("#id_resultTalbeBody").empty();
	     // var tbody2 = "";
	     // tbody2 = "<tr><td>"+dvArray[dvSelect]+" Average</td><td>"+averageA+"</td><td>"+averageB+"</td><tr>";
	     // $("#id_resultTalbeBody").append(tbody2);
	     updateList();
	     $('#group a[href="#screen6"]').tab('show');
	 }
	 function analyzeMore(){
	     idvcSelect = null;
	     idvSelect = null;
	     cutoffSelect = null;
	     cutoffValue = null;
	     dvcSelect = null;
	     dvSelect = null;
	     idvIndex = null;
	     groupA = [];
	     groupB = [];
	     $('#id_sd').hide();
	     $('#id_sc').hide();
	     $('#id_sq').hide();
	     $('#id_mp').hide();
	     $('#id_pp').hide();
	     $('#id_es').hide();
	     $('body').scrollTop(0);
	     $('html').scrollTop(0);
	     $('#group a[href="#screen1"]').tab('show');
	 }

	 function previous(screen){
	     switch(screen){
		 case 1:
		     idvcSelect = null;
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#id_sd').hide();
		     $('#id_sc').hide();
		     $('#id_sq').hide();
		     $('#group a[href="#screen1"]').tab('show');
		     break;
		 case 2:
		     idvSelect = null;
		     idvIndex = null;
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen2"]').tab('show');
		     break;
		 case 3:
		     cutoffSelect = null;
		     cutoffValue = null;
		     groupA = [];
		     groupB = [];
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen3"]').tab('show');
		     break;
		 case 4:
		     dvcSelect = null;
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#id_mp').hide();
		     $('#id_pp').hide();
		     $('#id_es').hide();
		     $('#group a[href="#screen4"]').tab('show');
		     break;
		 case 5:
		     dvSelect = null;
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen5"]').tab('show');
		     break;
	     }
	 }
	</script>
    </body>
</html>
