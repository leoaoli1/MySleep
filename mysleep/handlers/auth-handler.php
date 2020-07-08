<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#


    $username = $_POST["username"];
    $password = $_POST["password"];
    
        // Check whether user exists and entered password matches stored password
    include 'ConnectDb.php';
    $result = mysql_query("SELECT * FROM user_table WHERE userName='$username'");
    $row = mysql_fetch_array($result);
    if(($row['userName'] != $username) || ($row['password'] != SHA1($password))){   // This check will fail if no such username in database
        echo "The username or password does not exist.  Try again.";
    } else {
        echo "ok";
        
        session_start(); 
        unset($_SESSION['userId']);
        $_SESSION['userId'] = $row['userId']; 
        $_SESSION['firstName'] = $row['firstName']; 
        $_SESSION['lastName'] = $row['lastName']; 
        $_SESSION['userType'] = $row['type']; 
    }

    

/*

    // Almost all ready to enter the main page
    

    // Check if password must be updated
    if ($password != $row['lastName'])          // Password is okay because it's not the default
    {
        header("Location: MainPage");
        exit;
    }
    
    // Need to update password
    header("Location: UpdatePassword");
    exit;
    
    */
?>