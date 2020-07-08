<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#
# Author:   Ao Li
#           Siteng Chen

require_once('utilities.php');
require_once('utilities-actogram.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$type = $_GET['type'];
$classId = $_SESSION['classId'];
# check the demo mode for Science-City-2018
list($schoolId, $classId, $demoMode) = getDemoMode();

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review Actigraph</title>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php if ($config){
                      require_once('partials/nav-links.php');
                      navigationLinkReview($config,$userType);
                    } else {
                    ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page';">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
                                <?php if($grade==4){?>
                        				    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                        				<?php }else{?>
                        				    <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                        				<?php }?>
                                <?php if ($type == 'practice') { ?>
                                  <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=2&activity=1&name=estrella">Activity One</a></li>
                                  <?php
                                }elseif ($type == 'datahunt') { ?>
                                  <li><a  class="exit" data-location="fourth-grade-lesson-activity-menu?lesson=2&activity=2">Activity Two</a></li>
                                  <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=datahunt">Part 1</a></li>
                                  <?php
                                }elseif ($type == 'sleepdata') { ?>
                                  <li><a  class="exit" data-location="fourth-grade-lesson-activity-menu?lesson=2&activity=2">Activity Two</a></li>
                                  <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=mysleep">Part 2</a></li>
                                  <?php
                                } ?>


                                <li class="active">Review Estrella's Actogram</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>

            		    <form>
                  			<div class="col-xs-offset-1 col-xs-6 col-md-offset-1 col-md-6 ">
                                <?php if ($config): ?>
                                  <select class="input-lg" name='workId' id="workId">
                                <?php else: ?>
                                  <select class="input-lg" name='studentId' id="studentId">
                                <?php endif; ?>

                        				<option value='null' disabled selected>Please choose a student</option>
                        				<?php
                        				include 'connectdb.php';
                                if ($config) {
                                  $workList = mysql_query("SELECT * FROM fourthGradeLessonTwoEstrellaActogram WHERE classId='$classId' order by recordRow");
                                  showGroupOptionList($workList,$demoMode);
                                }else {
                                  $targetUserIds = getUserIdsInClass($classId);
                          				showUserOptionList($targetUserIds,$demoMode);
                                }
                        				mysql_close($con);
                        				?>
                  			    </select>
                  			</div>
            		   </form>

                    <div class="row">


                        <?php if ($type == 'practice') { ?>
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                          <div class="row">
                              <h3 class="text-center">Estrella's Actogram</h3>
                              <img class="img-responsive" id="datahunt">
                          </div>
                          <div class="row">
                              <h3 class="text-center">Answer Key</h3>
                              <img class="img-responsive" id="answerkey" src="images/fourthgrade-lessontwo/estrellaActogramAnswer.png" style="width:100%; display:none;">
                          </div>
                          </div>
                        <?php }elseif ($type == 'datahunt') { ?>
                          <div class="row" style="margin-top:2em;">
                            <div class="col-xs-10 col-md-6">
                              <div id="chart-slide-a">
                              </div>
                            </div>
                            <div class="col-xs-10 col-md-6">
                              <div id="chart-slide-b">
                              </div>
                            </div>
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

                          <div class="row">
                            <h3 class="text-center">Answer Key</h3>
                            <div class="col-xs-10 col-md-6">
                              <div id="chart-slide-c">
                              </div>
                            </div>
                            <div class="col-xs-10 col-md-6">
                              <div id="chart-slide-d">
                              </div>
                            </div>
                          </div>
                        <?php } ?>

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
     $('#studentId').change( function (e) {
      	 e.preventDefault();
      	 $.ajax({
      	     type: 'post',
      	     url: 'estrella-content',
      	     data: {id: $('#studentId').val()},
      	     dataType: 'json',
      	     success: function (response) {
               <?php if ($type == 'practice') { ?>
               $("#datahunt").attr("src", response.dataHunt);
               if (response.dataHunt) {
                 $("#answerkey").attr("style","display:block");
               }else {
                 $("#answerkey").attr("style","display:none");
               }
               <?php }elseif ($type == 'datahunt') { ?>
                 var newData = [{y: Number(response.dataGraphArray[0])},{y: Number(response.dataGraphArray[1])},{y: Number(response.dataGraphArray[2])},{y: Number(response.dataGraphArray[3])},{y: Number(response.dataGraphArray[4])},{y: Number(response.dataGraphArray[5])},{y: Number(response.dataGraphArray[6])}];
                 chartSlideA.series[0].update({data:newData},true);
                 newData = [{y: Number(response.diaryGraphArray[0])},{y: Number(response.diaryGraphArray[1])},{y: Number(response.diaryGraphArray[2])},{y: Number(response.diaryGraphArray[3])},{y: Number(response.diaryGraphArray[4])},{y: Number(response.diaryGraphArray[5])},{y: Number(response.diaryGraphArray[6])}];
                 chartSlideB.series[0].update({data:newData},true);
               <?php } ?>
              }
      	 });
     });

     $('#workId').change(function (e) {
      	 e.preventDefault();
      	 $.ajax({
      	     type: 'post',
      	     url: 'estrella-datahunt-content',
      	     data: {id: $('#workId').val()},
      	     dataType: 'json',
      	     success: function (response) {
                 var newData = [{y: Number(response.dataGraphArray[0])},{y: Number(response.dataGraphArray[1])},{y: Number(response.dataGraphArray[2])},{y: Number(response.dataGraphArray[3])},{y: Number(response.dataGraphArray[4])},{y: Number(response.dataGraphArray[5])},{y: Number(response.dataGraphArray[6])}];
                 chartSlideA.series[0].update({data:newData},true);
                 newData = [{y: Number(response.diaryGraphArray[0])},{y: Number(response.diaryGraphArray[1])},{y: Number(response.diaryGraphArray[2])},{y: Number(response.diaryGraphArray[3])},{y: Number(response.diaryGraphArray[4])},{y: Number(response.diaryGraphArray[5])},{y: Number(response.diaryGraphArray[6])}];
                 chartSlideB.series[0].update({data:newData},true);
                 $("#score").val(response.score);
                 $("#comment").val(response.comment);
                 $("#gradeWorkId").val(response.workId);
              }
      	 });

     });




     <?php if ($type == 'datahunt') { ?>
       function save(){
         $.ajax({
            type: "POST",
            url: "estrella-datahunt-review-done",
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

       function pad(d) {
           return (d < 10) ? '0' + d.toString() : d.toString();
       }

       var chartXAxis = {
           categories: ["Day1", "Day2", "Day3", "Day4","Day5","Day6","Average"]
       };
       var chartYAxis = {
           title: {
               text: 'Hours of Sleep',
           },
           min: 0,
           max: 820,
           tickPositions: [0, 120, 240, 360, 480, 600, 720, 840, 960],
           labels: {
             formatter: function() {
               return pad(Math.floor(this.value/60)) + ':' + pad(Math.floor(this.value%60));
             },
           },
           plotBands: [{
             color: "rgba(155, 200, 255, 0.3)",
             from: 540,
             to: 660,
             label: {
               text: 'Ideal Sleep Time',
               align: 'center',
               style: {
                 fontSize: 30,
                 color: "rgba(255, 255, 255, 1)",
               },
             },
           }],

       };

       var chartPlotOptions = {
           column: {
               stacking: 'normal',
           },
           line: {
               cursor: 'ns-resize'
           }
       };

       var chartTooltip = {
           animation: false,
           valueDecimals: 0,
           split: false,
           formatter: function() {
           return pad(Math.floor(this.y/60)) + ':' + pad(Math.floor(this.y%60));
           },
        };

        var initData = [
          {
          name: 'Day 1',
          id: 'day1',
          y: 0
        },{
          name: 'Day 2',
          id: 'day2',
          y: 0
        },{
          name: 'Day 3',
          id: 'day3',
          y: 0
        },{
          name: 'Day 4',
          id: 'day4',
          y: 0
        },{
          name: 'Day 5',
          id: 'day5',
          y: 0
        },{
          name: 'Day 6',
          id: 'day6',
          y: 0
        },
        {
          name: 'Average',
          id: 'average',
          y: 0
        }
      ];

       var chartSlideA = new Highcharts.Chart({
       chart: {
           renderTo: 'chart-slide-a',
           height: 600,
           animation: false,
       },
       title: {
           text: 'Sleep Watch Total Sleep Time'
       },
       xAxis: chartXAxis,
       yAxis: chartYAxis,
       plotOptions: chartPlotOptions,
       tooltip: chartTooltip,
       series: [{
           name: " ",
           data: initData,
           draggableY: false,
           dragMinY: 10,
           dragMaxY: 840,
           dragPrecisionY: 30,
           type: 'column',
           dragHandleFill: '#BC0016',
           color: '#DAF7A6',
       }]

     });

     var chartSlideB = new Highcharts.Chart({
     chart: {
         renderTo: 'chart-slide-b',
         height: 600,
         animation: false,
     },
     title: {
         text: 'Sleep Diary Total Sleep Time'
     },
     xAxis: chartXAxis,
     yAxis: chartYAxis,
     plotOptions: chartPlotOptions,
     tooltip: chartTooltip,
     series: [{
         name: " ",
         data: initData,
         draggableY: false,
         dragMinY: 10,
         dragMaxY: 870,
         dragPrecisionY: 30,
         type: 'column',
         dragHandleFill: '#BC0016',
         color: '#DAF7A6',
     }]

   });
   var chartSlideC = new Highcharts.Chart({
   chart: {
       renderTo: 'chart-slide-c',
       height: 600,
       animation: false,
   },
   title: {
       text: 'Sleep Watch Total Sleep Time'
   },
   xAxis: chartXAxis,
   yAxis: chartYAxis,
   plotOptions: chartPlotOptions,
   tooltip: chartTooltip,

   series: [{
       name: "Sleep Time",
       data: [
         {
         name: 'Day 1',
         id: 'day1',
         y: 240
       },{
         name: 'Day 2',
         id: 'day2',
         y: 300
       },{
         name: '111Day 3',
         id: 'day3',
         y: 810
       },{
         name: 'Day 4',
         id: 'day4',
         y: 420
       },{
         name: 'Day 5',
         id: 'day5',
         y: 540
       },{
         name: 'Day 6',
         id: 'day6',
         y: 300
       },
       {
         name: 'Average',
         id: 'average',
         y: 420
       }
       ],
       draggableY: false,
       dragMinY: 10,
       dragMaxY: 840,
       dragPrecisionY: 30,
       type: 'column',
       dragHandleFill: '#BC0016',
       color: '#DAF7A6',
   }]

 });

 var chartSlideD = new Highcharts.Chart({
 chart: {
     renderTo: 'chart-slide-d',
     height: 600,
     animation: false,
 },
 title: {
     text: 'Sleep Diary Total Sleep Time'
 },
 xAxis: chartXAxis,
 yAxis: chartYAxis,
 plotOptions: chartPlotOptions,
 tooltip: chartTooltip,

 series: [{
     name: "Sleep Time",
     data: [
       {
       name: 'Day 1',
       id: 'day1',
       y: 360
     },{
       name: 'Day 2',
       id: 'day2',
       y: 420
     },{
       name: '111Day 3',
       id: 'day3',
       y: 870
     },{
       name: 'Day 4',
       id: 'day4',
       y: 480
     },{
       name: 'Day 5',
       id: 'day5',
       y: 590
     },{
       name: 'Day 6',
       id: 'day6',
       y: 360
     },
     {
       name: 'Average',
       id: 'average',
       y: 510
     }
     ],
     draggableY: false,
     dragMinY: 10,
     dragMaxY: 870,
     dragPrecisionY: 30,
     type: 'column',
     dragHandleFill: '#BC0016',
     color: '#DAF7A6',
 }]

});
     <?php } ?>

    </script>
</html>
