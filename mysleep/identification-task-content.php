<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$resultTable = "";
//$count = 1;
if(isset($_POST['id'])){
    include 'connectdb.php';
    $studentId = $_POST['id'];
    
    $result = mysql_query("SELECT DISTINCT turn FROM identificationTaskResults WHERE userId='$studentId' ORDER BY id");
    while($row= mysql_fetch_array($result)){
	$turn = $row['turn'];
	//debugToConsole('submitTime', $submitTime);
	$resultDetial = mysql_query("SELECT turn, suit, card, response, time, submitTime FROM identificationTaskResults WHERE userId='$studentId' AND turn='$turn'");
	$sum = 0;
	$j = 0;
	$average = 0;
	while($rowDetial = mysql_fetch_array($resultDetial)){
	    $main = "<td>".$rowDetial["turn"]."</td><td>".$rowDetial["suit"]."</td><td>".$rowDetial["card"]."</td><td>".$rowDetial["response"]."</td><td>".$rowDetial["time"]."</td><td>".$rowDetial["submitTime"]."</td>";
	    $append = "<tr>".$main."</tr>";
	    $resultTable .= $append;
	    //$count += 1;

	    $j += 1;
	    //debugToConsole('time', $row['time']);
	    $sum += $rowDetial['time'];
	}
	
	$average = $sum / $j;
	$resultTable .= "<tr><td>Average</td><td></td><td></td><td></td><td>".ceil($average)."</td><td></td></tr>";
    }
    
    echo json_encode(
	array("resultTable" => $resultTable)
    );
    mysql_close($con);
}
exit;
?>
