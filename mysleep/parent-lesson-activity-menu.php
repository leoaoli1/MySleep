<!DOCTYPE html>
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
$activityId = $_GET['activity'];
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
                                    <li><a href="#" onclick="location.href='parent-lesson-menu?lesson=<?php echo $lessonId?>'"><?php if($lessonId == "1"){echo "Lesson One";}elseif($lessonId=="2"){echo "Lesson Two";}elseif($lessonId=="3"){echo "Lesson Three";}elseif($lessonId=="4"){echo "Lesson Four";}elseif($lessonId == "5"){echo "Lesson Five";}?></a></li>
                                    <li class="active"><?php if($activityId == "1"){echo "Activity One";}elseif($activityId == "2"){echo "Activity Two";}elseif($activityId==3){echo "Activity Three";}?></li>
                                </ol>
                            </div>
                        </div>
			<?php
			if($currentGrade == 5 || $_SESSION['parentLessonGrade'] == 5){ 
    			if($lessonId == 1){
    			    if($activityId==1) {?>
                            <div class="row">
				<!--<div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='StoryList'">
                                        <span><p class="lesson-text">Stories</p></span>
                                    </div>
                                </div>-->
                                <div class="col-xs-offset-2 col-xs-8">
                                    <div class="lesson lesson-danger" onclick="location.href='worksheet-fifth-one-non-student-review?showToClass=0'">
                                        <span><p class="lesson-text">Worksheet Children Responses</p></span>
                                    </div>
                                </div>
                            </div>
                            
                        <?php }elseif($activityId==2) {?>
				<div class="row">
                                    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='age-sleep-hours-test-non-student-review'">
                                            <span><p class="lesson-text">Part I: Predicting Sleep Needs Children Responses</p></span>
					</div>
                                    </div>
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='effect-card-test-non-student-review'">
                                            <span><p class="lesson-text">Part II: Sleep Effects Children Responses</p></span>
					</div>
                                    </div>
				</div>
                        <?php }
			}elseif($lessonId==2) { ?>		    
                <?php }elseif($lessonId==3) {
		    if($activityId == 1){ ?>				
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='basketball-tests-review?showToClass=0'">
						<span><p class="lesson-text">Game Changer Student Responses</p></span>
					    </div>
					</div>
				    </div> 
		<?php }	elseif ($activityId == 3){?>
					<div class="row">
					    <div class="col-xs-offset-2 col-xs-8">
						<div class="lesson lesson-danger" onclick="location.href='./body-changer/index.html'">
						    <span><p class="lesson-text">Body Changer</p></span>
						</div>
					    </div>
					</div>	
		      <?php }
		      }elseif($lessonId==4) {?>
					    
					    
			<?php }
			}else{

			}?>
		    </div>
		</div>
		
	    </div>
	    <?php include 'partials/footer.php' ?>
	</body>
	<?php include 'partials/scripts.php'?>
</html>
