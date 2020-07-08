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


$lesson = [];
   for ($i=0; $i < 5; $i++){
		   $num =$i+1;
    if($_POST['Lesson'.$num.'-checkbox'] == 'on'){
	$lesson[$i] = '1';
    }else{
	$lesson[$i] = '0';
    }
		}
include 'connectdb.php';
mysql_query("UPDATE class_info_table SET Lesson_1='$lesson[0]', Lesson_2='$lesson[1]', Lesson_3='$lesson[2]', Lesson_4='$lesson[3]', Lesson_5='$lesson[4]' WHERE classId='$classId'");
mysql_close($con);

exit;
?>

