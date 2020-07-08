<?php  
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li, Wo-Tak Wu
#
// This module contains utility functions for handling activity and sleep diary data

// Function to convert date string to the desired format for display on screen
function getDisplayDate($date)
{
    return(date('l F j, Y', strtotime($date)));   // Example: March 8, 2016 Monday
}

// Function to convert timestamp to the desired format for display on screen
function getDisplayTime($time)
{
    if (is_null($time))
        return "";
    if ($time == "")
        return "";
    return date('h:i a', $time);   // Example: 11:30 am
}

// Function to convert number of hours (in decimal) slept to the desired format for display on screen
function getDisplaySleptHours($numHours)
{
    if (is_null($numHours))
        return "";
    $hours = intval($numHours);
    $minutes = round(($numHours - $hours) * 60);
    /*if ($minutes == 0)
        return strval($hours);*/
    return strval($hours) . ":" . str_pad(strval($minutes), 2, '0', STR_PAD_LEFT);
}

// Function to convert number to the desired format for display on screen
function getDisplayNumber($num, $decimalPlaces)
{
    if (is_null($num))
        return "";
    //if ($num == 0)      // Need to specifically handle this case as round() would return NULL otherwise
    //    return 0;
    return round($num, $decimalPlaces, PHP_ROUND_HALF_UP);
}

function showLegend($lookup)
{
    $first = true;
    ksort($lookup);
    foreach ($lookup as $key => $value)
    {
        if (!is_numeric($key))
            continue;
        if (!$first)
            echo ", ";
        echo "(" . $key . ") " . $value;
        $first = false;
    }
}

// Function to convert a list of numbers to a string
function getNumListStr($list)
{
    $str = "";
    for ($i=0; $i<count($list); $i++)
    {
        if ($i != 0)
            $str .= ",";
        $str .= $list[$i];
    }
    return $str;
}

// Function to convert a list of enums to descriptor string
function getDescriptorList($enumLookup, $list)
{
    $str = "";
    for ($i=0; $i<count($list); $i++)
    {
        if ($i != 0)
            $str .= ", ";
        $str .= $enumLookup[$list[$i]];
    }
    return $str;
}

function getQueryOptions($includeUnsubmitted, $startingDiaryEntryId, $endingDiaryEntryId, $conjunctive)
{
    $options = "";
    if (!$includeUnsubmitted)
    {
        $options = " " . $conjunctive . " timeCompleted IS NOT NULL";
        // Assume diaryId changes monotonically with diaryDate, from which the selection list is ordered by date
        $options .= " AND diaryId >= '$startingDiaryEntryId'";
        $options .= " AND diaryId <= '$endingDiaryEntryId'";
    }
    return $options;
}

function getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, $conjunctive)
{
    $options = "";
    if (!$includeUnsubmitted)
    {
        $options = " " . $conjunctive . " timeCompleted IS NOT NULL";
        $options .= " AND diaryDate >= '$startingDiaryEntryDate'";
        $options .= " AND diaryDate <= '$endingDiaryEntryDate'";
    }
    return $options;
}

?> 
