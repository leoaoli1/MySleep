<?php
#
# Part of the MySleep package
#
# (C) Univeristy of Arizona, College of Education 2016
# Not to be changed, modified, or distributed without express written permission of the entity.
#
# Authors: Ao Li <aoli1@email.arizona.edu>
#          James Geiger <jamesgeiger@email.arizona.edu>
#

require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
#checkauth();

$hypothesis= $_POST["hypothesis"];
$player= $_POST["player"];
$improvement= $_POST["improvement"];
$submit = $_POST["submit"];
$support = $_POST["support"];
$points = $_POST["points"];
$response=  mysql_escape_string($_POST["response"]);

include 'connectdb.php';

$result =mysql_query("SELECT recordId, submit FROM gameChanger where userId='$userId' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$recordId = $row["recordId"];
$update = $row['submit'];

if ((mysql_num_rows($result)>0)&&($update == 0)) {
    $q = mysql_query("UPDATE gameChanger SET hypothesis='$hypothesis', player='$player', improvement='$improvement', support='$support', points='$points', gameChanger='$response', submit='$submit' WHERE recordId = '$recordId'");
} else {
    $q = mysql_query("INSERT INTO gameChanger(userId, hypothesis, player, improvement, support, points, gameChanger, submit) VALUES ('$userId', '$hypothesis', '$player', '$improvement',  '$support', '$points', '$response', '$submit')");
}



if (!$q) {
    $message = 'Could not enter answers to the database: ' . mysql_error();
    $data['success'] = false;
    $data['errors']  = $message;
}
else {
    // show a message of success and provide a true success variable
    $data['success'] = true;
    $data['message'] = 'Activity successfully submitted!';
}

mysql_close($con);

// return all our data to an AJAX call
echo json_encode($data);
?>
