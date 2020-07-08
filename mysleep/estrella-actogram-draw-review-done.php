<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
require_once('utilities.php');
session_start();

$workId = $_POST['workId'];
$score = $_POST['score'];
$comment = $_POST['comment'];

include 'connectdb.php';

$status = mysql_query("UPDATE estrellaActogramDraw SET score='$score', comment='$comment' WHERE recordRow='$workId'");
if (!$status) {
    $message = 'Could not enter answers to the database: ' . mysql_error();
    error_exit($message);
}

mysql_close($con);
