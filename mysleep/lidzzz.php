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
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$lessonId = $_GET['lesson'];
$classId = $_SESSION['classId'];
$backFlag = 0;
if(isset($_GET['back'])){
    $backFlag = $_GET['back'];
}

/*flexible framework section*/
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
/* end */

$currentGrade = getCurrentGrade($userId);
include 'connectdb.php';
$status = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$statusResult = mysql_fetch_array($status);
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
        <?php include 'partials/scripts.php' ?>
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
                      } else {
                   ?>
                    <?php } ?>
                    <div>
                        <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none">
                                  <li role="presentation" class="active"><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Sleepiness</a></li>
                                  <li role="presentation" ><a href="#diarygraphs" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">Alertness</a></li>
                                  <li role="presentation" style="display:none"><a href="#comparing" aria-controls="comparing" role="tab" data-toggle="tab" id = "thirdTab">Comparing</a></li>
                                </ul>



                                <?php
                                if ($config) {
                                  $result = mysql_query("SELECT * FROM lidzzz WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
                                }else {
                                  $result = mysql_query("SELECT * FROM lidzzz WHERE userId='$userId' order by resultRow DESC LIMIT 1");
                                }
                                $row = mysql_fetch_array($result);
                                unset($_SESSION['current_work']);
                                $_SESSION['current_work'] = $row;

                                if(mysql_num_rows($result)>0){
                                  $sleepiness1 = $row["sleepiness1"] ? $row["sleepiness1"] : null;
                                  $sleepiness2 = $row["sleepiness2"] ? $row["sleepiness2"] : null;
                                  $sleepiness3 = $row["sleepiness3"] ? $row["sleepiness3"] : null;
                                  $sleepiness4 = $row["sleepiness4"] ? $row["sleepiness4"] : null;
                                  $sleepiness5 = $row["sleepiness5"] ? $row["sleepiness5"] : null;
                                  $selection = ($row["selectedPattern"] != null) ? $row["selectedPattern"] : -1;
                                  $reasons = $row["reasons"] ? $row["reasons"] : null;
                                  $resultRow = $row['resultRow'];
                                }
                                else{
                                  $sleepiness1 = null;
                                  $sleepiness2 = null;
                                  $sleepiness3 = null;
                                  $sleepiness4 = null;
                                  $sleepiness5 = null;
                                  $reasons = null;
                                  $selection = -1;
                                }
                                mysql_close($con);
                                ?>
                                <?php include 'add-group-member-button.php' ?>


                                <!-- Tab panes -->
                                <div class="tab-content" style="margin-top: 2em;margin-bottom: 1.5em;">

		                                <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane active" id="datagraphs">
                                      <div class="card" style="width: 100%; margin-bottom: 1.5em;">
                                          <div class="card-body">
                                              <h4 class="card-title">Track your Daily Sleep-Wake Pattern </h4>
                                              <p class="card-text" style="font-size: 15px;">For humans, feelings of sleepiness and alertness vary throughout the day and are influenced by your activities and internal body clock, or Circadian Rhythm. Click and drag the top of each bar to make a bar graph of your sleepiness at different times of the day using a scale of 0 to 5, with 0 being not sleepy at all and 5 being so sleepy you can barely keep your eyes open.</p>
                                    			</div>
                                        </div>
                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-12 col-md-12">
                                            <div id="chart-slide-a">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
                                              <button type="button" class="btn btn-gradbg btn-roundBold" data-toggle="modal" data-target=".dataGraphSaveModal" style="width:100%;">Save</button>
                                              <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".dataGraphModal" style="width:100%;">Save and Submit</button>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="diarygraphs">
                                      <h4 class="card-title">Does your pattern match the expected?</h4>
                                      <div class="text-center">
                                          <ul class="nav nav-pills nav-pills-info btn-group" role="tablist" data-toggle="buttons">
                                              <li class="btn <?php echo ($selection==1)?'active':'' ?>">
                                                  <a href="#dashboard" role="tab" data-toggle="tab" onclick="matchPattern(1)"> <i class="material-icons">check_circle</i> Yes
                                                      <input type="radio" name="patternMatchVote" value="1" autocomplete="off" <?php echo ($selection==1)? 'checked': '' ?>> </a>
                                              </li>
                                              <li class="btn <?php echo ($selection==0)?'active':'' ?>">
                                                  <a href="#schedule" role="tab" data-toggle="tab" onclick="matchPattern(0)"> <i class="material-icons">cancel</i> No
                                                      <input type="radio" name="patternMatchVote" value="0" autocomplete="off" <?php echo ($selection==0)? 'checked': '' ?>> </a>
                                              </li>
                                          </ul>
                                      </div>
                                      <p class="card-text" style="font-size: 15px;">Explain why or why not.</p>
                                      <textarea name="reasons" id="reasons" class="form-control" rows="4" placeholder="Enter, save and submit"><?php echo htmlspecialchars($reasons);?></textarea>

                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-12 col-md-12">
                                            <div id="chart-slide-b">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
                                                <!-- <button type="button" class="btn btn-gradbg btn-roundBold" data-toggle="modal" data-target=".diaryGraphSaveModal" style="width:100%;">Save</button> -->
                                                <button type="button" class="btn btn-gradpr btn-roundBold" data-toggle="modal" data-target=".diaryGraphModal" style="width:100%;">Save and Submit</button>
                                          </div>
                                        </div>
                                    </div>

                                    <!-- Tab panes -->
                                    <div role="tabpanel" class="tab-pane" id="comparing">
                                      <div class="card" style="width: 100%; margin-bottom: 1.5em;">
                                          <div class="card-body">
                                              <h4 class="card-title">Comparing</h4>
                                              <p class="card-text" style="font-size: 15px;">Did you find some trend between sleepiness and alertness?</p>
                                    			</div>
                                        </div>
                                        <div class="row" style="margin-top:2em;">
                                          <div class="col-xs-12 col-md-12">
                                            <div id="chart-slide-c">
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                      </div>


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
  <div class="modal fade dataGraphModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="submit-modal-label">Submit the sleepiness</h4>
        </div>
        <div class="modal-body">
          Are you ready to submit your work to your teacher?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
          <button id="submit-activity" type="button" onclick="sleepinessSubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade dataGraphSaveModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="submit-modal-label">Save the Sleepiness</h4>
        </div>
        <div class="modal-body">
          Are you ready to save your work?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
          <button id="submit-activity" type="button" onclick="sleepinessSubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Save</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade diaryGraphModal" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="submit-modal-label">Submit the sleep diary graphs</h4>
      </div>
      <div class="modal-body">
        Are you ready to submit your work to your teacher?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
        <button id="submit-activity" type="button" onclick="secondSubmit();" data-dismiss="modal" class="btn btn-success btn-simple">Yes, Submit</button>
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
        Your answer has been submitted. Your teacher will now show you your class results.
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
     var query = '<?php echo $query;?>';
     var resultRow = '<?php echo $resultRow;?>';

     var d1o = <?php if($sleepiness1 > 0 ){ echo $sleepiness1; } else { echo 0.1; }?>;
     var d2o = <?php if($sleepiness2 > 0 ){ echo $sleepiness2; } else { echo 0.1; }?>;
     var d3o = <?php if($sleepiness3 > 0 ){ echo $sleepiness3; } else { echo 0.1; }?>;
     var d4o = <?php if($sleepiness4 > 0 ){ echo $sleepiness4; } else { echo 0.1; }?>;
     var d5o = <?php if($sleepiness5 > 0 ){ echo $sleepiness5; } else { echo 0.1; }?>;

     function sleepinessSubmit(){
       var d1 = chartSlideA.get("day1").y;
       var d2 = chartSlideA.get("day2").y;
       var d3 = chartSlideA.get("day3").y;
       var d4 = chartSlideA.get("day4").y;
       var d5 = chartSlideA.get("day5").y;

       console.log("chart d2:"+d2);
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "lidzzz-done",
            data: {d1:d1, d2:d2, d3:d3, d4:d4, d5:d5, type:'sleepiness', contributor:contributors, query:query, resultRow:resultRow}
           })
     .done(
       function(respond){
         d1o = d1;d2o = d2;d3o = d3;d4o = d4;d5o = d5;
         reloadChart();
         // console.log("done: "+respond);
         console.log('done');
         $('#secondTab').trigger('click')
         window.scrollTo({ top: 100, behavior: 'smooth' });

        })
     }
     var selectedPattern = null;
     function matchPattern(selection){
       selectedPattern = selection;
     }

     function secondSubmit(){
       var reasons = $("#reasons").val();
       var contributors = $("input[name='contributor[]']:checked")
              .map(function(){return $(this).val();}).get();
     $.ajax({
           type: "POST",
           url: "lidzzz-done",
            data: {reasons:reasons, selectedPattern:selectedPattern,type:'patternMatch',contributor:contributors, query:query, resultRow:resultRow}
           })
     .done(function(respond){
         reloadChart();
         window.scrollTo({ top: 100, behavior: 'smooth' });
         $("#submit-modal-feedback").modal('toggle')
     })
     }


     var chartXAxis = {
         categories: ["Before School", "During Morning Classes", "During Afternoon Classes", "After School", "Before Bed Time"],
         labels: {
            style: {
               fontSize: "15px"
            }
        }
     };

     var SleepinessYAxis = {
         title: {
             text: '',//'Sleepiness',
         },
         min: 0,
         max: 5,
         tickPositions: [0, 1, 2, 3, 4, 5],
         labels: {
            style: {
               fontSize: "15px"
            }
        }
     };
     var AlertnessYAxis = {
         title: {
             text: '',//'Alertness',
         },
         min: 0,
         max: 5,
         tickPositions: [0, 1, 2, 3, 4, 5],
         labels: {
            style: {
               fontSize: "15px"
            }
        }
     };

     var chartPlotOptions = {
         line: {
             cursor: 'ns-resize'
         }
     };

     var chartTooltip = {
         animation: false,
         valueDecimals: 0,
         split: false,
         formatter: function() {
           var result = this.y;
           if (this.y == 0.1) {
             result = 0;
           }
           return result;
         },
      };


    var chartSlideA = new Highcharts.Chart({
                chart: {
                    renderTo: 'chart-slide-a',
                    height: 600,
                    animation: false,
                },

                title: {
                    text: 'Sleepiness'
                },

                xAxis: chartXAxis,
                yAxis: SleepinessYAxis,
                plotOptions: chartPlotOptions,
                tooltip: chartTooltip,

                series: [{
                    name: " ",//legend name
                    data: [
                      {
                      name: 'Day 1',
                      id: 'day1',
                      y: d1o
                    },{
                      name: 'Day 2',
                      id: 'day2',
                      y: d2o
                    },{
                      name: '111Day 3',
                      id: 'day3',
                      y: d3o
                    },{
                      name: 'Day 4',
                      id: 'day4',
                      y: d4o
                    },{
                      name: 'Day 5',
                      id: 'day5',
                      y: d5o
                    },
                    ],
                    draggableY: true,
                    dragMinY: 0.1,
                    dragMaxY: 5,
                    dragPrecisionY: 1,
                    type: 'column',
                    dragHandleFill: '#BC0016',
                    color: '#DAF7A6',
                }]

          });



    function reloadChart(){
      var chartSlideB = new Highcharts.Chart({
                chart: {
                    renderTo: 'chart-slide-b',
                    height: 600,
                    animation: false,
                },
                title: {
                    text: ' ',
                },
                xAxis: chartXAxis,
                yAxis: AlertnessYAxis,
                plotOptions: chartPlotOptions,
                tooltip: chartTooltip,

                series: [{
                    name: "My Sleepiness",
                    data: [d1o,d2o,d3o,d4o,d5o],
                    draggableY: false,
                    dragMinY: 0.1,
                    dragMaxY: 5,
                    dragPrecisionY: 1,
                    type: 'column',
                    dragHandleFill: '#BC0016',
                    color: '#DAF7A6',
                },{
                    name: "Expected Pattern",
                    data: [0.2,0.2,1.8,0.2,5],
                    draggableY: false,
                    type: 'column',
                }]
        });
      }

    </script>
</html>
