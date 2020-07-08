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
				<li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=<?php echo $lessonId?>'"><?php if($lessonId == "1"){echo "Lesson One";}elseif($lessonId=="2"){echo "Lesson Two";}elseif($lessonId=="3"){echo "Lesson Three";}elseif($lessonId=="4"){echo "Lesson Four";}elseif($lessonId == "5"){echo "Lesson Five";}?></a></li>
				<li class="active"><?php if($activityId == "1"){echo "Activity One";}elseif($activityId == "2"){echo "Activity Two";}elseif($activityId==3){echo "Activity Three";}?></li>
			    </ol>
			</div>
		    </div>
		    <?php
    		    if($lessonId == 1){
    			if($activityId==1) {
			    if($userType == 'student') { ?>
			<div class="row">
			    <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-danger" onclick="location.href='age-sleep-hour-test'">
				    <span><p class="lesson-text">Part I: Predicting Sleep Needs</p></span>
				</div>
			    </div>
			    <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-danger" onclick="location.href='age-sleep-hours-test-review'">
				    <span><p class="lesson-text">Predicting Sleep Needs: My Response</p></span>
				</div>
			    </div>
			    <div class="col-xs-offset-2 col-xs-8">
				<div class="lesson lesson-danger" onclick="location.href='effect-card-test'">
				    <span><p class="lesson-text">Part II: Sleep Effects</p></span>
				</div>
			    </div>
			</div>
          <?php }elseif($userType=='teacher') { ?>
			    <div class="row">
				<div class="col-xs-offset-2 col-xs-8">
				    <div class="lesson lesson-danger" onclick="location.href='age-sleep-hours-test-non-student-review'">
					<span><p class="lesson-text">Part I: Predicting Sleep Needs Student Responses</p></span>
				    </div>
				</div>
				<div class="col-xs-offset-2 col-xs-8">
				    <div class="lesson lesson-danger" onclick="location.href='effect-card-test-non-student-review?showToClass=1'">
					<span><p class="lesson-text">Part II: Sleep Effects Student Responses (Show to class)</p></span>
				    </div>
				</div>
				<div class="col-xs-offset-2 col-xs-8">
				    <div class="lesson lesson-danger" onclick="location.href='effect-card-test-non-student-review?showToClass=0'">
					<span><p class="lesson-text">Part II: Sleep Effects Student Responses </p></span>
				    </div>
				</div>
			    </div>
          <?php }
	  }elseif($activityId==2) {
	      if($userType == 'student'){ ?>
				<div class="row">
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-danger" onclick="location.href='story-list'">
					    <span><p class="lesson-text">News Stories</p></span>
					</div>
				    </div>
				    <div class="col-xs-offset-2 col-xs-8">
					<div class="lesson lesson-info" onclick="location.href='worksheet-fifth-one'">
					    <span><p class="lesson-text">Worksheet</p></span>
					</div>
				    </div>
				    <!-- <div class="col-xs-offset-2 col-xs-8">
					 <div class="lesson lesson-info" onclick="location.href='summary-fifth-one'">
					 <span><p class="lesson-text">Story Summarizer (Group Submission)</p></span>
					 </div>
					 </div>-->
				</div>
          <?php } elseif($userType == 'teacher'){ ?>
				    <div class="row">
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='story-list'">
						<span><p class="lesson-text">News Stories</p></span>
					    </div>
					</div>
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='worksheet-fifth-one-non-student-review?showToClass=1'">
						<span><p class="lesson-text">Review Students' Worksheet Responses (Show To Class)</p></span>
					    </div>
					</div>
					<div class="col-xs-offset-2 col-xs-8">
					    <div class="lesson lesson-danger" onclick="location.href='worksheet-fifth-one-non-student-review?showToClass=0'">
						<span><p class="lesson-text">Review Students' Worksheet Responses</p></span>
					    </div>
					</div>
					<!-- <div class="col-xs-offset-2 col-xs-8">
					     <div class="lesson lesson-danger" onclick="location.href='summary-fifth-one-non-student-review?showToClass=1'">
					     <span><p class="lesson-text">Review Students' Story Summarizer (Show To Class)</p></span>
					     </div>
					     </div>
					     <div class="col-xs-offset-2 col-xs-8">
					     <div class="lesson lesson-danger" onclick="location.href='summary-fifth-one-non-student-review?showToClass=0'">
					     <span><p class="lesson-text">Review Students' Story Summarizer</p></span>
					     </div>
					     </div>-->
				    </div>
          <?php }
	  }	
	  }elseif($lessonId==2) {
	      if($activityId == 3){
		  if ($userType == 'student') { ?>
					<div class="row">
					    <div class="col-xs-offset-2 col-xs-8">
						<div class="lesson lesson-danger" onclick="location.href='sleep-detective?case=1'">
						    <span><p class="lesson-text">Case 1</p></span>
						</div>
					    </div>
					    <div class="col-xs-offset-2 col-xs-8">
						<div class="lesson lesson-info" onclick="location.href='sleep-detective?case=2'">
						    <span><p class="lesson-text">Case 2</p></span>
						</div>
					    </div>
					    <div class="col-xs-offset-2 col-xs-8">
						<div class="lesson lesson-warning" onclick="location.href='sleep-detective?case=3'">
						    <span><p class="lesson-text">Case 3</p></span>
						</div>
					    </div>
					</div>	
          <?php }elseif ($userType == 'teacher') {?>
					    <div class="row">
						<div class="col-xs-offset-2 col-xs-8">
						    <div class="lesson lesson-danger" onclick="location.href='sleep-detective?case=1'">
							<span><p class="lesson-text">Case 1</p></span>
						    </div>
						</div>
						<div class="col-xs-offset-2 col-xs-8">
						    <div class="lesson lesson-info" onclick="location.href='sleep-detective?case=2'">
							<span><p class="lesson-text">Case 2</p></span>
						    </div>
						</div>
						<div class="col-xs-offset-2 col-xs-8">
						    <div class="lesson lesson-warning" onclick="location.href='sleep-detective?case=3'">
							<span><p class="lesson-text">Case 3</p></span>
						    </div>
						</div>
	    <?php }
	    }
	    }elseif($lessonId==3) {
		if($activityId == 1){
		    if($userType == 'student'){
	    ?>
						    <div class="row">
							<div class="col-xs-offset-2 col-xs-8">
							    <div class="lesson lesson-danger" onclick="location.href='identification-task'">
								<span><p class="lesson-text">Task One: Identification Task</p></span>
							    </div>
							</div>
						    </div>
						    <div class="row">
							<div class="col-xs-offset-2 col-xs-8">
							    <div class="lesson lesson-danger" onclick="location.href='identification-task-student-review'">
								<span><p class="lesson-text">Task One Review</p></span>
							    </div>
							</div>
						    </div>
						    <div class="row">
							<div class="col-xs-offset-2 col-xs-8">
							    <div class="lesson lesson-danger" onclick="location.href='memory-task'">
								<span><p class="lesson-text">Task Two: Memory Task</p></span>
							    </div>
							</div>
						    </div>
						    <div class="row">
							<div class="col-xs-offset-2 col-xs-8">
							    <div class="lesson lesson-danger" onclick="location.href='memory-task-student-review'">
								<span><p class="lesson-text">Task Two Review</p></span>
							    </div>
							</div>
						    </div>
						    <div class="col-xs-offset-2 col-xs-8">
							<div class="lesson lesson-warning" onclick="window.open('docs/take_home_task.pdf')" >
							    <span><p class="lesson-text">Task Three: Taking it Home Activity</p></span>
							</div>
						    </div>
						    <div class="col-xs-offset-2 col-xs-8">
							<div class="lesson lesson-warning" onclick="location.href='home-activity-score'" >
							    <span><p class="lesson-text">Task Three: Score Submission</p></span>
							</div>
						    </div>
				 <?php }elseif($userType=='teacher') { ?>
							<div class="row">
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-danger" onclick="location.href='identification-task'">
								    <span><p class="lesson-text">Task One: Identification Task</p></span>
								</div>
							    </div>
							</div>
							<div class="row">
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-danger" onclick="location.href='identification-task-teacher-review-show-class'">
								    <span><p class="lesson-text">Task One Review (Show to class)</p></span>
								</div>
							    </div>
							</div>
							<div class="row">
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-danger" onclick="location.href='identification-task-teacher-review'">
								    <span><p class="lesson-text">Task One Review</p></span>
								</div>
							    </div>
							</div>
							<div class="row">
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-danger" onclick="location.href='memory-task'">
								    <span><p class="lesson-text">Task Two: Memory Task</p></span>
								</div>
							    </div>
							</div>
							<div class="row">
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-danger" onclick="location.href='memory-task-teacher-review-show-class'">
								    <span><p class="lesson-text">Task Two Review (Show to class)</p></span>
								</div>
							    </div>
							</div>
							<div class="row">
							    <div class="col-xs-offset-2 col-xs-8">
								<div class="lesson lesson-danger" onclick="location.href='memory-task-teacher-review'">
								    <span><p class="lesson-text">Task Two Review</p></span>
								</div>
							    </div>
							</div>
							<div class="col-xs-offset-2 col-xs-8">
							    <div class="lesson lesson-warning" onclick="window.open('docs/take_home_task.pdf')" >
								<span><p class="lesson-text">Task Three: Taking it Home Activity</p></span>
							    </div>
							</div>
							<div class="col-xs-offset-2 col-xs-8">
							    <div class="lesson lesson-warning" onclick="location.href='home-activity-score-review'" >
								<span><p class="lesson-text">Task Three: Review</p></span>
							    </div>
							</div>
							
		<?php } }elseif($activityId == 2){
		    if($userType == 'student') { ?>		
							    <div class="row">
								<div class="col-xs-offset-2 col-xs-8">
								    <div class="lesson lesson-danger" onclick="location.href='basketball-test-player'">
									<span><p class="lesson-text">Game Changer</p></span>
								    </div>
								</div>
								<!--<div class="col-xs-offset-2 col-xs-8">
								     <div class="lesson lesson-danger" onclick="location.href='basketball-tests-review'">
								     <span><p class="lesson-text">Game Changer: My Response</p></span>
								     </div>
								     </div>-->
							    </div>					
	    <?php }elseif($userType=='teacher') { ?>
								<div class="row">
								    <div class="col-xs-offset-2 col-xs-8">
									<div class="lesson lesson-danger" onclick="location.href='basketball-test-player'">
									    <span><p class="lesson-text">Game Changer (Student View)</p></span>
									</div>
								    </div>
								</div>	
								<div class="row">
								    <div class="col-xs-offset-2 col-xs-8">
									<div class="lesson lesson-danger" onclick="location.href='basketball-tests-review?showToClass=1'">
									    <span><p class="lesson-text">Game Changer Student Responses (Show to class)</p></span>
									</div>
								    </div>
								    <div class="col-xs-offset-2 col-xs-8">
									<div class="lesson lesson-danger" onclick="location.href='basketball-tests-review?showToClass=0'">
									    <span><p class="lesson-text">Game Changer Student Responses</p></span>
									</div>
								    </div>
								</div>
								
	    <?php }	}elseif($activityId == 3){
		if($userType == 'student'){?>
								    <div class="row">
									<div class="col-xs-offset-2 col-xs-8">
									    <div class="lesson lesson-danger" onclick="location.href='grade-changer'">
										<span><p class="lesson-text">Grade Changer</p></span>
									    </div>
									</div>
								    </div>
	    <?php }elseif($userType == 'teacher'){?>
									<div class="row">
									    <div class="col-xs-offset-2 col-xs-8">
										<div class="lesson lesson-danger" onclick="location.href='grade-changer'">
										    <span><p class="lesson-text">Grade Changer (Student View)</p></span>
										</div>
									    </div>
									</div>
									<div class="row">
									    <div class="col-xs-offset-2 col-xs-8">
										<div class="lesson lesson-danger" onclick="location.href='grade-changer-review?showToClass=1'">
										    <span><p class="lesson-text">Grage Changer Student Responses (Show to class)</p></span>
										</div>
									    </div>
									    <div class="col-xs-offset-2 col-xs-8">
										<div class="lesson lesson-danger" onclick="location.href='grade-changer-review?showToClass=0'">
										    <span><p class="lesson-text">Grage Changer Student Responses</p></span>
										</div>
									    </div>
									</div>
	    <?php }}elseif ($activityId == 4){
		if($userType == 'student') { ?>
									    <div class="row">
										<div class="col-xs-offset-2 col-xs-8">
										    <div class="lesson lesson-danger" onclick="location.href='body-changer-index'">
											<span><p class="lesson-text">Body Changer</p></span>
										    </div>
										</div>
									    </div>
									    <div class="row">
										<div class="col-xs-offset-2 col-xs-8">
										    <div class="lesson lesson-danger" onclick="location.href='body-changer-worksheet'">
											<span><p class="lesson-text">Body Changer Worksheet</p></span>
										    </div>
										</div>
									    </div>
									    
	    <?php }elseif($userType == 'teacher'){?>
										<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='body-changer-index'">
											    <span><p class="lesson-text">Body Changer (Student View)</p></span>
											</div>
										    </div>
										</div>
										<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='body-changer-worksheet'">
											    <span><p class="lesson-text">Body Changer Worksheet (Student View)</p></span>
											</div>
										    </div>
										</div>
										<div class="row">
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='body-changer-review?showToClass=1'">
											    <span><p class="lesson-text">Body Changer Student Responses (Show to class)</p></span>
											</div>
										    </div>
										    <div class="col-xs-offset-2 col-xs-8">
											<div class="lesson lesson-danger" onclick="location.href='body-changer-review?showToClass=0'">
											    <span><p class="lesson-text">Body Changer Student Responses</p></span>
											</div>
										    </div>
										</div>
	    <?php }
	    }	
	    }elseif($lessonId==4) {
		if($activityId == 1){
		    if($userType == 'teacher'){?>	
										    <div class="row">
											<div  class="col-xs-offset-2 col-xs-8">
											    <div class="lesson lesson-danger" onclick="location.href='how-do-i-sleep-teacher?grade=5'">
												<span><p class="lesson-text">Activity One: How Do I Sleep? (Student View)</p></span>
												
											    </div>
											</div>
											<div class="col-xs-offset-2 col-xs-8">
											    <div class="lesson lesson-danger" onclick="location.href='sleep-profile-teacher-review?showToClass=1'">
												<span><p class="lesson-text">Review Student Sleep Profile (Show To Class)</p></span>
											    </div>
											</div>
											<div class="col-xs-offset-2 col-xs-8">
											    <div class="lesson lesson-info" onclick="location.href='sleep-profile-teacher-review?showToClass=0'">
												<span><p class="lesson-text">Review Student Sleep Profile</p></span>
											    </div>
											</div>
										    </div>	
		<?php }
		}elseif($activityId == 2){
		    if($userType == 'student') { ?>		
											<!--<div class="row">
											    <div class="col-xs-offset-2 col-xs-8">
												<div class="lesson lesson-danger" onclick="location.href='aggregate-table?activity=2'">
												    <span><p class="lesson-text">My Class Data</p></span>
												</div>
											    </div>-->
											    
              <?php }elseif($userType == 'teacher'){?>
												<!--<div class="col-xs-offset-2 col-xs-8">
												    <div class="lesson lesson-danger" onclick="location.href='aggregate-table?activity=2'">
													<span><p class="lesson-text">My Class Data</p></span>
												    </div>
												</div>-->
							<?php }
							}elseif($activityId == 3){
							    if($userType == 'student'){?>
												    <div class="row">
													<div class="col-xs-offset-2 col-xs-8">
													    <div class="lesson lesson-danger" onclick="location.href='project-questions'">
														<span><p class="lesson-text">Project Questions</p></span>
													    </div>
													</div>
												    </div>
												    <!--<div class="row">
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
												    </div>-->
												    <!--<div class="row">
													 <div class="col-xs-offset-2 col-xs-8">
													 <div class="lesson lesson-danger" onclick="location.href='aggregate-table-school-data'">
													 <span><p class="lesson-text">My School Data</p></span>
													 </div>
													 </div>
													 </div>-->
												    
		    <?php }elseif($userType == 'teacher'){?>
													<div class="row">
													    <div class="col-xs-offset-2 col-xs-8">
														<div class="lesson lesson-danger" onclick="location.href='project-questions-teacher-review?showToClass=1'">
														    <span><p class="lesson-text">Project Questions Review (Show to Class)</p></span>
														</div>
													    </div>
													</div>
													<div class="row">
													    <div class="col-xs-offset-2 col-xs-8">
														<div class="lesson lesson-danger" onclick="location.href='project-questions-teacher-review?showToClass=0'">
														    <span><p class="lesson-text">Project Questions Review</p></span>
														</div>
													    </div>
													</div>
													<!--<div class="row">
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
													</div>-->

							<?php }
							}
							}?>
											</div>
					    </div>
					    
		</div>
		<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php'?>
</html>
