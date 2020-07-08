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
$currentGrade = getCurrentGrade($userId);
$classGrade = $_SESSION['classGrade'];
$lessonId = $_GET['lesson'];
$activityId = $_GET['activity'];
if(($userType == 'student') && ($currentGrade != 4)){
    header("Location: sleep-lesson");
    exit;
}
?>

<html>
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Lesson Activity Menu</title>
    </head>

    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
			    <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
				<li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
				<?php if($lessonId == 1){ ?>
				    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=1'">
          <?php }elseif($lessonId == 2){  ?>
					<li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2'">
			    <?php }elseif($lessonId == 3){  ?>
					    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=3'">
          <?php }elseif($lessonId == 4){  ?>
						<li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=4'">
				<?php } ?>
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
			}?></a></li>
						<li class="active">
			<?php
			if($lessonId == "1"){
			    if($activityId == "3"){
				echo "Activity Three";
			    }elseif($activityId == "15"){
				echo "Take Home Activity";
			    }
			}elseif($lessonId=="3"){
			    if($activityId=="1"){
				echo "Activity One";
			    }elseif($activityId == "2"){
				echo "Activity Two";
			    }elseif($activityId == "3"){
				echo "Activity Three";
			    }
			}elseif($lessonId=="4"){
			    if($activityId == "2"){
				echo "Activity Two";
			    }elseif($activityId == "3"){
				echo "Activity Three";
			    }
			}
			?></li>
			    </ol>
			</div>
		    </div>
		</div>

		<div class="row">
		    <div class="col-md-offset-3 col-md-6">
    			<?php
    			if($lessonId == 1){
			    if($activityId == 1){
			?>

			    <div class="col-xs-offset-1 col-xs-10">
				<div class="lesson lesson-warning" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=animal'">
				    <span><p class="lesson-text">Part 1: Animal Sleep Sorting Task</p></span>
				</div>
			    </div>
			    <div class="col-xs-offset-1 col-xs-10">
				<div class="lesson lesson-success" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=whySleep'">
				    <span><p class="lesson-text">Part 2: Why do We Sleep?</p></span>
				</div>
			    </div>
			    <div class="col-xs-offset-1 col-xs-10">
				<div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=sleepVote'">
				    <span><p class="lesson-text">Part 3: Do People Get Enough Sleep?</p></span>
				</div>
			    </div>
			    <div class="col-xs-offset-1 col-xs-10">
				<div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=prepare'">
				    <span><p class="lesson-text">Part 4: Preparing to Interview an Adult</p></span>
				</div>
			    </div>
      <?php }elseif ($activityId == 15) {?>
				<?php if ($userType == 'student') {?>
				    <div class="col-xs-offset-1 col-xs-10">
					<div class="lesson lesson-danger" onclick="location.href='interview-adult'">
					    <span><p class="lesson-text">Interviewing an Adult</p></span>
					</div>
				    </div>
        <?php }elseif ($userType == 'teacher') {?>
					<div class="col-xs-offset-1 col-xs-10">
					    <div class="lesson lesson-danger" onclick="location.href='interview-adult'">
						<span><p class="lesson-text">Interviewing an Adult (Student View)</p></span>
					    </div>
					</div>
					<div class="col-xs-offset-1 col-xs-10">
					    <div class="lesson lesson-info" onclick="location.href='interview-adult-non-student-review?showClass=1'">
						<span><p class="lesson-text">Review: Interviewing an Adult (Show to Class)</p></span>
					    </div>
					</div>
					<div class="col-xs-offset-1 col-xs-10">
					    <div class="lesson lesson-warning" onclick="location.href='interview-adult-non-student-review?showClass=0'">
						<span><p class="lesson-text">Review: Interviewing an Adult (Not Show to Class)</p></span>
					    </div>
					</div>
				<?php } ?>

			<?php } ?>



        <?php
	}elseif($lessonId==2) {
	    if($activityId == 2){
		if ($userType == 'teacher') { ?>
			    <div class="col-xs-offset-1 col-xs-10">
				<div class="lesson lesson-warning" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=datahunt'">
				    <span><p class="lesson-text">Part 1: Estrella's Data Hunt</p></span>
				</div>
			    </div>
			    <div class="col-xs-offset-1 col-xs-10">
				<div class="lesson lesson-success" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=sleepdata'">
				    <span><p class="lesson-text">Part 2: My Sleep Data</p></span>
				</div>
			    </div>
       <?php }elseif ($userType == 'student') { ?>
				<div class="col-xs-offset-1 col-xs-10">
				    <div class="lesson lesson-warning" onclick="location.href='estrella-datahunt?grade=4&lesson=2'">
					<span><p class="lesson-text">Part 1: Estrella's Data Hunt</p></span>
				    </div>
				</div>
				<div class="col-xs-offset-1 col-xs-10">
				    <div class="lesson lesson-success" onclick="location.href='my-sleep-data?grade=4&lesson=2'">
					<span><p class="lesson-text">Part 2: My Sleep Data</p></span>
				    </div>
				</div>
       <?php }
       }elseif($activityId == 3){
           if ($userType == 'teacher') { ?>
				    <div class="col-xs-offset-1 col-xs-10">
					<div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=3&name=story'">
					    <span><p class="lesson-text">Part 1: Ideas about the Purpose of Sleep Story</p></span>
					</div>
				    </div>
      <?php }elseif ($userType == 'student') { ?>
					<div class="col-xs-offset-1 col-xs-10">
					    <div class="lesson lesson-danger" onclick="location.href='sleep-stories?storyId=1'">
						<span><p class="lesson-text">Part 1: Ideas about the Purpose of Sleep Story</p></span>
					    </div>
					</div>
      <?php }
      }

      }elseif($lessonId==3) {
	  if($activityId == 1){
	      if($userType == 'student') {?>
					    <div class="row">
    						<div class="col-xs-offset-2 col-xs-8">
  						    <div class="lesson lesson-warning" onclick="location.href='circadian-rhythm-tempery?lesson=3&part=1'">
							<span><p class="lesson-text">Part 1</p></span>
  						    </div>
    						</div>
						<div class="col-xs-offset-2 col-xs-8">
  						    <div class="lesson lesson-warning" onclick="location.href='circadian-rhythm-tempery?lesson=3&part=2'">
							<span><p class="lesson-text">Part 2</p></span>
  						    </div>
    						</div>
					    </div>



			    <?php }elseif($userType=='teacher') {?>
						<div class="row">
						    <div class="col-xs-offset-2 col-xs-8">
							<div class="lesson lesson-warning" onclick="location.href='circadian-rhythm-tempery?lesson=3&part=1'">
							    <span><p class="lesson-text">Part 1</p></span>
							</div>
						    </div>
						    <div class="col-xs-offset-2 col-xs-8">
							<div class="lesson lesson-warning" onclick="location.href='circadian-rhythm-tempery?lesson=3&part=2'">
							    <span><p class="lesson-text">Part 2</p></span>
							</div>
						    </div>
						</div>
	           <?php  }
		   }elseif($activityId == 2){

		       if ($userType == 'teacher') { ?>
						    <div class="col-xs-offset-1 col-xs-10">
							<div class="lesson lesson-warning" onclick="location.href='estrella-datahunt?grade=4&lesson=3'">
							    <span><p class="lesson-text">Part 1: Estrella's Sleep Consistency</p></span>
							</div>
						    </div>
						    <div class="col-xs-offset-1 col-xs-10">
							<div class="lesson lesson-success" onclick="location.href='my-sleep-data?grade=4&lesson=3'">
							    <span><p class="lesson-text">Part 2: How Consistent do I Sleep?</p></span>
							</div>
						    </div>
          <?php }elseif ($userType == 'student') { ?>
							<div class="col-xs-offset-1 col-xs-10">
							    <div class="lesson lesson-warning" onclick="location.href='estrella-datahunt?grade=4&lesson=3'">
								<span><p class="lesson-text">Part 1: Estrella's Sleep Consistency</p></span>
							    </div>
							</div>
							<div class="col-xs-offset-1 col-xs-10">
							    <div class="lesson lesson-success" onclick="location.href='my-sleep-data?grade=4&lesson=3'">
								<span><p class="lesson-text">Part 2: How Consistent do I Sleep?</p></span>
							    </div>
							</div>
          <?php }

	  }elseif($activityId == 3){
	      if($userType == 'student') { ?>
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-info" onclick="location.href='sleep-habits-of-animals'">
								    <span><p class="lesson-text">Part 1: Sleep Habits of Our Favorite Animals</p></span>
								</div>
							    </div>
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-info" onclick="location.href='animal-card-test?lesson=3'">
								    <span><p class="lesson-text">Part 2: Animal Sleep Sorting Task</p></span>
								</div>
							    </div>
							    <!-- <div class="row">
								 <div class="col-xs-offset-2 col-xs-8">
								 <div class="lesson lesson-danger" onclick="location.href='sleep-environment'">
								 <span><p class="lesson-text">Sleep Environment</p></span>
								 </div>
								 </div>
								 </div> -->

		<?php 	    }elseif($userType=='teacher') { ?>
								<div class="col-xs-offset-2 col-xs-8">
								    <div class="lesson lesson-info" onclick="location.href='sleep-habits-of-animals'">
									<span><p class="lesson-text">Part 1: Sleep Habits of Our Favorite Animals</p></span>
								    </div>
								</div>
								<div class="col-xs-offset-2 col-xs-8">
								    <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=3&activity=3&name=animal'">
									<span><p class="lesson-text">Part 2: Animal Sleep Sorting Task</p></span>
								    </div>
								</div>

								<!-- <div class="row">
								     <div class="col-xs-offset-2 col-xs-8">
								     <div class="lesson lesson-danger" onclick="location.href='sleep-environment-non-student-review?showToClass=1'">
								     <span><p class="lesson-text">Sleep Environment Review (Show to class)</p></span>
								     </div>
								     </div>
								     </div>
								     <div class="row">
								     <div class="col-xs-offset-2 col-xs-8">
								     <div class="lesson lesson-danger" onclick="location.href='sleep-environment-non-student-review?showToClass=0'">
								     <span><p class="lesson-text">Sleep Environment Review</p></span>
								     </div>
								     </div>
								     </div> -->
		<?php 	    }
		}
		}elseif($lessonId==4) {
		    if ($activityId == 1) {
			if($userType == 'student') { ?>
								    <div class="row">
									<div class="col-xs-offset-2 col-xs-8">
									    <div class="lesson lesson-danger" onclick="location.href='sleep-environment'">
										<span><p class="lesson-text">Sleep Environment</p></span>
									    </div>
									</div>
								    </div>
								    
       <?php }elseif($userType == 'teacher') { ?>
									<div class="row">
									    <div class="col-xs-offset-2 col-xs-8">
										<div class="lesson lesson-danger" onclick="location.href='sleep-environment'">
										    <span><p class="lesson-text">Sleep Environment(Student View)</p></span>
										</div>
									    </div>
									    <div class="col-xs-offset-2 col-xs-8">
										<div class="lesson lesson-danger" onclick="location.href='sleep-environment-non-student-review?showToClass=1'">
										    <span><p class="lesson-text">Sleep Environment Review (Show to class)</p></span>
										</div>
									    </div>
									</div>
									<div class="row">
									    <div class="col-xs-offset-2 col-xs-8">
										<div class="lesson lesson-danger" onclick="location.href='sleep-environment-non-student-review?showToClass=0'">
										    <span><p class="lesson-text">Sleep Environment Review</p></span>
										</div>
									    </div>
									</div>
									

      <?php
      }
      }elseif($activityId == 2){
	  if($userType == 'student') { ?>
									    <!--<div class="row">
										<div class="col-xs-offset-2 col-xs-8">
										    <div class="lesson lesson-danger" onclick="location.href='aggregate-table?activity=2'">
											<span><p class="lesson-text">My Class Data</p></span>
										    </div>
										</div>
									    </div>-->

		<?php 	    }
		}elseif($activityId == 3){
		    if($userType == 'student') { ?>
									<!--	<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='aggregate-table?activity=3&grade=4'">
											    <span><p class="lesson-text">Fourth Grade Data</p></span>
											</div>
										    </div>
										</div>
										<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='aggregate-table?activity=3&grade=5'">
											    <span><p class="lesson-text">Fifth Grade Data</p></span>
											</div>
										    </div>
										</div>
										<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='aggregate-table-school-data'">
											    <span><p class="lesson-text">My School Data</p></span>
											</div>
										    </div>
										</div>-->
										<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='roomEnvironment'">
											    <span><p class="lesson-text">Room Environment</p></span>
											</div>
										    </div>
										</div>

	<?php 	    }elseif($userType == 'teacher'){?>
										    <div class="row">
											<div class="col-xs-offset-2 col-xs-8">
											    <div class="lesson lesson-danger" onclick="location.href='roomEnvironment'">
												<span><p class="lesson-text">Room Environment (Student View)</p></span>
											    </div>
											</div>
										    </div>							    
	    <?php }
	}
	}
    	?>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
