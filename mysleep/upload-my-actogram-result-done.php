<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
    header("Location: login.php");
    exit;
}
$menuGrade = $_GET['grade'];
if (isset($_POST['quit'])) {
    if($menuGrade == 4){
	header("Location: fourth-grade-lesson-menu.php?lesson=2");
    }else{
	header("Location: fifth-grade-lesson-menu.php?lesson=2");
	}
    exit;
}


$studentId = $_POST['userId'];
$grade = getCurrentGrade($studentId);

include 'connectdb.php';
//Get Image File Data
//header("Content-type:text/html;charset:utf-8");
//header("content-type: image/png");
$file=$_FILES['actigraphy'];
$fname=$file['name'];
$ftype=strtolower(substr(strrchr($fname,'.'),1));
$uploadfile=$file['tmp_name'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(is_uploaded_file($uploadfile)){
	//echo $file['size'];
	if($ftype!='png' && $ftype!='PNG'){
	    echo "Import file type is error";
	    exit;   
	}

	$image = addslashes($file['tmp_name']);
	//$path = $file['tmp_name'];
	$data = file_get_contents($image);
	$base64 = base64_encode($data);
	//echo $base64;

	//Save to database
	$result = mysql_query("SELECT resultRow, userId, grade, imgSrc FROM my_actogram WHERE userId='$studentId' and grade='$grade' order by resultRow DESC LIMIT 1");
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
	    $row = mysql_fetch_array($result);
	    $rowNum = $row['resultRow'];
	    $status = mysql_query("UPDATE my_actogram SET imgSrc='$base64' WHERE resultRow='$rowNum'"); 
	    if (!$status) {
		$message = 'Could not enter answers to the database: ' . mysql_error();
		error_exit($message);
	    }
	}else {
	    $status = mysql_query("INSERT INTO  my_actogram(userId, grade, imgSrc) VALUES ('$studentId', '$grade', '$base64')"); 
	    if (!$status) {
		$message = 'Could not enter answers to the database: ' . mysql_error();
		error_exit($message);
	    }
	}	
    }
}




//Get Raw Data File Data
$rawDataFile=$_FILES['rawData'];
$rawDataFname=$rawDataFile['name'];
$rawDataFtype=strtolower(substr(strrchr($rawDataFname,'.'),1));
//log_info("Uploaded file: ".$rawDataFname);

$uploadRawDataFile=$rawDataFile['tmp_name'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(is_uploaded_file($uploadRawDataFile)){
	//echo $file['size'];
	if($rawDataFilefile['size']>$max_size){
	    echo "Import file is too large"; 
	    exit;
	}
	if($rawDataFtype!='csv'){
	    echo "Import file type is error";
	    exit;   
	}
	list($startDate, $startDay, $endDate, $endDay, $bedTime, $getUpTime, $timeInBed, $totalSleepTime, $timeItTookToFallAsleep, $averageSleepQuality, $numberOfAwak, $awakeTime) = saveActiWareFileData($uploadRawDataFile);
	
	   /*echo $startDate."<br>";
	   echo $startDay."<br>";
	   echo $endDate."<br>";
	   echo $endDay."<br>";
	   echo $bedTime."<br>";
	   echo $getUpTime."<br>";
	   echo $timeInBed."<br>";
	   echo $totalSleepTime."<br>";
	   echo $timeItTookToFallAsleep."<br>";
	   echo $averageSleepQuality."<br>";
	   echo $numberOfAwak."<br>";
	   echo $awakeTime."<br>";*/

	
	//Save to database
	$result = mysql_query("SELECT resultRow, userId, grade, startDate, startDay, endDate, endDay, bedTime, getUpTime, timeInBed, totalSleepTime, timeItTookToFallAsleep, averageSleepQuality, numberOfAwak, awakeTime FROM my_actogram WHERE userId='$studentId' and grade='$grade' order by resultRow DESC LIMIT 1");
	$numRow = mysql_num_rows ($result);

	if ($numRow>0) {
	    $row = mysql_fetch_array($result);
	    $rowNum = $row['resultRow'];
	    $status = mysql_query("UPDATE  my_actogram SET startDate='$startDate', startDay='$startDay', endDate='$endDate', endDay='$endDay', bedTime='$bedTime', getUpTime='$getUpTime', timeInBed='$timeInBed', totalSleepTime='$totalSleepTime', timeItTookToFallAsleep='$timeItTookToFallAsleep', averageSleepQuality='$averageSleepQuality', numberOfAwak='$numberOfAwak', awakeTime='$awakeTime' WHERE resultRow='$rowNum'"); 
	    if (!$status) {
		$message = 'Could not enter answers to the database: ' . mysql_error();
		error_exit($message);
	    }
	}else {
	    $status = mysql_query("INSERT INTO  my_actogram(userId, grade, startDate, startDay, endDate, endDay, bedTime, getUpTime, timeInBed, totalSleepTime, timeItTookToFallAsleep, averageSleepQuality, numberOfAwak, awakeTime) VALUES ('$studentId', '$grade', '$startDate', '$startDay', '$endDate', '$endDay', '$bedTime', '$getUpTime', '$timeInBed', '$totalSleepTime', '$timeItTookToFallAsleep', '$averageSleepQuality', '$numberOfAwak', '$awakeTime')"); 
	    if (!$status) {
		$message = 'Could not enter answers to the database: ' . mysql_error();
		error_exit($message);
	    }
	}
    }
}

