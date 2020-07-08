<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#

require_once('utilities.php');
checkauth();
$userId= $_SESSION['userId'];
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];


include 'connectdb.php';

$grade = getClassGrade($classId);
$resultLink = getUserIdsInClass($classId);
$arrId = [];
foreach ($resultLink as $studentId){
    if($_POST['checkbox'.$studentId] == 'on'){
		array_push($arrId, $studentId);
	}
}
	
foreach($arrId as $updateId){
	if($grade == 4){
		mysql_query("UPDATE user_table SET diaryStartDateFour='$startDate', diaryEndDateFour='$endDate' WHERE userId='$updateId'");
	}else{
		mysql_query("UPDATE user_table SET diaryStartDateFive='$startDate', diaryEndDateFive='$endDate' WHERE userId='$updateId'");
    }
}	           	


mysql_close($con);
header("Location: set-diary-date");
exit;
?>

