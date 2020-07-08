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
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$userDisplayName = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
if($userId==""){
    header("Location: login");
    exit;
}
if($userType!="parent"){
    header("Location: login");
    exit;
}
$currentGrade = $_SESSION['parentGrade'];
//debugToConsole('grade', $currentGrade);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php require 'partials/header.php' ?>
        <title>MySleep // Select Lesson</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li class="active">Lessons</li>
                            </ol>
                        </div>
                    </div>
                    <?php if ($currentGrade==4 || $_SESSION['parentLessonGrade'] == 4) {  //After finish G4 menu, two menu will be merged. ?>
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="lesson lesson-danger" onclick="location.href='parent-lesson-menu?lesson=1'">
				    <span><i class="material-icons">filter_1</i></span>
                                    <p>Lesson One</p>
                                </div>
                            </div>
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="lesson lesson-info" onclick="location.href='parent-lesson-menu?lesson=2'">
				    <span><i class="material-icons">filter_2</i></span>
                                    <p>Lesson Two</p>
                                </div>
                            </div>
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="lesson lesson-warning" onclick="location.href='parent-lesson-menu?lesson=3'">
				    <span><i class="material-icons">filter_3</i></span>
                                    <p>Lesson Three</p>
                                </div>
                            </div>
                            <div class="col-xs-8 col-xs-offset-2">
                                <div class="lesson lesson-success" onclick="location.href='parent-lesson-menu?lesson=4'">
				    <span><i class="material-icons">filter_4</i></span>
                                    <p>Lesson Four</p>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($currentGrade==5 || $_SESSION['parentLessonGrade'] == 5) { ?>
                            <div class="row">
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="lesson lesson-danger" onclick="location.href='parent-lesson-menu?lesson=1'">
					<span><i class="material-icons">filter_1</i></span>
                                        <p>Lesson One</p>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="lesson lesson-info" onclick="location.href='parent-lesson-menu?lesson=2'">
					<span><i class="material-icons">filter_2</i></span>
                                        <p>Lesson Two</p>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="lesson lesson-warning" onclick="location.href='parent-lesson-menu?lesson=3'">
					<span><i class="material-icons">filter_3</i></span>
                                        <p>Lesson Three</p>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-xs-offset-2">
                                    <div class="lesson lesson-success" onclick="location.href='parent-lesson-menu?lesson=4'">
					<span><i class="material-icons">filter_4</i></span>
                                        <p>Lesson Four</p>
                                    </div>
                                </div>
                            </div>
                    <?php }else{ ?>
			
		    <?php } ?>
                </div>
            </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
