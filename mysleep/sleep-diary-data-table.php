<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li, Wo-Tak Wu
#
// This module contains functions for displaying sleep diary data in table or other forms
require_once('utilities.php');
require_once('utilities-diary.php');

// Global arrays for translation
// Translate among enum, descriptor and value in the database
// There are two sections:
//   1. enum in database to some numeric value which users see;
//   2. same numeric value above to some description which users see.
$enumWokeupState = array
(
    'refreshed' => 3,
    'lessRefreshed' => 2,
    'tired' => 1,
    3 => 'Refreshed',
    2 => 'Somewhat Refreshed',
    1 => 'Tired'
);

$enumSleepQuality = array
(
    'veryRestless' => 1,
    'restless' => 2,
    'average' => 3,
    'sound' => 4,
    'verySound' => 5,
    1 => 'Very Restless',
    2 => 'Restless',
    3 => 'Average',
    4 => 'Sound',
    5 => 'Very Sound'
);

$enumSleepCompare = array
(
    'worse' => 1,
    'same' => 2,
    'better' => 3,
    1 => 'Worse',
    2 => 'Same',
    3 => 'Better'
);

$enumRoomDarkness = array
(
	1 => 'Very bright',
	2 => 'Somewhat bright',
	3 => 'Dim',
	4 => 'Mostly dark',
	5 => 'Very dark'
);

$enumRoomQuietness = array
(
	1 => 'Very noisy',
	2 => 'Mostly noisy',
	3 => 'Sometimes noisy/sometimes quiet',
	4 => 'Mostly quiet',
	5 => 'Very quiet'
);

$enumRoomWarmness = array
(
	1 => 'Very uncomfortable (Too hot/cold)',
	2 => 'Somewhat uncomfortable (slightly too warm/chilly)',
	3 => 'Comfortable (just the right temperature)'
);

