<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#                                                                           #
# Filename: MemoryTaskDone.php                                              #
#                                                                           #
# Purpose:  To recieve and handle form input from MemoryTask.php            #
#                                                                           #
#############################################################################

require_once('utilities.php'); 
require_once('connectdb.php');
checkAuth();

# SET UP DATA

$userId = $_SESSION['userId'];

$tableData = stripcslashes($_POST['pTableData']); // Unescape the string values in the JSON array

$tableData = json_decode($tableData,TRUE); // Decode the JSON array

$result= mysql_query("SELECT COUNT(DISTINCT turn) as cnt FROM memoryTaskResults WHERE userId='$userId'");
$row = mysql_fetch_array($result);
$turn = $row['cnt'];
$turn += 1;
foreach ($tableData as $row) {
    $trialNum = $row['trialNum'];
    $trialType = $row['trialType'];
    $response = $row['response'];
    $time = $row['time'];
    $letterShown = $row['letterShown'];
    $letterTwoBack = $row['letterTwoBack'];
    $sql = "INSERT INTO memoryTaskResults (userId, turn, trialNum, trialType, response, time, letterShown, letterTwoBack) VALUES ('$userId', '$turn', '$trialNum', '$trialType', '$response', '$time', '$letterShown', '$letterTwoBack')";
    mysql_query($sql) or die(mysql_error());
}
            
?>
