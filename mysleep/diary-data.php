<?php  
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
// This module contains common functions for computing diary data
require_once('utilities.php');     

// Function to accumulate data from selected sleep diaries in the database
function accumulateSleepData($row, &$stats)
{
global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;

    addData($stats['timeLightsOff'], get2DayTimeStamp($row['timeLightsOff']));
    addData($stats['timeFellAsleep'], get2DayTimeStamp($row['timeFellAsleep']));
    addData($stats['timeWakeup'], get2DayTimeStamp($row['timeWakeup']));

    addData($stats['numWokeup'], $row['numWokeup']);
    addData($stats['minWokeup'], $row['minWokeup']);

    addData($stats['wokeupState'], $enumWokeupState[$row['wokeupState']]);
    addData($stats['sleepQuality'], $enumSleepQuality[$row['sleepQuality']]);
    addData($stats['sleepCompare'], $enumSleepCompare[$row['sleepCompare']]);
    
	 addData($stats['roomDarkness'], $row['roomDarkness']);
	 addData($stats['roomQuietness'], $row['roomQuietness']);
	 addData($stats['roomWarmness'], $row['roomWarmness']);
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
    computeDataStats($stats['timeLightsOff']);
    computeDataStats($stats['timeFellAsleep']);
    computeDataStats($stats['timeWakeup']);

    computeDataStats($stats['numWokeup']);
    computeDataStats($stats['minWokeup']);
    
    computeDataStats($stats['wokeupState']);
    computeDataStats($stats['sleepQuality']);
    computeDataStats($stats['sleepCompare']);
    
    computeDataStats($stats['roomDarkness']);
    computeDataStats($stats['roomQuietness']);
    computeDataStats($stats['roomWarmness']);
    
    computeDataStats($stats['hourSlept']);
}

// Function to accumulate data from selected activity diaries in the database
function accumulateActivityData($row, &$stats)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;

    addData($stats['napStart'], get2DayTimeStamp($row['napStart']));
    addData($stats['napEnd'], get2DayTimeStamp($row['napEnd']));
    addData($stats['napDuration'], computeElapsedTimeHours($row['napStart'], $row['napEnd']));
    
    addData($stats['minExercised'], $row['minExercised']);
    addData($stats['minTechnology'], $row['minTechnology']);
    addData($stats['minComputer'], $row['minComputer']);
    addData($stats['minVideoGame'], $row['minVideoGame']);
    addData($stats['numCaffeinatedDrinks'], $row['numCaffeinatedDrinks']);

    addData($stats['feltDuringDay'], $enumFeltDuringDay[$row['feltDuringDay']]);
    addData($stats['howSleepy'], $enumHowSleepy[$row['howSleepy']]);
    addData($stats['attention'], $enumAttention[$row['attention']]);
    addData($stats['behavior'], $enumBehavior[$row['behavior']]);
    addData($stats['interaction'], $enumInteraction[$row['interaction']]);
}

// Function to compute the statistics of activity diary data
function computeActivityStats(&$stats)
{
    computeDataStats($stats['napStart']);
    computeDataStats($stats['napEnd']);
    computeDataStats($stats['napDuration']);
    computeDataStats($stats['minExercised']);
    
    computeDataStats($stats['minTechnology']);
    computeDataStats($stats['minComputer']);
    computeDataStats($stats['minVideoGame']);
    
    computeDataStats($stats['numCaffeinatedDrinks']);
    
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

?> 
