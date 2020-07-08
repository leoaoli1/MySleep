<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$targetUserId = $_POST["targetUserId"];
$username =  base64_encode(strtolower($_POST["username"]));
if ($userId == "") {
    header("Location: login.php");
    exit;
}
?>


<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Change Username</title>
    </head>
    <body>
<?php
// Check if everything is filled
if (empty($targetUserId)) {
    echo "<div class='row_settings'>";
    echo   "Everything has to be filled in the page.</br></br>";
    echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
    echo "</div>";
    exit;
}

// check whether userid exists
include 'connectdb.php';
$result = mysql_query("SELECT * FROM user_table WHERE userId='$targetUserId'");
$rowCount = mysql_num_rows($result);
if ($rowCount == 0) {
    echo "<div class='row_settings'>";
    echo   "Invalid user ID.</br></br>";
    echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
    echo "</div>";
    mysql_close($con);
    exit;
}

// Update database with new username

$status = mysql_query("UPDATE user_table SET username='$username' WHERE userId='$targetUserId'"); 
if (!$status) {
    error_exit('Could not update new password to database: ' . mysql_error());
}
else {
    //echo "<div class='row_settings'>";
   // echo   "New password: " . $newPassword . "<br><br>";
   // echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
   // echo "</div>";
}
mysql_close($con);
?>

<script>
    history.go(-2); 
</script>

</body>

</html> 
