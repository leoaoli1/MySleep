<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li 
#
require_once('utilities.php');

function extractActigraphData($row){
    $strStartDate = $row['startDate'];
    $strStartDay = $row['startDay'];
    $strEndDate = $row['endDate'];
    $strEndDay = $row['endDay'];
    $strBedTime = $row['bedTime'];
    $strGetUpTime = $row['getUpTime'];
    $strTimeInBed = $row['timeInBed'];
    $strTotalSleepTime = $row['totalSleepTime'];
    $strTimeItTookToFallAsleep = $row['timeItTookToFallAsleep'];
    $strAverageSleepQuality = $row['averageSleepQuality'];
    $strNumberOfAwak = $row['numberOfAwak'];
    $strAwakeTime = $row['awakeTime'];

    $arrStartDate = explode(",", $strStartDate);
    $arrStartDay = explode(",", $strStartDay);
    $arrEndDate = explode(",", $strEndDate);
    $arrEndDay = explode(",", $strEndDay);
    $arrBedTime = explode(",", $strBedTime);
    $arrGetUpTime = explode(",", $strGetUpTime);
    $arrTimeInBed = explode(",", $strTimeInBed);
    $arrTotalSleepTime = explode(",", $strTotalSleepTime);
    $arrTimeItTookToFallAsleep = explode(",", $strTimeItTookToFallAsleep);
    $arrAverageSleepQuality = explode(",", $strAverageSleepQuality);
    $arrNumberOfAwak = explode(",", $strNumberOfAwak);
    $arrAwakeTime = explode(",", $strAwakeTime);


    #check nap date by bed time
    $earlyTime = strtotime("9:00:00");
    $lateTime = strtotime("18:00:00");
    $duration = 300;  # unit is min
    for($i=0; $i<count($arrBedTime)-1; $i++){
	$checkTime = strtotime($arrBedTime[$i]);
	$totalDuration = floatval($arrTotalSleepTime[$i]);
	if($earlyTime<$checkTime&&$checkTime<$lateTime&&$totalDuration<$duration){
	    array_splice($arrStartDate, $i, 1);
	    array_splice($arrStartDay, $i, 1);
	    array_splice($arrEndDate, $i, 1); 
	    array_splice($arrEndDay, $i, 1);
	    array_splice($arrBedTime, $i, 1);
	    array_splice($arrGetUpTime, $i, 1); 
	    array_splice($arrTimeInBed, $i, 1); 
	    array_splice($arrTotalSleepTime, $i, 1); 
	    array_splice($arrTimeItTookToFallAsleep, $i, 1);
	    array_splice($arrAverageSleepQuality, $i, 1);
	    array_splice($arrNumberOfAwak, $i, 1);
	    array_splice($arrAwakeTime, $i, 1);
	    $i--;
	}
    }
    return array( $arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime);
}

function displayActographSummaryHeader() {
    echo '<th>Earliest Bed Time_Sleep_Watch</th>
		  <th>Latest Bed Time_Sleep_Watch</th>
		  <th>Average Bed Time_Sleep_Watch</th>
		  <th>Earliest Wake Up Time_Sleep_Watch</th>
		  <th>Latest Wake Up Time_Sleep_Watch</th>
		  <th>Average Wake Up Time_Sleep_Watch</th>
		  <th>Shortest Total Sleep Time (hours:Min)_Sleep_Watch</th>
		  <th>Longest Total Sleep Time (hours:Min)_Sleep_Watch</th>
		  <th>Average Total Sleep Time (hours:Min)_Sleep_Watch</th>
		  <th>Average Time in Bed (hours)_Sleep_Watch</th>
		  <th>Average Time it Took to Fall Asleep (min)_Sleep_Watch</th>
		  <th>Average Sleep Quality (percent)_Sleep_Watch</th>
		  <th>Average #Awak._Sleep_Watch</th>
                  <th>Average Awak. Time (min)_Sleep_Watch</th>';
}

function displayActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime){

    if($arrStartDate!="0"){
	$noonSecond = strtotime("12:00:00");
	$midNight = strtotime("00:00:00");
	$earliestBed = earliestBedTime($arrBedTime, $noonSecond);
	$lastBed = lastBedTime($arrBedTime, $noonSecond);
	$averBed = averageBedTime($arrBedTime, $noonSecond);
	$earliestGetUp = earliestGetUpTime($arrGetUpTime, $noonSecond);
	$lastGetUp = lastGetUpTime($arrGetUpTime, $noonSecond);
	$averGetUp = averageGetUpTime($arrGetUpTime, $noonSecond);
	$shortTotalSleepTime = gmdate('H:i', floor(minValue($arrTotalSleepTime)*60));
	$longTotalSleepTime = gmdate('H:i', floor(maxValue($arrTotalSleepTime)*60));
	$meanTotalSleepTime = gmdate('H:i', floor(meanValue($arrTotalSleepTime)*60));
	$meanTimeInBed = gmdate('H:i', floor(meanValue($arrTimeInBed)*60));
	$meanTimeItTookToFallAsleep =number_format(meanValue($arrTimeItTookToFallAsleep), 2, '.', '');
	$meanAverageSleepQuality = number_format(meanValue($arrAverageSleepQuality), 2, '.', '');
	$meanNumberOfAwak = number_format(meanValue($arrNumberOfAwak), 2, '.', '');
	$meanAwakeTime = number_format(meanValue($arrAwakeTime), 2, '.', '');
	
	echo "<td>".$earliestBed."</td>";
	echo "<td>".$lastBed."</td>";
	echo "<td>".$averBed."</td>";
	echo "<td>".$earliestGetUp."</td>";
	echo "<td>".$lastGetUp."</td>";
	echo "<td>".$averGetUp."</td>";
	echo "<td>".$shortTotalSleepTime."</td>";
	echo "<td>".$longTotalSleepTime."</td>";
	echo "<td>".$meanTotalSleepTime."</td>";
	echo "<td>".$meanTimeInBed."</td>";
	echo "<td>".$meanTimeItTookToFallAsleep."</td>";
	echo "<td>".$meanAverageSleepQuality."</td>";
	echo "<td>".$meanNumberOfAwak."</td>";
	echo "<td>".$meanAwakeTime."</td>";
    }else{
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
    }
}


function earliestBedTime($array, $noon){
    $maxTime = strtotime("23:59:59")+1;
    $rightMinTime = strtotime("23:59:59")+1;
    $leftMinTime =  strtotime("23:59:59")+1;
    //echo $leftMinTime."<br>";
    //echo $rightMaxTime."<br>";
    for($i = 0; $i<count($array)-1; $i++){
	$time = strtotime($array[$i]);
	//echo $time."<br>";
	if($time >= $noon){
	    $rightMinTime = min($time, $rightMinTime);
	}else{
	    $leftMinTime = min($time, $leftMinTime);	
	}
    }
    if($rightMinTime != $maxTime){
	return date("h:i:s A", $rightMinTime);
	//echo date("h:i:s A", $rightMinTime);
    }else{
	return date("h:i:s A", $leftMinTime);
    }
}

function earliestGetUpTime($array, $noon){
    $maxTime = strtotime("23:59:59")+1;
    $rightMinTime = strtotime("23:59:59")+1;
    $leftMinTime =  strtotime("23:59:59")+1;
    //echo $leftMinTime."<br>";
    //echo $rightMaxTime."<br>";
    for($i = 0; $i<count($array)-1; $i++){
	$time = strtotime($array[$i]);
	if($time >= $noon){
	    $rightMinTime = min($time, $rightMinTime);
	}else{
	    $leftMinTime = min($time, $leftMinTime);	
	}
    }
    if($leftMinTime != $maxTime){
	return date("h:i:s A", $leftMinTime);
    }else{
	return date("h:i:s A", $rightMinTime);
    }
}

