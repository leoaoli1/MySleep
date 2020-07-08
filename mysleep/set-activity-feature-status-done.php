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

if($_POST['estrella-checkbox'] == 'on'){
  $EstrellaDataHuntBar = '1';
}else{
  $EstrellaDataHuntBar = '0';
}
include 'connectdb.php';
mysql_query("UPDATE class_info_table SET EstrellaDataHuntBar='$EstrellaDataHuntBar' WHERE classId='$classId'");
mysql_close($con);

exit;
?>
