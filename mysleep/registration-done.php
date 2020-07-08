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
if($userId==""){
    header("Location: login");
    exit;
} 
$userType = $_SESSION['userType'];
include 'connectdb.php';
$fname = $_POST["fname"];
$lname = $_POST["lname"];
//$dob = $_POST["dob"];
$username = base64_encode(strtolower($_POST["username"]));
/*$password1 = $_POST["password1"];
   $password2 = $_POST["password2"];
   $sex = $_POST["sex"];*/
$email = $_POST["email"];
if($userType == "researcher"){
    $user_type = $_POST["user_type"]; 
    if($user_type == "teacher"){
        $schoolId = $_POST["school_Id"];
    }elseif($user_type == "parent"){
	$firstId = $_POST["firstId"];
	$secondId = $_POST["secondId"];
    }
}elseif($userType == "teacher"){
    $user_type = "student";
    $classId = $_SESSION['classId'];
    $schoolId = $_SESSION['schoolId'];
    $classGrade = getClassGrade($classId);
    $firstId = $_POST["firstId"];
    $secondId = $_POST["secondId"];
    //$thirdId = $_POST["thirdId"];
}elseif($userType == "student"){
    $user_type = "parent";
}


// Check if everything is filled
if (empty($fname) || empty($lname) || empty($username)){
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    //die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
}else{
    if($userType == "teacher"){
	if (empty($firstId) || empty($schoolId) || empty($classId) || empty($classGrade)){
	    //if (empty($firstId) || empty($secondId) || empty($thirdId) || empty($schoolId) || empty($classId) || empty($classGrade)){
	    header('HTTP/1.1 500 Internal Server Error');
	    header('Content-Type: application/json; charset=UTF-8');
	    //die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
	}
    } 
    // check whether userid has been taken
    
    $result = mysql_query("SELECT * FROM user_table WHERE userName='$username'");
    $row = mysql_fetch_array($result);
    if($row['userName'] == $username){
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: application/json; charset=UTF-8');
	//die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }else{
        // Insert new user into database
        $encrypted = SHA1('zfactor');
	if($userType == "researcher"){
	    if($user_type == "teacher"){
		$status = mysql_query("INSERT INTO user_table(userName,firstName,lastName, password, type, emailAddress, schoolId) VALUES ('$username', '$fname','$lname','$encrypted','$user_type', '$email', '$schoolId')"); 
		if (!$status) {
		    error_exit('Could not add user to the database: ' . mysql_error());
		}
	    }elseif($user_type == "parent"){
		$status = mysql_query("INSERT INTO user_table(firstId, secondId, userName,firstName,lastName, password, type, emailAddress) VALUES ('$firstId', '$secondId', '$username', '$fname','$lname','$encrypted','$user_type', '$email')"); 
		if (!$status) {
		    error_exit('Could not add user to the database: ' . mysql_error());
		}
	    }elseif($user_type == "researcher"){
		$status = mysql_query("INSERT INTO user_table(userName,firstName,lastName, password, type, emailAddress, schoolId) VALUES ('$username', '$fname','$lname','$encrypted','$user_type', '$email', '$schoolId')"); 
		if (!$status) {
		    error_exit('Could not add user to the database: ' . mysql_error());
		}
	    }
	}elseif($userType == "teacher"){
	    $status = mysql_query("INSERT INTO user_table(firstId, secondId, userName,firstName,lastName, password,type, emailAddress, currentGrade, classId, schoolId) VALUES ('$firstId', '$secondId', '$username', '$fname','$lname','$encrypted','$user_type', '$email', '$classGrade', '$classId', '$schoolId')"); 
	    //$status = mysql_query("INSERT INTO user_table(firstId, secondId, thirdId, userName,firstName,lastName, password,type, emailAddress, currentGrade, classId, schoolId) VALUES ('$firstId', '$secondId', '$thirdId', '$username', '$fname','$lname','$encrypted','$user_type', '$email', '$classGrade', '$classId', '$schoolId')"); 
	    if (!$status) {
		error_exit('Could not add user to the database: ' . mysql_error());
	    }
	    $lastInsertId = mysql_insert_id();
	    getUserSettings($lastInsertId );       // Force to create user settings
	    mysql_query("INSERT INTO user_link_table (userId, linkUserId) VALUES ('$userId', '$lastInsertId')"); //link student and teacher
	    mysql_query("INSERT INTO class_table (userId, classId) VALUES ('$lastInsertId', '$classId')"); // Add Student to current class
	    mysql_query("INSERT INTO class_tracking_table (userId, classId) VALUES ('$lastInsertId', '$classId')"); // track students' classes
	}elseif($userType == "student"){
	    $status = mysql_query("INSERT INTO user_table(userName,firstName,lastName, password,type, emailAddress) VALUES ( '$username', '$fname','$lname','$encrypted','$user_type', '$email')"); 
	    if (!$status) {
		error_exit('Could not add user to the database: ' . mysql_error());
	    } 
	}
    } 
}
mysql_close($con);

?>
