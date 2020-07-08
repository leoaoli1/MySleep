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

$config = $_SESSION['current_config'];

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
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                              <li><a href="#" onclick="location.href='main-page'">Home</a></li>
		                          <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                              <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=3'">Lesson Three</a></li>
                  			      <li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">Activity Four</a></li>
                  			      <li><a href="#" onclick="location.href='body-changer-index'">Body Change Welcome Page</a></li>
                  			      <!--<li><a href="#" onclick="location.href='body-changer-simulator-display'">Body Change Simulator Display</a></li>-->
                              <li class="active">Body Changer Menu</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>

		    <div class="row">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='body-changer-simulation-selection.php'">
                                <span><p class="lesson-text">Task 1: Simulation</p></span>
                            </div>
                        </div>
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-info" onclick="location.href='body-changer-game-about'">
                                <span><p class="lesson-text">Task 2: True False Game</p></span>
                            </div>
                        </div>
                        <!-- <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="location.href='body-changer-worksheet'">
                                <span><p class="lesson-text">Task 3: Body Changer Worksheet</p></span>
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
