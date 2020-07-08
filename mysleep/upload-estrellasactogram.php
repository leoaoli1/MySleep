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

 $img = $_POST['image'];
 $type = $_POST['type'];
 $d1 = $_POST['d1'];
 $d2 = $_POST['d2'];
 $d3 = $_POST['d3'];
 $d4 = $_POST['d4'];
 $d5 = $_POST['d5'];
 $d6 = $_POST['d6'];
 $ds = $_POST['ds'];

 include 'connectdb.php';

      if($type=='hunt'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE userId='$userId' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);

          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoEstrellaActogram SET dataHunt='$img' WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoEstrellaActogram(userId, dataHunt) VALUES ('$userId', '$img')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }

      }
      else if($type=='data'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE userId='$userId' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);
          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoEstrellaActogram SET D1='$d1',D2='$d2',D3='$d3',D4='$d4',D5='$d5',D6='$d6',DS='$ds' WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoEstrellaActogram(userId, D1, D2, D3, D4, D5, D6, DS) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$ds')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }
      }
      else if($type=='diary'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE userId='$userId' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);
          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoEstrellaActogram SET S1='$d1',S2='$d2',S3='$d3',S4='$d4',S5='$d5',S6='$d6',SS='$ds' WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoEstrellaActogram(userId, S1, S2, S3, S4, S5, S6, SS) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$ds')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }
      }else if($type=='mydata'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoMySleepDataHunt WHERE userId='$userId' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);
          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoMySleepDataHunt SET D1='$d1',D2='$d2',D3='$d3',D4='$d4',D5='$d5',D6='$d6',DS='$ds' WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoMySleepDataHunt(userId, D1, D2, D3, D4, D5, D6, DS) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$ds')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }
      }
      else if($type=='mydiary'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoMySleepDataHunt WHERE userId='$userId' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);
          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoMySleepDataHunt SET S1='$d1',S2='$d2',S3='$d3',S4='$d4',S5='$d5',S6='$d6',SS='$ds' WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoMySleepDataHunt(userId, S1, S2, S3, S4, S5, S6, SS) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$ds')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }
      }
      mysql_close($con);
      echo $numRow;


 ?>
