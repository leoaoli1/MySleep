<?php
    #
    # Part of the MySleep package
    #
    # University of Arizona Own the Copyright
    #
    # Author: Siteng Chen <sitengchen@email.arizona.edu>
    #
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];

$type = $_POST['type'];
$contributor = $_POST['contributors'];
$contributors = join(",", $contributor);
$d1 = $_POST['d1'];
$d2 = $_POST['d2'];
$d3 = $_POST['d3'];
$d4 = $_POST['d4'];
$d5 = $_POST['d5'];
$d6 = $_POST['d6'];


if ($type == 'analysis') {
  $watch1 = $_POST['watch1'];
  $watch2 = $_POST['watch2'];
  $watch3 = $_POST['watch3'];
  $diary1 = $_POST['diary1'];
  $diary2 = $_POST['diary2'];
  $diary3 = $_POST['diary3'];

  include 'connectdb.php';
  $result = mysql_query("SELECT * FROM mySleepData WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
  $numRow = mysql_num_rows ($result);
    if ($numRow>0) {
        $row = mysql_fetch_array($result);
        $rowNum = $row['resultRow'];
        $status = mysql_query("UPDATE mySleepData SET A1='$d1',A2='$d2',A3='$d3',A4='$d4',A5='$d5',A6='$d6',watch1='$watch1',watch2='$watch2',watch3='$watch3',diary1='$diary1',diary2='$diary2',diary3='$diary3',contributors='$contributors'  WHERE resultRow='$rowNum'");
        if (!$status) {
            $message = 'Could not enter answers to the database: ' . mysql_error();
            error_exit($message);
        }
        $numRow = 'success update';
    }else {
        $status = mysql_query("INSERT INTO  mySleepData(userId, A1, A2, A3, A4, A5, A6, watch1,watch2,watch3,diary1,diary2,diary3, classId, contributors, submit) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$watch1','$watch2','$watch3','$diary1','$diary2','$diary3','$classId','$contributors',1)");
        if (!$status) {
            $message = 'Could not add answers to the database: ' . mysql_error();
            error_exit($message);
        }
        $numRow = 'success create';
    }
  mysql_close($con);
  echo $numRow;
} else {
  include 'connectdb.php';
  $result = mysql_query("SELECT * FROM mySleepData WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
  $numRow = mysql_num_rows ($result);
    if ($numRow>0) {
        $row = mysql_fetch_array($result);
        $rowNum = $row['resultRow'];
        $status = mysql_query("UPDATE mySleepData SET D1='$d1',D2='$d2',D3='$d3',D4='$d4',D5='$d5',D6='$d6',contributors='$contributors'  WHERE resultRow='$rowNum'");
        if (!$status) {
            $message = 'Could not enter answers to the database: ' . mysql_error();
            error_exit($message);
        }
        $numRow = 'success update';
    }else {
        $status = mysql_query("INSERT INTO  mySleepData(userId, D1, D2, D3, D4, D5, D6, classId, contributors, submit) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$classId','$contributors',1)");
        if (!$status) {
            $message = 'Could not add answers to the database: ' . mysql_error();
            error_exit($message);
        }
        $numRow = 'success create';
    }
  mysql_close($con);
  echo $numRow;
}

 ?>
