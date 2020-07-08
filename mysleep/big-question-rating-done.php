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
$currentGrade = getCurrentGrade($userId);

$resultRow = $_POST['resultRow'];
$type = $_POST['type'];
$myResultRow = $_POST['myResultRow'];

 include 'connectdb.php';

$result = mysql_query("SELECT * FROM bigQuestions WHERE resultRow = '$myResultRow'");
$numRow = mysql_num_rows ($result);
$agrees = [];
if ($numRow>0) {
      $row = mysql_fetch_array($result);
      $agrees = explode(",",$row['vote']);
      if ($type == 'agree') {
        if (($key = array_search($resultRow, $agrees)) !== false) {
          unset($agrees[$key]);
        } else {
          array_push($agrees,$resultRow);
          $agrees = array_unique($agrees);
        }
      }
      $agree = implode(",",$agrees);
      $status = mysql_query("UPDATE bigQuestions SET vote='$agree' WHERE resultRow = '$myResultRow'");
      if (!$status) {
          $message = 'Could not enter answers to the database: ' . mysql_error();
          error_exit($message);
      }
}
mysql_close($con);
echo count($agrees);


 ?>
