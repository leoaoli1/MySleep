<!DOCTYPE html>
<?php
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if(empty($_SESSION['clickTimesRT'])){
    $_SESSION['clickTimesRT']=1;
}else{
    $_SESSION['clickTimesRT']+=1;
}
$buttonName = "Next";
$link = "body-changer-rt-simulation-input";
$hours = "";
if (isset($_POST["formSubmit"])) {
    $hours=$_POST["sleephours"];
    if (!empty($hours)) {
	switch ($hours) {
	    case "A":
	        array_push($_SESSION['hoursRT'], 10);
		array_push($_SESSION['timeRT'], 380);
		array_push($_SESSION['radioRT'], 'A');
		$delayTime = 400;
		break;
	    case "B":
	        array_push($_SESSION['hoursRT'], 9);
		array_push($_SESSION['timeRT'], 380);
		array_push($_SESSION['radioRT'], 'B');
		$delayTime = 800;
		break;
	    case "C":
		array_push($_SESSION['hoursRT'], 8);
		array_push($_SESSION['timeRT'], 390);
		array_push($_SESSION['radioRT'], 'C');
		$delayTime = 1200;
		break;
	    case "D":
	 	array_push($_SESSION['hoursRT'], 7);
		array_push($_SESSION['timeRT'], 400);
		array_push($_SESSION['radioRT'], 'D');
		$delayTime = 1600;
		break;
	    case "E":
		array_push($_SESSION['hoursRT'], 6);
		array_push($_SESSION['timeRT'], 410);
		array_push($_SESSION['radioRT'], 'E');
		$delayTime = 2000;
		break;
	    case "F":
		array_push($_SESSION['hoursRT'], 5);
		array_push($_SESSION['timeRT'], 420);
		array_push($_SESSION['radioRT'], 'F');
		$delayTime = 2400;
		break;
	    case "G":
		array_push($_SESSION['hoursRT'], 4);
		array_push($_SESSION['timeRT'], 425);
		array_push($_SESSION['radioRT'], 'G');
		$delayTime = 2800;
		break;
	    default: echo "Please submit the form.";
		$_SESSION['clickTimesRT']-=1;
	}
	if($_SESSION['clickTimesRT']>2 && $_SESSION['clickTimesRT']<7){
	    $question = "Question";
								      $displayQuestion = true;
								      $_SESSION['rtSim'] = 1;
	}else{
	    $question = "Non-Question";
	    $displayQuestion = false;
	}
    }
}
//debugToConsole('hours', $_SESSION['hoursRT']);

if($_SESSION['clickTimesRT'] == 7){
    $_SESSION['clickTimesRT']=1;
    $show = true;
    $buttonName = "Next";
    $link = "body-changer-simulation-selection";
}
//set question two flag
$displayQuestionTwo = true;
if(isset($_SESSION['rtAnswer'])){
    if($_SESSION['rtAnswer'] == 'correct'){
	$displayQuestionTwo = false;
    }else{
	$displayQuestionTwo = true;
    }
   }
