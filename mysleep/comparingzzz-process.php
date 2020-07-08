<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$studentIdList = getUserIdsInClass($classId);
$databaseName = 'fourthGradeComparingzzz';
$whySleepAnswerList = [];
$ID = [];
$First = [];
$Last = [];
$answer1 = [];
$answer2 = [];
$answer3 = [];
$answer4 = [];

$result = mysql_query("SELECT userId, answer1, answer2, answer3, answer4, resultRow FROM $databaseName WHERE submit IS NOT NULL");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      	$studentId = $row['userId'];
        $resultRow = $row['resultRow'];

      	if (in_array($studentId, $studentIdList)) {
      	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
      	    array_push($First, $firstname);
      	    array_push($Last, $lastname);
      	    array_push($ID, $studentId);
      	    array_push($answer1, $row['answer1']);
            array_push($answer2, $row['answer2']);
            array_push($answer3, $row['answer3']);
            array_push($answer4, $row['answer4']);
      	}
    }
}

echo json_encode(
    array("whySleepAnswer" => $whySleepAnswerList,
    "firstList" => $First,
    "lastList" => $Last,
    "idList" => $ID,
    "answer1" => $answer1,
    "answer2" => $answer2,
    "answer3" => $answer3,
    "answer4" => $answer4
    )
);
?>
