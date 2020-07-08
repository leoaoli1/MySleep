<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
require_once('utilities-diary.php');
require_once('diary-data.php');
require_once('sleep-diary-data-table.php');
require_once('activity-diary-data-table.php');
session_start();
$userId= $_POST['id'];


$dailyTable = "";
if(isset($_POST['id'])){
    include 'connectdb.php';
    $studentId = $_POST['id'];
    $currentGrade = getGrade($studentId);
    $includeUnsubmitted = false;
    list($startingDiaryEntryDate, $endingDiaryEntryDate) = getDiarySelection($studentId, $currentGrade);
    $diarySleep = "";
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
    $queryCommandSleep = "SELECT * FROM diary_data_table WHERE userId='$userId' AND diaryGrade = '$currentGrade'" . $queryOptionsDiary . " ORDER BY diaryDate";
    $resultsSleepDiaryToShow = mysql_query($queryCommandSleep);
   // Get Summary Table Data
    if(mysql_num_rows($resultsSleepDiaryToShow)>0) {

      while ($rowSleepDiaryToShow = mysql_fetch_array($resultsSleepDiaryToShow)) {
        $diarySleep .= "<tr><td>" . getDisplayDate($rowSleepDiaryToShow['diaryDate']) . "</td>";
        $diarySleep .= appendCommonDataSleep($rowSleepDiaryToShow);
        $diarySleep .= "</tr>";
        accumulateSleepData($rowSleepDiaryToShow, $statsSleep);
      }
      computeSleepStats($statsSleep);
    }

    //get activity diary data
    list($startingActivityEntryDate, $endingActivityEntryDate) = getActivitySelection($studentId, $currentGrade);
    $diaryactivity = "";
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
    $queryCommandActivity = "SELECT * FROM activity_diary_data_table WHERE userId='$studentId'  AND diaryGrade = '$currentGrade'" . $queryOptionsActivity . " ORDER BY diaryDate";
    $resultsActivityDiaryToShow = mysql_query($queryCommandActivity);
    $dayCount = 0;
    $symptomCount = 0;
    while ($rowActivityDiaryToShow = mysql_fetch_array($resultsActivityDiaryToShow)) {
      $diaryactivity .= "<tr><td>" . getDisplayDate($rowActivityDiaryToShow['diaryDate']) . "</td>";
      $diaryactivity .= appendCommonDataActivity($rowActivityDiaryToShow, $currentGrade);
      $diaryactivity .= "</tr>";

      accumulateActivityData($rowActivityDiaryToShow, $statsActivity);
      $symptomCount += computeSymptom($rowActivityDiaryToShow);
      $dayCount += 1;
    }
    computeActivityStats($statsActivity);
    $activityStatsData = appendActivityStatsSummaryData($statsActivity,$currentGrade);
    if(!empty($dayCount)){
        $activityStatsData .= "<td>".number_format($symptomCount/$dayCount, 2, '.', ',')."</td>"; //compute for symptoms
    }else{
        $activityStatsData .= "<td></td>";
    }
    echo json_encode(
    	array(
    	    "sleepDiaryTable" => $diarySleep,//$queryCommandSleep,
    	    "sleepStatsTable" => appendSleepStatsSummaryData($statsSleep,$currentGrade),
          "activityDiaryTable" => $diaryactivity,
          "activityStatsTable" => $activityStatsData
    	)
    );
    mysql_close($con);
}

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


function displaySleepCommonData($row, $table, $grade)
{
    echo "<td>" . getDisplayDate($row['diaryDate']) . "</td>";
    if($table=='sleep'){
	displayCommonDataSleep($row);
    }else{
	displayCommonDataActivity($row, $grade);
    }
}

exit;
?>
