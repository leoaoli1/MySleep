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

unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
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
        <?php include 'partials/scripts.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php
                      if ($config) {
                        require_once('partials/nav-links.php');
                        navigationLink($config,$userType);
                      }
                   ?>
                        <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                            <div>
                                <?php
                                  $currentGrade = getCurrentGrade($userId);
                                  include 'connectdb.php';
                                  if ($userType == 'teacher') {
                                      $result = mysql_query("SELECT * FROM estrellaActogramDraw WHERE userId='$userId' order by recordRow DESC LIMIT 1");
                                  } else {
                                      $result = mysql_query("SELECT * FROM estrellaActogramDraw WHERE contributors LIKE '%$userId%' order by recordRow DESC LIMIT 1");
                                      // $result = mysql_query("SELECT pictureId, promoteGoodSleep, preventGoodSleep, groupMember, contributors FROM sleepEnvironment WHERE contributors LIKE '%$userId%' ORDER BY recordId");
                                  }
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

                                  unset($_SESSION['current_work']);
                                  $_SESSION['current_work'] = $row;

                                  mysql_close($con);
                                ?>
                                <?php include 'add-group-member-button.php' ?>

                                      <div class="card-body">
                                          <h3 class="card-title">Estrella’s Actogram Practice</h3>
                                          <p class="card-text" id="instruction" style="font-size:18px">Click on the places on Estrella’s actogram to mark where you can find the answer to Question 1. Then go on to the other questions each time clicking to mark where the answers are found. If you have trouble reading the actogram, use the Sleep Watch data tables below to help you find answers. Click UNDO if you need to change an answer. Click START OVER if you need to clear all your answers.</p>
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
                                                                  '7. The sleep period with the shortest Total Sleep Time.',
                                                                  '8. The sleep period with the longest Total Sleep Time.',
                                                                  '9. The sleep period with the longest time it took to fall asleep.',
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
                                          <button type="button" class="btn btn-gradbg btn-roundThin btn-sm" onclick="redrawAll();" style="float: right;"> Start Over</button>
                                          <button type="button" class="btn btn-gradorange btn-roundThin btn-sm" onclick="redraw();" style="float: right; margin-right:1.5em;">Undo</button>
                                        <?php } else { ?>
                                          <button type="button" class="btn btn-gradbg btn-roundThin btn-sm" onclick="startOver();" style="float: right;"> <B>Start Over</B></button>
                                        <?php } ?>
                            					</div>

                                      <h3>Sleep Watch Daily Statistics</h3>
                                      <div id="toolbarWatchData">
                                        <button id="hide-watchWatchData" class="btn btn-sm btn-default">Unselect All Variables</button>
                                        <button id="show-watchWatchData" class="btn btn-sm btn-default">Select All Variables</button>
                                      </div>
                                      <table id="table-watchWatchData" class="table" data-toggle="table" data-toolbar="#toolbarWatchData" data-search="true" data-icons-prefix="fa"  data-show-columns="true">
                                        <colgroup>
                                          <?php if($lessonId==2){?>
                                            <col span="4" class="background-color:clear"></col>
                                            <col class="bg-success"></col>
                                          <?php } ?>
                                        </colgroup>
                                      <thead>
                                        <tr>
                                          <th data-field="end-date-a">End Date_Sleep_Watch</th>
                                          <th data-field="bed-time-a">Bed Time_Sleep_Watch</th>
                                          <th data-field="wake-up-time-a">Wake Up Time_Sleep_Watch</th>
                                          <th data-field="time-in-bed-a">Time in Bed (hours:min)_Sleep_Watch</th>
                                          <th data-field="total-sleep-time-a">Total Sleep Time (hours:min)_Sleep_Watch</th>
                                          <th data-field="time-it-took-to-fall-asleep-a">Time It Took to Fall Asleep (min)_Sleep_Watch</th>
                                          <th data-field="average-sleep-quality-a">Average Sleep Quality (precent)_Sleep_Watch</th>
                                          <th data-field="num-awak-a">#Awak._Sleep_Watch</th>
                                          <th data-field="awak-time-a">Awak. Time(min)_Sleep_Watch</th>
                                        </tr>
                                      </thead>
                                        <tbody>
                                      <tr>
                                        <tr><td>Tue (Day 1))</td><td>2:08:00 AM</td><td>7:02:00 AM</td><td>04:54</td><td>04:10</td><td>3.50</td><td>85.20</td><td>29</td><td>35.00</td></tr>
                                        <tr><td>Wed (Day 2)</td><td>1:21:00 AM</td><td>7:13:30 AM</td><td>05:52</td><td>05:06</td><td>8.50</td><td>86.81</td><td>24</td><td>20.00</td></tr>
                                        <tr><td>Thu (day 3)</td><td>10:08:30 PM</td><td>2:05:30 PM</td><td>15:57</td><td>13:36</td><td>14.00</td><td>85.54</td><td>72</td><td>85.50</td></tr>
                                        <tr><td>Fri (Day 4)</td><td>11:13:30 PM</td><td>7:08:00 AM</td><td>07:54</td><td>07:00</td><td>14.50</td><td>88.62</td><td>49</td><td>39.00</td></tr>
                                        <tr><td>Sat (Day 5)</td><td>2:47:00 AM</td><td>12:57:00 PM</td><td>10:10</td><td>09:01</td><td>12.50</td><td>89.14</td><td>46</td><td>53.00</td></tr>
                                        <tr><td>Sun (Day 6)</td><td>2:59:30 AM</td><td>8:57:30 AM</td><td>05:58</td><td>05:01</td><td>23.00</td><td>84.22</td><td>32</td><td>33.00</td></tr>
                                      </tr>
                                        </tbody>
                                      </table>
                                      <!-- data table start below -->
                                      <h3>Sleep Watch Summary Statistics</h3>
                                      <div id="toolbar">
                                        <button id="hide-watch" class="btn btn-sm btn-default">Unselect All Variables</button>
                                        <button id="show-watch" class="btn btn-sm btn-default">Select All Variables</button>
                                      </div>
                                      <table id="table-watch" class="table" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-icons-prefix="fa"  data-show-columns="true">
                                        <colgroup>
                                          <?php if($lessonId==2){?>
                                            <col span="8" class="background-color:clear"></col>
                                            <col class="bg-success"></col>
                                          <?php }elseif($lessonId==3){ ?>
                                            <col span="2" class="bg-success"></col>
                                            <col class="bg-warning"></col>
                                            <col span="3" class="background-color:clear"></col>
                                            <col span="2" class="bg-info"></col>
                                          <?php } ?>
                                        </colgroup>
                                        <thead>
                                          <tr>
                                            <th>Earliest Bed Time</th>
                                            <th>Latest Bed Time_Actigraphy</th>
                                            <th>Average Bed Time_Actigraphy</th>
                                            <th>Earliest Wake Up Time_Actigraphy</th>
                                            <th>Latest Wake Up Time_Actigraphy</th>
                                            <th>Average Wake Up Time_Actigraphy</th>
                                            <th>Shortest Total Sleep Time (hours:Min)_Actigraphy</th>
                                            <th>Longest Total Sleep Time (hours:Min)_Actigraphy</th>
                                            <th>Average Total Sleep Time (hours:Min)_Actigraphy</th>
                                            <th>Average Time in Bed (hours)_Actigraphy</th>
                                            <th>Average Time it Took to Fall Asleep (min)_Actigraphy</th>
                                            <th>Average Sleep Quality (percent)_Actigraphy</th>
                                            <th>Average #Awak._Actigraphy</th>
                                            <th>Average Awak. Time (min)_Actigraphy</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>10:08:30 PM</td>
                                            <td>02:59:30 AM</td>
                                            <td>01:06:15 AM</td>
                                            <td>07:02:00 AM</td>
                                            <td>02:05:30 PM</td>
                                            <td>09:33:55 AM</td>
                                            <td>04:10</td>
                                            <td>13:36</td>
                                            <td>07:19</td>
                                            <td>08:27</td>
                                            <td>12.67</td>
                                            <td>86.59</td>
                                            <td>42.00</td>
                                            <td>44.25</td>

                                          </tr>
                                        </tbody>
                                      </table>
                                      <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i><b style="padding-right: 20%; padding-left: 20%;">&nbsp&nbsp</b><i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>

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
      <div class="modal fade" id="submit-success" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
			    Your answers have been submitted. Wait and your teacher will show you the correct answers.
			</div>
		    </div>
		</div>
	    </div>


        <?php include 'partials/footer.php' ?>
        </div>
    </body>


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
            // instruction
            if (current == 10) {
              $('#instruction').html("Click on the places on Estrella’s actogram to mark where you can find the answer to Question "+current+". If you have trouble reading the actogram, use the Sleep Watch data tables below to help you find answers. Click UNDO if you need to change an answer. Click START OVER if you need to clear all your answers.");
            } else {
              $('#instruction').html("Click on the places on Estrella’s actogram to mark where you can find the answer to Question "+current+". Then go on to the other questions each time clicking to mark where the answers are found. If you have trouble reading the actogram, use the Sleep Watch data tables below to help you find answers. Click UNDO if you need to change an answer. Click START OVER if you need to clear all your answers.");
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

     function startOver(){
      $.ajax({
        type: "POST",
        url: "estrella-actogram-draw-done",
        data: {type:'startover'}
      }).done(function(respond){
        console.log("done: "+respond);
        location.reload()
      })
     }

     function submit(){
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
       var img = huntcanvas.toDataURL('image/png');
       $.ajax({
        type: "POST",
        url: "estrella-actogram-draw-done",
        data: {image:img,type:'hunt',contributors:contributors}
        }).done(function(respond){
          console.log("done: "+respond);
          $('#submit-success').modal();
        })
     }

    </script>
</html>
