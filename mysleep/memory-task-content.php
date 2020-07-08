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
if(isset($_POST['id'])){
    include 'connectdb.php';
    $studentId = $_POST['id'];
    
    $result = mysql_query("SELECT DISTINCT turn FROM memoryTaskResults WHERE userId='$studentId' ORDER BY id");
    while($row= mysql_fetch_array($result)){
	$turn = $row['turn'];
	//debugToConsole('submitTime', $submitTime);
	$resultDetial = mysql_query("SELECT turn, trialType, response, time, letterShown, letterTwoBack, submitTime FROM memoryTaskResults WHERE userId='$studentId' AND turn='$turn'");
	$correct = 0;
	$incorrect = 0;
	$score = 0;
	while($rowDetial = mysql_fetch_array($resultDetial)){
	    $main = "<td>".$rowDetial["turn"]."</td><td>".$rowDetial["trialType"]."</td><td>".$rowDetial["response"]."</td><td>".$rowDetial["time"]."</td><td>".$rowDetial["letterShown"]."</td><td>".$rowDetial["letterTwoBack"]."</td><td>".$rowDetial["submitTime"]."</td>";
	    $append = "<tr>".$main."</tr>";
	    $resultTable .= $append;

	    if($rowDetial['response'] == 'Correct'){
		$correct += 1;
	    }else{
		$incorrect += 1;
	    }
	}
	
	$score = $correct / ($correct + $incorrect);
	$resultTable .= '<tr><td>Score<sup>1</sup></td><td colspan="5">'.number_format($score, 2, '.', ',').'</td></tr>';
    }
    
    echo json_encode(
	array("resultTable" => $resultTable)
    );
    mysql_close($con);
}
exit;
?>
