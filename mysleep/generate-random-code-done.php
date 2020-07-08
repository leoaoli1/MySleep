<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>

session_start();
$userId= $_SESSION['userId'];
include 'connectdb.php';

$code = substr(md5(uniqid(rand(), true)), 0, 8);

$result = mysql_query("SELECT random FROM random_code_table Where userId='$userId'");
if( mysql_num_rows($result) > 0){
    $status = mysql_query("UPDATE random_code_table SET random='$code' WHERE userId='$userId'"); 
    if (!$status) {
	$message = 'Could not enter answers to the database: ' . mysql_error();
	error_exit($message);
    }
}else{
    $status = mysql_query("INSERT INTO random_code_table(userId, random) VALUES ('$userId', '$code')"); 
    if (!$status) {
	$message = 'Could not enter answers to the database: ' . mysql_error();
	error_exit($message);
    }
}
echo json_encode(
array("code" => $code)
);
mysql_close($con);
exit;
?>
