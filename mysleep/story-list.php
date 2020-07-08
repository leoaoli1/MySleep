<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li 
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

if($userId==""){
    header("Location: login");
    exit;
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Lesson Menu</title>
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
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">Activity Two</a></li>
                                <li class="active">Story Menu</li>
                            </ol>
                        </div>
                    </div>
                  <?php } ?>
		    <div class="row">
          <div class="col-xs-offset-2 col-xs-8">
              <h4>
                Your teacher will assign you to a group to read or listen, and discuss one of the following news stories concerning a major event or a business or school policy decision. In your group, decide how sleep affected the outcomes described in the stories. After your group discussion, you will be directed to a worksheet to answer a few questions about the story.
              </h4>
          </div>
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='story-one?<?php echo $query; ?>'">
                                <span><p class="lesson-text">Story 1: Grounded Tanker Spreads Destruction</p></span>
                            </div>
                        </div>
			<div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-info" onclick="location.href='story-two?<?php echo $query; ?>'">
                                <span><p class="lesson-text">Story 2: Google Replaces Facebook as Best Place to Work</p></span>
                            </div>
                        </div>
			<div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="location.href='story-three?<?php echo $query; ?>'">
                                <span><p class="lesson-text">Story 3: Explosion Rocks Space Program</p></span>
                            </div>
                        </div>
			<div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-success" onclick="location.href='story-four?<?php echo $query; ?>'">
                                <span><p class="lesson-text">Story 4: Near Miss for Nuclear Disaster</p></span>
                            </div>
                        </div>
			<div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-primary" onclick="location.href='story-five?<?php echo $query; ?>'">
                                <span><p class="lesson-text">Story 5: School Start Times: It’s Too Early to Get Up!</p></span>
                            </div>
                        </div>
		    </div>
		</div>
	    </div>
            <?php include 'partials/footer.php' ?>
	</div>
    </body>
    <?php include 'partials/scripts.php'?>
</html>
