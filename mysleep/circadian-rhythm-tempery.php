<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#
# Author:   Ao Li <aoli1@email.arizona.edu>
#           Siteng Chen <sitengchen@email.arizona.edu>
#

require_once('utilities.php');
require_once('utilities-diary.php');
require_once('diary-data.php');
require_once('utilities-actogram.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$partId = $_GET['part'];
$lessonId = $_GET['lesson'];
$classId = $_SESSION['classId'];
$backFlag = 0;
$lessonNameArray = array('','One','Two','Three','Four');
if(isset($_GET['back'])){
    $backFlag = $_GET['back'];
}
$currentGrade = getCurrentGrade($userId);
include 'connectdb.php';
$status = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$statusResult = mysql_fetch_array($status);

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep</title>
	<style>
	 #id_actigraphy{
	     cursor: pointer;
	 }
	</style>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php
                  if ($config) {
                    $partId = 2;
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType);
                  }else {
                   ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a  class="exit" data-location="main-page">Home</a></li>
                                <li><a  class="exit" data-location="sleep-lesson">Lessons</a></li>
                        				<li><a  class="exit" data-location="fourth-grade-lesson-menu?lesson=<?php echo $lessonId; ?>">Lesson <?php echo $lessonNameArray[$lessonId]; ?></a></li>
                                <li><a  class="exit" data-location="fourth-grade-lesson-activity-menu?lesson=<?php echo $lessonId; ?>&activity=1">Activity One</a></li>

                                <?php if($partId == 1){ ?>
                                  <li class="active">Part 1</li>
                                <?php }elseif($partId == 2){ ?>
                                  <li class="active">Part 2</li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                        <div>
                            <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                              <?php if($partId == 1){ ?>
                                <h2>Coming Soon<h2>
                              <?php }elseif($partId == 2){ ?>
                                  <video src="./videos/CircadianVideo.mp4" controls="controls" style="width:100%;">
                                    your browser does not support the video tag
                                  </video>
                              <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="modal fade diaryGraphSaveModal" id="submit-modal-feedback" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        In the next activity you will find out if you are in sync with your biological clock.
      </div>
      <div class="modal-footer">
        <button type="button" onclick="<?php echo "location.href='lesson-menu?".$query."'"; ?>" data-dismiss="modal" class="btn btn-success btn-simple">Continue</button>
      </div>
    </div>
  </div>
</div>
        <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>


<script>
document.querySelector('video').addEventListener('ended',function(){
  $('#submit-modal-feedback').modal('show');
    console.log('Video has ended!');
  }, false);
    </script>
</html>
