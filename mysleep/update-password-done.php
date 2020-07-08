<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li , Wo-Tak Wu 
#
    require_once('utilities.php');
    session_start();
    $userId= $_SESSION['userId'];
    $password0 = $_POST["password0"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    if ($userId == "") {
        header("Location: login.php");
        exit;
    }
    // Check if everything is filled
    if (empty($password0) || empty($password1) || empty($password2)) {
        //echo "<div class='row_settings'>";
        echo   "Everything has to be filled in the page. Please try again.";
        //echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
        //echo "</div>";
        exit;
    }

// Check whether both new passwords entered match
if ($password1 != $password2){
    echo   "The new passwords you entered do not match. Please try again.";
        exit;
    }

    // Check if new password is still the old one
if ($password0 == $password1) {
    echo   "New password is same as the old one. Please try again.";
        exit;
    }

    // Check database
    include 'connectdb.php';
    $result = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    $storedEncryptedPassword = $row['password'];
    $logOnTimes = $row['logOnTimes'];
    mysql_close($con);

    // Check whether entered password matches stored password
if ($storedEncryptedPassword != SHA1($password0)) {
    echo  "The current password is incorrect. Please try again.";
        exit;
    }

    // Update database with new password
    include 'connectdb.php';
    $encrypted = SHA1($password1);
    $logOnTimes += 1;
    $status = mysql_query("UPDATE user_table SET password='$encrypted', logOnTimes='$logOnTimes' WHERE userId='$userId'");
    if (!$status) {
        error_exit('Could not update new password to database: ' . mysql_error());
	echo 'Could not update new password to database: ' . mysql_error();
    }else{
	echo 'Success';
    }
    mysql_close($con);
    exit;
?>
