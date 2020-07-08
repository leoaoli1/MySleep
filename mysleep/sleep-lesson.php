<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Wo-Tak Wu 
#
require_once('utilities.php');
include 'connectdb.php';
session_start();

$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$userDisplayName = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
if($userId==""){
    header("Location: login");
    exit;
}
$classGrade = $_SESSION['classGrade'];
$classId = $_SESSION['classId'];
if(($userType=='student')&&($classId == null)){
    $message = "Cannot find you class, Please contact your teacher!";
    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'main-page';</script>";
}

$currentGrade = getGrade($userId);
$result = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$row = mysql_fetch_array($result);

$hasConfig = False;
if ($config = getActivityConfigWithLesson(0)) {
  $hasConfig = True;
  $titleArray = explode("&z&", $config['activity_title']);
}
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
                        <?php
                        if ($hasConfig){
                          echo '<div class="row">';
                          for ($i=1; $i <= 5 ; $i++) {
                            if($row['Lesson_'.$i]||$userType=='teacher'){
                              $link = "'lesson-menu?lesson=".$i."'";
                              // $link = ($i==5 ? "'analysis-project-g".$classGrade."'":"'lesson-menu?lesson=".$i."'");
                              echo '<div class="col-xs-8 col-xs-offset-2">';
                              echo '<div class="lesson lesson-'.num2color($i).'" onclick="location.href='.$link.'"> <span><i class="material-icons">filter_'.$i.'</i></span>';
                              echo '<p>Lesson '.num2word($i);
                              if(count($titleArray)>=$i){
                                echo ': '.$titleArray[$i-1];
                              }
                              echo "</p>";
                              echo "</div>";
                              echo "</div>";
                            }
                          }
                        }else{
                          if ($classGrade==4) { ?>
                              <div class="row">
    			                     <?php if($row['Lesson_1']||$userType=='teacher') {?>
                                  <div class="col-xs-8 col-xs-offset-2">
                                      <div class="lesson lesson-danger" onclick="location.href='fourth-grade-lesson-menu?lesson=1'"> <span><i class="material-icons">filter_1</i></span>
                                          <?php
                                            echo "<p>Lesson One";
                                            if(count($titleArray)>=1){
                                              echo ': '.$titleArray[0];
                                            }
                                            echo "</p>";
                                           ?>
                                      </div>
                                  </div>
    			                     <?php } if($row['Lesson_2']||$userType=='teacher') {?>
                                  <div class="col-xs-8 col-xs-offset-2">
                                      <div class="lesson lesson-info" onclick="location.href='fourth-grade-lesson-menu?lesson=2'"> <span><i class="material-icons">filter_2</i></span>
                                        <?php
                                          echo "<p>Lesson Two";
                                          if(count($titleArray)>=2){
                                            echo ': '.$titleArray[1];
                                          }
                                          echo "</p>";
                                         ?>
                                      </div>
                                  </div>
    			                     <?php } if($row['Lesson_3']||$userType=='teacher') {?>
                                  <div class="col-xs-8 col-xs-offset-2">
                                      <div class="lesson lesson-warning" onclick="location.href='fourth-grade-lesson-menu?lesson=3'"> <span><i class="material-icons">filter_3</i></span>
                                        <?php
                                          echo "<p>Lesson Three";
                                          if(count($titleArray)>=3){
                                            echo ': '.$titleArray[2];
                                          }
                                          echo "</p>";
                                         ?>
                                      </div>
                                  </div>
    			                      <?php } ?>

    			                      <?php if($row['Lesson_4']||$userType=='teacher') {?>
                                  <div class="col-xs-8 col-xs-offset-2">
                                      <div class="lesson lesson-success" onclick="location.href='fourth-grade-lesson-menu?lesson=4'"> <span><i class="material-icons">filter_4</i></span>
                                        <?php
                                          echo "<p>Lesson Four";
                                          if(count($titleArray)>=4){
                                            echo ': '.$titleArray[3];
                                          }
                                          echo "</p>";
                                         ?>
                                      </div>
                                  </div>
                        				<?php } if($row['Lesson_5']||$userType=='teacher') {  // assume it is lesson 5 for now?>
                      				    <div class="col-xs-offset-2 col-xs-8">
                                      <div class="lesson lesson-success" onclick="location.href='analysis-project-g4'"><span><i class="material-icons">filter_5</i></span>
                                          <p>Lesson Five: Analysis Project</p>
                                      </div>
                                  </div>
    			                     <?php } ?>
                              </div>

                            <?php } elseif (($currentGrade==5)&&($userType == 'student')) { ?>
                              <div class="row">
                      					<div class="col-xs-8 col-xs-offset-2">
                      					    <div class="lesson lesson-danger" onclick="location.href='practice-diary-menu'">
                      						<p>Practice Diaries</p>
                      					    </div>
                      					</div>
                      					<?php if($row['Lesson_1']) {?>
                      					    <div class="col-xs-8 col-xs-offset-2">
                      						<div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-menu?lesson=1'"> <span><i class="material-icons">filter_1</i></span>
                                                                          <p>Lesson One</p>
                      						</div>
                      					    </div>
                      					<?php } if($row['Lesson_2']) {?>
                                                                  <div class="col-xs-8 col-xs-offset-2">
                      						<div class="lesson lesson-info" onclick="location.href='fifth-grade-lesson-menu?lesson=2'"> <span><i class="material-icons">filter_2</i></span>
                                                                          <p>Lesson Two</p>
                      						</div>
                                                                  </div>
                      					<?php } if($row['Lesson_3']) {?>
                      					    <div class="col-xs-8 col-xs-offset-2">
                      						<div class="lesson lesson-warning" onclick="location.href='fifth-grade-lesson-menu?lesson=3'"> <span><i class="material-icons">filter_3</i></span>
                                                                          <p>Lesson Three</p>
                      						</div>
                      					    </div>
                      					<?php } ?>

                      					<?php if($row['Lesson_4']) {?>
                      					    <div class="col-xs-8 col-xs-offset-2">
                      						<div class="lesson lesson-success" onclick="location.href='fifth-grade-lesson-menu?lesson=4'"> <span><i class="material-icons">filter_4</i></span>
                                                                          <p>Lesson Four</p>
                      						</div>
                      					    </div>
                      				<?php } if($row['Lesson_5']) {?>
                      				    <div class="col-xs-offset-2 col-xs-8">
                                                              <div class="lesson lesson-success" onclick="location.href='analysis-project-g5'"><span><i class="material-icons">filter_5</i></span>
                                                                  <p>Lesson Five: Analysis Project</p>
                                                              </div>
                                                          </div>
                      					<?php } ?>
                                </div>
                              <?php } elseif(($classGrade==5)&&($userType == 'teacher')) { ?>
                                              <div class="row">
                                        					<div class="col-xs-8 col-xs-offset-2">
                                        					    <div class="lesson lesson-danger" onclick="location.href='practice-diary-menu'">
                                        						<p>Practice Diaries</p>
                                        					    </div>
                                        					</div>
                                                  <div class="col-xs-offset-2 col-xs-8">
                                                      <div class="lesson lesson-danger" onclick="location.href='fifth-grade-lesson-menu?lesson=1'"> <span><i class="material-icons">filter_1</i></span>
                                                          <p>Lesson One</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-offset-2 col-xs-8">
                                                      <div class="lesson lesson-info" onclick="location.href='fifth-grade-lesson-menu?lesson=2'"> <span><i class="material-icons">filter_2</i></span>
                                                          <p>Lesson Two</p>
                                                      </div>
                                                  </div>

                                                  <div class="col-xs-offset-2 col-xs-8">
                                                      <div class="lesson lesson-warning" onclick="location.href='fifth-grade-lesson-menu?lesson=3'"> <span><i class="material-icons">filter_3</i></span>
                                                          <p>Lesson Three</p>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-offset-2 col-xs-8">
                                                      <div class="lesson lesson-success" onclick="location.href='fifth-grade-lesson-menu?lesson=4'"> <span><i class="material-icons">filter_4</i></span>
                                                          <p>Lesson Four</p>
                                                      </div>
                                                  </div>
  						                                          <div class="col-xs-offset-2 col-xs-8">
                                                      <div class="lesson lesson-success" onclick="location.href='analysis-project-g5'"><span><i class="material-icons">filter_5</i></span>
                                                          <p>Lesson Five: Analysis Project</p>
                                                      </div>
                                                  </div>
                                              </div>
                                    <?php }else{ ?>
                                      <p>MISMATCH: PLEASE CONTACT TECH SUPPORT!</p>
                                    <?php }
                                  }?>


                            </div>
                    </div>
                <?php include 'partials/footer.php' ?>
                </div>

		<?php mysql_close($con); ?>
    </body>
    <?php include 'partials/scripts.php' ?>

    </html>
