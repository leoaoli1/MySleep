<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
// This module contains functions for displaying activity diary data in table or other forms
require_once('utilities.php');
require_once('utilities-diary.php');

// Translate among enum, descriptor and value in the database
// There are two sections:
//   1. enum in database to some numeric value which users see;
//   2. same numeric value above to some description which users see.
$enumFeltDuringDay = array
(
    'veryPleasant' => 5,
    'pleasant' => 4,
    'sometimesPleasant' => 3,
    'unpleasant' => 2,
    'veryUnpleasant' => 1,
    5 => 'Very Pleasant',
    4 => 'Pleasant',
    3 => 'Sometimes Pleasant',
    2 => 'Unpleasant',
    1 => 'Very Unpleasant'
);

$enumHowSleepy = array
(
    'not' => 4,
    'somewhat' => 3,
    'sleepy' => 2,
    'very' => 1,
    4 => 'Not Sleepy',
    3 => 'Somewhat Sleepy',
    2 => 'Sleepy',
    1 => 'Very Sleepy'
);

/*$enumHowAttentive = array
(
    'very' => 3,
    'mostly' => 2,
    'not' => 1,
    3 => 'Paid Attention',
    2 => 'Mostly Paid Attention',
    1 => 'Couldn\'t Paid Attention'
);*/

$enumAttention = array
(
    'always' => 5,
    'mostly' => 4,
    'sometimes' => 3,
    'little' => 2,
    'never' => 1,
    5 => 'focus all day',
    4 => 'focus most of the day',
    3 => 'focus about half of the time',
    2 => 'focus occasionally',
    1 => 'couldn’t focus'
);


$enumBehavior = array
(
    'challenging' => 4,
    'somewhatDifficult' => 3,
    'good' => 2,
    'excellent' => 1,
    4 => 'Had trouble following the classroom and home rules/often disrupted the activities of others',
    3 => 'Sometimes had trouble following the classroom and home rules/occasionally disrupted the activities of others',
    2 => 'Mostly followed the classroom rules at home and school/rarely disrupted the activities of others',
    1 => 'Followed classroom and home rules/never disrupted the activities of others'
);


$enumInteraction = array
(
    'challenging' => 4,
    'somewhatDifficult' => 3,
    'good' => 2,
    'excellent' => 1,
    4 => 'Challenging',
    3 => 'Somewhat Difficult',
    2 => 'Good',
    1 => 'Excellent'
);


