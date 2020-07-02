<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$userId= $_SESSION['userId'];
$studentIdList = getUserIdsInClass($classId);

$whatSleepAnswerList = [];
$ID = [];
$resultRows = [];
$agree = [];
$disagree = [];
$notSure = [];
$myResult = mysql_fetch_row(mysql_query("SELECT agree, disagree, notSure, resultRow FROM fourthGradeLessonOneWhatSleep WHERE contributors LIKE '%$userId%'"));
$myAgrees = $myResult[0];
$myDisagrees = $myResult[1];
$myNotSure = $myResult[2];
$myResultRow = $myResult[3];
$yourself = [];
$result = mysql_query("SELECT userId, response, resultRow FROM fourthGradeLessonOneWhatSleep WHERE submit IS NOT NULL");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      	$studentId = $row['userId'];
        $resultRow = $row['resultRow'];
      	if (in_array($studentId, $studentIdList)) {
      	    array_push($resultRows, $resultRow);
      	    array_push($ID, $studentId);
      	    array_push($whatSleepAnswerList, $row['response']);
            // array_push($agree, $myAgrees);
            array_push($yourself, strcmp($myResultRow,$resultRow));
            if (strpos($myAgrees, $resultRow) !== false) {
                array_push($agree, '');
                array_push($disagree, '-o');
                array_push($notSure, '-o');
            } elseif (strpos($myDisagrees, $resultRow) !== false) {
                array_push($agree, '-o');
                array_push($disagree, '');
                array_push($notSure, '-o');
            } elseif (strpos($myNotSure, $resultRow) !== false) {
                array_push($agree, '-o');
                array_push($disagree, '-o');
                array_push($notSure, '');
            } else {
                array_push($agree, '-o');
                array_push($disagree, '-o');
                array_push($notSure, '-o');
            }

      	}
    }
}

echo json_encode(
    array("whatSleepAnswer" => $whatSleepAnswerList,
    "resultRows" => $resultRows,
    "idList" => $ID,
    "agree" => $agree,
    "disagree" => $disagree,
    "notsure" => $notSure,
    "yourself" => $yourself,
    "myResultRow" => $myResultRow
    )
);
?>
