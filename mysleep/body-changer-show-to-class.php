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
	require_once('utilities-actogram.php');
	session_start();
	$userId= $_SESSION['userId'];
	$userType = $_SESSION['userType'];
	if ($userId == ""){
	    header("Location: login");
	    exit;
	}
	$lessonNum = $_GET['lesson'];
	$activityNum = $_GET['activity'];
	$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
	$query = $_SERVER['QUERY_STRING'];
	unset($_SESSION['current_config']);
	$_SESSION['current_config'] = $config;

    // If data has already been saved for this student, place it in the body.
  include 'connectdb.php';
	$classId = $_SESSION['classId'];
	$result = mysql_query("SELECT * FROM ourzzzdata WHERE classId = $classId");
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	$titleArray = [];
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		$titleArray = [$row['durationTitle'],$row['consistencyTitle'],$row['qualityTitle']];
   }else {
		 $titleArray = ['Sleep Watch Hours of Sleep','Total Minutes Difference between shortest and longest sleep times','Sleep Watch Rating'];
   }

   mysql_close($con);

?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep <?php  echo '// '.$config['activity_title']; ?></title>
    </head>

		<?php include 'partials/scripts.php' ?>
<body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
												<?php
												require_once('partials/nav-links.php');
												navigationLink($config,$userType);
												 ?>
                         <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
                         	<div class="row" style="padding-top: 2em;" >
                            <h4>Why is 9-11 hours the optimal amount of sleep for good health?</h4>
                          </div>
                      </div>
                      <div class="col-md-offset-0 col-md-offset-10 col-sm-offset-0 col-sm-12">
                       <div class="row" style="padding-top: 2em;" >
                         	    <div class="col-md-6 col-sm-6">
                       			    <div id="chart-scatter-rt" style="width: 100%;"></div>
                              </div>
                         			<div class="col-md-6 col-sm-6">
                       			    <div id="chart-scatter-hr"></div>
                              </div>
                              <div class="col-md-6 col-sm-6">
                   			        <div id="chart-scatter-cc"></div>
                              </div>
                         			<div class="col-md-6 col-sm-6">
                       			    <div id="chart-scatter-bs"></div>
                              </div>
                            </div>
                       	</div>
                        <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
                         <div class="row" style="padding-top: 2em;" >
                           <h2>Recommended Sleep Time per Night</h2>
                         </div>
                     </div>
                         <div class="row">
                           <div class="col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8 ">
                             <img src="images/fifthgrade/recommandedSleepHours.png" alt="Awesome Image" id="carousalImg" style="width: 100%;">
                         </div>
           		       </div>

                </div>
            </div>
            <?php include 'partials/footer.php' ?>
          	<?php include 'partials/scripts.php' ?>

            <script src="https://code.highcharts.com/highcharts.src.js"></script>
            <script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawHRChart);

            function drawHRChart(){
       	 var data = new google.visualization.DataTable();
       	 data.addColumn('number', 'Heart Beat Per Minute');
       	 data.addColumn('number', 'Average Sleeping Hours for Last Week');

       	 data.addRows([
       	     [10, 71.5],
       	     [9, 71.5],
       	     [8, 72],
       	     [7, 72.5],
       	     [6, 73],
       	     [5, 73.5],
       	     [4, 76]
       	 ]);

       	 var options = {
                    title: 'Heart Beat Per Minute',
                    vAxis: {title: 'Heart Beat Per Minute (bpm)',
       		     ticks: [71, 72, 73, 74, 75, 76]
       	     },
                    hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
       		     ticks: [4, 5, 6, 7, 8, 9, 10]
       	     },
                    legend: 'none',
       	     height: 500,
             width: '100%'
                };

                var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter-hr'));
                chart.draw(data, options);
            }

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawBSChart);

            function drawBSChart(){
       	 var data = new google.visualization.DataTable();
       	 data.addColumn('number', 'Blood Glucose');
       	 data.addColumn('number', 'Average Sleeping Hours for Last Week');


       	 data.addRows([
       	     [10, 84],
       	     [9, 84],
       	     [8, 87],
       	     [7, 90],
       	     [6, 90],
       	     [5, 95],
       	     [4, 98]
       	 ]);


                var options = {
                    title: 'Blood Glucose Data',
                    vAxis: {title: 'Blood Glucose(mg/dl)',
       		     ticks: [75, 80, 85, 90, 95, 100]
       	     },
                    hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
       		     ticks: [4, 5, 6, 7, 8, 9, 10]
       	     },
                    legend: 'none',
       	     height: 500
                };

                var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter-bs'));
                chart.draw(data, options);
            }

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawCCChart);

            function drawCCChart(){
       	 var data = new google.visualization.DataTable();
       	 data.addColumn('number', 'Percentage');
       	 data.addColumn('number', 'Average Sleeping Hours for Last Week');

       	 data.addRows([
       	     [10, 19],
       	     [9, 19],
       	     [8, 20],
       	     [7, 20],
       	     [6, 21],
       	     [5, 30],
       	     [4, 45]
       	 ]);


                var options = {
                    title: 'Probability to Catch Cold',
                    vAxis: {title: 'Percentage (%)',
       		     ticks: [0, 10, 20, 30, 40, 50]
       	     },
                    hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
       		     ticks: [4, 5, 6, 7, 8, 9, 10]
       	     },
                    legend: 'none',
       	     height: 500
                };

                var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter-cc'));
                chart.draw(data, options);
            }


            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawRTChart);

            function drawRTChart(){
       	 var data = new google.visualization.DataTable();
       	 data.addColumn('number', 'Reaction Time');
       	 data.addColumn('number', 'Average Sleeping Hours for Last Week');

       	 data.addRows([
       	     [10, 380],
       	     [9, 380],
       	     [8, 390],
       	     [7, 400],
       	     [6, 410],
       	     [5, 420],
       	     [4, 425]
       	 ]);


                var options = {
                    title: 'Psychomotor Vigilance Task (PVT) Performance',
                    vAxis: {title: 'Reaction Time (ms)',
       		     ticks: [360, 370, 380, 390, 400, 410, 420, 430]
       	     },
                    hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
       		     ticks: [4, 5, 6, 7, 8, 9, 10]
       	     },
                    legend: 'none',
       	     height: 500
                };

                var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter-rt'));
                chart.draw(data, options);
            }
          	</script>
            </body>
          </html>
