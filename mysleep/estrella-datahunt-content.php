<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#         Siteng Chen <sitengchen@email.arizona.edu>
require_once('utilities.php');
require_once('utilities-actogram.php');
session_start();
$userId= $_SESSION['userId'];


$dailyTable = "";
$dataGraphArray=array(0,0,0,0,0,0,0);
$diaryGraphArray=array(0,0,0,0,0,0,0);
if(isset($_POST['id'])){
    include 'connectdb.php';
    $workId = $_POST['id'];
    $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE recordRow='$workId' order by recordRow DESC LIMIT 1");

    // Get actigram src

    if(mysql_num_rows($result)>0) {
	$row = mysql_fetch_array($result);
	$dataHunt=$row['dataHunt'];
  $dataGraphArray = array($row['D1'],$row['D2'],$row['D3'],$row['D4'],$row['D5'],$row['D6'],$row['DS']);
  $diaryGraphArray = array($row['S1'],$row['S2'],$row['S3'],$row['S4'],$row['S5'],$row['S6'],$row['SS']);
	$datagraphTable = "<td>".$row['D1']."</td><td>".$row['D2']."</td><td>".$row['D3']."</td><td>".$row['D4']."</td><td>".$row['D5']."</td><td>".$row['D6']."</td>";
  $score = $row['score'];
  $comment = $row['comment'];
  }

    echo json_encode(
      	array("dataHunt" => $dataHunt,
      	    "dategraphTable" => $datagraphTable,
            "dataGraphArray" => $dataGraphArray,
            "diaryGraphArray" => $diaryGraphArray,
            "workId" => $workId,
            "score" => $score,
            "comment" => $comment
      	)
    );
    mysql_close($con);
}
exit;
?>
