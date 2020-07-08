<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
require_once('utilities.php');
require_once('utilities-actogram.php');
session_start();
$userId= $_SESSION['userId'];

if(isset($_POST['id'])){
    include 'connectdb.php';
    $workId = $_POST['id'];
    $result = mysql_query("SELECT * FROM estrellaActogramDraw WHERE recordRow='$workId' order by recordRow DESC LIMIT 1");

    // Get actigram src
    if(mysql_num_rows($result)>0) {
    	$row = mysql_fetch_array($result);
    	$dataHunt=$row['dataHunt'];
      $score = $row['score'];
      $comment = $row['comment'];
    }

    echo json_encode(
  	   array("dataHunt" => $dataHunt,
              "workId" => $workId,
              "score" => $score,
              "comment" => $comment)
    );
    mysql_close($con);
}
exit;
?>
