<?php
require_once('utilities.php');
require_once('utilities-actogram.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$userId= $_SESSION['userId'];
$studentIdList = getUserIdsInClass($classId);

$content = $_POST['content'];
$return = [];
$range = [];
$studentList = getUserIdswithClassId('50017');
$studentArray = '('.implode(',',$studentList).')';
$keyword = '';
$rangekeyword = '';
$titleDict = array(
  "Average Sleep Duration (Sleep Diary)" => "sleephourdiary",
  "Average Sleep Duration (Sleep Watch)" => "sleephourwatch",
  "Total Minutes Difference between shortest and longest sleep times" => "consistencylongshort",
  "Average Sleep Consistency (Sleep Watch)" => "consistencyearlylate",
  "Average Sleep Consistency (Sleep Diary)" => "consistencyearlylatediary",
  "Sleep Diary (Sleep Quality ratings)" => "qualityrating",
  "Sleep Watch (Awakenings)" => "qualityawaken",
  "Wake-up State" => "qualitywakeupstate",
);
$rangeDict = array(
  "sleephourdiary" => "< 6 hours;≥ 6 hours < 7 hours;≥ 7 hours < 8 hours;≥ 8 hours < 9 hours;≥ 9 hours",
  "sleephourwatch" => "< 6 hours;≥ 6 hours < 7 hours;≥ 7 hours < 8 hours;≥ 8 hours < 9 hours;≥ 9 hours",
  "consistencylongshort" => "< 60  (less than 1 hour) ;61 - 120  (1 - 2 hours) ;121 - 180  (2 - 3 hours) ;>180  (more than 3 hours) ;",
  "consistencyearlylate" => "< 60  (less than 1 hour) ;61 - 120  (1 - 2 hours) ;121 - 180  (2 - 3 hours) ;>180  (more than 3 hours) ;",
  "consistencyearlylatediary" => "< 60  (less than 1 hour) ;61 - 120  (1 - 2 hours) ;121 - 180  (2 - 3 hours) ;>180  (more than 3 hours) ;",
  "qualityrating" => "1.0 - 1.99;2.0 - 2.99;3.0 - 3.99;4.0 - 5.0",
  "qualityawaken" => "> 44;37 - 43.99;30 - 36.99;< 30",
  "qualitywakeupstate" => "1.0 - 1.59;1.6 - 2.0;2.1 - 2.59;2.6 - 3",
);
if ($content == 'sleephourdiary') {
  $keyword = 'sleepDuration';
  $rangekeyword = 'durationRange';
  $queryCommandSleep = "SELECT AVG(hourSlept) as $keyword, userId FROM diary_data_table WHERE hourSlept IS NOT NULL AND userId IN $studentArray GROUP BY userId ORDER BY sleepDuration";
  $result = mysql_query($queryCommandSleep);
  $queryRange = "SELECT durationRange, durationTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
  $numRow = mysql_num_rows ($result);
  if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      $hours = $row[$keyword];
      array_push($return, floor($hours).':'.sprintf("%02d", floor(60*($hours-floor($hours)))));
    }
  }

} elseif ($content == 'sleephourwatch') {
  $rangekeyword = 'durationRange';
  $result = mysql_query("SELECT totalSleepTime FROM my_actogram WHERE totalSleepTime IS NOT NULL AND userId IN $studentArray");
  while($row = mysql_fetch_array($result)){
    $array = array_filter(explode(',', $row['totalSleepTime']));
    $hours = array_sum($array)/count($array);
    array_push($return, floor($hours/60.0) .':'. sprintf("%02d", $hours%60.0));
  }
  sort($return);
  $queryRange = "SELECT durationRange, durationTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);

} elseif ($content == 'consistencylongshort') {
  $keyword = 'sleepConsistency';
  $rangekeyword = 'consistencyRange';
  $result = mysql_query("SELECT totalSleepTime FROM my_actogram WHERE totalSleepTime IS NOT NULL AND userId IN $studentArray");
  while($row = mysql_fetch_array($result)){
    $array = array_filter(explode(',', $row['totalSleepTime']));
    $sleepTimeMax = max($array);
    $sleepTimeMin = min($array);
    array_push($return, ($sleepTimeMax-$sleepTimeMin));
  }

  $queryRange = "SELECT consistencyRange, consistencyTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
} elseif ($content == 'consistencyearlylate') {
  $keyword = 'sleepConsistency';
  $rangekeyword = 'consistencyRange';
  $result = mysql_query("SELECT bedTime FROM my_actogram WHERE bedTime IS NOT NULL AND userId IN $studentArray");
  while($row = mysql_fetch_array($result)){
    $array = array_filter(explode(',', $row['bedTime']));
    $noonSecond = strtotime("12:00:00");
    $midNight = strtotime("00:00:00");
    $earliestBed = earliestBedTime($array, $noonSecond);
    $lastBed = lastBedTime($array, $noonSecond);
    $earliestBed = strtotime($earliestBed);
    $lastBed = strtotime($lastBed);
    if($lastBed >= $noonSecond){
       $diffBedTime = $lastBed - $earliestBed;
    }else{
       if($earliestBed >= $noonSecond){
           $diffBedTime = $lastBed - $midNight + strtotime("23:59:59") - $earliestBed;
       }else{
           $diffBedTime = $lastBed - $earliestBed;
       }
    }
    if ($diffBedTime>0) {
      array_push($return, number_format((float)$diffBedTime/60, 2, '.', ''));
    }

  }
  sort($return);
  $queryRange = "SELECT consistencyRange, consistencyTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
} elseif ($content == 'consistencyearlylatediary') {
  $keyword = 'sleepConsistency';
  $rangekeyword = 'consistencyRange';
  // array_push($return, $studentArray);
  foreach ($studentList as $student) {
    $result = mysql_query("SELECT timeLightsOff FROM diary_data_table WHERE timeLightsOff IS NOT NULL AND userId=$student");
    $array = [];
    while($row = mysql_fetch_array($result)){
      array_push($array, $row['timeLightsOff']);
    }
    $noonSecond = strtotime("12:00:00");
    $midNight = strtotime("00:00:00");
    $earliestBed = earliestBedTime($array, $noonSecond);
    $lastBed = lastBedTime($array, $noonSecond);
    $earliestBed = strtotime($earliestBed);
    $lastBed = strtotime($lastBed);
    if($lastBed >= $noonSecond){
       $diffBedTime = $lastBed - $earliestBed;
    }else{
       if($earliestBed >= $noonSecond){
           $diffBedTime = $lastBed - $midNight + strtotime("23:59:59") - $earliestBed;
       }else{
           $diffBedTime = $lastBed - $earliestBed;
       }
    }

    if ($diffBedTime>0) {
      array_push($return, number_format((float)$diffBedTime/60, 2, '.', ''));
    }
  }
  sort($return);
  $queryRange = "SELECT consistencyRange, consistencyTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
} elseif ($content == 'qualityrating') {
  $keyword = 'sleepQuality';
  $rangekeyword = 'qualityRange';
  $result = mysql_query("SELECT AVG(find_in_set(sleepQuality,'veryRestless,restless,average,sound,verySound')) as qualityNum FROM diary_data_table WHERE sleepQuality IS NOT NULL AND userId IN $studentArray group by userId");
  while($row = mysql_fetch_array($result)){
    $array = array_filter(explode(',', $row['qualityNum']));
    $quality = array_sum($array)/count($array);
    array_push($return, number_format((float)$quality, 2, '.', ''));
  }

  $queryRange = "SELECT qualityRange, qualityTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
  sort($return);
} elseif ($content == 'qualityawaken') {
  $keyword = 'sleepQuality';
  $rangekeyword = 'qualityRange';
  $result = mysql_query("SELECT awakeTime FROM my_actogram WHERE awakeTime IS NOT NULL AND userId IN $studentArray");
  while($row = mysql_fetch_array($result)){
    $array = array_filter(explode(',', $row['awakeTime']));
    $quality = array_sum($array)/count($array);
    array_push($return, number_format((float)$quality, 2, '.', ''));
  }

  $queryRange = "SELECT qualityRange, qualityTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
  sort($return);
} elseif ($content == 'qualitywakeupstate') {
  $keyword = 'sleepQuality';
  $rangekeyword = 'qualityRange';
  $queryCommandSleep = "SELECT AVG(wokeupState) as $keyword, userId FROM diary_data_table WHERE wokeupState IS NOT NULL AND userId IN $studentArray GROUP BY userId ORDER BY $keyword";
  $result = mysql_query($queryCommandSleep);
  $numRow = mysql_num_rows ($result);
  if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      array_push($return, $row[$keyword]);
    }
  }

  $queryRange = "SELECT qualityRange, qualityTitle as title FROM ourzzzdata WHERE classId = $classId";
  $rangeResult = mysql_query($queryRange);
  sort($return);
}


$test = '< 6 hours;≥ 6 hours < 7 hours;≥ 7 hours < 8 hours;≥ 8 hours < 9 hours;≥ 9 hours';

$numRow = mysql_num_rows ($rangeResult);
if ($numRow>0) {
  $row = mysql_fetch_array($rangeResult);
  if ($content == $titleDict[$row['title']]) {
    $range = explode(';',$row[$rangekeyword]);
  }else {
    $range = explode(';',$rangeDict[$content]);
  }
}


echo json_encode(
    array(
      "result" => $return,
      "range" => $range
    )
);
?>
