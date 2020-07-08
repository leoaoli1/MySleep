<!DOCTYPE html>
<?php
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
if ($userType == "teacher"){
   $classId = $_SESSION['classId'];
}
$showToClass = 0;
$showToClass = $_GET['showToClass'];

$query = $_SERVER['QUERY_STRING'];
if ($showToClass==0) {
  header('Location: teacher-review-estrella?type=datahunt&'.$query);
}

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
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
                              <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                              <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=2'">Activity Two</a></li>
                              <li><a  class="exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=datahunt">Part 1</a></li>
                              <li class="active">Review Estrella's Data Hunt (Show Class)</li>
                            </ol>
                        </div>
                    </div>
                  <?php } ?>
		    <div class="row">
          <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
            <div>

                  <!-- Tab panes -->
                  <div role="tabpanel" class="tab-pane" id="datagraphs">
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



      function pad(d) {
          return (d < 10) ? '0' + d.toString() : d.toString();
      }
      var chartSlideA = new Highcharts.Chart({
      chart: {
          renderTo: 'chart-slide-a',
          height: 600,
          animation: false,
      },
      title: {
          text: 'Sleep Watch Total Sleep Time'
      },
      xAxis: {
          categories: ["Day1", "Day2", "Day3", "Day4","Day5","Day6","Average"]
      },
      yAxis: {
          title: {
              text: 'Time of Sleep',
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

      },

      plotOptions: {
          column: {
              stacking: 'normal',
          },
          line: {
              cursor: 'ns-resize'
          }
      },

      tooltip: {
          animation: false,
          valueDecimals: 0,
          split: false,
          formatter: function() {
          return pad(Math.floor(this.y/60)) + ':' + pad(Math.floor(this.y%60));
      },
      },

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
    var chartSlideB = new Highcharts.Chart({
    chart: {
        renderTo: 'chart-slide-b',
        height: 600,
        animation: false,
    },
    title: {
        text: 'Sleep Diary Total Sleep Time'
    },
    xAxis: {
        categories: ["Day1", "Day2", "Day3", "Day4","Day5","Day6","Average"]
    },
    yAxis: {
        title: {
            text: 'Time of Sleep',
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

    },

    plotOptions: {
        column: {
            stacking: 'normal',
        },
        line: {
            cursor: 'ns-resize'
        }
    },

    tooltip: {
        animation: false,
        valueDecimals: 0,
        split: false,
        formatter: function() {
        return pad(Math.floor(this.y/60)) + ':' + pad(Math.floor(this.y%60));
    },
    },

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
	</script>
  </body>
</html>
