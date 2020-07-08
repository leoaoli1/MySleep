<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
session_start();
unset($_SESSION['userId']);
require_once('utilities.php');
$username = base64_encode(strtolower($_POST["username"]));
$password = $_POST["password"];

// Check whether user exists and entered password matches stored password
include 'connectdb.php';
$result = mysql_query("SELECT * FROM user_table WHERE userName='$username'");
$row = mysql_fetch_array($result);
$logOnTimes = $row['logOnTimes'];
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
	<style type="text/css">
	 .top{
	     margin-top: 200px;
	 }
	</style>
    </head>
    <body>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
		    <div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php
			    if(($row['userName'] != $username) || ($row['password'] != SHA1($password))){   // This check will fail if no such username in database
				echo "<h2>The user ID and/or password do not match. Please try again.<h2>";
				echo "<a class='btn btn-large btn-block' href='login.php'>Go Back</a>";
				exit;
			    }
			    ?>

			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
<?php
// Almost all ready to enter the main page
session_start();
unset($_SESSION['userId']);
$_SESSION['userId'] = $row['userId'];
$_SESSION['firstName'] = $row['firstName'];
$_SESSION['lastName'] = $row['lastName'];
$_SESSION['userType'] = $row['type'];


// This creates a session variable that allows nav.php to display the user's full name
$_SESSION['userDisplayName'] = $row['firstName'] . " " . $row['lastName'];


if($row['type']=='student'){
    $classId = getStudentClassId($row['userId']);
    $_SESSION['classId'] = $classId;
    $_SESSION['classGrade'] = getClassGrade($classId);
    $schoolId = getUserSchoolId($row['userId']);
    $_SESSION['schoolId'] = $schoolId;

    // $_SESSION['classConfig'] =

}elseif($row['type']=='teacher'){
    $schoolId = getUserSchoolId($row['userId']);
    $_SESSION['schoolId'] = $schoolId;
}elseif($row['type']=='parent'){
    # Check Linked Students' Grade
    $checkGrade = [];
    $linkUsers = getLinkedUserIds($row['userId']);
    foreach($linkUsers as $user){
	$userGrade = getGrade($user);
	if(empty($checkGrade)){
	    array_push($checkGrade, $userGrade);
	}else{
	    if(count($checkGrade) < 2){
		if(end($checkGrade) != $userGrade){
		    array_push($checkGrade, $userGrade);
		}
	    }
	}
	if(count($checkGrade) == 2){
	    $_SESSION['parentGrade'] = "both";
	}else{
	    $_SESSION['parentGrade'] = end($checkGrade);
	}
    }
   /*$schoolId = getUserSchoolId($row['userId']);
      $_SESSION['schoolId'] = $schoolId;*/

}
// Check if password must be updated
if (SHA1($password) != SHA1('zfactor') & $logOnTimes != 0)          // Password is okay because it's not the default
{
	$logOnTimes += 1;
	$userId = $_SESSION['userId'];
	$status = mysql_query("UPDATE user_table SET logOnTimes='$logOnTimes' WHERE userId='$userId'");
    if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
    }
    /*if ($_SESSION['userType'] == 'student') {
	$gender = getUserGender($_SESSION['userId']);
	//debugToConsole('gender', $gender);
	if(empty($gender)){
	    header("Location: set-gender");
	    mysql_close($con);
	    exit;
	}
    }*/
    header("Location: main-page");
    mysql_close($con);
    exit;

}


// Need to update password
header("Location: update-password");
mysql_close($con);
exit;
?>
