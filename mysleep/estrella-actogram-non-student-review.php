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
if ($userType == "teacher"){
   $classId = $_SESSION['classId'];
}
$showToClass = 0;
$showToClass = $_GET['showToClass'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Effect Card</title>
	<style>

	 table{
	     font-size:x-large;
	 }
	</style>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php
                  if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLinkReview($config,$userType);
                  }else {
                   ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                              <li><a href="#" onclick="location.href='main-page';">Home</a></li>
                              <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
                              <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                              <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=2&activity=1&name=estrella">Activity One</a></li>
                              <li class="active">Review Estrella's Actogram (Show Class)</li>
                            </ol>
                        </div>
                    </div>
                  <?php } ?>

		    <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
            <div>
                    <div class="card-body">
                        <h4 class="card-title">Estrella’s Actogram Practice</h4>
                        <p class="card-text">Using the data table below the actogram, mark on Estrella’s Actogram where each time is with the appropriate question number.</p>
                    </div>
                    <!--question div-->
                    <div id="rootwizard" style="margin-top: 2em;">

                          <div class="row" style="width: 100%;">
                            <div class="col-xs-12 col-md-12">
                              <ul class="nav nav-justified nav-pills nav-pills-warning" role="tablist">
                                  <li class="nav-item col-1"><a href="#question1" data-toggle="tab" style="min-width:20px">Q1</a></li>
                                  <li class="nav-item col-1"><a href="#question2" data-toggle="tab" style="min-width:20px">Q2</a></li>
                                  <li class="nav-item col-1"><a href="#question3" data-toggle="tab" style="min-width:20px">Q3</a></li>
                                  <li class="nav-item col-1"><a href="#question4" data-toggle="tab" style="min-width:20px">Q4</a></li>
                                  <li class="nav-item col-1"><a href="#question5" data-toggle="tab" style="min-width:20px">Q5</a></li>
                                  <li class="nav-item col-1"><a href="#question6" data-toggle="tab" style="min-width:20px">Q6</a></li>
                                  <li class="nav-item col-1"><a href="#question7" data-toggle="tab" style="min-width:20px">Q7</a></li>
                                  <li class="nav-item col-1"><a href="#question8" data-toggle="tab" style="min-width:20px">Q8</a></li>
                                  <li class="nav-item col-1"><a href="#question9" data-toggle="tab" style="min-width:20px">Q9</a></li>
                                  <li class="nav-item col-1"><a href="#question10" data-toggle="tab" style="min-width:20px">Q10</a></li>
                              </ul>
                            </div>
                        </div>


                        <div class="tab-content" style="margin-top: 1em;">
                            <div class="tab-pane active" id="question1">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">1. Time watch was put on and when she took it off at the end of the data collection period.</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question2">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">2. One time that Estrella may have taken her watch off her wrist and no data were collected.</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question3">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">3. The sleep period that begins at 11pm.</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question4">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">4. The START of Tuesday night’s Sleep.</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question5">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">5. The time Estrella woke up on Wednesday.</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question6">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">6. Latest Bedtime</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question7">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">7. The sleep period with the shortest Total Sleep Time</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question8">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">8. The sleep period with the longest Total Sleep Time</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question9">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">9. The sleep period with the longest time it took to fall asleep</h4>
                                  </div>
                              </div>
                            </div>
                            <div class="tab-pane" id="question10">
                              <div class="card" style="width: 100%;margin-bottom: 1em;">
                                  <div class="card-body">
                                      <h4 class="card-title">10. On Friday night’s sleep (Saturday), mark the halfway point (5 hours) into the nights sleep.</h4>
                                  </div>
                              </div>
                            </div>
                            <ul class="pager wizard">
                                <li class="previous"><a href="#">Previous</a></li>
                                <li class="next"><a href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <img id="id_actibackground" name="actibackground" src="images/fourthgrade-lessontwo/estrellaActogramAnswer.png" style="width:100%" />
                    </div>


              </div>
		          </div>
        </div>

		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>

  <script src="https://code.highcharts.com/highcharts.src.js"></script>
  <script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
  <script type="text/javascript">


      $(function () {
           $('#rootwizard').bootstrapWizard({
               'nextSelector': '.next',
               'previousSelector': '.previous',

               onTabShow: function(tab, navigation, index) {
                 var total = navigation.find('li').length;
                 var current = index + 1;
                   if (current >= total) {
                       $('#rootwizard').find('.pager .next').hide();
                   } else {
                       $('#rootwizard').find('.pager .next').show();
                       $('#rootwizard').find('.pager .finish').hide();
                   }
               },
           });
      });
	</script>
  </body>
</html>
