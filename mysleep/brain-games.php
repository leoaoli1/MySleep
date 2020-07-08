<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# Copyright 2017 University of Arizona
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

if($userId==""){
    header("Location: login");
    exit;
}
?>


<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Body Changer</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType);
                  } else {?>
                    <?php } ?>

          		    <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <h4>
                          Data from the Grade Changer experiment provides evidence that there is a relationship between sleep and learning.  Other research shows that lack of sleep makes it difficult to be focused and attentive, and recall new information.    In this activity you are going to collect data for an experiment in which one or more of your sleep variables will be the independent variable and your score on an attention or memory brain game will be the dependent variable.
                          <br><br>
                          Select a brain game to begin:
                        </h4>
                    </div>
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="location.href='identification-task.php'">
                                <span><p class="lesson-text">Brain game 1:  <font color="black">Black</font> or <font color="red">Red</font>?</p></span>
                            </div>
                        </div>
                        <!-- <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='identification-task-student-review.php'">
                                <span><p class="lesson-text">Task 1: Review</p></span>
                            </div>
                        </div> -->
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-info" onclick="location.href='memory-task'">
                                <span><p class="lesson-text">Brain game 2:  Remember it</p></span>
                            </div>
                        </div>
                        <!-- <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-info" onclick="location.href='memory-task-student-review'">
                                <span><p class="lesson-text">Task 2: Review</p></span>
                            </div>
                        </div> -->
                        <!-- <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="window.open('docs/take_home_task.pdf')">
                                <span><p class="lesson-text">Task 3: Taking it Home Activity</p></span>
                            </div>
                        </div>
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="location.href='home-activity-score'">
                                <span><p class="lesson-text">Task 3: Score Submission</p></span>
                            </div>
                        </div> -->
                    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php'?>
</html>
