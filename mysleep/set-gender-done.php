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
require_once('utilities.php');
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
$currentGrade = getCurrentGrade($userId);
?> 
<html>
<head>
</head>
<body>
<?php
include 'connectdb.php';
$gender = $_POST['gender'];
mysql_query("UPDATE user_table SET gender='$gender' WHERE userId='$userId'");
mysql_close($con);
header("Location: main-page");



exit;
?>
</body>
</html>
