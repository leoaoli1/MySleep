<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$studentIdList = getUserIdsInClass($classId);

$content = [];
$ID = [];

$result = mysql_query("SELECT userId, content, resultRow FROM bottomLine WHERE submit IS NOT NULL");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
      	$studentId = $row['userId'];
        $resultRow = $row['resultRow'];
      	if (in_array($studentId, $studentIdList)) {
      	    list($firstname, $lastname) = getUserFirstLastNames($studentId);
      	    array_push($ID, $studentId);
      	    array_push($content, $row['content']);
      	}
    }
}

echo json_encode(
    array("content" => $content,
    "idList" => $ID,
    )
);
?>
