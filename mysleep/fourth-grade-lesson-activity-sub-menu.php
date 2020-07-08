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
   $pageName = $_GET['name'];
      if(($userType == 'student') && ($currentGrade != 4)){
    header("Location: sleep-lesson");
    exit;
}
?>

<html>
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Lesson Activity Sub Menu</title>
    </head>

    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <div class="row">
        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
			<li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
			<li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=<?php echo $lessonId;?>'">
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

      <?php if($lessonId == "1"){?>
				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=<?php echo $activityId; ?>'">

      <?php
        if($activityId=="1"){
        echo "Activity One</a></li>";
        }elseif($activityId == "2"){
          echo "Activity Two</a></li>";
        }elseif($activityId == "3"){
          echo "Activity Three</a></li>";
        }
			}elseif($lessonId=="2"){
        if ($activityId !="1") {
        ?>
  				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=<?php echo $activityId; ?>'">
        <?php
          if($activityId=="1"){
    			echo "Activity One</a></li>";
    			}elseif($activityId == "2"){
    				echo "Activity Two</a></li>";
    			}elseif($activityId == "3"){
    				echo "Activity Three</a></li>";
    			}
        }
			}elseif($lessonId=="3"){?>
				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=<?php echo $activityId; ?>'">

      <?php
        if($activityId=="1"){
        echo "Activity One</a></li>";
        }elseif($activityId == "2"){
          echo "Activity Two</a></li>";
        }elseif($activityId == "3"){
          echo "Activity Three</a></li>";
        }
			}elseif($lessonId=="4"){
			    echo "Lesson Four";
			}elseif($lessonId == "5"){
				echo "Lesson Five";
			}?>

			<li class="active">
			<?php if($pageName == "story"){
			echo "Why do We Sleep";
			}elseif($pageName == "allAnimal"){
			echo "Do All Animals Sleep?";
			}elseif($pageName=="animal"){
			echo "Animal Sleep Sorting Task";
    }elseif($pageName=="whySleep"){
			echo "Why do We Sleep";
    }elseif($pageName=="sleepVote"){
    echo "Sleep Vote";
    }elseif($pageName=="prepare"){
        echo "Prepare Interview";
    }elseif($pageName=="sleepHabits"){
			  echo "Sleep Habits of Our Favorite Animals";
		}elseif($pageName=="goodNightSleep"){
			  echo "I Can Use A Good Night's Sleep";
    }elseif($pageName=="estrella"){
			  echo "Estrella Actogram";
    }elseif($pageName=="datahunt"){
  			echo "Estrella Data Hunt";
  	}elseif($pageName=="sleepdata"){
  			echo "My Sleep Data";
  			}?></li>
		    </ol>
      </div>
    </div>

		    <div class="row">
			<div class="col-md-offset-3 col-md-6">


    	<?php
    	if($lessonId == 1){
        if($activityId == 1){
          if($pageName === "whySleep"){
            if($userType == 'student') { ?>
              <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='why-do-we-sleep'">
                  <span><p class="lesson-text">Why do We Sleep</p></span>
                    </div>
                </div>
              </div>
              <?php 	    }elseif($userType == 'teacher') { ?>
            <div class="row">
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-danger" onclick="location.href='why-do-we-sleep'">
                <span><p class="lesson-text">Why do We Sleep (student view)</p></span>
                  </div>
              </div>
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='why-do-we-sleep-non-student-review?showClass=1'">
                  <span><p class="lesson-text">Review: Why do We Sleep (Show to Class)</p></span>
              </div>
                </div>
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='why-do-we-sleep-non-student-review?showClass=0'">
                  <span><p class="lesson-text">Review: Why do We Sleep (Not Show to Class)</p></span>
              </div>
                </div>
            </div>
          <?php 	    }
            }elseif($pageName === "sleepVote"){
              if($userType == 'student') { ?>
                <div class="row">
                  <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-danger" onclick="location.href='enough-sleep-vote'">
                    <span><p class="lesson-text">Do People Get Enough Sleep?</p></span>
                      </div>
                  </div>
                </div>
                <?php 	    }elseif($userType == 'teacher') { ?>
              <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='enough-sleep-vote'">
                  <span><p class="lesson-text">Do People Get Enough Sleep? (student view)</p></span>
                    </div>
                </div>
                  <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='enough-sleep-vote-non-student-review?showClass=1'">
                    <span><p class="lesson-text">Review: Do People Get Enough Sleep? (Show to Class)</p></span>
                </div>
                  </div>
                  <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='enough-sleep-vote-non-student-review?showClass=0'">
                    <span><p class="lesson-text">Review: Do People Get Enough Sleep? (Not Show to Class)</p></span>
                </div>
                  </div>
              </div>
            <?php 	    }

          }elseif($pageName === "prepare"){
            if($userType == 'student') { ?>
              <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='adult-pre-interview'">
                  <span><p class="lesson-text">Preparing to Interview an Adult</p></span>
                    </div>
                </div>
              </div>
              <?php 	    }elseif($userType == 'teacher') { ?>
            <div class="row">
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-danger" onclick="location.href='adult-pre-interview'">
                <span><p class="lesson-text">Preparing to Interview an Adult (student view)</p></span>
                  </div>
              </div>
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='adult-pre-interview-non-student-review?showClass=1'">
                  <span><p class="lesson-text">Review: Preparing to Interview an Adult (Show to Class)</p></span>
              </div>
                </div>
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='adult-pre-interview-non-student-review?showClass=0'">
                  <span><p class="lesson-text">Review: Preparing to Interview an Adult (Not Show to Class)</p></span>
              </div>
                </div>
            </div>
          <?php 	    }

          }elseif($pageName === "animal"){
              if($userType == 'student') { ?>
                <div class="row">
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=1'">
                <span><p class="lesson-text">Animal card sorting</p></span>
                  </div>
              </div>
                </div>
                <?php 	    }elseif($userType == 'teacher') { ?>
              <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=1'">
                  <span><p class="lesson-text">Animal card sorting (student view)</p></span>
                    </div>
                </div>
                  <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?lesson=1&showClass=yes'">
                      <span><p class="lesson-text">Animal Cards Students' Response (Show to Class)</p></span>
                    </div>
                  </div>
                  <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?lesson=1&showClass=no'">
                    <span><p class="lesson-text">Animal Cards Students' Response (Not Show to Class)</p></span>
                </div>
                  </div>
              </div>
          <?php
        }
          }
        }
	     }elseif($lessonId==2) {
         if($activityId == 1){
           if($pageName === "estrella"){
             if($userType == 'teacher') { ?>
             <div class="row">
               <div class="col-xs-offset-2 col-xs-8">
                   <div class="lesson lesson-danger" onclick="location.href='estrella-actogram?grade=4'">
                 <span><p class="lesson-text">Estrella's Actogram (student view)</p></span>
                   </div>
               </div>
                 <div class="col-xs-offset-2 col-xs-8">
               <div class="lesson lesson-warning" onclick="location.href='estrella-actogram-non-student-review?showClass=1'">
                   <span><p class="lesson-text">Review: Estrella's Actogram (Show to Class)</p></span>
               </div>
                 </div>
                 <div class="col-xs-offset-2 col-xs-8">
               <div class="lesson lesson-info" onclick="location.href='teacher-review-estrella?grade=4&type=practice'">
                   <span><p class="lesson-text">Review: Estrella's Actogram (Not Show to Class)</p></span>
               </div>
                 </div>
             </div>
           <?php 	    }
             }
         }elseif($activityId == 2){
           if($pageName === "datahunt"){
             if($userType == 'teacher') { ?>
             <div class="row">
               <div class="col-xs-offset-2 col-xs-8">
                   <div class="lesson lesson-danger" onclick="location.href='estrella-datahunt?grade=4&lesson=2'">
                 <span><p class="lesson-text">Estrella's Data Hunt (student view)</p></span>
                   </div>
               </div>
                 <div class="col-xs-offset-2 col-xs-8">
               <div class="lesson lesson-warning" onclick="location.href='estrella-datahunt-non-student-review?showClass=1'">
                   <span><p class="lesson-text">Review: Data Hunt (Show to Class)</p></span>
               </div>
                 </div>
                 <div class="col-xs-offset-2 col-xs-8">
               <div class="lesson lesson-info" onclick="location.href='teacher-review-estrella?grade=4&type=datahunt'">
                   <span><p class="lesson-text">Review: Data Hunt (Not Show to Class)</p></span>
               </div>
                 </div>
             </div>
           <?php }elseif($userType == 'student') { ?>
           <div class="row">
             <div class="col-xs-offset-2 col-xs-8">
                 <div class="lesson lesson-danger" onclick="location.href='estrella-datahunt?grade=4&lesson=2'">
               <span><p class="lesson-text">Estrella's Data Hunt</p></span>
                 </div>
             </div>

           </div>
         <?php 	    }
       }elseif($pageName === "sleepdata"){
               if($userType == 'teacher') { ?>
               <div class="row">
                 <div class="col-xs-offset-2 col-xs-8">
                     <div class="lesson lesson-danger" onclick="location.href='my-sleep-data?grade=4&lesson=2'">
                   <span><p class="lesson-text">My Sleep Data (student view)</p></span>
                     </div>
                 </div>
                 <div class="col-xs-offset-2 col-xs-8">
                     <div class="lesson lesson-success" onclick="location.href='upload-my-actogram-result?grade=4'">
                         <span><p class="lesson-text">Upload Students' Actogram</p></span>
                     </div>
                 </div>
                 <div class="col-xs-offset-2 col-xs-8">
                     <div class="lesson lesson-warning" onclick="location.href='teacher-review-actigram?grade=4'">
                         <span><p class="lesson-text">Review Students' Actogram</p></span>

                     </div>
                 </div>
                   <!-- <div class="col-xs-offset-2 col-xs-8">
                 <div class="lesson lesson-warning" onclick="location.href='estrella-datahunt-non-student-review?showClass=1'">
                     <span><p class="lesson-text">Review: >My Sleep Data (Show to Class)</p></span>
                 </div>
                   </div>
                   <div class="col-xs-offset-2 col-xs-8">
                 <div class="lesson lesson-info" onclick="location.href='teacher-review-estrella?grade=4&type=sleepdata'">
                     <span><p class="lesson-text">Review: >My Sleep Data (Not Show to Class)</p></span>
                 </div>
                   </div> -->
               </div>
             <?php }elseif($userType == 'student') { ?>
             <div class="row">
               <div class="col-xs-offset-2 col-xs-8">
                   <div class="lesson lesson-danger" onclick="location.href='my-sleep-data?grade=4'">
                 <span><p class="lesson-text">My Sleep Data</p></span>
                   </div>
               </div>

             </div>
           <?php 	    }
               }
         }elseif ($activityId == 3) {
           if($pageName === "story"){
       		    if($userType == 'student') { ?>
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='sleep-stories?storyId=1'">
                  <span><p class="lesson-text">Ideas about the Purpose of Sleep Story</p></span>
                    </div>
                </div>
              <?php
       			/*echo '<div class="col-md-offset-1 col-md-10" style="padding-top: 1em;">';
       			echo '<h4 class="description"><h2>Why Do We Sleep?</h2><br><h4>This question doesn’t have a simple answer. Sleep scientists have come up with evidence that supports more than one answer to this question. Please click on your assigned story to find out more!</h4></div>';
       			echo "<button type='button' class='btn btn-primary btn-large btn-block' onclick=\"location.href='SleepStories?storyId=1'\">Function of Sleep Story 1</button>";
       			echo "<button type='button' class='btn btn-primary btn-large btn-block' onclick=\"location.href='SleepStories?storyId=2'\">Function of Sleep Story 2</button>";
       			echo "<button type='button' class='btn btn-primary btn-large btn-block' onclick=\"location.href='SleepStories?storyId=3'\">Function of Sleep Story 3</button>";
       			echo "<button type='button' class='btn btn-primary btn-large btn-block' onclick=\"location.href='SleepStories?storyId=4'\">Function of Sleep Story 4</button>";*/
       		    }elseif($userType == 'teacher') { ?>
       			    <div class="row">
                  <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-danger" onclick="location.href='sleep-stories?storyId=1'">
                    <span><p class="lesson-text">Ideas about the Purpose of Sleep Story (Student View)</p></span>
                      </div>
                  </div>
       				<div class="col-xs-offset-2 col-xs-8">
       				    <div class="lesson lesson-danger" onclick="location.href='sleep-stories-non-student-review?showClass=1'">
       					<span><p class="lesson-text">Ideas about the Purpose of Sleep Story Review (Show to class)</p></span>
       				    </div>
       				</div>
       				<div class="col-xs-offset-2 col-xs-8">
       				    <div class="lesson lesson-danger" onclick="location.href='sleep-stories-non-student-review'">
       					<span><p class="lesson-text">Ideas about the Purpose of Sleep Story Review (Not Show to class)</p></span>
       				    </div>
       				</div>
       			    </div>
       	       <?php 	    }
       		}
         }

       }elseif($lessonId==3) {
	        if($activityId == 1){
		if($pageName==="sleepHabits"){
		    //echo "<h1>Please See Master 4 for proposed content of slide show<h1>";
		}elseif ($pageName==="animal") {
              if($userType == 'student') { ?>
                <div class="row">
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=3'">
                <span><p class="lesson-text">Animal card sorting</p></span>
                  </div>
              </div>
                </div>
                <?php 	    }elseif($userType == 'teacher') { ?>
              <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=3'">
                  <span><p class="lesson-text">Animal card sorting (student view)</p></span>
                    </div>
                </div>
                  <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?showClass=yes'">
                    <span><p class="lesson-text">Animal Cards Students' Response (Show to Class)</p></span>
                </div>
                  </div>
                  <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?showClass=no'">
                    <span><p class="lesson-text">Animal Cards Students' Response (Not Show to Class)</p></span>
                </div>
                  </div>
              </div>
          <?php
        }
		  # code...
		}
	    }elseif($activityId == 2){
        if($pageName === "datahunt"){
          if($userType == 'teacher') { ?>

        <?php }elseif($userType == 'student') { ?>

      <?php }
    }elseif($pageName === "sleepdata"){
            if($userType == 'teacher') { ?>
            <div class="row">
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-danger" onclick="location.href='my-sleep-data?grade=4'">
                <span><p class="lesson-text">My Sleep Data (student view)</p></span>
                  </div>
              </div>
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-success" onclick="location.href='upload-my-actogram-result?grade=4'">
                      <span><p class="lesson-text">Upload Students' Actogram</p></span>
                  </div>
              </div>
              <div class="col-xs-offset-2 col-xs-8">
                  <div class="lesson lesson-warning" onclick="location.href='teacher-review-actigram?grade=4'">
                      <span><p class="lesson-text">Review Students' Actogram</p></span>

                  </div>
              </div>
            </div>
          <?php }elseif($userType == 'student') { ?>

        <?php 	    }
            }
      }elseif($activityId == 3){
        if ($pageName==="animalSlide") {
                  if($userType == 'student') { ?>
                    <div class="row">
                  <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=3'">
                    <span><p class="lesson-text">Animal card sorting</p></span>
                      </div>
                  </div>
                    </div>
                    <?php 	    }elseif($userType == 'teacher') { ?>
                  <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=3'">
                      <span><p class="lesson-text">Animal card sorting (student view)</p></span>
                        </div>
                    </div>
                      <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?showClass=yes'">
                        <span><p class="lesson-text">Animal Cards Students' Response (Show to Class)</p></span>
                    </div>
                      </div>
                      <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?showClass=no'">
                        <span><p class="lesson-text">Animal Cards Students' Response (Not Show to Class)</p></span>
                    </div>
                      </div>
                  </div>
              <?php
            }
          }elseif ($pageName==="animal") {
                    if($userType == 'student') { ?>
                      <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=3'">
                      <span><p class="lesson-text">Animal card sorting</p></span>
                        </div>
                    </div>
                      </div>
                      <?php 	    }elseif($userType == 'teacher') { ?>
                    <div class="row">
                      <div class="col-xs-offset-2 col-xs-8">
                          <div class="lesson lesson-danger" onclick="location.href='animal-card-test?lesson=3'">
                        <span><p class="lesson-text">Animal card sorting (student view)</p></span>
                          </div>
                      </div>
                        <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?lesson=3&showClass=yes'">
                          <span><p class="lesson-text">Animal Cards Students' Response (Show to Class)</p></span>
                      </div>
                        </div>
                        <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-danger" onclick="location.href='animal-card-test-non-student-review?lesson=3&showClass=no'">
                          <span><p class="lesson-text">Animal Cards Students' Response (Not Show to Class)</p></span>
                      </div>
                        </div>
                    </div>
                <?php
              }
            }

      }
        }elseif($lessonId==4) {
          if($userType == 'student') { ?>
              <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='good-night-sleep'">
              <span><p class="lesson-text">Part One</p></span>
                </div>
            </div>
            <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='good-night-sleep-part-two'">
              <span><p class="lesson-text">Part Two</p></span>
                </div>
            </div>
              </div>
              <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
                <div class="lesson lesson-danger" onclick="location.href='good-night-sleep-part-three'">
              <span><p class="lesson-text">Part Three</p></span>
                </div>
            </div>
              </div>
    <?php 	    }elseif($userType == 'teacher'){ ?>
            <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='good-night-sleep-teacher-select'">
                  <span><p class="lesson-text">Part Two Review</p></span>
              </div>
                </div>
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='good-night-sleep-teacher-review?showToClass=1'">
                  <span><p class="lesson-text">Part Three Review (Show To Class)</p></span>
              </div>
                </div>
                <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-danger" onclick="location.href='good-night-sleep-teacher-review?showToClass=0'">
                  <span><p class="lesson-text">Part Three Review</p></span>
              </div>
                </div>
            </div>
    <?php 	    }

        }
    	?>
			</div>
		    </div>
	        </div>


	    </div>


	    <?php include 'partials/footer.php' ?>
	</div>
    </body>
<?php include 'partials/scripts.php' ?>
</html>
