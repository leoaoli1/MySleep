<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$studentIdList = getUserIdsInClass($classId);

$sleepAnswerList = [];
$ID = [];

$result = mysql_query("SELECT userId, response, resultRow, COUNT(agree) as total, SUM(agree) as agrees FROM fourthGradeLessonDoAnimalSleep WHERE submit IS NOT NULL");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      	$studentId = $row['userId'];
        $resultRow = $row['resultRow'];
        $agree = $row['agrees'];
        $disagree = $row['total'] - $row['agrees'];
      	if (in_array($studentId, $studentIdList)) {
      	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
      	    array_push($ID, $studentId);
      	    array_push($sleepAnswerList, $row['response']);
      	}
    }
}

echo json_encode(
    array("sleepAnswer" => $sleepAnswerList,
    "idList" => $ID,
    'agrees' => (int)$agree,
    'disagree' => (int)$disagree
    )
);
?>
