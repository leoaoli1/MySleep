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
session_start();
$userId = $_SESSION['userId'];
if ($userId == ""){
	header("Location: login");
	exit;
}
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
?>

<html>

<body>

<?php
include 'connectdb.php';
$grade = getClassGrade($classId);
$resultLink = getUserIdsInSchool($schoolId);
$arrUpdateId = [];
if (isset($_POST['addClass'])) {	
    /*foreach ($resultLink as $user) {
        $result = mysql_query("SELECT * FROM class_table where userId ='$user'");
        if(mysql_num_rows($result)==0) {
	    array_push($arrId, $user);
        }	
       }*/
    foreach ($resultLink as $studentId){
	if(isset($_POST['checkbox'.$studentId])){
	if($_POST['checkbox'.$studentId] == "on"){
	    array_push($arrUpdateId, $studentId);
	}
	    }
    }
    foreach($arrUpdateId as $updateStudentId){
        $result = mysql_query("INSERT INTO class_table (userId, classId) VALUES ('$updateStudentId','$classId')");
	$result = mysql_query("INSERT INTO class_tracking_table (userId, classId) VALUES ('$updateStudentId','$classId')");
        $status = mysql_query("UPDATE user_table SET currentGrade='$grade', classId='$classId' WHERE userId='$updateStudentId'");
	if (!$status) {
	    error_exit( mysql_error());
	}
	}
}
elseif (isset($_POST['deleteClass'])) {
    /*foreach ($resultLink as $user) {
        $result = mysql_query("SELECT * FROM class_table where userId ='$user' And classId = '$classId'");
        $row = mysql_fetch_array($result);
        if(isset($row['classId'])) {
            array_push($arrId, $user);
        }
       }*/
    foreach ($resultLink as $studentId){
	if(isset($_POST['checkbox'.$studentId])){
	if($_POST['checkbox'.$studentId] == "on"){
	    array_push($arrUpdateId, $studentId);
	}
	    }
    }
    foreach($arrUpdateId as $updateStudentId){
	$result = mysql_query("DELETE FROM class_table WHERE userId='$updateStudentId' AND classId='$classId'");
	mysql_query("UPDATE user_table SET currentGrade=NULL, classId=NULL WHERE userId='$updateStudentId'");
    }
}
mysql_close($con);
//exit;
?> 

<script>
    history.go(-1); 
</script>

</body>
</html> 
