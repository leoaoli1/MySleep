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
if($userId==""){
    header("Location: login");
    exit;
} 
$userType = $_SESSION['userType'];
include 'connectdb.php';
$username = base64_encode(strtolower($_POST["username"]));
$code = $_POST["code"];
$result = mysql_query("SELECT userId FROM user_table WHERE userName='$username'");
$row = mysql_fetch_array($result);
$studentId = $row['userId'];
// Check if alread have linked
$linkUsers = getLinkedUserIds($userId);
$linked = 0;
foreach($linkUsers as $user){
    # Check Linked Status
    if($user == $studentId){
	$linked = 1;
    }
}
//echo $linked;
//echo $studentId;
//exit;
if ($linked == 1){
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    //die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
}

$result = mysql_query("SELECT random, updateTime FROM random_code_table WHERE userId = '$studentId'");
if( mysql_num_rows($result) > 0){
    $row = mysql_fetch_array($result);
    $verificationCode = $row['random']; 
    $currentTime = get_localtime($format="Y-m-d H:i:s");
    $threeHours = 3*60*60;
    $substractTime = strtotime($currentTime) - strtotime($row['updateTime']);
    if( $substractTime > $threeHours){
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: application/json; charset=UTF-8');
    }
    else{
	if($code == $verificationCode){
	    mysql_query("INSERT INTO user_link_table (userId, linkUserId) VALUES ('$userId', '$studentId')"); //link student and parent
	    # Update Parent Grade  4: 4th Grade; 5: 5th Grade; both: both Grade;
	    $studentGrade = getGrade($studentId);
	    // Check linked students' grade
	    if($_SESSION['parentGrade'] != "both"){
		if($_SESSION['parentGrade'] != $studentGrade){
		    $_SESSION['parentGrade'] = "both";
		}
	    }
	}else{
	    header('HTTP/1.1 500 Internal Server Error');
	    header('Content-Type: application/json; charset=UTF-8');
	}
    }
}else{
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
}


mysql_close($con);
exit;
?>
