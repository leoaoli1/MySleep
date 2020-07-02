<?php
    #
    # Part of the MySleep package
    #
    # University of Arizona Own the Copyright
    #
    # Author: Siteng Chen 
    #
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
$currentGrade = getCurrentGrade($userId);

$resultRow = $_POST['resultRow'];
$type = $_POST['type'];
$myResultRow = $_POST['myResultRow'];

 include 'connectdb.php';

$result = mysql_query("SELECT * FROM fourthGradeLessonOneWhySleep WHERE resultRow = '$myResultRow'");
$numRow = mysql_num_rows ($result);
$agrees = [];
if ($numRow>0) {
      $row = mysql_fetch_array($result);
      $agrees = explode(",",$row['agree']);
      $disagrees = explode(",",$row['disagree']);
      if ($type == 'agree') {
        array_push($agrees,$resultRow);
        $agrees = array_unique($agrees);
        if (($key = array_search($resultRow, $disagrees)) !== false) {
            unset($disagrees[$key]);
        }
      }elseif ($type == 'disagree') {
        array_push($disagrees,$resultRow);
        $disagrees = array_unique($disagrees);
        if (($key = array_search($resultRow, $agrees)) !== false) {
            unset($agrees[$key]);
        }
      }
      $agree = implode(",",$agrees);
      $disagree = implode(",",$disagrees);
      $status = mysql_query("UPDATE fourthGradeLessonOneWhySleep SET agree='$agree', disagree='$disagree' WHERE resultRow = '$myResultRow'");
      if (!$status) {
          $message = 'Could not enter answers to the database: ' . mysql_error();
          error_exit($message);
      }
}
mysql_close($con);
echo count($agrees);


 ?>
