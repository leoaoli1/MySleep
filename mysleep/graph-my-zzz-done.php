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

$contributor = $_POST['contributors'];
$contributors = join(",", $contributor);
$d1 = $_POST['d1'];
$d2 = $_POST['d2'];
$d3 = $_POST['d3'];
$d4 = $_POST['d4'];
$d5 = $_POST['d5'];
$d6 = $_POST['d6'];
$type = $_POST['type'];

include 'connectdb.php';
      $result = mysql_query("SELECT * FROM mySleepData WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
      $numRow = mysql_num_rows ($result);
        if ($numRow>0) {
            $row = mysql_fetch_array($result);
            $rowNum = $row['resultRow'];
            if ($type=='watch') {
              $status = mysql_query("UPDATE mySleepData SET W1='$d1',W2='$d2',W3='$d3',W4='$d4',W5='$d5',W6='$d6',contributors='$contributors'  WHERE resultRow='$rowNum'");
            }elseif ($type == 'diary') {
              $status = mysql_query("UPDATE mySleepData SET D1='$d1',D2='$d2',D3='$d3',D4='$d4',D5='$d5',D6='$d6',contributors='$contributors'  WHERE resultRow='$rowNum'");
            }
            elseif ($type == 'question') {
              $status = mysql_query("UPDATE mySleepData SET A1='$d1',A2='$d2',A3='$d3',A4='$d4',A5='$d5',A6='$d6',contributors='$contributors'  WHERE resultRow='$rowNum'");
            }
            if (!$status) {
                $message = 'Could not enter answers to the database: ' . mysql_error();
                error_exit($message);
            }
            $numRow = 'success update';
        }else {
          if ($type=='watch') {
            $status = mysql_query("INSERT INTO  mySleepData(userId, W1, W2, W3, W4, W5, W6, classId, contributors, submit) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$classId','$contributors',1)");
          }elseif ($type == 'diary') {
            $status = mysql_query("INSERT INTO  mySleepData(userId, D1, D2, D3, D4, D5, D6, classId, contributors, submit) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$classId','$contributors',1)");
          }
          elseif ($type == 'question') {
            $status = mysql_query("INSERT INTO  mySleepData(userId, A1, A2, A3, A4, A5, A6, classId, contributors, submit) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$classId','$contributors',1)");
          }

            if (!$status) {
                $message = 'Could not add answers to the database: ' . mysql_error();
                error_exit($message);
            }
            $numRow = 'success create';
        }
      mysql_close($con);
      echo $numRow;
 ?>
