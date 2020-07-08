<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$userId= $_SESSION['userId'];
$studentIdList = getUserIdsInClass($classId);

$hypothesisList = [];
$evidenceList = [];
$ID = [];
$resultRows = [];
$agree = [];
$myResult = mysql_fetch_row(mysql_query("SELECT vote, resultRow FROM bigQuestions WHERE contributors LIKE '%$userId%'"));
$myAgrees = $myResult[0];
$myResultRow = $myResult[1];
$yourself = [];
$result = mysql_query("SELECT userId, hypothesis, evidence, resultRow FROM bigQuestions WHERE classId=$classId");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      	$studentId = $row['userId'];
        $resultRow = $row['resultRow'];
      	if (in_array($studentId, $studentIdList)) {
      	    array_push($resultRows, $resultRow);
      	    array_push($ID, $studentId);
      	    array_push($hypothesisList, $row['hypothesis']);
            array_push($evidenceList, $row['evidence']);
            // array_push($agree, $myAgrees);
            array_push($yourself, strcmp($myResultRow,$resultRow));
            if (strpos($myAgrees, $resultRow) !== false) {
                array_push($agree, '');
            } else {
                array_push($agree, '-o');
            }

      	}
    }
}

echo json_encode(
    array("hypothesis" => $hypothesisList,
    "evidence" => $evidenceList,
    "resultRows" => $resultRows,
    "idList" => $ID,
    "agree" => $agree,
    "yourself" => $yourself,
    "myResultRow" => $myResultRow,
    "myAgrees" => $myAgrees
    )
);
?>
