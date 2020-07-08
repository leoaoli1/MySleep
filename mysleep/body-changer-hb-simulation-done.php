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

  $response=  mysql_escape_string($_POST["response"]);

  include 'connectdb.php';
  
  $q = mysql_query("INSERT INTO bodyChanger(userId, cardiovascular) VALUES ('$userId', '$response')");

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