// Utility and common functions for diary data
function getDisturbances($row)
{
    $count = 0;
    $str = "";
    if ($row['disturbedByNoise'])
    {
        $str .= "Noise";
        $count++;
    }
    if ($row['disturbedBypets'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Pet";
    }
    if ($row['disturbedByElectronics'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Electronics";
    }
    if ($row['disturbedByFamily'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Family";
    }
    if ($row['disturbedByDream'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Dream";
    }
    if ($row['disturbedByBathroomNeed'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Bathroom need";
    }
    if ($row['disturbedByTemperature'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Temperature";
    }
    if ($row['disturbedByIllness'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Illness";
    }
    if ($row['disturbedByBodilyPain'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Bodily pain";
    }
    if ($row['disturbedByUnknown'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Unknown";
    }
    if ($row['disturbedByNothing'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Nothing";
    }
    if ($row['disturbedByWorries'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Worries";
    }
    if ($row['disturbedByBusyMinds'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Busy Minds";
    }
    if ($row['disturbedByLighting'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Lighting";
    }
    if ($row['disturbedByOther'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= $row['disturbedByOtherContent'];
    }
    return $str;
}

function getActivityBeforeSleep($row)
{
    $count = 0;
    $str = "";
    if ($row['actBefSleepTV'])
    {
        $str .= "TV";
        $count++;
    }
    if ($row['actBefSleepMusic'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Music";
    }
    if ($row['actBefSleepVideoGame'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Video game";
    }
    if ($row['actBefSleepComp'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Computer";
    }
    if ($row['actBefSleepRead'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Reading";
    }
    if ($row['actBefSleepHomework'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Homework";
    }
    if ($row['actBefSleepShower'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Shower";
    }
    if ($row['actBefSleepPlayWithPeople'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Play with people";
    }
    if ($row['actBefSleepSnack'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Snack";
    }
    if ($row['actBefSleepText'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Texting";
    }
    if ($row['actBefSleepPhone'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Phoning";
    }
    if ($row['actBefSleepDrinkCaff'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Caffeinated drink";
    }
    if ($row['actBefSleepExercise'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Exercised";
    }
    if ($row['actBefSleepMeal'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Ate a meal";
    }
    if ($row['actBefSleepOther'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= $row['actBefSleepOtherContent'];
    }
    return $str;
}

function displayCommonHeaderSleep($grade)
{
    if(!isset($grade)){
	$grade = 0;
    }
    echo   "<th>Activities Before Sleep_Sleep Diary</th>";
    if($grade == 4 || $grade == 0){
	echo   "<th>Parent Set Bed Time_Sleep Diary</th>";
    }
    echo   "<th>Bed Time_Sleep Diary</th>";
    echo   "<th>Wake Up Time_Sleep Diary</th>";
    echo   "<th>Time It Took to Fall Asleep (min)_Sleep Diary</th>";
    echo   "<th>#Awak._Sleep Diary</th>";
    echo   "<th>Awake Time (min)_Sleep Diary</th>";
    echo   "<th>Total Sleep Time (hours:min)_Sleep Diary</th>";
    echo   "<th>Total Time in Bed (hours:min)_Sleep Diary</th>";
    echo   "<th>Sleep Interrupted By_Sleep Diary</th>";
    if($grade == 4 || $grade == 0){
	echo   "<th>Bedroom Lighting Rating_Sleep Diary</th>";
	echo   "<th>Bedroom Lighting Descriptor_Sleep Diary</th>";
	echo   "<th>Bedroom Noise Rating_Sleep Diary</th>";
	echo   "<th>Bedroom Noise Descriptor_Sleep Diary</th>";
	echo   "<th>Bedroom Temperature Rating_Sleep Diary</th>";
	echo   "<th>Bedroom Temperature Descriptor_Sleep Diary</th>";
	echo   "<th>Wake-up Way_Sleep Diary</th>";
    }
    echo   "<th>Wake-up State Rating_Sleep Diary</th>";
    echo   "<th>Wake-up State Descriptor_Sleep Diary</th>";
    echo   "<th>Sleep Quality<br>(last night) Rating_Sleep Diary</th>";
    echo   "<th>Sleep Quality<br>(last night) Descriptor_Sleep Diary</th>";
    //echo   "<th>Sleep Quality<br>(compared to usual) Rating</th>";
    //echo   "<th>Sleep Quality<br>(compared to usual) Descriptor</th>";

}

// Function to display one row of sleep diary data
function appendCommonDataSleep($row)
{
  $result = "";
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    $diaryGrade= $row['diaryGrade'];
    $result .= "<td>" . getActivityBeforeSleep($row) . "</td>";
    if($diaryGrade == 4 || $diaryGrade == 0){
	if ($row['parentSetBedTime'] == 1){
	    $result .= "<td>Yes</td>";
	}else{
	    $result .= "<td>No</td>";
	}
    }
    $result .= "<td>" . getTimeDisplay($row['timeLightsOff']) . "</td>";
    //$result .= "<td>" . getTimeDisplay($row['timeFellAsleep']) . "</td>";
    $result .= "<td>" . getTimeDisplay($row['timeWakeup']) . "</td>";
    $result .= "<td>" . $row['minFallAsleep'] . "</td>";
    $result .= "<td>" . $row['numWokeup'] . "</td>";
    $result .= "<td>" . $row['minWokeup'] . "</td>";
    $result .= "<td>" . getDisplaySleptHours($row['hourSlept']) . "</td>";
    $result .= "<td>" . gmdate('g:i', abs(strtotime($row['timeWakeup']) + (strtotime('midnight') - strtotime($row['timeLightsOff'])))).  "</td>";
    $result .= "<td>" . getDisturbances($row) . "</td>";
    if($diaryGrade == 4 || $diaryGrade == 0){
    	 if ($row['roomDarkness'] != NULL){
        $result .= "<td>" . $row['roomDarkness'] . "</td><td>" . $enumRoomDarkness[$row['roomDarkness']] . "</td>";
       }else{
        $result .= "<td></td><td></td>";
       }
       if ($row['roomQuietness'] != NULL){
        $result .= "<td>" . $row['roomDarkness'] . "</td><td>" . $enumRoomQuietness[$row['roomQuietness']] . "</td>";
    	 }else{
        $result .= "<td></td><td></td>";
       }
       if ($row['roomDarkness'] != NULL){
        $result .= "<td>" . $row['roomWarmness'] . "</td><td>" . $enumRoomWarmness[$row['roomWarmness']] . "</td>";
    	 }else{
        $result .= "<td></td><td></td>";
	 }
	if ($row['wakeUpWay'] != NULL){
	    if ($row['wakeUpWay'] == 1){
		$result .= "<td>woke up on my own</td>";
	    }else{
		$result .= "<td>Someone else woke me up</td>";
	    }
	}else{
            $result .= "<td></td>";
	}
    }
    if ($row['wokeupState'] != NULL)
        $result .= "<td>" . $enumWokeupState[$row['wokeupState']] . "</td><td>" . $enumWokeupState[$enumWokeupState[$row['wokeupState']]] . "</td>";
    else
        $result .= "<td></td><td></td>";
    if ($row['sleepQuality'] != NULL)
        $result .= "<td>" . $enumSleepQuality[$row['sleepQuality']] . "</td><td>" . $enumSleepQuality[$enumSleepQuality[$row['sleepQuality']]] . "</td>";
    else
        $result .= "<td></td><td></td>";
    /*if ($row['sleepCompare'] != NULL)
        echo "<td>" . $enumSleepCompare[$row['sleepCompare']] . "</td><td>" . $enumSleepCompare[$enumSleepCompare[$row['sleepCompare']]] . "</td>";
    else
        echo "<td></td><td></td>";*/
        return $result;
}

function displayCommonDataSleep($row)
{
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    $diaryGrade= $row['diaryGrade'];
    echo "<td>" . getActivityBeforeSleep($row) . "</td>";
    if($diaryGrade == 4 || $diaryGrade == 0){
	if ($row['parentSetBedTime'] == 1){
	    echo "<td>Yes</td>";
	}else{
	    echo "<td>No</td>";
	}
    }
    echo "<td>" . getTimeDisplay($row['timeLightsOff']) . "</td>";
    //echo "<td>" . getTimeDisplay($row['timeFellAsleep']) . "</td>";
    echo "<td>" . getTimeDisplay($row['timeWakeup']) . "</td>";
    echo "<td>" . $row['minFallAsleep'] . "</td>";
    echo "<td>" . $row['numWokeup'] . "</td>";
    echo "<td>" . $row['minWokeup'] . "</td>";
    echo "<td>" . getDisplaySleptHours($row['hourSlept']) . "</td>";
    echo "<td>" . gmdate('g:i', abs(strtotime($row['timeWakeup']) + (strtotime('midnight') - strtotime($row['timeLightsOff'])))).  "</td>";
    echo "<td>" . getDisturbances($row) . "</td>";
    if($diaryGrade == 4 || $diaryGrade == 0){
    	 if ($row['roomDarkness'] != NULL){
        echo "<td>" . $row['roomDarkness'] . "</td><td>" . $enumRoomDarkness[$row['roomDarkness']] . "</td>";
       }else{
        echo "<td></td><td></td>";
       }
       if ($row['roomQuietness'] != NULL){
        echo "<td>" . $row['roomDarkness'] . "</td><td>" . $enumRoomQuietness[$row['roomQuietness']] . "</td>";
    	 }else{
        echo "<td></td><td></td>";
       }
       if ($row['roomDarkness'] != NULL){
        echo "<td>" . $row['roomWarmness'] . "</td><td>" . $enumRoomWarmness[$row['roomWarmness']] . "</td>";
    	 }else{
        echo "<td></td><td></td>";
	 }
	if ($row['wakeUpWay'] != NULL){
	    if ($row['wakeUpWay'] == 1){
		echo "<td>woke up on my own</td>";
	    }else{
		echo "<td>Someone else woke me up</td>";
	    }
	}else{
            echo "<td></td>";
	}
    }
    if ($row['wokeupState'] != NULL)
        echo "<td>" . $enumWokeupState[$row['wokeupState']] . "</td><td>" . $enumWokeupState[$enumWokeupState[$row['wokeupState']]] . "</td>";
    else
        echo "<td></td><td></td>";
    if ($row['sleepQuality'] != NULL)
        echo "<td>" . $enumSleepQuality[$row['sleepQuality']] . "</td><td>" . $enumSleepQuality[$enumSleepQuality[$row['sleepQuality']]] . "</td>";
    else
        echo "<td></td><td></td>";
    /*if ($row['sleepCompare'] != NULL)
        echo "<td>" . $enumSleepCompare[$row['sleepCompare']] . "</td><td>" . $enumSleepCompare[$enumSleepCompare[$row['sleepCompare']]] . "</td>";
    else
        echo "<td></td><td></td>";*/
}

// Function to show a table of sleep data statistics
function displaySleepStatsTable($stats, $grade)
{
    if(!isset($grade)){
	$grade = 0;
    }
    echo "<table>";
    displaySleepStatsTableHeader($grade);
    displaySleepStatsType($stats, 0, 'min', $grade);
    displaySleepStatsType($stats, 0, 'max', $grade);
    displaySleepStatsType($stats, 0, 'mean', $grade);
    echo "</table>";
}

// Function to display the header row for the sleep statistics table
function displaySleepStatsTableHeader($grade)
{
    echo   "<tr>";
    echo   "<th></th>";
    echo   "<th>Bed Time_Sleep Diary</th>";
    echo   "<th>Time it took to fell Asleep_Sleep Diary</th>";
    echo   "<th>Wake Up Time_Sleep Diary</th>";
    echo   "<th>Awake Time_Sleep Diary</th>";
    echo   "<th>Total Sleep Time (hours:min)_Sleep Diary</th>";
    echo   "<th>Wake-up State Rating_Sleep Diary</th>";
    echo   "<th>Wake-up State Descriptor_Sleep Diary</th>";
    echo   "<th>Sleep Quality<br>(last night) Rating_Sleep Diary</th>";
    echo   "<th>Sleep Quality<br>(last night) Descriptor_Sleep Diary</th>";
    echo   "<th>Sleep Quality<br>(compared to usual) Rating_Sleep Diary</th>";
    echo   "<th>Sleep Quality<br>(compared to usual) Descriptor_Sleep Diary</th>";
    if($grade==4 || $grade == 0){
	echo   "<th>Bedroom Lighting Rating</th>";
	echo   "<th>Bedroom Lighting Descriptor</th>";
	echo   "<th>Bedroom Noise Rating</th>";
	echo   "<th>Bedroom Noise Descriptor</th>";
	echo   "<th>Bedroom Temperature Rating</th>";
	echo   "<th>Bedroom Temperature Descriptor</th>";
    }
    echo   "</tr>";
}

function displaySleepStatsType($stats, $nskip, $type, $grade)
{
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;

    echo "<tr>";
    echo "<td>" . ucfirst($type) . "</td>";
    for ($i=0; $i<$nskip; $i++)
        echo "<td></td>";
    echo "<td>" . getDisplayTime($stats['timeLightsOff'][$type]) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeFellAsleep'][$type]) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup'][$type]) . "</td>";
    echo "<td>" . getDisplayNumber($stats['numWokeup'][$type], 2) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept'][$type]) . "</td>";

    $wokeupStateNum = getDisplayNumber($stats['wokeupState'][$type], 2);
    echo "<td>" . $wokeupStateNum . "</td>";
    if ($type != 'mean')
        echo "<td>" . $enumWokeupState[$wokeupStateNum] . "</td>";
    else
        echo "<td></td>";

    $sleepQualityNum = getDisplayNumber($stats['sleepQuality'][$type], 2);
    echo "<td>" . $sleepQualityNum . "</td>";
    if ($type != 'mean')
        echo "<td>" . $enumSleepQuality[$sleepQualityNum] . "</td>";
    else
        echo "<td></td>";

    $sleepCompareNum = getDisplayNumber($stats['sleepCompare'][$type], 2);
    echo "<td>" . $sleepCompareNum . "</td>";
    if ($type != 'mean')
        echo "<td>" . $enumSleepCompare[$sleepCompareNum] . "</td>";
    else
        echo "<td></td>";
    if($grade==4){
	$roomDarknessNum = getDisplayNumber($stats['roomDarkness'][$type], 2);
	echo "<td>" . $roomDarknessNum . "</td>";
	if ($type != 'mean')
            echo "<td>" . $enumRoomDarkness[$roomDarknessNum] . "</td>";
	else
            echo "<td></td>";

	$roomQuietnessNum = getDisplayNumber($stats['roomQuietness'][$type], 2);
	echo "<td>" . $roomQuietnessNum . "</td>";
	if ($type != 'mean')
            echo "<td>" . $enumRoomQuietness[$roomQuietnessNum] . "</td>";
	else
            echo "<td></td>";

	$roomWarmnessNum = getDisplayNumber($stats['roomWarmness'][$type], 2);
	echo "<td>" . $roomWarmnessNum . "</td>";
	if ($type != 'mean')
            echo "<td>" . $enumRoomWarmness[$roomWarmnessNum] . "</td>";
	else
            echo "<td></td>";
    }
    echo "</tr>";
}

function displaySleepStatsSummaryHeader($grade)
{
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    if(!isset($grade)){
	$grade = 0;
    }

    echo   "<th>Earliest Bed Time_Sleep Diary</th>";
    echo   "<th>Latest Bed Time_Sleep Diary</th>";
    echo   "<th>Average Bed Time_Sleep Diary</th>";
    echo   "<th>Earliest Wake Up Time_Sleep Diary</th>";
    echo   "<th>Latest Wake Up Time_Sleep Diary</th>";
    echo   "<th>Average Wake Up Time_Sleep Diary</th>";
    echo   "<th>Shortest Total Sleep Time (hours:min)_Sleep Diary</th>";
    echo   "<th>Longest Total Sleep Time (hours:min)_Sleep Diary</th>";
    echo   "<th>Average Total Sleep Time_Sleep Diary</th>";
    echo   "<th>Average Time in Bed (hours:min)_Sleep Diary</th>";
    echo   "<th>Average Time it Took to Fall Asleep (min)_Sleep Diary</th>";
    echo   "<th>Average #Awak._Sleep Diary</th>";
    echo   "<th>Average Awake Time (min)_Sleep Diary</th>";
    if($grade==4){
        echo   "<th>Average Bedroom Lighting Rating_Sleep Diary</th>";
        echo   "<th>Average Bedroom Noise Rating_Sleep Diary</th>";
        echo   "<th>Average Bedroom Temperature Rating_Sleep Diary</th>";
    }
    echo   "<th>Average Wake Up State Rating_Sleep Diary</th>";
    echo   "<th>Average Sleep Quality (last night) Rating_Sleep Diary</th>";
        //echo   "<th>Average Sleep Quality (compared to usual) Rating</th>";


}
function appendSleepStatsSummaryData($stats, $grade){
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    if(!isset($grade)){
	     $grade = 0;
    }
    $sleepStatsDataDisplay = "";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeLightsOff']['min']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeLightsOff']['max']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeLightsOff']['mean']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeWakeup']['min']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeWakeup']['max']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeWakeup']['mean']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours($stats['hourSlept']['min'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours($stats['hourSlept']['max'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours($stats['hourSlept']['mean'], 2) . "</td>";
    if(is_null($stats['timeWakeup']['mean'])){
      $sleepStatsDataDisplay .= "<td></td>";
    	$sleepStatsDataDisplay .= "<td></td>";

    }else{
      $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours(($stats['timeWakeup']['mean']-$stats['timeLightsOff']['mean'])/3600,2) . "</td>";
      $sleepStatsDataDisplay .= "<td>" . getDisplayNumber(($stats['timeFellAsleep']['mean']-$stats['timeLightsOff']['mean'])/60,0) . "</td>";
    }
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['numWokeup']['mean'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['minWokeup']['mean'], 2) . "</td>";
	  if($grade==4 || $grade == 0){
      $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['roomDarkness']['mean'], 2) . "</td>";
    	$sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['roomQuietness']['mean'], 2) . "</td>";
    	$sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['roomWarmness']['mean'], 2) . "</td>";
    }
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['wokeupState']['mean'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['sleepQuality']['mean'], 2) . "</td>";
	  //echo "<td>" . getDisplayNumber($stats['sleepCompare']['mean'], 2) . "</td>";

    return $sleepStatsDataDisplay;
}
function displaySleepStatsSummaryData($stats, $grade){

    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    if(!isset($grade)){
	     $grade = 0;
    }
    $sleepStatsDataDisplay = "";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeLightsOff']['min']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeLightsOff']['min']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeLightsOff']['max']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeLightsOff']['max']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeLightsOff']['mean']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeLightsOff']['mean']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeWakeup']['min']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup']['min']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeWakeup']['max']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup']['max']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayTime($stats['timeWakeup']['mean']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup']['mean']) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours($stats['hourSlept']['min'], 2) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept']['min'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours($stats['hourSlept']['max'], 2) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept']['max'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours($stats['hourSlept']['mean'], 2) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept']['mean'], 2) . "</td>";
    if(is_null($stats['timeWakeup']['mean'])){
      $sleepStatsDataDisplay .= "<td></td>";
    	echo "<td></td>";
      $sleepStatsDataDisplay .= "<td></td>";
    	echo "<td></td>";
    }else{
      $sleepStatsDataDisplay .= "<td>" . getDisplaySleptHours(($stats['timeWakeup']['mean']-$stats['timeLightsOff']['mean'])/3600,2) . "</td>";
      echo "<td>" . getDisplaySleptHours(($stats['timeWakeup']['mean']-$stats['timeLightsOff']['mean'])/3600,2) . "</td>";
      $sleepStatsDataDisplay .= "<td>" . getDisplayNumber(($stats['timeFellAsleep']['mean']-$stats['timeLightsOff']['mean'])/60,0) . "</td>";
      echo "<td>" . getDisplayNumber(($stats['timeFellAsleep']['mean']-$stats['timeLightsOff']['mean'])/60,0) . "</td>";
    }
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['numWokeup']['mean'], 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['numWokeup']['mean'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['minWokeup']['mean'], 2) . "</td>";
	echo "<td>" . getDisplayNumber($stats['minWokeup']['mean'], 2) . "</td>";
    if($grade==4 || $grade == 0){
      $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['roomDarkness']['mean'], 2) . "</td>";
    	echo "<td>" . getDisplayNumber($stats['roomDarkness']['mean'], 2) . "</td>";
      $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['roomQuietness']['mean'], 2) . "</td>";
    	echo "<td>" . getDisplayNumber($stats['roomQuietness']['mean'], 2) . "</td>";
      $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['roomWarmness']['mean'], 2) . "</td>";
    	echo "<td>" . getDisplayNumber($stats['roomWarmness']['mean'], 2) . "</td>";
    }
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['wokeupState']['mean'], 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['wokeupState']['mean'], 2) . "</td>";
    $sleepStatsDataDisplay .= "<td>" . getDisplayNumber($stats['sleepQuality']['mean'], 2) . "</td>";
	  echo "<td>" . getDisplayNumber($stats['sleepQuality']['mean'], 2) . "</td>";
    //echo "<td>" . getDisplayNumber($stats['sleepCompare']['mean'], 2) . "</td>";

    return $sleepStatsDataDisplay;
}

function showSleepLegends($grade)
{
global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    if(!isset($grade)){
	$grade = 0;
    }
    echo "Wake Up State Ratings: ";
    showLegend($enumWokeupState);
    echo "<br>";

    echo "Sleep Quality (last night) Ratings: ";
    showLegend($enumSleepQuality);
    echo "<br>";

    /*echo "Sleep Quality (compared to usual) Ratings: ";
    showLegend($enumSleepCompare);
    echo "<br>";*/

    if($grade==4 || $grade == 0){
	echo "Bedroom Lighting Ratings: ";
	showLegend($enumRoomDarkness);
	echo "<br>";

	echo "Bedroom Noise Ratings: ";
	showLegend($enumRoomQuietness);
	echo "<br>";

	echo "Bedroom Temperature Ratings: ";
	showLegend($enumRoomWarmness);
	echo "<br>";
    }
}

?>
