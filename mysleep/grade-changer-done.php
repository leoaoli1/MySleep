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

  $hypothesis                   = $_POST["hypothesis"];
  $hypothesizedValueB           = $_POST["hypothesizedValueB"] ? $_POST["hypothesizedValueB"] : null;
  $hypothesizedValueCD          = $_POST["hypothesizedValueCD"] ? $_POST["hypothesizedValueCD"] : null;
  $hypothesisSupported          = $_POST["hypothesisSupported"];
  $hypothesisBenefit            = $_POST["hypothesisBenefit"];
  $conclusionsCalcOne           = $_POST["conclusionsCalcOne"] ? $_POST["conclusionsCalcOne"] : null;
  $conclusionsCalcTwo           = $_POST["conclusionsCalcTwo"] ? $_POST["conclusionsCalcTwo"] : null;
  $conclusionsCalcThree         = $_POST["conclusionsCalcThree"] ? $_POST["conclusionsCalcThree"] : null;
  $conclusionsCalcFour          = $_POST["conclusionsCalcFour"] ? $_POST["conclusionsCalcFour"] : null;
  $conclusionsCalcFive          = $_POST["conclusionsCalcFive"] ? $_POST["conclusionsCalcFive"] : null;
  $conclusionsCalcSix           = $_POST["conclusionsCalcSix"] ? $_POST["conclusionsCalcSix"] : null;
  $conclusionsDiffGreatest      = $_POST["conclusionsDiffGreatest"] ? $_POST["conclusionsDiffGreatest"] : null;
  $conclusionsDiffLeast         = $_POST["conclusionsDiffLeast"] ? $_POST["conclusionsDiffLeast"] : null;
  $responseOne                  = $_POST["responseOne"] ? $_POST["responseOne"] : null;
  $responseTwo                  = $_POST["responseTwo"] ? $_POST["responseTwo"] : null;
  $isSubmitted                  = $_POST["isSubmitted"];

$responseOne =  mysql_escape_string($responseOne);
$responseTwo =  mysql_escape_string($responseTwo);
  include 'connectdb.php';

  $existing = mysql_query("SELECT `id`, `isSubmitted` FROM gradeChanger WHERE `userId` = '$userId'");

  if (mysql_fetch_row($existing)) {
      $q = mysql_query("UPDATE gradeChanger SET hypothesis = '$hypothesis', hypothesizedValueB = '$hypothesizedValueB', hypothesizedValueCD = '$hypothesizedValueCD', hypothesisSupported = '$hypothesisSupported', hypothesisBenefit = '$hypothesisBenefit', conclusionsCalcOne = '$conclusionsCalcOne', conclusionsCalcTwo = '$conclusionsCalcTwo', conclusionsCalcThree = '$conclusionsCalcThree', conclusionsCalcFour = '$conclusionsCalcFour', conclusionsCalcFive = '$conclusionsCalcFive', conclusionsCalcSix = '$conclusionsCalcSix', conclusionsDiffGreatest = '$conclusionsDiffGreatest', conclusionsDiffLeast = '$conclusionsDiffLeast', responseOne = '$responseOne', responseTwo = '$responseTwo' WHERE userId = '$userId' ORDER BY submitTime DESC LIMIT 1");
  } else {
      $q = mysql_query("INSERT INTO gradeChanger(userId, hypothesis, hypothesizedValueB, hypothesizedValueCD, hypothesisSupported, hypothesisBenefit, conclusionsCalcOne, conclusionsCalcTwo, conclusionsCalcThree, conclusionsCalcFour, conclusionsCalcFive, conclusionsCalcSix, conclusionsDiffGreatest, conclusionsDiffLeast, responseOne, responseTwo, isSubmitted) VALUES ('$userId', '$hypothesis', '$hypothesizedValueB', '$hypothesizedValueCD', '$hypothesisSupported', '$hypothesisBenefit', '$conclusionsCalcOne', '$conclusionsCalcTwo', '$conclusionsCalcThree', '$conclusionsCalcFour', '$conclusionsCalcFive', '$conclusionsCalcSix', '$conclusionsDiffGreatest', '$conclusionsDiffLeast', '$responseOne', '$responseTwo', '$isSubmitted')");
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
