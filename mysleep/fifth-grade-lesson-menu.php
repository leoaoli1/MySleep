<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
$currentGrade = getCurrentGrade($userId);
$classGrade = $_SESSION['classGrade'];
$lessonId = $_GET['lesson'];
if(($userType == 'student') && ($currentGrade != 5)){
    header("Location: sleep-lesson");
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
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <ol class="breadcrumb">
                                    <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                    <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                    <li class="active">
				<?php if($lessonId == "1"){
				    echo "Lesson One";
				}elseif($lessonId=="2"){
				    echo "Lesson Two";
				}elseif($lessonId=="3"){
				    echo "Lesson Three";
				}elseif($lessonId=="4"){
				    echo "Lesson Four";
				}elseif($lessonId == "5"){
				    echo "Lesson Five";
				}?>
					    </li>
                                        </ol>
                            </div>
                        </div>



    <?php
        #  Lesson One
    	if($lessonId == 1){
            if ($userType == 'student') { ?>
                <div class="row">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=1'">
                                <span><p class="lesson-text">Activity One</p></span>

                            </div>
                        </div>
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-info" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">
                                <span><p class="lesson-text">Activity Two: Sleep and News Stories</p></span>
                            </div>
                        </div>
			<div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="window.open('https://classroom.google.com')" >
                                <span><p class="lesson-text">Activity Three: Lab Notebook (Google Classroom)</p></span>
                            </div>
                        </div>
                </div>
            <?php }elseif($userType == 'teacher') { ?>
                        <div class="row">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=1'">
                                <span><p class="lesson-text">Activity One</p></span>

                            </div>
                        </div>
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-info" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">
                                <span><p class="lesson-text">Activity Two: Sleep and News Stories</p></span>
                            </div>
                        </div>
			<div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-warning" onclick="window.open('https://classroom.google.com')" >
                                <span><p class="lesson-text">Activity Three: Lab Notebook (Google Classroom)</p></span>
                            </div>
                        </div>
                </div>
            <?php }else {
                // May need to distinguish other user types here in the future
            }
        }

        # Lesson Two
        elseif($lessonId == 2){
            if ($userType == 'student') { ?>
                        <div class="row">
                            <div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='diary-menu'">
                                        <span><p class="lesson-text">Activity One: Gathering and Recording Data</p></span>
                                    </div>
                                </div>
                                <div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-info" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=2&activity=3'">
                                        <span><p class="lesson-text">Activity Three: Sleep Detective</p></span>

                                    </div>
                                </div>
				<div class="col-xs-offset-2 col-xs-8">
				    <div class="lesson lesson-warning" onclick="window.open('https://classroom.google.com')" >
					<span><p class="lesson-text">Lab Notebook (Google Classroom)</p></span>
				    </div>
				</div>
                        </div>
            <?php }elseif($userType == 'teacher') { ?>
                            <div class="row">
				<div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='diary-menu'">
                                        <span><p class="lesson-text">Activity One: Gathering and Recording Data</p></span>
                                    </div>
                                </div>
                                <div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='upload-my-actogram-result?grade=5'">
                                        <span><p class="lesson-text">Activity Two: Upload Students' Actigraph</p></span>

                                    </div>
                                </div>
				<div  class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='teacher-review-actigram?grade=5'">
                                        <span><p class="lesson-text">Review Students' Actigraph</p></span>

                                    </div>
                                </div>
				<div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-info" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=2&activity=3'">
                                        <span><p class="lesson-text">Activity Three: Sleep Detective</p></span>

                                    </div>
                                </div>
                            </div>
            <?php }else {
                // May need to distinguish other user types here in the future
            }
        }

        # Lesson 3
        elseif($lessonId == 3){
            if ($userType == 'student') { ?>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=1'">
					    <span><p class="lesson-text">Activity One: Brain Games</p></span>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=2'">
					    <span><p class="lesson-text">Activity Two: GAME CHANGER</p></span>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=3'">
					    <span><p class="lesson-text">Activity Three: GRADE CHANGER</p></span>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">
					    <span><p class="lesson-text">Activity Four: BODY CHANGER</p></span>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-warning" onclick="window.open('https://classroom.google.com')" >
					    <span><p class="lesson-text">Lab Notebook (Google Classroom)</p></span>
					</div>
				    </div>
				</div>
            <?php }elseif($userType == 'teacher') { ?>
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=1'">
						<span><p class="lesson-text">Activity One: Brain Games</p></span>
					    </div>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=2'">
						<span><p class="lesson-text">Activity Two: GAME CHANGER</p></span>
					    </div>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=3'">
						<span><p class="lesson-text">Activity Three: GRADE CHANGER</p></span>
					    </div>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">
						<span><p class="lesson-text">Activity Four: BODY CHANGER</p></span>
					    </div>
					</div>
				    </div>
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-warning" onclick="window.open('https://classroom.google.com')" >
						<span><p class="lesson-text">Lab Notebook (Google Classrooms)</p></span>
					    </div>
					</div>
				    </div>
            <?php } else {
                // May need to distinguish other user types here in the future
            }
        }

        # Lesson 4
        elseif($lessonId == 4){
            if ($userType == 'student') {

	    ?>
	    <div class="row">
			<div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-warning" onclick="location.href='how-do-i-sleep?grade=5'">
                                        <span><p class="lesson-text">Activity One: How Do I Sleep?</p></span>

                                    </div>
                                </div>
				</div>
                       <!-- <div class="row">
                            <div class="col-xs-offset-2 col-xs-8">
                                <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=2'">
                                    <span><p class="lesson-text">Activity Two</p></span>
                                </div>
                            </div>
                        </div>-->
			<div class="row">
                            <div class="col-xs-offset-2 col-xs-8">
                                <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=3'">
                                    <span><p class="lesson-text">Activity Three</p></span>
                                </div>
                            </div>
                        </div>
            <?php }elseif($userType == 'teacher') { ?>
                            <div class="row">
			    	<div  class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=1'">
                                        <span><p class="lesson-text">Activity One: How Do I Sleep?</p></span>

                                    </div>
                                </div>

			<!--	<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=2'">
					    <span><p class="lesson-text">Activity Two</p></span>
					</div>
				    </div>
				</div>-->
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=3'">
					    <span><p class="lesson-text">Activity Three</p></span>
					</div>
				    </div>

				</div>
        <div class="row">
          <div class="col-xs-offset-2 col-xs-8">
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-danger" onclick="location.href='teacher-aggregate-table'">
                      <span><p class="lesson-text">Aggregate Table</p></span>
                  </div>
              </div>
          </div>
        </div>
                            </div>
            <?php }else {
                // May need to distinguish other user types here in the future
            }
        } ?>
                    </div>
                </div>
                <?php include 'partials/footer.php' ?>
            </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
