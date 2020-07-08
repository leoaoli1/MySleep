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
include 'connectdb.php';
$result =mysql_query("SELECT endocrine FROM bodyChanger where userId='$userId' AND endocrine!='null' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$endocrine = $row['endocrine'];

$result =mysql_query("SELECT immune FROM bodyChanger where userId='$userId' AND immune!='null' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$immune = $row['immune'];

$result =mysql_query("SELECT cardiovascular FROM bodyChanger where userId='$userId' AND cardiovascular!='null' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$cardiovascular = $row['cardiovascular'];

$result =mysql_query("SELECT nervous FROM bodyChanger where userId='$userId' AND nervous!='null' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$nervous = $row['nervous'];
mysql_close($con);
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
	<?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType);
                  } else {?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=3'">Lesson Three</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">Body Changer</a></li>
                                <li class="active">Body Changer Worksheet</li>
                            </ol>
                        </div>
                    </div>
		    <?php } ?>
		    <div class="row" style="padding-top: 2em;" >
			<form method="post">
			    <table class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				<tr>
				    <td>
					<div id="chart-scatter-rt"></div>
				    </td>
				</tr>
				<tr>
				    <td>
					<h4>Implications of the research:  Slow reaction time is one reason why sleepy drivers have more car crashes. Can you think of another consequence of slow reaction time?</h4>
					<textarea class="form-control" rows="5" name="nervous" id="id_nervous"><?php echo $nervous ?></textarea>
					<p><b>Implications are the “take away” statements that help others </b>understand what the research results mean to them.</p>
				    </td>
				</tr>
				<tr>
				    <td>
					<div id="chart-scatter-hr"></div>
				    </td>
				</tr>
				<tr>
				    <td>
					<h4>Insufficient sleep is stressful for the body, and therefore the heart rate becomes faster. What do you think the risks are of having a high heart rate over a long period of time?</h4>
					<textarea class="form-control" rows="5" name="cardiovascular" id="id_cardiovascular"><?php echo $cardiovascular ?></textarea>
					<p><b>Implications are the “take away” statements that help others </b>understand what the research results mean to them.</p>
				    </td>
				</tr>
				<tr>
				    <td>
					<div id="chart-scatter-cc"></div>
				    </td>
				</tr>
				<tr>
				    <td>
					<h4>Implications of the research: Why are people who had insufficient sleep are more likely to get sick when they are exposed to a cold virus?</h4>
					<textarea class="form-control" rows="5" name="immune" id="id_immune"><?php echo $immune ?></textarea>
					<p><b>Implications are the “take away” statements that help others</b> understand what the research results mean to them.</p>
				    </td>
				</tr>
				<tr>
				    <td>
					<div id="chart-scatter-bs"></div>
				    </td>
				</tr>
				<tr>
				    <td>
					<h4>Implications of the research:  People who don’t sleep enough tend to eat more snacks for energy. How does this affect health over time?</h4>
					<textarea class="form-control" rows="5" name="endocrine" id="id_endocrine"><?php echo $endocrine ?></textarea>
					<p><b>Implications are the “take away” statements that help others</b> understand what the research results mean to them.</p>
				    </td>
				</tr>
			    </table>
			</form>
			<?php if($_SESSION['userType']=="student"){ ?>
			    <div class="row">
				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				    <button class="btn btn-info btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
				</div>
			    </div>
			    <div class="row">
				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				    <a class="btn btn-success btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
				</div>
			    </div>
			<?php }else{?>
			    <div class="row">
				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				    <a class="btn btn-info btn-large btn-block">Save</a>
				</div>
			    </div>
			    <div class="row">
				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				    <a class="btn btn-success btn-large btn-block">Save &amp; Submit</a>
				</div>
			    </div>
			<?php } ?>
		    </div>
		</div>
	    </div>
	</div>
	<!-- Submit Modal -->
	<div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
		    </div>
		    <div class="modal-body">
			Are you ready to submit your work to your teacher?
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			<button id="submit-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
		    </div>
		</div>
	    </div>
	</div>
	  <?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script type="text/javascript">
     $(function () {
         $("#save-activity").click(function(e) {
	     e.preventDefault();
             $.ajax({
                 url: 'body-changer-worksheet-done',
                 method: 'POST',
                 data: $('form').serialize(),
                 success: (function() {
                     $.notify({
                         title: '<strong>Success!</strong>',
                         message: 'Your response has been saved, but has not been submitted.'
                     },{
                         placement: {
                             from: "top",
                             align: "center"
                         },
                         type: 'success'
                     }
                     );
                 }),
                 error:(function(XMLHttpRequest, textStatus, errorThrown){
                     $.notify({
                         title: '<strong>Error:</strong>',
                         message: 'Your work was not saved. Please contact your teacher<br>Code: ' + errorThrown
                     },{
                         placement: {
                             from: "top",
                             align: "center"
                         },
                         type: 'danger'
                     }
                     );
                 })
             });
         });
         $("#submit-activity").click(function() {
             var input = $("<input>")
                 .attr("type", "hidden")
                 .attr("name", "btnSubmit").val("1");
             $('form').append($(input));
	     $("form").attr("action", "body-changer-worksheet-done")
             $('form').submit();
         });
     });


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
