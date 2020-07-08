<?Php
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
$configs = getAllActivityConfigWithLesson($lessonId);
   if(($userType == 'student') && ($currentGrade != 4)){
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
                            <li><a href="main-page">Home</a></li>
                            <li><a href="sleep-lesson">Lessons</a></li>
                            <li class="active"><?php echo "Lesson ".ucfirst(num2word($lessonId)); ?></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-10 text-center">
                        <h2 class="title"><?php echo "Lesson ".ucfirst(num2word($lessonId)); ?></h2>
                    </div>
                </div>
                <?php
                // student flexible framework
                  if (mysql_num_rows($configs)>0){
                    echo '<div class="row">';
                    while ($row = mysql_fetch_array($configs)) {
                      if ($userType == 'teacher') {
                        $link = "'fourth-grade-lesson-activity-menu?lesson=".$row['lesson_num']."&activity=".$row['activity_num']."'";// "'".$row['activity_id']."'";
                      }else {
                        $link = "'".$row['activity_id']."'";
                      }
                      echo '<div class="col-xs-offset-2 col-xs-8">';
                      echo '<div class="lesson lesson-'.num2color($row['activity_num']).'" onclick="location.href='.$link.' ">';
                      echo '<span><p class="lesson-text">Activity '.num2word($row['activity_num']).': '.$row['activity_title'].'</p></span>';
                      echo '</div>';
                      echo '</div>';
                    }
                    echo '</div>';
                  }else{

                    // old versions below *********************

                 ?>
                    <!-- Lesson One -->
                <?php if($lessonId == 1){
	    	    if ($userType == 'student') { ?>

              <div class="row">
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=1'">
                        <span><p class="lesson-text">Activity One</p></span>
                    </div>
                </div>
                <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=15'">
                        <span><p class="lesson-text">Taking It Home Activity: Interviewing an Adult</p></span>
                    </div>
                </div>
                  <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-primary" onclick="location.href='practice-diary-menu'">
                          <span><p class="lesson-text">Activity Two: Practice Diaries</p></span>
                      </div>
                  </div>
                  <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-warning" onclick="location.href='diary-menu'">
                          <span><p class="lesson-text">Activity Three: Gathering and Recording Data</p></span>
                      </div>
                  </div>
              </div>

      <?php }elseif($userType == 'teacher') { ?>
      <div class="row">
        <div class="col-xs-offset-2 col-xs-8">
            <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=1'">
                <span><p class="lesson-text">Activity One</p></span>
            </div>
        </div>
        <div class="col-xs-offset-2 col-xs-8">
            <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=15'">
                <span><p class="lesson-text">Taking It Home Activity: Interviewing an Adult</p></span>
            </div>
        </div>
          <div class="col-xs-offset-2 col-xs-8">
              <div class="lesson lesson-primary" onclick="location.href='practice-diary-menu'">
                  <span><p class="lesson-text">Activity Two: Practice Diaries</p></span>
              </div>
          </div>
      </div>

                <?php }
			else {      // May need to distinguish other user types here in the future


			}  }elseif($lessonId==2) {
			    if ($userType == 'student') {
			?>

                <!-- Lesson Two -->
                <div class="row">
                  <!-- <div class="col-xs-offset-2 col-xs-8">
                      <div class="lesson lesson-danger" onclick="location.href='review-interview'">
                          <span><p class="lesson-text">Review Interviews</p></span>
                      </div>
                  </div> -->
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-info" onclick="location.href='estrella-actogram?grade=4'">
                            <span><p class="lesson-text">Activity One: Estrella's Actogram</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-warning" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=2'">
                            <span><p class="lesson-text">Activity Two: Data Hunt</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=3'">
                            <span><p class="lesson-text">Activity Three: Why do We Sleep?</p></span>
                        </div>
                    </div>

                    <!-- <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='how-do-i-sleep?grade=4'">
                            <span><p class="lesson-text">Activity Three: How Do I Sleep?</p></span>

                        </div>
                    </div> -->
                </div>

                <?php } elseif($userType == 'teacher') {?>
                <div class="row">
		                <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=1&name=estrella'">
                            <span><p class="lesson-text">Activity One: Estrella's Actogram</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=2'">
                            <span><p class="lesson-text">Activity Two: Data Hunt</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-success" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=3'">
                            <span><p class="lesson-text">Activity Three: Why do We Sleep?</p></span>
                        </div>
                    </div>
                    <!-- <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='diary-menu'">
                            <span><p class="lesson-text">Gathering and Recording Data</p></span>
                        </div>
                    </div> -->
                    <!-- <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-success" onclick="location.href='upload-my-actogram-result?grade=4'">
                            <span><p class="lesson-text">Upload Students' Actogram</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-warning" onclick="location.href='teacher-review-actigram?grade=4'">
                            <span><p class="lesson-text">Review Students' Actogram</p></span>

                        </div>
                    </div> -->
		    <!--<div  class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='FourthGradeLessonActivityMenu?lesson=2&activity=3'">
                            <span><p class="lesson-text">How Do I Sleep?</p></span>

                        </div>
                    </div>-->
                </div>


                <?php } }elseif($lessonId==3) { if($userType == 'student') { ?>

                <!-- Lesson Three -->

                <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=1'">
                            <span><p class="lesson-text">Activity One</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=2'">
                            <span><p class="lesson-text">Activity Two</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-warning" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=3'">
                            <span><p class="lesson-text">Activity Three</p></span>
                        </div>
                    </div>
                </div>

                <?php } elseif($userType=='teacher') { ?>

                <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=1'">
                            <span><p class="lesson-text">Activity One</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=2'">
                            <span><p class="lesson-text">Activity Two</p></span>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="lesson lesson-warning" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=3'">
                            <span><p class="lesson-text">Activity Three</p></span>
                        </div>
                    </div>
                </div>

              <?php } }elseif($lessonId==4) {
		    if($userType == 'student') {

		?>
		           <!-- <div class="row">
        		    <div class="col-xs-offset-2 col-xs-8">
               <div class="col-xs-offset-2 col-xs-8">
                    <div class="lesson lesson-danger" onclick="location.href='how-do-i-sleep?grade=4'">
                        <span><p class="lesson-text">Activity One: How Do I Sleep?</p></span>

                    </div>
                </div>
        		    </div>
        		    </div> -->
                <div class="row">
                  <div class="col-xs-offset-2 col-xs-8">
                      <div class="col-xs-offset-2 col-xs-8">
                          <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=1'">
                              <span><p class="lesson-text">Activity One</p></span>
                          </div>
                      </div>
                  </div>
		  <div class="col-xs-offset-2 col-xs-8">
                      <div class="col-xs-offset-2 col-xs-8">
                          <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=3'">
                              <span><p class="lesson-text">Activity Three</p></span>
                          </div>
                      </div>
                  </div>
		</div>
                    <!-- <div class="col-xs-offset-2 col-xs-8">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=2'">
                                <span><p class="lesson-text">Avtivity Two</p></span>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=3'">
                                <span><p class="lesson-text">Avtivity Three</p></span>
                            </div>
                        </div>
                    </div>
                </div> -->

                <?php } elseif($userType=='teacher') { ?>
		    <div class="row">
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=1'">
                                <span><p class="lesson-text">Activity One</p></span>
                            </div>
                        </div>
                    </div>
		    <div class="col-xs-offset-2 col-xs-8">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=3'">
                                <span><p class="lesson-text">Activity Three</p></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-offset-2 col-xs-8">
                        <div class="col-xs-offset-2 col-xs-8">
                            <div class="lesson lesson-danger" onclick="location.href='teacher-aggregate-table'">
                                <span><p class="lesson-text">Aggregate Table</p></span>
                            </div>
                        </div>
                    </div>
                </div>



              <?php } } }?>

            </div>
        </div>
        <?php include 'partials/footer.php' ?>
    </div>







</body>
<?php include 'partials/scripts.php' ?>

</html>