//debugToConsole('answer', $_SESSION['rtAnswer']);
include 'connectdb.php';
$result =mysql_query("SELECT nervous FROM bodyChanger where userId='$userId' AND nervous!='null' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$response = $row['nervous'];
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
	 #id_whiteBoard{
	 cursor: pointer;
	 /*background: url("images/body-changer/rt_background.png");*/
	 /*background-size: 100% 100%;*/
	 }
	 .select {
	     width: 28px;
	     height: 28px;
	     position: relative;
	     background: #fcfff4;
	     background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     background: linear-gradient(to bottom, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label {
	     width: 20px;
	     height: 20px;
	     cursor: pointer;
	     position: absolute;
	     left: 4px;
	     top: 4px;
	     background: -webkit-linear-gradient(top, #FFFFFF 0%, #FFFFFF 100%);
	     background: linear-gradient(to bottom, #FFFFFF 0%, #FFFFFF 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px white;
	 }
	 .select label:after {
	     content: '';
	     width: 16px;
	     height: 16px;
	     position: absolute;
	     top: 2px;
	     left: 2px;
	     background: #6495ED;
	     background: -webkit-linear-gradient(top, #6495ED 0%, #6495ED 100%);
	     background: linear-gradient(to bottom, #6495ED 0%, #6495ED 100%);
	     opacity: 0;
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label:hover::after {
	     opacity: 0.3;
	 }
	 .select input[type=radio] {
	     visibility: hidden;
	 }
	 .select input[type=radio]:checked + label:after {
	     opacity: 1;
	 }
	</style>
  <?php include 'partials/scripts.php' ?>
    </head>
    <body>
	<!-- <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 2em">
	    <h1 id="question"><center><?php echo $question ?></center></h1>
	     </div> -->
	<img src="./images/body-changer/cross.png" id="cross" class="col-md-offset-5 cil-md-2 col-sm-offset-5 col-sm-2" style="display: none; padding-top: 200px"></div>
<form id="answer" style="display: none">
	    <div class="row" style="padding-top: 2em;" >
		<?php if($displayQuestion){ ?>
		    <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
			<h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>Draw a conclusion from your data points</strong></h1>
		    </div>
		    <div >
			<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="display:none" id="chart-scatter"></div>
		    </div>
		    <div id="container1" class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			<div>
			    <div class="row">
				<h3>Summarize the relationship between sleep and reaction time shown in the graph by selecting the word that completes the sentence below the graph.</h3>
			    </div>
			    <div class="row">
				<canvas id="id_whiteBoard" name="whiteBoard" style="border:1px solid #d3d3d3;">
				</canvas>
			    </div>
			    <!--<div class="row">
				<button type="button" class="btn btn-danger btn-sm" onclick="redraw();">Clear</button>
			    </div>-->
			</div>
			<?php if($displayQuestionTwo){ ?>
			    <div>
				<div class="row">
				    <!--<h2>Summarize the relationship between sleep and reaction time by selecting the correct button.</h2>-->
				  <h3>When nightly sleep decreased, then the reaction time:</h3>
				</div>
				<table>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_increase" data-toggle="modal" data-target="#correct"/><label for="id_increase"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 30px">Increased</span>
					</td>
				    </tr>
				    <tr style="height: 1em">
				    </tr>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_decrease" onclick="showModal()"/><label for="id_decrease"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 30px">Decreased</span>
					</td>
				    </tr>
				    <tr  style="height: 1em">
				    </tr>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_noChange" onclick="showModal()"/><label for="id_noChange"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 30px">Did not change</span>
					</td>
				    </tr>
				</table>
			    </div>
			<?php } ?>
		    </div>
		<?php }else{ ?>
		    <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
			<h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>Can you draw a conclusion from your data points? Click next obtain more data.</strong></h1>
		    </div>
		    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			<div id="chart-scatter"></div>
		    </div>
		    <?php if($show){ ?>
			<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			  <!-- <h4 style="margin-top: 1em">Answer the questions following the complete graph in your lab notebook: <a href="https://www.google.com/docs" target="_blank">Google Docs</a>
			  <ol>
			    <li>Slow reaction time is one reason why sleepy drivers have more car crashes.   Can you think of another consequence of slow reaction time?</li>
			    <li>Reaction time decreases as the amount of nightly sleep increases until the recommended amount of recommended sleep is met. Why do you think reaction doesn’t continue to improve with more and more sleep?</li>
			  </ol></h4> -->
        <h4>Implications of the research:  Slow reaction time is one reason why sleepy drivers have more car crashes. Can you think of another consequence of slow reaction time?</h4>
			  <!-- <h4>Implications of the research:  Slow reaction time is one reason why sleepy drivers have more car crashes. Can you think of another consequence of slow reaction time?</h4> -->
			  <textarea class="form-control" rows="5" name="response" id="id_response"><?php echo $response ?></textarea>
			  <p><b>Implications are the “take away” statements that help others </b>understand what the research results mean to them.</p>
			</div>
		    <?php } ?>
		    <!-- <div class="form-group">
			 <textarea class="form-control input-lg" id=<?php echo $id; ?> name= <?php echo $name ?> placeholder="My response" rows="5"></textarea>
			 </div> -->
		<?php } ?>
	    </div>
	    <?php if(!$displayQuestion || !$displayQuestionTwo){ ?>
		<div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
		    <?php if($_SESSION['clickTimesRT'] == 7){ ?>
			<?php if($userType == 'student'){ ?>
			    <button type="button" class="btn btn-default btn-lg" id="id_submit">Submit</button>
			<?php }else{ ?>
			    <button type="button" class="btn btn-default btn-lg" onClick="location.href='body-changer-simulation-selection'">Done</button>
			<?php } ?>
		    <?php }else{ ?>
			<a type="submit" href=<?php echo $link ?> class="btn btn-info btn-lg" role="button"><?php echo $buttonName ?></a>
		    <?php } ?>
		</div>
	    <?php } ?>
	</form>
<div id="final-result"  style="display: none">
  <!-- <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
    <h4>Implications of the research:  Slow reaction time is one reason why sleepy drivers have more car crashes. Can you think of another consequence of slow reaction time?</h4>
    </div> -->
	    <div  class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
		<div id="chart-scatter-final"></div>
	    </div>
      <div  class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
        <?php include 'add-group-member-button.php' ?>
      </div>
	    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
        <h3>Think about how much sleep that you usually get. What activities that you do are helped with a faster reaction time?</h3>
		<!-- <h4 style="margin-top: 1em">Answer the questions following the complete graph in your lab notebook: <a href="https://www.google.com/docs" target="_blank">Google Docs</a>
			  <ol>
			    <li>Slow reaction time is one reason why sleepy drivers have more car crashes.   Can you think of another consequence of slow reaction time?</li>
			    <li>Reaction time decreases as the amount of nightly sleep increases until the recommended amount of recommended sleep is met. Why do you think reaction doesn’t continue to improve with more and more sleep?</li>
			  </ol></h4>-->

			  <textarea class="form-control" rows="5" name="response" id="id_response"><?php echo $response ?></textarea>
			  <!-- <p><b>Implications are the “take away” statements that help others </b>understand what the research results mean to them.</p> -->
	    </div>
	    <div>
		<div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
		    <?php if($userType == 'student'){ ?>
			<button type="button" class="btn btn-default btn-lg" id="id_submit">Submit</button>
		    <?php }else{ ?>
			<button type="button" class="btn btn-default btn-lg" onClick="location.href='body-changer-simulation-selection'">Done</button>
		    <?php } ?>
		</div>
	    </div>
	</div>
	<!-- Model -->
	<div id="correct" class="modal fade" data-backdrop="static" data-keyboard="false"  role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Great choice, less sleep slows down the speed of the brain so that your ability to quickly move is slower. Do the results match your hypothesis which was: If nightly sleep decreases, then reaction time will <span id="hypothesis" style="color: red"></span> </h4>
			<div class="dropdown">
			    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Please Select One
				<span class="caret"></span></button>
			    <ul class="dropdown-menu">
				<li><a href="#" onclick="showResult()" data-dismiss="modal">Yes</a></li>
				<li><a href="#" onclick="showResult()" data-dismiss="modal">No</a></li>
			    </ul>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="wrong" role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Not the best choice.</h4>
			<h4>Look at the pattern of dots on the graph and click “No” to try drawing the line again. If you would like to input more values for hours of sleep click “Yes”.</h4>
		    </div>
		    <div class="modal-footer">
			<!--<button data-toggle="modal" data-target="#choice" type="button" class="btn btn-default" data-dismiss="modal">Ok</button>-->
			<button onclick="location.href = 'body-changer-rt-simulation-input?answer=wrong'" type="button" class="btn btn-default" data-dismiss="modal">Yes</button>
			<button onclick="redraw();" type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="wrong-2" role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
	    <div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-body">
			<h4>Not the best choice. Please input more values.</h4>
		    </div>
		    <div class="modal-footer">
			<button onclick="location.href = 'body-changer-rt-simulation-input?answer=wrong'" type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
		    </div>
		</div>
	    </div>
	</div>
	<!-- <div class="modal fade" id="choice" role="dialog" data-modal-index="1" aria-labelledby="choice">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Would you like to input more values for hours of sleep?</h4>
		    </div>
		    <div class="modal-footer">
		      	<button onclick="location.href = 'body-changer-rt-simulation-input?answer=wrong'" type="button" class="btn btn-default" data-dismiss="modal">Yes</button>
			<button onclick="redraw();" type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    </div>
		</div>
	    </div>
	</div>-->
    </body>
    <script type="text/javascript">
     var hours = <?php echo json_encode($_SESSION['hoursRT']); ?>;
     var time = <?php echo json_encode($_SESSION['timeRT']); ?>;
     var delayTime = <?php echo $delayTime; ?>;
     var canvas;
     var modalFlag = false;
     var active = false;
     //console.log(hours);
     //console.log(time);


     $(document).ready(function() {
	 $('#cross').delay(delayTime).fadeIn(100);
     });

     $(document).keypress(function(e) {
	 if(e.which == 32 && !active) {
	     if(!$('#answer').is(':visible')){
		 if($('#cross').is(':visible')){

     $('#cross').hide();
     e.preventDefault();
		     google.charts.load('current', {'packages':['corechart']});
		     google.charts.setOnLoadCallback(drawChart);
		     $('#answer').show();
		     canvas = document.getElementById('id_whiteBoard');
		     if (canvas !== null){
			 canvas.style.width ='700px'; //style size is the CSS size
			 canvas.style.height='500px';
			 //then set the internal size to match
			 canvas.width  = canvas.offsetWidth; //need to set canvas size
			 canvas.height = canvas.offsetHeight;
     }
     active = true;
     }

     }


	 }
     });

     function showModal(){
	 if(modalFlag){
	     $('#wrong-2').modal();
	 }else{
	     $('#wrong').modal();
	     modalFlag = true;
	 }
     }

     function showResult(){
	 $('#answer').hide();
	 google.charts.load('current', {'packages':['corechart']});
	 google.charts.setOnLoadCallback(drawFinalChart);
	 $('#final-result').show();
     }

     function drawFinalChart(){
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

         var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter-final'));
         chart.draw(data, options);
     }

     function drawChart() {
     var data = new google.visualization.DataTable();
	 data.addColumn('number', 'Reaction Time');
	 data.addColumn('number', 'Average Sleeping Hours for Last Week');

	 for(var i = 0; i < hours.length; i++){
	     data.addRow([hours[i], time[i]]);
         }

         var options = {
             title: 'Psychomotor Vigilance Task (PVT) Performance',
             vAxis: {title: 'Reaction Time (ms)',
		     ticks: [360, 370, 380, 390, 400, 410, 420, 430]
	     },
             hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
		     ticks: [4, 5, 6, 7, 8, 9, 10]
	     },
             legend: 'none',
			 width: 700,
	     height: 500
         };

         var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter'));

		  google.visualization.events.addListener(chart, 'ready', function () {
			  if(canvas != null){
			canvas.style.backgroundImage = 'url(' + chart.getImageURI() + ')';
			  }
			});

         chart.draw(data, options);

     }



     // painting for question 3
     canvas = document.getElementById('id_whiteBoard');
     if (canvas !== null){
	 canvas.style.width ='100%'; //style size is the CSS size
	 canvas.style.height='300px';
	 //then set the internal size to match
	 canvas.width  = canvas.offsetWidth; //need to set canvas size
	 canvas.height = canvas.offsetHeight;
	 var ctx = canvas.getContext('2d');
	 click = false;


	 /*$(window).mousedown(function(){
	     click = true;
	 });

	 $(window).mouseup(function(){
	     click = false;
	 });

	 $('canvas').mousedown(function(e){
	     draw(e.pageX, e.pageY);
	 });

	 $('canvas').mouseup(function(e){
	     draw(e.pageX, e.pageY);
	 });

	 $('canvas').mousemove(function(e){
	     if(click === true){
		 draw(e.pageX, e.pageY);
	     }
	 });*/
     }

     function draw(xPos, yPos){
	 ctx.beginPath();
	 ctx.fillStyle = '#000000';
	 ctx.arc(xPos - $('canvas').offset().left, yPos - $('canvas').offset().top, 4, 0, 2 * Math.PI);
	 ctx.fill();
	 ctx.closePath();
     }

     function redraw(){
	 ctx.clearRect(0, 0, canvas.width, canvas.height);
			    }

			    $(function() {
	 var h = localStorage.getItem('rtH');
	 $("#hypothesis").text(h);
			    });

     //submit function
     $('#id_submit').click(function() {
var result = confirm('Want to submit?');
if(!result){
	return false;
}
	 var formData = {
	     'response': $('#id_response').val()
	 };

	 $.ajax({
	     type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
	     url         : 'body-changer-rt-simulation-done', // the url where we want to POST
	     data        : formData, // our data object
	     dataType    : 'json', // what type of data do we expect back from the server
	     encode      : true
	 })
	  .success(function(data) {
	      if (!data.success) {
		  alert(data.errors);
	      }
	      else {
		  alert(data.message);
		  location.href = 'body-changer-simulation-selection';
	      }
	  });
     });
    </script>
</html>
