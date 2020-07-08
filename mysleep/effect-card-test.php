<!DOCTYPE html>
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
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
if ($config) {
  $result = mysql_query("SELECT * FROM effect_card_test_table WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
}else {
  $result = mysql_query("SELECT * FROM effect_card_test_table WHERE userId='$userId' order by resultRow DESC LIMIT 1");
}
$numRow = mysql_num_rows ($result);
unset($_SESSION['current_work']);
if ($numRow>0) {
  $row = mysql_fetch_array($result);
  // if (isset($row['response'])) {
  //    $content = $row['response'];
  // }
  $_SESSION['current_work'] = $row;
  $resultRow = $row['resultRow'];
 }else {
  $content = "";
  $resultRow = -1;
 }


$result =mysql_query("SELECT preSchoolPos, preSchoolNeg FROM effect_card_test_table WHERE userId='$userId' and tag='1' order by recordId DESC LIMIT 1");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
	$text_1 = $row['preSchoolPos'];
	$text_2 = $row['preSchoolNeg'];
    }
}else {
    $text_1 = "";
    $text_2 = "";
}

$result =mysql_query("SELECT schoolAgePos, schoolAgeNeg FROM effect_card_test_table WHERE userId='$userId' and tag='2' order by recordId DESC LIMIT 1");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
	$text_3 = $row['schoolAgePos'];
	$text_4 = $row['schoolAgeNeg'];
    }
}else {
    $text_3 = "";
    $text_4 = "";
}

