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
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login.php");
    exit;
}
    if(!empty($_POST['location'])){
        $location = $_POST['location'];
    }

   if(isset($_POST['classId'])){
   if($_POST['classId']!='null'){
	$classId = $_POST['classId'];
	$_SESSION['classId'] = $classId;
	include 'connectdb.php';
   $result = mysql_query("SELECT * FROM class_info_table where classId='$classId'");
	$row = mysql_fetch_array($result);
   $classGrade = $row['grade'];
       $className = $row['className'];
   $_SESSION['classGrade'] = $classGrade;
   $_SESSION['className'] = $className;
   mysql_close($con);
	/*echo $_SESSION['classId'];
   echo $_SESSION['schoolId'];*/
   }else{
    header("Location: select-school-and-class?class=null");
    exit;
   }
   }else{
       header("Location: select-school-and-class?class=null");
       exit;
   }

if(!empty($location)){
    header("Location: $location");
    exit;
}else{
    header("Location: main-page.php?choseSchoolClass=done");
    exit;
}

?>
