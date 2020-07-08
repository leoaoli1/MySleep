<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
require_once('utilities-actogram.php');
session_start();
$userId= $_SESSION['userId'];


$dailyTable = "";
if(isset($_POST['id'])){
    include 'connectdb.php';
    $studentId = $_POST['id'];
    $currentGrade = getGrade($studentId);

    $result = mysql_query("SELECT * FROM my_actogram WHERE userId='$studentId' and grade='$currentGrade' order by resultRow DESC LIMIT 1");
    
    // Get actigram src
    if(mysql_num_rows($result)>0) {
	$row = mysql_fetch_array($result);
	$imgSrc='data:image/png;base64,'.$row['imgSrc'];
    }
   // Get Summary Table Data
    if(mysql_num_rows($result)>0) {
	list($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime) = extractActigraphData($row);
    }

    for($i = 0; $i < (count($arrEndDate)-1); $i++){
	$main = "<td>".$arrEndDay[$i]." ".$arrEndDate[$i]."</td><td>".$arrBedTime[$i]."</td><td>".$arrGetUpTime[$i]."</td><td>". gmdate('H:i', floor($arrTimeInBed[$i]*60))."</td><td>". gmdate('H:i', floor($arrTotalSleepTime[$i]*60))."</td><td>".$arrTimeItTookToFallAsleep[$i]."</td><td>".$arrAverageSleepQuality[$i]."</td><td>".$arrNumberOfAwak[$i]."</td><td>".$arrAwakeTime[$i]."</td>";
	$append = "<tr>".$main."</tr>";
	$dailyTable .= $append;
    }

    
    // Get Statistic Data
    $summary = generateActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime);
    
    echo json_encode(
	array("imgSrc" => $imgSrc,
	    "dailyTable" => $dailyTable,
	      "summaryTable" => $summary
	)
    );
    mysql_close($con);
}


function generateActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime){
    $summaryTable = "";
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
	
	$summaryTable = "<td>".$earliestBed."</td>"."<td>".$lastBed."</td>"."<td>".$averBed."</td>"."<td>".$earliestGetUp."</td>"."<td>".$lastGetUp."</td>"."<td>".$averGetUp."</td>"."<td>".$shortTotalSleepTime."</td>"."<td>".$longTotalSleepTime."</td>"."<td>".$meanTotalSleepTime."</td>"."<td>".$meanTimeInBed."</td>"."<td>".$meanTimeItTookToFallAsleep."</td>"."<td>".$meanAverageSleepQuality."</td>"."<td>".$meanNumberOfAwak."</td>"."<td>".$meanAwakeTime."</td>";
    }

    return $summaryTable;
}
exit;
?>
