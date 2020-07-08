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
if($userType!="parent"){
    header("Location: login");
    exit;
}
$currentGrade = $_SESSION['parentGrade'];
$lessonId = $_GET['lesson'];
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
                                <li><a href="#" onclick="location.href='parent-sleep-lesson'">Lessons</a></li>
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
		    <?php if($currentGrade == 5 || $_SESSION['parentLessonGrade'] == 5){  
		    if($lessonId == 1){ ?>
                        <div class="row">
                            <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-danger" onclick="location.href='parent-lesson-activity-menu?lesson=1&activity=1'">
                                    <span><p class="lesson-text">Activity One</p></span>

				</div>
                            </div>
                            <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-info" onclick="location.href='parent-lesson-activity-menu?lesson=1&activity=2'">
                                    <span><p class="lesson-text">Activity Two</p></span>
				</div>
                            </div>
			</div>
            <?php } elseif($lessonId == 2){ ?>
                            <div class="row">
				<div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='diary-menu'">
                                        <span><p class="lesson-text">Activity One: Gathering and Recording Data</p></span>
                                    </div>
                                </div>
				<!-- <div  class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='TeacherReviewActigram?grade=5'">
                                        <span><p class="lesson-text">Children Actigraphs</p></span>
                                    </div>
                                </div> -->
                            </div>
            <?php }elseif($lessonId == 3){ ?>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='parent-lesson-activity-menu?lesson=3&activity=1'">
                                            <span><p class="lesson-text">Activity One</p></span>
					</div>
                                    </div>
				</div>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='parent-lesson-activity-menu?lesson=3&activity=3'">
					    <span><p class="lesson-text">Activity Three</p></span>
					</div>
				    </div>
				</div>
            <?php }elseif($lessonId == 4){ ?>
				 <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='parent-aggregate-table'">
						<span><p class="lesson-text">Aggregate Table</p></span>
					    </div>
					</div>
				    </div> 
		    <?php   }
		    }else{ 
			if($lessonId == 1){ ?>
                      <!--  <div class="row">
                            <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-danger" onclick="location.href='ParentLessonActivityMenu?lesson=1&activity=1'">
                                    <span><p class="lesson-text">Activity One</p></span>

				</div>
                            </div>
                            <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-info" onclick="location.href='ParentLessonActivityMenu?lesson=1&activity=2'">
                                    <span><p class="lesson-text">Activity Two</p></span>
				</div>
                            </div>
			</div> -->
            <?php } elseif($lessonId == 2){ ?>
                            <div class="row">
				<div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='diary-menu'">
                                        <span><p class="lesson-text">Activity One: Gathering and Recording Data</p></span>
                                    </div>
                                </div>
				<!-- <div  class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='TeacherReviewActigram?grade=5'">
                                        <span><p class="lesson-text">Children Actigraphs</p></span>
                                    </div>
                                </div> -->
                            </div>
            <?php }elseif($lessonId == 3){ ?>
			 <!--	<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='ParentLessonActivityMenu?lesson=3&activity=1'">
                                            <span><p class="lesson-text">Activity One</p></span>
					</div>
                                    </div>
				</div>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='ParentLessonActivityMenu?lesson=3&activity=3'">
					    <span><p class="lesson-text">Activity Three</p></span>
					</div>
				    </div>
				</div> -->
            <?php }elseif($lessonId == 4){ ?>
				 <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='parent-aggregate-table'">
						<span><p class="lesson-text">Aggregate Table</p></span>
					    </div>
					</div>
				    </div> 
		    <?php }
			}?>
                </div>
            </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