mysql_close($con);

// Function to read an CSV file exported by Actiware.
function saveActiWareFileData($filename)
{
    //$NUM_DATA_COLUMNS = 72;         Number of columns of data
    $startDate = "";
    $startDay = "";
    $endDate = "";
    $endDay = "";
    $bedTime = "";
    $getUpTime = "";
    $timeInBed = "";
    $totalSleepTime = "";
    $timeItTookToFallAsleep = "";
    $averageSleepQuality = "";
    $numberOfAwak = "";
    $awakeTime = "";

    //echo "Done 1";

    $fhandle = fopen($filename, 'r');
    while (!feof($fhandle)) {
        $lines[] = fgetcsv($fhandle, $delimiter=',');
    }
    fclose($fhandle);
    
    //print_r($lines);
    
    $row=0;
    // Skip over lines to get to the data
    for (; $row<count($lines); $row++) {
        //if (count($lines[$row]) != $NUM_DATA_COLUMNS)
        //    continue;
        // Verify data type
        if ($lines[$row][0] != "Interval Type")
            continue;
        if ($lines[$row][2] != "Start Date")
            continue;
        if ($lines[$row][3] != "Start Day")
            continue;
        if ($lines[$row][4] != "Start Time")
            continue;
        break;
    }

    $headerRow = $row;

    //echo $row;
    //echo "Done 2";
    
    if ($row == count($lines)) {          // Nothing has been found
        log_error($filename);
        log_error("No data header is found in file.");
        return;
    }

    // Skip over lines to get to the data
    for (; $row<count($lines); $row++) {
        //if (count($lines[$row]) != $NUM_DATA_COLUMNS)
        //    continue;
        if ($lines[$row][0] != "REST")
            continue;
        break;
    }
    if ($row == count($lines)) {          // Nothing has been found
        log_error($filename);
        log_error("No data header is found in file.");
        return;
    }
    
    //echo $row;
    //echo "Done 3";
    $firstDataRow = $row;
    
    $i = $firstDataRow;
    while ($i < count($lines)) {
        //if (count($lines[$i]) != $NUM_DATA_COLUMNS)
        //    break;
        if ($lines[$i][0] != "REST")
            break;
        
	$numCol = count($lines[$i]);
	for($index=0; $index<$numCol; $index++){
            if($lines[$headerRow][$index] == "Start Date"){
		$startDate = $startDate.$lines[$i][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "Start Day"){
		$startDay = $startDay.$lines[$i][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "Start Time"){
		$bedTime = $bedTime.$lines[$i][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "End Date"){
		$endDate = $endDate.$lines[$i][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "End Day"){
		$endDay = $endDay.$lines[$i][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "End Time"){
		$getUpTime = $getUpTime.$lines[$i][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "Duration"){
	        $timeInBed = $timeInBed.$lines[$i][$index].",";
		continue;
            }   
	}
        $i++;
    }
    if ($i == $firstDataRow) {         // No data
        log_error($filename);
        log_error("No data is found in file.");
        return;
    }

    //Get Sleep data
    for (; $row<count($lines); $row++) {
        //if (count($lines[$row]) != $NUM_DATA_COLUMNS)
        //    continue;
        if ($lines[$row][0] != "SLEEP")
            continue;
        break;
    }
    if ($row == count($lines)) {          // Nothing has been found
        log_error($filename);
        log_error("No rest data header is found in file.");
        return;
    }
    
    $firstSleepDataRow = $row;
    
    $j = $firstSleepDataRow;

    //echo $row;
    //echo "Done 4";
    while ($j < count($lines)) {
        //if (count($lines[$j]) != $NUM_DATA_COLUMNS)
        //    break;
        if ($lines[$j][0] != "SLEEP")
            break;
	
        $numCol = count($lines[$i]);
	for($index=0; $index<$numCol; $index++){
            if($lines[$headerRow][$index] == "Wake Time"){
		$awakeTime = $awakeTime.$lines[$j][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "Onset Latency"){
		$timeItTookToFallAsleep = $timeItTookToFallAsleep.$lines[$j][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "Efficiency"){
		$averageSleepQuality = $averageSleepQuality.$lines[$j][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "#Wake Bouts"){
		$numberOfAwak = $numberOfAwak.$lines[$j][$index].",";
		continue;
	    }elseif($lines[$headerRow][$index] == "Sleep Time"){
		$totalSleepTime = $totalSleepTime.$lines[$j][$index].",";
		continue;
	    }
	}
        $j++;
    }
    if ($j == $firstSleepDataRow) {         // No data
        log_error($filename);
        log_error("No Sleep data is found in file.");
        return;
    }

    //echo "Done";
    return  array(
	$startDate,
	$startDay,
	$endDate,
	$endDay,
	$bedTime,
	$getUpTime,
	$timeInBed,
	$totalSleepTime,
	$timeItTookToFallAsleep,
	$averageSleepQuality,
	$numberOfAwak,
	$awakeTime
    );
    
}


if($menuGrade == 4){
    header("Location: fourth-grade-lesson-menu.php?lesson=2");
}else{
    header("Location: fifth-grade-lesson-menu.php?lesson=2");
}
exit;

?>
