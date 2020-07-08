<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$studentIdList = getUserIdsInClass($classId);


$preSchoolNegList = [];
$preSchoolPosList = [];
$preSchoolID = [];
$preSchoolFirst = [];
$preSchoolLast = [];

$schoolNegList = [];
$schoolPosList = [];
$schoolID = [];
$schoolFirst = [];
$schoolLast = [];

$adultNegList = [];
$adultPosList = [];
$adultID = [];
$adultFirst = [];
$adultLast = [];



$result = mysql_query("SELECT userId, preSchoolPos, preSchoolNeg FROM effect_card_test_table WHERE (userId , resultRow) IN (SELECT userId, MAX(resultRow) FROM effect_card_test_table WHERE tag = '1' AND submit = '1' GROUP BY userId) order by resultRow DESC");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
	$studentId = $row['userId'];
	if (in_array($studentId, $studentIdList)) {
	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
	    array_push($preSchoolFirst, $firstname);
	    array_push($preSchoolLast, $lastname);
	    array_push($preSchoolID, $studentId);
	    array_push($preSchoolNegList, $row['preSchoolNeg']);
	    array_push($preSchoolPosList, $row['preSchoolPos']);
	}
    }
}

$result = mysql_query("SELECT userId, schoolAgePos, schoolAgeNeg FROM effect_card_test_table WHERE (userId , resultRow) IN (SELECT userId, MAX(resultRow) FROM effect_card_test_table WHERE tag = '2' AND submit = '1' GROUP BY userId) order by resultRow DESC");
$numRowSchool = mysql_num_rows ($result);
if ($numRowSchool>0) {
    while($row = mysql_fetch_array($result)){
	$studentId = $row['userId'];
	if (in_array($studentId, $studentIdList)) {
	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
	    array_push($schoolFirst, $firstname);
	    array_push($schoolLast, $lastname);
	    array_push($schoolID, $studentId);
	    array_push($schoolNegList, $row['schoolAgeNeg']);
	    array_push($schoolPosList, $row['schoolAgePos']);
	}
    }
}

$result = mysql_query("SELECT userId, adultPos, adultNeg FROM effect_card_test_table WHERE (userId , resultRow) IN (SELECT userId, MAX(resultRow) FROM effect_card_test_table WHERE tag = '3' AND submit = '1' GROUP BY userId) order by resultRow DESC");
$numRowAdult = mysql_num_rows ($result);
if ($numRowAdult>0) {
    while($row = mysql_fetch_array($result)){
	$studentId = $row['userId'];
	if (in_array($studentId, $studentIdList)) {
	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
	    array_push($adultFirst, $firstname);
	    array_push($adultLast, $lastname);
	    array_push($adultID, $studentId);
	    array_push($adultNegList, $row['adultNeg']);
	    array_push($adultPosList, $row['adultPos']);
	}
    }
}

echo json_encode(
    array("preSchoolNegList" => $preSchoolNegList,
	  "preSchoolPosList" => $preSchoolPosList,
	  "preSchoolID" => $preSchoolID,
	  "preSchoolFirst" => $preSchoolFirst,
	  "preSchoolLast" => $preSchoolLast,
	  "schoolNegList" => $schoolNegList,
	  "schoolPosList" => $schoolPosList,
	  "schoolID" => $schoolID,
	  "schoolFirst" => $schoolFirst,
	  "schoolLast" => $schoolLast,
	  "adultNegList" => $adultNegList,
	  "adultPosList" => $adultPosList,
	  "adultID" => $adultID,
	  "adultFirst" => $adultFirst,
	  "adultLast" => $adultLast,
	  "row" => $numRow
    )
);
?>