function lastBedTime($array, $noon){
    $rightMaxTime = strtotime("00:00:00");
    $leftMaxTime =  strtotime("00:00:00");
    //echo $leftMaxTime."<br>";
    //echo $rightMaxTime."<br>";
    for($i = 0; $i<count($array)-1; $i++){
	$time = strtotime($array[$i]);
	if($time >= $noon){
	    //echo $compareTime;
	    //echo gettype($rightMinTime);
	    $rightMaxTime = max($time, $rightMaxTime);	
	}else{
	    if($time >= $leftMaxTime){
		$leftMaxTime = $time;
		//echo $leftMaxTime."<br>";
	    }
	}
    }
    if($leftMaxTime != strtotime("00:00:00")){
	return date("h:i:s A", $leftMaxTime);
    }else{
	return date("h:i:s A", $rightMaxTime);
    }	
}

function averageBedTime($array, $noon){
    /*
       Mid Night as 0; from noon to midnight is negative;
       from midnight to noon is positive
     */
    $midNight = strtotime("00:00:00");
    /* echo strtotime("00:00:00")."<br>";
    echo strtotime("23:59:59")."<br>";
    echo strtotime("12:00:00")."<br>";*/
    $sum = 0;
    # $noon -= $midNight;
    for($i = 0; $i<count($array)-1; $i++){
	$time = strtotime($array[$i]);
	# $time -= $midNight;
	if($time>$noon){
	    $time = $time - strtotime("23:59:59") - 1; 
	}else{
	    $time -= strtotime("00:00:00"); 
	}
	$sum += $time;   
    }
    $mean = $sum / (count($array)-1);
    if($mean<0){
	$mean = strtotime("23:59:59") + $mean;
    }else{
	$mean += strtotime("00:00:00");
    }
    return date("h:i:s A", $mean);
}

function averageGetUpTime($array, $noon){
    /*
       midnigh as 0; all positive
     */
    $midNight = strtotime("00:00:00");
    $sum = 0;
    for($i = 0; $i<count($array)-1; $i++){
	$time = strtotime($array[$i]);
	$time -= $midNight;
	$sum += $time;   
    }
    $mean = $sum / (count($array)-1) + $midNight;
    return date("h:i:s A", $mean);
}

function lastGetUpTime($array, $noon){
    $rightMaxTime = $noon-1;
    $leftMaxTime =  strtotime("00:00:00");
    //echo $leftMaxTime."<br>";
    //echo $rightMaxTime."<br>";
    for($i = 0; $i<count($array)-1; $i++){
	$time = strtotime($array[$i]);
	if($time >= $noon){
	    if($time >= $rightMaxTime){
		$rightMaxTime = $time;
		//echo $leftMaxTime."<br>";
	    }
	}else{
	    if($time >= $leftMaxTime){
		$leftMaxTime = $time;
		//echo $leftMaxTime."<br>";
	    }
	}
    }
    if($rightMaxTime != ($noon-1)){
	return date("h:i:s A", $rightMaxTime);
    }else{
	return date("h:i:s A", $leftMaxTime);
    }	
}
function minValue($array){
    $minTime = 1441; // minute
    for($i = 0; $i<count($array)-1; $i++){
	$time = $array[$i];
	$minTime = min($time, $minTime);	
    }
    return $minTime;
}

function maxValue($array){
    $maxTime = 0; // minute
    for($i = 0; $i<count($array)-1; $i++){
	$time = $array[$i];
	$maxTime = max($time, $maxTime);	
    }
    return $maxTime;
}
function meanValue($array){
    $sum = 0; // minute
    for($i = 0; $i<count($array)-1; $i++){
	$sum += $array[$i];	
    }
    $meanTime = ($sum/(count($array)-1));
    return $meanTime;
}
?>

