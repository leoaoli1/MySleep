<!DOCTYPE html>
 <?php  
 # 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
if ($userId == "") {
	header("Location: login.php");
	exit;
}
$score = $_POST['score'];
?>

<html>

<body>

<?php
include 'connectdb.php';
mysql_query("INSERT INTO fifthGradeLessonThreeTakeHome (userID, score)
VALUES ('$userId', '$score');");
mysql_close($con);
?> 

<script>
    history.go(-1); 
</script>

</body>
</html> 
