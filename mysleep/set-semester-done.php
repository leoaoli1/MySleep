<!DOCTYPE html>
<?php  
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login.php");
	exit;
}

if (isset($_POST['quit'])) {
    header("Location: admin-tools.php");
    exit;
}   
$classId = $_SESSION['classId'];      
?>
<html>
<head>

</head>
<body>
<?php
$currentSemester = $_POST['semester'];
$currentYear = $_POST['year'];
include 'connectdb.php';
require_once('utilities.php');
$result_link = getUserIdsInClass($classId);
for($j=0; $j<count($result_link); $j++) {
	$student_id = $result_link[$j];
	if ($currentSemester == "") {
	 mysql_query("UPDATE user_table SET semester=NULL, year='$currentYear' WHERE userId='$student_id'");
	}
	else {
	 mysql_query("UPDATE user_table SET semester='$currentSemester', year='$currentYear' WHERE userId='$student_id'");
	}
}

mysql_close($con);

?> 
   </body>
<script type="text/javascript">
window.onload = function () {
     window.history.go(-1);
  }
</script>
</html>
