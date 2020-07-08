<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$studentIdList = getUserIdsInClass($classId);

$hypothesisList = [];
$evidenceList = [];
$ID = [];
$First = [];
$Last = [];
$count = [];

$result = mysql_query("SELECT userId, hypothesis, evidence, resultRow FROM bigQuestions WHERE classId=$classId");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      	$studentId = $row['userId'];
        $resultRow = $row['resultRow'];
        $agreeGroups = mysql_query("SELECT contributors FROM bigQuestions WHERE vote LIKE '%$resultRow%'");
        $numbers = 0;
        while($agreeGroup = mysql_fetch_array($agreeGroups)){
          $numbers = $numbers + count(explode(',',$agreeGroup['contributors']));
        }
      	if (in_array($studentId, $studentIdList)) {
      	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
      	    array_push($First, $firstname);
      	    array_push($Last, $lastname);
      	    array_push($ID, $studentId);
      	    array_push($hypothesisList, $row['hypothesis']);
            array_push($evidenceList, $row['evidence']);
            array_push($count, $numbers);
      	}
    }
}

echo json_encode(
    array("hypothesis" => $hypothesisList,
    "evidence" => $evidenceList,
    "firstList" => $First,
    "lastList" => $Last,
    "idList" => $ID,
    "agreeCount" => $count
    )
);
?>
