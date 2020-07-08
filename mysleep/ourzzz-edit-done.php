<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$userId= $_SESSION['userId'];

$keyword = $_POST['keyword'];
$dataArray = $_POST['dataArray'];
$data = implode(';',$dataArray);
$range = $_POST['range'];

$query = '';
$column = '';
$columnRange = '';
$title = '';
$result = mysql_query("SELECT * FROM ourzzzdata WHERE classId = $classId");
$numRow = mysql_num_rows ($result);

if ($keyword == 'sleephourdiary' || $keyword == 'sleephourwatch') {
  if ($keyword == 'sleephourdiary') {
    $title = 'Average Sleep Duration (Sleep Diary)';
  }else {
    $title = 'Average Sleep Duration (Sleep Watch)';
  }
  if ($numRow>0) {
      $query = "UPDATE ourzzzdata SET duration='$data', durationRange='$range', durationTitle='$title' WHERE classId='$classId'";
  }else {
      $query = "INSERT INTO  ourzzzdata(classId, duration, durationRange, durationTitle) VALUES ('$classId', '$data', '$range','$title')";
  }
} elseif ($keyword == 'consistencyearlylatediary' || $keyword == 'consistencyearlylate') {
  if ($keyword == 'consistencyearlylatediary') {
    $title = 'Average Sleep Consistency (Sleep Diary)';
  }else {
    $title = 'Average Sleep Consistency (Sleep Watch)';
  }
  if ($numRow>0) {
      $query = "UPDATE ourzzzdata SET consistency='$data', consistencyRange='$range', consistencyTitle='$title' WHERE classId='$classId'";
  }else {
      $query = "INSERT INTO  ourzzzdata(classId, consistency, consistencyRange, consistencyTitle) VALUES ('$classId', '$data', '$range', '$title')";
  }
} elseif ($keyword == 'qualityrating' || $keyword == 'qualityawaken') {
  if ($keyword == 'qualityrating') {
    $title = 'Sleep Diary (Sleep Quality ratings)';
  }elseif ($keyword == 'qualityawaken') {
    $title = 'Sleep Watch (Awakenings)';
  }
  if ($numRow>0) {
      $query = "UPDATE ourzzzdata SET quality='$data', qualityRange='$range', qualityTitle='$title' WHERE classId='$classId'";
  }else {
      $query = "INSERT INTO  ourzzzdata(classId, quality, qualityRange, qualityTitle) VALUES ('$classId', '$data', '$range', '$title')";
  }
}
 $status = mysql_query($query);
 if (!$status) {
     $message = 'Could not add answers to the database: ' . mysql_error();
     error_exit($message);
 }


mysql_close($con);
echo $status;
?>