$result =mysql_query("SELECT adultPos, adultNeg FROM effect_card_test_table WHERE userId='$userId' and tag='3' order by recordId DESC LIMIT 1");
$numRow = mysql_num_rows ($result);
if ($numRow>0) {
    while($row = mysql_fetch_array($result)){
	$text_5 = $row['adultPos'];
	$text_6 = $row['adultNeg'];
    }
}else {
    $text_5 = "";
    $text_6 = "";
}
mysql_close($con);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Sleep Votes</title>
        <style type="text/css">
	 #last-row{
	     postion:relative;
	     margin-top:2%;
	 }
	 .textpane{
	     font:25px cursive;
	     height:100%;
	     width:100%;
	     background-size: 100% 100%;
	 }
	</style>
  <?php include 'partials/scripts.php' ?>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType);
                  }else {?>
                  <!-- Original navigationLink Code -->
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="main-page">Home</a></li>
                                <li><a href="sleep-lesson">Lessons</a></li>
                                <li><a href="fifth-grade-lesson-menu?lesson=1">Lesson One</a></li>
				                        <li><a href="fifth-grade-lesson-activity-menu?lesson=1&activity=1">Activity One</a></li>
                                <li class="active">Effect Card</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
		    <?php include 'partials/alerts.php' ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <h4>For the box on the left hand side, list some behaviors or feelings that someone in that age group might experience if he/she does not get enough sleep. For the box on the right hand side, list possible positive effects of getting the recommended amount of sleep. Be sure to click submit before leaving class. You may add to the boxes and send updated responses to your teacher by clicking submit at any point.</h4>
                        </div>
                    </div>
		    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                            <div>
				<!-- Nav tabs -->
				<ul id="group" class="nav nav-justified nav-pills nav-pills-info" role="tablist">

				    <li role="presentation" class="active"><a href="#preschool" aria-controls="preschool" role="tab" data-toggle="tab">Preschool</a></li>
				    <li role="presentation"><a href="#school" aria-controls="school" role="tab" data-toggle="tab">School Aged</a></li>
				    <li role="presentation"><a href="#adult" aria-controls="adult" role="tab" data-toggle="tab">Adult</a></li>
				</ul>
			    </div>
			</div>
		    </div>
		    <div class="tab-content" style="margin-top: 2em;">
			<!-- Tab One -->
          <div role="tabpanel" class="tab-pane active" id="preschool">
			    <form id="pre-school">
            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
            <div class="row">
              <div class ="col-xs-offset-1 col-xs-10 col-md-6 col-md-offset-3">
                <?php include 'add-group-member-button.php' ?>
              </div>
            </div>
				<div class="row">
				    <div class="col-md-offset-1 col-md-5 col-sm-offset-1 col-sm-5">
					<textarea placeholder="Not enough sleep" class="textpane" name="effect_2" id="effect_2" cols="23" rows="8" style="color: black; font-weight: bold; font-size: 250%;); filter: opacity(85%);"><?php echo htmlspecialchars($text_2);?></textarea>
				    </div>
				    <div class="col-md-5 col-sm-5">
					<textarea placeholder="Right amount of sleep" class="textpane" name="effect_1" id="effect_1" cols="23" rows="8" style="color: black; font-weight: bold; font-size: 250%;); filter: opacity(85%);"><?php echo htmlspecialchars($text_1);?></textarea>
				    </div>
				</div>

				<?php if($_SESSION['userType']=="student"){ ?>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <button class="btn btn-gradbb btn-roundThin btn-large btn-block" name="save" id="save-pre-school">Save</button>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradpr btn-roundThin btn-large btn-block" data-toggle="modal" data-target="#submit-modal-1">Submit &amp; Next</a>
					</div>
				    </div>
				<?php }else{?>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradbb btn-roundThin btn-large btn-block">Save</a>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradpr btn-roundThin btn-large btn-block"  name="submit" id="submit">Submit</a>
					</div>
				    </div>
				<?php } ?>
			    </form>
			</div>
			<!-- Tab Two -->
			<div role="tabpanel" class="tab-pane" id="school">
			    <form id="school-form">
            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
				<div class="row">
				    <div class="col-md-offset-1 col-md-5 col-sm-offset-1 col-sm-5">
					<textarea placeholder="Not enough sleep" class="textpane" name="effect_4" id="effect_4" cols="23" rows="8" style="color: black; font-weight: bold; font-size: 250%;); filter: opacity(85%);"><?php echo htmlspecialchars($text_4);?></textarea>
				    </div>
				    <div class="col-md-5 col-sm-5">
					<textarea placeholder="Right amount of sleep" class="textpane" name="effect_3" id="effect_3" cols="23" rows="8" style="color: black; font-weight: bold; font-size: 250%;); filter: opacity(85%);"><?php echo htmlspecialchars($text_3);?></textarea>
				    </div>
				</div>
				<?php if($_SESSION['userType']=="student"){ ?>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <button class="btn btn-gradbb btn-roundThin btn-large btn-block" name="save" id="save-school">Save</button>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradpr btn-roundThin btn-large btn-block" data-toggle="modal" data-target="#submit-modal-2">Submit &amp; Next</a>
					</div>
				    </div>
				<?php }else{?>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradbb btn-roundThin btn-large btn-block">Save</a>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradpr btn-roundThin btn-large btn-block"  name="submit" id="submit">Submit</a>
					</div>
				    </div>
				<?php } ?>
			    </form>
			</div>
			<!-- Tab Three -->
			<div role="tabpanel" class="tab-pane" id="adult">
			    <form id="adult-form">
            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
				<div class="row">
				    <div class="col-md-offset-1 col-md-5 col-sm-offset-1 col-sm-5">
					<textarea placeholder="Not enough sleep" class="textpane" name="effect_6" id="effect_6" cols="23" rows="8" style="color: black; font-weight: bold; font-size: 250%;); filter: opacity(85%);"><?php echo htmlspecialchars($text_6);?></textarea>
				    </div>
				    <div class="col-md-5 col-sm-5">
					<textarea placeholder="Right amount of sleep" class="textpane" name="effect_5" id="effect_5" cols="23" rows="8" style="color: black; font-weight: bold; font-size: 250%; black;); filter: opacity(85%);"><?php echo htmlspecialchars($text_5);?></textarea>
				    </div>
				</div>
				<?php if($_SESSION['userType']=="student"){ ?>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <button class="btn btn-gradbb btn-roundThin btn-large btn-block" name="save" id="save-adult">Save</button>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradpr btn-roundThin btn-large btn-block" data-toggle="modal" data-target="#submit-modal-3">Submit &amp; Next</a>
					</div>
				    </div>
				<?php }else{?>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradbb btn-roundThin btn-large btn-block">Save</a>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
					    <a class="btn btn-gradpr btn-roundThin btn-large btn-block"  name="submit" id="submit">Submit</a>
					</div>
				    </div>
				<?php } ?>
			    </form>
			</div>
		    </div>
                </div>
            </div>
        </div>

        <!-- Submit Modal -->
	<div class="modal fade" id="submit-modal-1" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
		    </div>
		    <div class="modal-body">
			Are you ready to submit your work to your teacher and move to the next?
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			<button id="submit-pre" type="button" class="btn btn-success btn-simple" data-dismiss="modal">Yes, Submit</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="submit-modal-2" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
		    </div>
		    <div class="modal-body">
			Are you ready to submit your work to your teacher and move to the next?
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			<button id="submit-school" type="button" class="btn btn-success btn-simple" data-dismiss="modal">Yes, Submit</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="submit-modal-3" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
		    </div>
		    <div class="modal-body">
			Are you ready to submit your work to your teacher and move to the next?
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			<button id="submit-adult" type="button" class="btn btn-success btn-simple" data-dismiss="modal">Yes, Submit</button>
		    </div>
		</div>
	    </div>
	</div>
        <?php include 'partials/footer.php' ?>
        </div>
    </body>

    <script>
     $("#submit-pre").click(function(e) {
	 $('#group a[href="#school"]').tab('show');
	 e.preventDefault();
	 $.ajax({
	     type: "post",
	     url: "effect-card-test-done?tag=1",
	     data: $('#pre-school').serialize(),
	     success: function () {
		 $("#success-alert-text").html("Your work is submited!");
		 $("#success-alert").show(500).delay(3000);
		 $("#success-alert").hide(500);
	     },
	     error: function () {
		 $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.");
		 $("#error-alert").show(500).delay(6000);
		 $("#error-alert").hide(500);
	     },
	 });
     });

     $("#save-pre-school").click(function(e) {
	 e.preventDefault();
	 $.ajax({
	     type: "post",
	     url: "effect-card-test-done?tag=1",
	     data: $('#pre-school').serialize(),
	     success: function () {
		 $("#success-alert-text").html("Your work is saved!");
		 $("#success-alert").show(500).delay(3000);
		 $("#success-alert").hide(500);
	     },
	     error: function () {
		 $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.");
		 $("#error-alert").show(500).delay(6000);
		 $("#error-alert").hide(500);
	     },
	 });
     });

     $("#submit-school").click(function(e) {
	 $('#group a[href="#adult"]').tab('show');
	 e.preventDefault();
	 $.ajax({
	     type: "post",
	     url: "effect-card-test-done?tag=2",
	     data: $('#school-form').serialize(),
	     success: function () {
		 $("#success-alert-text").html("Your work is submited!");
		 $("#success-alert").show(500).delay(3000);
		 $("#success-alert").hide(500);
	     },
	     error: function () {
		 $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.");
		 $("#error-alert").show(500).delay(6000);
		 $("#error-alert").hide(500);
	     },
	 });
     });

     $("#save-school").click(function(e) {
	 e.preventDefault();
	 $.ajax({
	     type: "post",
	     url: "effect-card-test-done?tag=2",
	     data: $('#school-form').serialize(),
	     success: function () {
		 $("#success-alert-text").html("Your work is saved!");
		 $("#success-alert").show(500).delay(3000);
		 $("#success-alert").hide(500);
	     },
	     error: function () {
		 $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.");
		 $("#error-alert").show(500).delay(6000);
		 $("#error-alert").hide(500);
	     },
	 });
     });

     $("#submit-adult").click(function(e) {
	 $('#adult-form').attr('action','effect-card-test-done?tag=3');
	 $('#adult-form').attr('method', 'post');
	 $('#adult-form').submit();
     });

     $("#save-adult").click(function(e) {
	 e.preventDefault();
	 $.ajax({
	     type: "post",
	     url: "effect-card-test-done?tag=3",
	     data: $('#adult-form').serialize(),
	     success: function () {
		 $("#success-alert-text").html("Your work is saved!");
		 $("#success-alert").show(500).delay(3000);
		 $("#success-alert").hide(500);
	     },
	     error: function () {
		 $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.");
		 $("#error-alert").show(500).delay(6000);
		 $("#error-alert").hide(500);
	     },
	 });
     });
    </script>
</html>
