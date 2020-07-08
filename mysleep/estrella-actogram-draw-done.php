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

$contributor = $_POST['contributors'];
$contributors = join(",", $contributor);
$img = $_POST['image'];
$type = $_POST['type'];

 include 'connectdb.php';

$result = mysql_query("SELECT * FROM estrellaActogramDraw WHERE contributors LIKE '%$userId%' order by recordRow DESC LIMIT 1");
$numRow = mysql_num_rows ($result);
if ($type == 'startover' & $numRow>0){
    $row = mysql_fetch_array($result);
    $rowNum = $row['recordRow'];
    $status = mysql_query("DELETE FROM estrellaActogramDraw WHERE recordRow='$rowNum'");
    if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
    }
    mysql_close($con);
    echo $numRow;
} elseif ($type == 'hunt'){
    if ($numRow>0) {
        $row = mysql_fetch_array($result);
        $rowNum = $row['recordRow'];
        $status = mysql_query("UPDATE estrellaActogramDraw SET dataHunt='$img', contributors='$contributors' WHERE recordRow='$rowNum'");
        if (!$status) {
            $message = 'Could not enter answers to the database: ' . mysql_error();
            error_exit($message);
        }
    }else {
        $status = mysql_query("INSERT INTO  estrellaActogramDraw(userId, dataHunt, contributors, classId) VALUES ('$userId', '$img', '$contributors', '$classId')");
        if (!$status) {
            $message = 'Could not add answers to the database: ' . mysql_error();
            error_exit($message);
        }
    }
mysql_close($con);
echo $numRow;
}



 ?>
