<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#
# Author:   Siteng Chen <sitengchen@email.arizona.edu>
#

require_once('utilities.php');
require_once('utilities-diary.php');
require_once('diary-data.php');
require_once('utilities-actogram.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$classId = $_SESSION['classId'];
$backFlag = 0;
if(isset($_GET['back'])){
    $backFlag = $_GET['back'];
}
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Estrella's Actogram</title>
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
                        require_once('partials/nav-links.php');
                        navigationLink($config,$userType);
                      }else {
                   ?>
                   <div class="row">
                       <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                           <ol class="breadcrumb">
                               <li><a  class="exit" data-location="main-page">Home</a></li>
                               <li><a  class="exit" data-location="sleep-lesson">Lessons</a></li>
                               <?php if($grade==4){?>
                                   <li><a  class="exit" data-location="fourth-grade-lesson-menu?lesson=2">Lesson Two</a></li>
                               <?php }else{?>
                                   <li><a  class="exit" data-location="fifth-grade-lesson-menu?lesson=2">Lesson Two</a></li>
                               <?php }?>
                               <?php if($userType=='teacher'){?>
                                   <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=2&activity=1&name=estrella">Activity One</a></li>
                                   <li class="active">Estrella's Actogram (Student View)</li>
                                   <?php }else{?>
                                   <li class="active">Estrella's Actogram</li>
                               <?php }?>
                             </ol>
                         </div>
                     </div>
                     <?php } ?>
                        <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                            <div>
                                <?php
                                  $currentGrade = getCurrentGrade($userId);
                                  include 'connectdb.php';
                                  $result = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE userId='$userId' order by recordRow DESC LIMIT 1");
                                  $row = mysql_fetch_array($result);
                                  if(mysql_num_rows($result)>0){
                                      if($row['dataHunt'] != null){
                                          $submitted = 'Submitted';
                                      }else{
                                          $submitted = 'Submit';
                                      }
                                  }
                                  else{
                                      $submitted = 'Submit';
                                  }
                                  $imgSrc =$row['dataHunt'];

                                  mysql_close($con);
                                ?>
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
                                                  <?php if($submitted == 'Submit'){ ?>
                                                  <li class="finish"><a href="#">Finished!  Submit to Teacher</a></li>
                                                  <?php } ?>
                                                  <li class="next"><a href="#">Next</a></li>
                                              </ul>
                                          </div>
                                      </div>
                            					<div class="row">
                            						<canvas id="id_actigraphy" name="actigraphy" style="border:1px solid #d3d3d3; background: url(<?php echo $imgSrc ?>); background-size: 100% 100%;"></canvas>
                                                    <?php if($submitted == 'Submit'){ ?>
                                                        <img id="id_actibackground" name="actibackground" src="images/fourthgrade-lessontwo/estrellasactogram.png" style="width:100%" />
                                                    <?php } ?>

                            					</div>
                            					<div>

                                                    <?php if($submitted == 'Submit'){ ?>
                                                      <button type="button" class="btn btn-gradbg btn-roundThin btn-sm" onclick="redrawAll();" style="float: right;"> Clear All</button>
                                                      <button type="button" class="btn btn-gradorange btn-roundThin btn-sm" onclick="redraw();" style="float: right; margin-right:1.5em;">Undo</button>
                                                    <?php } ?>
                            					</div>


                                </div>
                            </div>
                    </div>
                </div>
            </div>
	    <div class="modal fade dataHuntModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title" id="submit-modal-label">Submit the data hunt?</h4>
			</div>
			<div class="modal-body">
			    Are you ready to submit your work to your teacher?
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			    <button id="submit-activity" type="button" onclick="submit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
			</div>
		    </div>
		</div>
	    </div>


        <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>

<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
<script type="text/javascript">
     var huntcanvas;
     var datacanvas;
     var color = "red";
     var questionIndex = 0;

    partialImage = new Image();
    questionIcon = new Image();
     questionIcon.src = './assets/img/number/question1icon.png';
