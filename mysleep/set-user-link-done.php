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
$userId = $_SESSION['userId'];
if ($userId == ""){
	header("Location: login.php");
	exit;
}
$updateUserId = $_POST['updateUserId'];
?>

<html>

<body>

<?php
    include 'connectdb.php';
    if (isset($_POST['addLink'])) {
        $result = mysql_query("INSERT INTO user_link_table (userId, linkUserId) VALUES ('$userId','$updateUserId')");
    }
    else if (isset($_POST['deleteLink'])) {
        $result = mysql_query("DELETE FROM user_link_table WHERE userId='$userId' AND linkUserId='$updateUserId'");
    }
    mysql_close($con);
?> 

<script>
    history.go(-1); 
</script>

</body>
</html> 
