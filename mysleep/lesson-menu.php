<?Php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
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
                  // flexible framework
                    if (mysql_num_rows($configs)>0){
                      echo '<div class="row">';
                      while ($row = mysql_fetch_array($configs)) {
                        if ($userType == 'teacher' && ($row['activity_type'] == 'normal'||$row['activity_type'] == 'assignment')) {
                          $link = "location.href='activity-console?lesson=".$row['lesson_num']."&activity=".$row['activity_num']."'";// "'".$row['activity_id']."'";
                        }elseif ($row['activity_type'] == 'link'){
                          $link = "window.open('".$row['activity_id']."')";
                        }else {
                          $link = "location.href='".$row['activity_id']."?lesson=".$row['lesson_num']."&activity=".$row['activity_num']."'";
                        }

                        if ($row['activity_type'] == 'normal' || $row['activity_type'] == 'link') {
                          $pix = 'Activity '.$row['lesson_num'].'.'.$row['activity_num'].': ';
                        }elseif ($row['activity_type'] == 'assignment') {
                          $pix = 'Take Home Assignment: ';
                        }else {
                          $pix = '';
                        }
                        echo '<div class="col-xs-offset-2 col-xs-8">';
                        echo '<div class="lesson lesson-'.num2color($row['activity_num']).'" onclick="'.$link.' ">';
                        echo '<span><p class="lesson-text">';
                        echo $pix.''.$row['activity_title'];//'Activity '.num2word($row['activity_num']).': '.$row['activity_title']
                        echo '</p></span>';
                        echo '</div>';
                        echo '</div>';
                      }
                      echo '</div>';
                    }
                  ?>
              </div>
          </div>
          <?php include 'partials/footer.php' ?>
      </div>
  </body>
  <?php include 'partials/scripts.php' ?>
</html>
