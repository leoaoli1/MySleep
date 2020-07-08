<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen
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
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
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
                          				<?php
                                    $link = "'lesson-menu?lesson=".$lessonNum."'";
                                    echo '<li><a href="#" onclick="location.href='.$link.'">Lesson '.ucfirst(num2word($lessonNum)).'</a></li>';
                                    echo '<li class="active">Activity '.ucfirst(num2word($activityNum)).'</li>';
			                             ?>
                             </ol>
                       </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-offset-1 col-xs-10 col-sm-10 text-center">
                      <h2 class="title"><?php echo ucfirst($config['activity_title']); ?></h2>
                  </div>
              </div>
              <?php
                $activityId = $config['activity_id'];
                if (file_exists ( $activityId.".php" )) {
                  $link = "'".$activityId."?lesson=".$lessonNum."&activity=".$activityNum."'";
                   echo '<div class="row">';
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link.'"><span><p class="lesson-text">Student View</p></span></div>';
    							 echo '</div>';
                }

                 if (file_exists ( $activityId."-non-student-review.php" )) {
                   $link0 = "'".$activityId."-non-student-review?showToClass=1&lesson=".$lessonNum."&activity=".$activityNum."'";
                   $link1 = "'".$activityId."-non-student-review?showToClass=0&lesson=".$lessonNum."&activity=".$activityNum."'";
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link0.'"><span><p class="lesson-text">Show to class result</p></span></div>';
    							 echo '</div>';
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link1.'"><span><p class="lesson-text">Review';
                   if ($config['gradable']>0) {
                     echo ' and Grade';
                   } elseif ($config['gradable'] == 0) {
                     echo ' Answers';
                   }
                   echo '</p></span></div>';
    							 echo '</div>';
                 }
                 if (file_exists ( $activityId."-slides.php" )) {
                   $link0 = "'".$activityId."-slides?lesson=".$lessonNum."&activity=".$activityNum."'";
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link0.'"><span><p class="lesson-text">Slides</p></span></div>';
    							 echo '</div>';
                 }
                 if (file_exists ( $activityId."-keys.php" )) {
                   $link0 = "'".$activityId."-keys?lesson=".$lessonNum."&activity=".$activityNum."'";
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link0.'"><span><p class="lesson-text">Keys</p></span></div>';
    							 echo '</div>';
                 }
                 if (file_exists ( $activityId."-show-to-class.php" )) {
                   $link0 = "'".$activityId."-show-to-class?lesson=".$lessonNum."&activity=".$activityNum."'";
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link0.'"><span><p class="lesson-text">Show To Class</p></span></div>';
    							 echo '</div>';
                 }
                 if (file_exists ( $activityId."-edit.php" )) {
                   $link0 = "'".$activityId."-edit?lesson=".$lessonNum."&activity=".$activityNum."'";
                   echo '<div class="col-xs-offset-3 col-xs-6">';
    							 echo '<div class="lesson lesson-'.num2color($activityNum).'" onclick="location.href='.$link0.'"><span><p class="lesson-text">Choose Data Source</p></span></div>';
    							 echo '</div>';
                 }
                 echo '</div>';
  			       ?>
           </div>
       </div>
       <?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
