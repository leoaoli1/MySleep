<!DOCTYPE html>
 <?php  
 # 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
if ($userId == "") {
	header("Location: login.php");
	exit;
}
$emailAddress = $_POST['emailAddress'];
?>

<html>

<body>

<?php
include 'connectdb.php';
if ($emailAddress == "") {
    mysql_query("UPDATE user_table SET emailAddress=NULL WHERE userId='$userId'");
}
else {
    mysql_query("UPDATE user_table SET emailAddress='$emailAddress' WHERE userId='$userId'");
}
mysql_close($con);
?> 

<script>
    history.go(-1); 
</script>

</body>
</html> 