// Utility and common functions for diary data
function getSymptom($row)
{
    $count = 0;
    $str = "";
    if ($row['symptomRunnyNose'])
    {
        $str .= "Runny Nose";
        $count++;
    }
    if ($row['symptomSoreThroat'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Sore Throat";
    }
    if ($row['symptomStuffyNose'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Stuffy Nose (Congestion)";
    }
    if ($row['symptomItchyEyes'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Itchy Eyes";
    }
    if ($row['symptomHeadache'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Headache";
    }
    if ($row['symptomFever'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Fever";
    }
    if ($row['symptomSneezing'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Sneezing (more than usual)";
    }
    if ($row['symptomCoughing'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Coughing";
    }
    if ($row['symptomBodyAches'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Body/Muscle aches";
    }
    if ($row['symptomStomach'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Nausea/stomach ache";
    }
    if ($row['symptomUnknown'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Unknown";
    }
    if ($count == 0){
     $str .= "None";
}
    return $str;
}


function computeSymptom($row)
{
    $count = 0;
    $str = "";
    if ($row['symptomRunnyNose'])
    {
        $str .= "Runny Nose";
        $count++;
    }
    if ($row['symptomSoreThroat'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Sore Throat";
    }
    if ($row['symptomStuffyNose'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Stuffy Nose (Congestion)";
    }
    if ($row['symptomItchyEyes'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Itchy Eyes";
    }
    if ($row['symptomHeadache'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Headache";
    }
    if ($row['symptomFever'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Fever";
    }
    if ($row['symptomSneezing'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Sneezing (more than usual)";
    }
    if ($row['symptomCoughing'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Coughing";
    }
    if ($row['symptomBodyAches'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Body/Muscle aches";
    }
    if ($row['symptomStomach'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Nausea/stomach ache";
    }
    if ($row['symptomUnknown'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Unknown";
    }
    return $count;
}
/*function getCaffeinatedDrink($row)
{
    $count = 0;
    $str = "";
    if ($row['caffDrinkMorning'])
    {
        $str .= "Morning";
        $count++;
    }
    if ($row['caffDrinkAfternoon'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Afternoon";
    }
    if ($row['caffDrinkWithinBedtime'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Before sleep";
    }
    return $str;
}

function getExercise($row)
{
    $count = 0;
    $str = "";
    if ($row['exercisedMorning'])
    {
        $str .= "Morning";
        $count++;
    }
    if ($row['exercisedAfternoon'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Afternoon";
    }
    if ($row['exercisedWithinBedtime'])
    {
        if ($count++ > 0)
            $str .= ", ";
        $str .= "Before sleep";
    }
    return $str;
}*/

// Function to show a table of activity data statistics
/*function displayActivityStatsTable($stats)
{
    echo "<table>";
    displayActivityStatsTableHeader();
    displayCommonStatsTypeActivity($stats, 0, 'min');
    displayCommonStatsTypeActivity($stats, 0, 'max');
    displayCommonStatsTypeActivity($stats, 0, 'mean');
    echo "</table>";
}*/

/*function displayCommonStatsTypeActivity($stats, $nskip, $type)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;

    echo "<tr>";
    echo "<td>" . ucfirst($type) . "</td>";
    for ($i=0; $i<$nskip; $i++)
        echo "<td></td>";

    echo "<td>" . getDisplayTime($stats['napStart'][$type]) . "</td>";
    echo "<td>" . getDisplayTime($stats['napEnd'][$type]) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['napDuration'][$type]) . "</td>";
    echo "<td>" . getDisplayNumber($stats['minExercised'][$type], 0) . "</td>";
    //echo "<td>" . getDisplayNumber($stats['minExercised'][$type], 0) . "</td>";
    //echo "<td>" . getDisplayNumber(0, 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['numCaffeinatedDrinks'][$type], 2) . "</td>";

    $feltDuringDayNum = getDisplayNumber($stats['feltDuringDay'][$type], 0);
    echo "<td>" . $feltDuringDayNum . "</td>";
    echo "<td>" . $enumFeltDuringDay[$feltDuringDayNum] . "</td>";

    $howSleepyNum = getDisplayNumber($stats['howSleepy'][$type], 0);
    echo "<td>" . $howSleepyNum . "</td>";
    echo "<td>" . $enumHowSleepy[$howSleepyNum] . "</td>";

    $howAttentiveNum = getDisplayNumber($stats['howAttentive'][$type], 0);
    echo "<td>" . $howAttentiveNum . "</td>";
    echo "<td>" . $enumHowAttentive[$howAttentiveNum] . "</td>";
    echo "</tr>";
}*/

// Function to show a summary table for the statistics
function displayActivityStatsSummaryHeader($grade)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }

    echo   "<th>Number of Days Napped_Activity Diary</th>";
    echo   "<th>Average Number of Caffeinated Drinks_Activity Diary</th>";
    echo   "<th>Average Number of Minutes Exercised_Activity Diary</th>";
    if($grade==4 || $grade ==0){
	echo   "<th>Average Number of Minutes Played Video Games_Activity Diary</th>";
	echo   "<th>Average Number of Minutes Spent Using a Computer_Activity Diary</th>";
	echo   "<th>Average Number of Minutes Using Other Technology_Activity Diary</th>";
    }
    if($grade == 5 || $grade ==0){
        echo   "<th>Average Mood Rating_Activity Diary</th>";
        echo   "<th>Mood Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th>Average Sleepiness Rating_Activity Diary</th>";
    echo   "<th>Sleepiness Descriptor Most Often Selected_Activity Diary</th>";
    if($grade == 5 || $grade ==0){
        echo   "<th>Average Attention Rating_Activity Diary</th>";
        echo   "<th>Attention Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th>Average Behavior Rating_Activity Diary</th>";
	echo   "<th>Behavior Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th>Average Interactions Rating_Activity Diary</th>";
	echo   "<th>Interactions Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='symptoms'>Physical Symptoms_Activity Diary</th>";

}

function displayActivityStatsSummaryData($stats, $grade)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }
    if(is_null($stats['numCaffeinatedDrinks']['mean'])){ // check null
	echo "<td></td>";
    }else{
	echo "<td>" . getNumDataGreaterThan($stats['napDuration']['data'], 0) . "</td>";
    }
    echo "<td>" . getDisplayNumber($stats['numCaffeinatedDrinks']['mean'], 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['minExercised']['mean'], 0) . "</td>";
    if($grade == 4 || $grade ==0){
	echo "<td>" . getDisplayNumber($stats['minVideoGame']['mean'], 0) . "</td>";
	echo "<td>" . getDisplayNumber($stats['minComputer']['mean'], 0) . "</td>";
	echo "<td>" . getDisplayNumber($stats['minTechnology']['mean'], 0) . "</td>";
    }
    if($grade == 5 || $grade ==0){
        echo "<td>" . getDisplayNumber($stats['feltDuringDay']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumFeltDuringDay, $stats['feltDuringDay']['mode']) . "</td>";
    }
    echo "<td>" . getDisplayNumber($stats['howSleepy']['mean'], 2) . "</td>";
    echo "<td>" . getDescriptorList($enumHowSleepy, $stats['howSleepy']['mode']) . "</td>";
    if($grade == 5 || $grade ==0){
        echo "<td>" . getDisplayNumber($stats['attention']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumAttention, $stats['attention']['mode']) . "</td>";

	echo "<td>" . getDisplayNumber($stats['behavior']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumBehavior, $stats['behavior']['mode']) . "</td>";

	echo "<td>" . getDisplayNumber($stats['interaction']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumInteraction, $stats['interaction']['mode']) . "</td>";
    }
}
function appendActivityStatsSummaryData($stats, $grade)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    $result = "";
    if(!isset($grade)){
	$grade = 0;
    }
    if(is_null($stats['numCaffeinatedDrinks']['mean'])){ // check null
	$result .= "<td></td>";
    }else{
	$result .= "<td>" . getNumDataGreaterThan($stats['napDuration']['data'], 0) . "</td>";
    }
    $result .= "<td>" . getDisplayNumber($stats['numCaffeinatedDrinks']['mean'], 2) . "</td>";
    $result .= "<td>" . getDisplayNumber($stats['minExercised']['mean'], 0) . "</td>";
    if($grade == 4 || $grade ==0){
	$result .= "<td>" . getDisplayNumber($stats['minVideoGame']['mean'], 0) . "</td>";
	$result .= "<td>" . getDisplayNumber($stats['minComputer']['mean'], 0) . "</td>";
	$result .= "<td>" . getDisplayNumber($stats['minTechnology']['mean'], 0) . "</td>";
    }
    if($grade == 5 || $grade ==0){
        $result .= "<td>" . getDisplayNumber($stats['feltDuringDay']['mean'], 2) . "</td>";
        $result .= "<td>" . getDescriptorList($enumFeltDuringDay, $stats['feltDuringDay']['mode']) . "</td>";
    }
    $result .= "<td>" . getDisplayNumber($stats['howSleepy']['mean'], 2) . "</td>";
    $result .= "<td>" . getDescriptorList($enumHowSleepy, $stats['howSleepy']['mode']) . "</td>";
    if($grade == 5 || $grade ==0){
        $result .= "<td>" . getDisplayNumber($stats['attention']['mean'], 2) . "</td>";
        $result .= "<td>" . getDescriptorList($enumAttention, $stats['attention']['mode']) . "</td>";

	$result .= "<td>" . getDisplayNumber($stats['behavior']['mean'], 2) . "</td>";
        $result .= "<td>" . getDescriptorList($enumBehavior, $stats['behavior']['mode']) . "</td>";

	$result .= "<td>" . getDisplayNumber($stats['interaction']['mean'], 2) . "</td>";
        $result .= "<td>" . getDescriptorList($enumInteraction, $stats['interaction']['mode']) . "</td>";
    }

    return $result;
}

// Function to display the header row for the activity data
function displayCommonHeaderActivity($grade)
{
    if(!isset($grade)){
	$grade = 0;
    }
    echo   "<th>Nap Start Time_Activity Diary</th>";
    echo   "<th>Nap End Time_Activity Diary</th>";
    echo   "<th>Nap Duration (hrs.)_Activity Diary</th>";
    echo   "<th>Time Exercised (min)_Activity Diary</th>";
    if($grade==4 || $grade ==0){
	echo   "<th>Time Played Video Games (min)_Activity Diary</th>";
	echo   "<th>Time Spent Using a Computer (min)_Activity Diary</th>";
	echo   "<th>Time Using Other Technology (min)_Activity Diary</th>";
    }
    echo   "<th>#Caffeinated Drinks_Activity Diary</th>";
    if($grade==5 || $grade ==0){
	echo   "<th>Mood Rating_Activity Diary</th>";
	echo   "<th>Mood Descriptor_Activity Diary</th>";
	}
    echo   "<th>Sleepiness Rating_Activity Diary</th>";
    echo   "<th>Sleepiness Descriptor_Activity Diary</th>";
    if($grade==5 || $grade ==0){
	echo   "<th>Attentiveness Rating_Activity Diary</th>";
	echo   "<th>Attentiveness Descriptor_Activity Diary</th>";

	echo   "<th>Behavior Rating_Activity Diary</th>";
	echo   "<th>Behavior Descriptor_Activity Diary</th>";

	echo   "<th>Interactions Rating_Activity Diary</th>";
	echo   "<th>Interactions Descriptor_Activity Diary</th>";
    }
    echo   "<th>Any Physical Symptoms_Activity Diary</th>";
}

// Function to display the header row for the activity statistics table
/*function displayActivityStatsTableHeader()
{
    echo   "<tr>";
    echo   "<th></th>";
    echo   "<th>Nap Start Time_Activity Diary</th>";
    echo   "<th>Nap End Time_Activity Diary</th>";
    echo   "<th>Nap Duration (hrs.)_Activity Diary</th>";
    echo   "<th>Time Exercised (min)_Activity Diary</th>";
    echo   "<th>#Caffeinated Drinks_Activity Diary</th>";
    echo   "<th>Mood Rating_Activity Diary</th>";
    echo   "<th>Mood Descriptor_Activity Diary</th>";
    echo   "<th>Sleepiness Rating_Activity Diary</th>";
    echo   "<th>Sleepiness Descriptor_Activity Diary</th>";
    echo   "<th>Attentiveness Rating_Activity Diary</th>";
    echo   "<th>Attentiveness Descriptor_Activity Diary</th>";
    echo   "</tr>";
}*/

function displayCommonDataActivity($row, $grade)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }
    if (!is_null($row['napStart']))
        echo "<td>" . getTimeDisplay($row['napStart']) . "</td>";
    else
        echo "<td>-</td>";
    if (!is_null($row['napEnd']))
        echo "<td>" . getTimeDisplay($row['napEnd']) . "</td>";
    else
        echo "<td>-</td>";

    // Compute nap time
    $napTimeHrs = computeElapsedTimeHours($row['napStart'], $row['napEnd']);
    if (!is_null($napTimeHrs))
	echo "<td>" . getDisplaySleptHours($napTimeHrs) . "</td>";
    else
        echo "<td>-</td>";

    echo "<td>" . $row['minExercised'] . "</td>";

    if($grade==4 || $grade ==0){
	echo "<td>" . $row['minTechnology'] . "</td>";
	echo "<td>" . $row['minComputer'] . "</td>";
	echo "<td>" . $row['minVideoGame'] . "</td>";
    }

    echo "<td>" . $row['numCaffeinatedDrinks'] . "</td>";


    if($grade==5 || $grade ==0){
	if ($row['feltDuringDay'] != NULL)
            echo "<td>" . $enumFeltDuringDay[$row['feltDuringDay']] . "</td><td>" . $enumFeltDuringDay[$enumFeltDuringDay[$row['feltDuringDay']]] . "</td>";
	else
            echo "<td></td><td></td>";
    }
    if ($row['howSleepy'] != NULL)
        echo "<td>" . $enumHowSleepy[$row['howSleepy']] . "</td><td>" . $enumHowSleepy[$enumHowSleepy[$row['howSleepy']]] . "</td>";
    else
        echo "<td></td><td></td>";
    if($grade==5 || $grade ==0){
	if ($row['attention'] != NULL)
            echo "<td>" . $enumAttention[$row['attention']] . "</td><td>" . $enumAttention[$enumAttention[$row['attention']]] . "</td>";
	else
            echo "<td></td><td></td>";

	if ($row['behavior'] != NULL)
            echo "<td>" . $enumBehavior[$row['behavior']] . "</td><td>" . $enumBehavior[$enumBehavior[$row['behavior']]] . "</td>";
	else
            echo "<td></td><td></td>";


	if ($row['interaction'] != NULL)
            echo "<td>" . $enumInteraction[$row['interaction']] . "</td><td>" . $enumInteraction[$enumInteraction[$row['interaction']]] . "</td>";
	else
            echo "<td></td><td></td>";
    }

    echo "<td>" .getSymptom($row). "</td>";

}
function appendCommonDataActivity($row, $grade)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    $result = "";
    if(!isset($grade)){
	$grade = 0;
    }
    if (!is_null($row['napStart']))
        $result .= "<td>" . getTimeDisplay($row['napStart']) . "</td>";
    else
        $result .= "<td>-</td>";
    if (!is_null($row['napEnd']))
        $result .= "<td>" . getTimeDisplay($row['napEnd']) . "</td>";
    else
        $result .= "<td>-</td>";

    // Compute nap time
    $napTimeHrs = computeElapsedTimeHours($row['napStart'], $row['napEnd']);
    if (!is_null($napTimeHrs))
	$result .= "<td>" . getDisplaySleptHours($napTimeHrs) . "</td>";
    else
        $result .= "<td>-</td>";

    $result .= "<td>" . $row['minExercised'] . "</td>";

    if($grade==4 || $grade ==0){
	$result .= "<td>" . $row['minTechnology'] . "</td>";
	$result .= "<td>" . $row['minComputer'] . "</td>";
	$result .= "<td>" . $row['minVideoGame'] . "</td>";
    }

    $result .= "<td>" . $row['numCaffeinatedDrinks'] . "</td>";


    if($grade==5 || $grade ==0){
	if ($row['feltDuringDay'] != NULL)
            $result .= "<td>" . $enumFeltDuringDay[$row['feltDuringDay']] . "</td><td>" . $enumFeltDuringDay[$enumFeltDuringDay[$row['feltDuringDay']]] . "</td>";
	else
            $result .= "<td></td><td></td>";
    }
    if ($row['howSleepy'] != NULL)
        $result .= "<td>" . $enumHowSleepy[$row['howSleepy']] . "</td><td>" . $enumHowSleepy[$enumHowSleepy[$row['howSleepy']]] . "</td>";
    else
        $result .= "<td></td><td></td>";
    if($grade==5 || $grade ==0){
        if ($row['attention'] != NULL)
                  $result .= "<td>" . $enumAttention[$row['attention']] . "</td><td>" . $enumAttention[$enumAttention[$row['attention']]] . "</td>";
        else
                  $result .= "<td></td><td></td>";

        if ($row['behavior'] != NULL)
                  $result .= "<td>" . $enumBehavior[$row['behavior']] . "</td><td>" . $enumBehavior[$enumBehavior[$row['behavior']]] . "</td>";
        else
                  $result .= "<td></td><td></td>";


        if ($row['interaction'] != NULL)
                  $result .= "<td>" . $enumInteraction[$row['interaction']] . "</td><td>" . $enumInteraction[$enumInteraction[$row['interaction']]] . "</td>";
        else
                  $result .= "<td></td><td></td>";
    }

    $result .= "<td>" .getSymptom($row). "</td>";
    return $result;
}

function showActivityLegends($grade)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }
    if($grade==5 || $grade == 0){
	echo "Mood Ratings: ";
	showLegend($enumFeltDuringDay);
	echo "<br>";
    }

    echo "Sleepiness Ratings: ";
    showLegend($enumHowSleepy);
    echo "<br>";
    if($grade==5 || $grade == 0){
	echo "Attentiveness Ratings: ";
	showLegend($enumAttention);
	echo "<br>";

	echo "Behavior Ratings: ";
	showLegend($enumBehavior);
	echo "<br>";

	echo "Interaction Ratings: ";
	showLegend($enumInteraction);
	echo "<br>";
    }
}

?>
