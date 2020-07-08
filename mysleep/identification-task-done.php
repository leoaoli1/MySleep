<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#                                                                           #
# Filename: IdentificationTaskDone.php                                      #
#                                                                           #
# Purpose:  To recieve and handle form input from IdentificationTask.php    #
#                                                                           #
#############################################################################

require_once('utilities.php'); 
require_once('connectdb.php');
checkAuth();

# SET UP DATA

$userId = $_SESSION['userId'];

$tableData = stripcslashes($_POST['pTableData']); // Unescape the string values in the JSON array

$tableData = json_decode($tableData,TRUE); // Decode the JSON array

$result= mysql_query("SELECT COUNT(DISTINCT turn) as cnt FROM identificationTaskResults WHERE userId='$userId'");
$row = mysql_fetch_array($result);
$turn = $row['cnt'];
$turn += 1;
array_pop($tableData);
foreach ($tableData as $row) {
    $card = $row['card'];
    $suit = $row['suit'];
    $response = $row['response'];
    $time = $row['time'];
    $sql = "INSERT INTO identificationTaskResults (userId, turn, suit, card, response, time) VALUES ('$userId', '$turn', '$suit', '$card',  '$response', '$time')";
    mysql_query($sql) or die(mysql_error());
}

mysql_close($con);
?>
