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


                    <?php if ($showToClass): ?>
                      <div class="card-body">
                          <h4 class="card-title">Estrella’s Actogram Practice</h4>
                          <p class="card-text">Using the data table below the actogram, mark on Estrella’s Actogram where each time is with the appropriate question number.</p>
                      </div>
                      <!--question div-->
                      <div id="rootwizard" style="margin-top: 2em;">

                            <div class="row" style="width: 100%;">
                              <div class="col-xs-12 col-md-12">
                                <ul class="nav nav-justified nav-pills nav-pills-warning" role="tablist">
                                  <?php for ($i=1; $i<=10 ; $i++) {
                                      echo '<li class="nav-item col-1"><a href="#question'.$i.'" data-toggle="tab" style="min-width:20px">Q'.$i.'</a></li>';
                                  } ?>
                                </ul>
                              </div>
                          </div>


                          <div class="tab-content" style="margin-top: 1em;">
                            <?php
                            $questionArray = array('1. Time watch was put on and when she took it off at the end of the data collection period.',
                                                  '2. One time that Estrella may have taken her watch off her wrist and no data were collected.',
                                                  '3. The sleep period that begins at 11pm.',
                                                  '4. The START of Tuesday night’s Sleep.',
                                                  '5. The time Estrella woke up on Wednesday.',
                                                  '6. Latest Bedtime',
                                                  '7. The sleep period with the shortest Total Sleep Time',
                                                  '8. The sleep period with the longest Total Sleep Time',
                                                  '9. The sleep period with the longest time it took to fall asleep',
                                                  '10. On Friday night’s sleep (Saturday), mark the halfway point (5 hours) into the nights sleep.');
                            for ($i=1; $i <=10 ; $i++) {
                              ?>
                              <div class="tab-pane active" id="question<?php echo $i; ?>">
                                <div class="card" style="width: 100%;margin-bottom: 1em;">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $questionArray[$i-1]; ?></h4>
                                    </div>
                                </div>
                              </div>
                            <?php } ?>
                              <ul class="pager wizard">
                                  <li class="previous"><a href="#">Previous</a></li>
                                  <li class="next"><a href="#">Next</a></li>
                              </ul>
                          </div>
                      </div>
                    <?php else: //not show to class section?>
                      <div class="row">
                          <form>
                      			<div class="col-xs-offset-1 col-xs-6 col-md-offset-1 col-md-6 ">
                      			    <select class="input-lg" name='workId' id="workId">
                        				<option value='null' disabled selected>Please choose a student</option>
                        				<?php
                          				include 'connectdb.php';
                                  $workList = mysql_query("SELECT * FROM estrellaActogramDraw WHERE classId='$classId' order by recordRow");
                          				showGroupOptionList($workList,$demoMode);
                          				mysql_close($con);
                        				?>
                      			    </select>
                      			</div>
                  		   </form>
                     </div>
                     <div class="row">
                         <h3 class="text-center">Estrella's Actogram</h3>
                         <img class="img-responsive" id="datahunt">
                     </div>

                     <?php if ($config['gradable']): ?>
                       <div class="row">
                         <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10">
                           <input type="text" id="gradeWorkId" name="workId" style="display: none">
                           <div class="row">
                             <div class="col-xs-3 col-md-3">
                               <h5 class="text-center">Score</h5>
                               <textarea class="form-control input-md" style="text-align: justify; text-align-last: center;" id="score" name="score" rows="1"></textarea>
                             </div>
                             <div class="col-xs-9 col-md-9">
                               <h5 class="text-center">Comment</h5>
                               <textarea class="form-control input-md" id="comment" name="comment" rows="3"></textarea>
                             </div>
                           </div>
                           <div class="row">
                             <div class="col-xs-offset-4 col-xs-4 col-md-offset-4 col-md-4">
                               <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save" onclick="save()">Save</button>
                             </div>
                           </div>
                         </div>
                       </div>
                     <?php endif; ?>


                    <?php endif; ?>

                    <!-- Right Answer -->
                    <div class="row">
                        <h3 class="text-center">Answer Key</h3>
                        <img id="answerkey" name="actibackground" src="images/fourthgrade-lessontwo/estrellaActogramAnswer.png" style="width:100%" />
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

  $('#workId').change( function (e) {

      e.preventDefault();

      $.ajax({
        type: 'post',
        url: 'estrella-actogram-content',
        data: {id: $('#workId').val()},
        dataType: 'json',
        success: function (response) {
          $("#datahunt").attr("src", response.dataHunt);
          $("#score").val(response.score);
          $("#comment").val(response.comment);
          $("#gradeWorkId").val(response.workId);
          if (response.dataHunt) {
            // $("#answerkey").attr("style","display:block");
          }else {
            // $("#answerkey").attr("style","display:none");
          }
         }
      });
  });

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

      function save(){
        $.ajax({
           type: "POST",
           url: "estrella-actogram-draw-review-done",
           data: {
                  workId: $("#gradeWorkId").val(),
                  score: $("#score").val(),
                  comment: $("#comment").val()
                }
         })
        .done(function(){
          console.log("done");
          alert("Score and comment saved successfully.");
        })
      }
	</script>
  </body>
</html>
