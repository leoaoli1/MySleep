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
$type = $_POST['type'];
$d1 = $_POST['d1'];
$d2 = $_POST['d2'];
$d3 = $_POST['d3'];
$d4 = $_POST['d4'];
$d5 = $_POST['d5'];
$d6 = $_POST['d6'];
$ds = $_POST['ds'];

include 'connectdb.php';

      if($type=='data'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE contributors LIKE '%$userId%' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);
          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoEstrellaActogram SET D1='$d1',D2='$d2',D3='$d3',D4='$d4',D5='$d5',D6='$d6',DS='$ds',contributors='$contributors'  WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoEstrellaActogram(userId, D1, D2, D3, D4, D5, D6, DS, classId, contributors) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$ds','$classId','$contributors')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }
      }
      else if($type=='diary'){
        $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE contributors LIKE '%$userId%' order by recordRow DESC LIMIT 1");
        $numRow = mysql_num_rows ($result);
          if ($numRow>0) {
              $row = mysql_fetch_array($result);
              $rowNum = $row['recordRow'];
              $status = mysql_query("UPDATE fourthGradeLessonTwoEstrellaActogram SET S1='$d1',S2='$d2',S3='$d3',S4='$d4',S5='$d5',S6='$d6',SS='$ds',contributors='$contributors' WHERE recordRow='$rowNum'");
              if (!$status) {
                  $message = 'Could not enter answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }else {
              $status = mysql_query("INSERT INTO  fourthGradeLessonTwoEstrellaActogram(userId, S1, S2, S3, S4, S5, S6, SS, classId, contributors) VALUES ('$userId', '$d1','$d2','$d3','$d4','$d5','$d6','$ds','$classId','$contributors')");
              if (!$status) {
                  $message = 'Could not add answers to the database: ' . mysql_error();
                  error_exit($message);
              }
          }
      }
      mysql_close($con);
      echo $numRow;
 ?>
