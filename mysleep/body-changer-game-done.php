<!DOCTYPE html>
<?php
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];

$config = $_SESSION['current_config'];

if($userId==""){
    header("Location: login");
    exit;
   }
   $_SESSION['hbSim'] = 0;
   $_SESSION['rtSim'] = 0;
   $_SESSION['ccSim'] = 0;
   $_SESSION['bsSim'] = 0;
?>
<html>
    <head>
        <?php include 'partials/header.php'?>
	<title>Simulation</title>
	<style>
	 #chart-scatter{
	     width: 100%;
	     min-height: 500px;
	 }
	</style>
    </head>
    <body>
	<div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
	    <h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>What is your overall conclusion?</strong></h1>
	</div>
	<div class="row" style="padding-top: 2em;" >
	    <div id="final-result">
		<table class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
		    <tr>
			<td class="col-md-5 col-sm-5">
			    <div id="chart-scatter-rt"></div>
			</td>
			<td class="col-md-5 col-sm-5">
			    <div id="chart-scatter-hr"></div>
			</td>
		    </tr>
		    <tr>
			<td class="col-md-5 col-sm-5">
			    <div id="chart-scatter-cc"></div>
			</td>
			<td class="col-md-5 col-sm-5">
			    <div id="chart-scatter-bs"></div>
			</td>
		    </tr>
		</table>
		<div  class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="padding-top: 2em;">
		  <h4>Congratulations on completing Sleep as a Body Changer!</h4>
		   <h4> The amount of sleep affects body systems in different ways. Looking at the similarities and differences in the 4 graphs,</h4>
		    <h4 style="margin-top: 1em">Answer the following question in your lab notebook: <a href="https://www.google.com/docs" target="_blank">Google Docs</a>
			<ul>
			    <li>Why is 9-11 hours the optimal amount of sleep needed for good physical performance, grades, and health?</li>
			</ul>
		    </h4>
		</div>
		<div>
		    <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
          <?php if ($config) { ?>
             <a type="submit" href="<?php echo $config['parent_id'].'?lesson='.$config['lesson_num']; ?>"  class="btn btn-info btn-lg" role="button">Done</a>
          <?php } else {?>
			       <a type="submit" href="fifth-grade-lesson-menu?lesson=3"  class="btn btn-info btn-lg" role="button">Done</a>
          <?php } ?>
		    </div>
		</div>
	    </div>
	</div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script type="text/javascript">
     localStorage.clear();
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
	     height: 500
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
             title: 'Blood Clucose Data',
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
</html>