//     var offsetTop;
     $(function () {
         $("#submit-activity").click(function() {
	     $( "form" ).submit();
        });
    $('#rootwizard').bootstrapWizard({
        'nextSelector': '.next',
        'previousSelector': '.previous',

        onTabShow: function(tab, navigation, index) {
            var total = navigation.find('li').length;
            var current = index + 1;
            saveImage();
            questionIcon.src = './assets/img/number/question'+current+'icon.png';

            // If it's the last tab then hide the last button and show the finish instead
            if (current >= total) {
                $('#rootwizard').find('.pager .next').hide();
                $('#rootwizard').find('.pager .finish').show();
                $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
                $('#rootwizard').find('.pager .next').show();
                $('#rootwizard').find('.pager .finish').hide();
            }
        },

    });
    $('#rootwizard .finish').click(function(event) {
        event.preventDefault();
        var type = "<?php echo $_SESSION["userType"]?>";
        if(type == "student"){
            $('#submit-modal').modal();
          }

    });



     });

    //data hunt
     var bkimage = document.getElementById('id_actibackground');
     if (bkimage !== null){
         bkimage.style.width ='0%'; //style size is the CSS size
         bkimage.style.height='0px';
     }
     huntcanvas = document.getElementById('id_actigraphy');
     if (huntcanvas !== null){
	 huntcanvas.style.width ='100%'; //style size is the CSS size
	 huntcanvas.style.height='600px';
	 //then set the internal size to match
	 huntcanvas.width  = huntcanvas.offsetWidth; //need to set canvas size
	 huntcanvas.height = huntcanvas.offsetHeight;

     if (bkimage !== null){
         var huntctx = huntcanvas.getContext('2d');
         click = false;
         var isDraw = false;
         huntctx.drawImage(bkimage,0,0,huntcanvas.width, 600);//draw the estralla actogram as background


         $('#id_actigraphy').mousedown(function(e){
                               click = true;
                             });

         $('#id_actigraphy').mouseup(function(e){
                             click = false;
                             if (isDraw) {
                               isDraw=false;
                             }else {
                               drawIcon(e.pageX, e.pageY);
                              //  draw(e.pageX, e.pageY);
                             }

                             });




         $('#id_actigraphy').mousemove(function(e){
                               if(click === true){
                               draw(e.pageX, e.pageY);
                               isDraw = true;
                               }
                               });
     }

     }



     window.onload = function(){
         if (bkimage !== null){
           partialImage.src = bkimage.src;
             huntctx.drawImage(bkimage,0,0,huntcanvas.width, 600);//draw the estralla actogram as background
         }
     }

     function saveImage(){
       partialImage.src = huntcanvas.toDataURL('image/png');
     }
     function draw(xPos, yPos){
	 huntctx.beginPath();
	 huntctx.fillStyle = color;
	 console.log($('#id_actigraphy').offset().top);
	 huntctx.arc(xPos - $('#id_actigraphy').offset().left, yPos - $('#id_actigraphy').offset().top, 4, 0, 1 * Math.PI);
	 huntctx.fill();
	 huntctx.closePath();
     }
     function dgdraw(xPos, yPos){
     dgctx.beginPath();
     dgctx.fillStyle = color;
     console.log($('#id_dataactigraphy').offset().top);
     dgctx.arc(xPos - $('#id_dataactigraphy').offset().left, yPos - $('#id_dataactigraphy').offset().top, 4, 0, 1 * Math.PI);
     dgctx.fill();
     dgctx.closePath();
     }

     function redraw(){
	      huntctx.clearRect(0, 0, huntcanvas.width, huntcanvas.height);
        huntctx.drawImage(partialImage,0,0,huntcanvas.width, 600);
     }
     function redrawAll(){
	      huntctx.clearRect(0, 0, huntcanvas.width, huntcanvas.height);
        huntctx.drawImage(bkimage,0,0,huntcanvas.width, 600);
        partialImage.src = bkimage.src;
     }

     function drawIcon(xPos, yPos){
       console.log(xPos+','+yPos);
       huntctx.drawImage(questionIcon,xPos - $('#id_actigraphy').offset().left - 15, yPos - $('#id_actigraphy').offset().top - 15, 30, 30);
     }


     function submit(){
       var img = huntcanvas.toDataURL('image/png');
       $.ajax({
        type: "POST",
        url: "upload-estrellasactogram",
              data: {image: img,type:'hunt'}
      })
      .done(function(respond){console.log("done: "+respond);})
     }
    </script>
</html>
