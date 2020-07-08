<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# Copyright 2017 University of Arizona
#

require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];

$config = $_SESSION['current_config'];

if($userId==""){
    header("Location: login");
    exit;
   }
   if(isset($_GET['answer'])){
    $_SESSION['hbAnswer'] = $_GET['answer'];
   }
   //debugToConsole('answer', $_SESSION['hbAnswer']);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Body Changer</title>
	<style type="text/css">
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
    </head>

    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
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
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">Activity Four</a></li>
				<li><a href="#" onclick="location.href='body-changer-index'">Body Change Welcome Page</a></li>
				<!--<li><a href="#" onclick="location.href='body-changer-simulator-display'">Body Change Simulator Display</a></li>-->
				<li><a href="#" onclick="location.href='body-changer-simulation-selection'">Body Change Simulation Selection</a></li>
                                <li class="active">Body Changer Heart Rate</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>

		    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                            <div style="display: none">
				<!-- Nav tabs -->
				<ul id="group" class="nav nav-justified nav-pills nav-pills-info" role="tablist">
				    <li role="presentation" class="active"><a href="#screen3" aria-controls="screen3" role="tab" data-toggle="tab">Screen 3</a></li>
				    <li role="presentation"><a href="#screen4" aria-controls="screen4" role="tab" data-toggle="tab">Screen 4</a></li>
				</ul>
			    </div>
			</div>
		    </div>

		    <div class="tab-content" style="margin-top: 2em;">
			<!-- Tab One -->
                        <div role="tabpanel" class="tab-pane active" id="screen3">
			    <div class="item"><img src="./images/body-changer/heart1.png" alt="First slide image" class="center-block image-fill" style="width:100px; height:200px">
			    </div>
			    <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
				<h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>Sleep and Heart Rate Simulation</strong></h1>
				<h2 style="font-family:Comic Sans MS; color:blue;font-size:150%;" ><p style="color:blue">Heart rate is the number of times your heart beats per minute. Generally, your heart beats faster when you are active so more blood carrying oxygen can be supplied to the muscles.  Stress also increases heart rate because the brain anticipates the need for more oxygen.  Your heart rate should be slower when the body is at rest.  The heart needs to rest, too!</p>
				</h2>
				<h4 style="font-family:Comic Sans MS; color:red;">CLICK NEXT TO CONTINUE</h4>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
				<div class="next">
				    <button type="button" class="btn btn-default btn-lg" onClick="next()">Next</button>
				</div>
			    </div>
			</div>
			<div role="tabpanel" class="tab-pane" id="screen4">
			    <div class="row">
				<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
				    <h2 class="title text-center"><strong>Hypothesize</strong></h2>
				    <h5 class="description" style="color: black;">
					<p>Make a prediction by selecting one of the following words to complete the sentence.</p>
				    </h5>
				</div>
			    </div>
			    <div class="row">
				<div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
				    <h5>If nightly sleep decreases, then heart rate will:</h5>
				</div>
				<div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <table>
					<tr>
					    <td>
						<section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_increase"/><label for="id_increase"></label></div></section>
					    </td>
					    <td>
						<span style="font-size: 20px">Increase</span>
					    </td>
					</tr>
					<tr style="height: 1em">
					</tr>
					<tr>
					    <td>
						<section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_decrease"/><label for="id_decrease"></label></div></section>
					    </td>
					    <td>
						<span style="font-size: 20px">Decrease</span>
					    </td>
					</tr>
					<tr  style="height: 1em">
					</tr>
					<tr>
					    <td>
						<section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_noChange"/><label for="id_noChange"></label></div></section>
					    </td>
					    <td>
						<span style="font-size: 20px">No Change</span>
					    </td>
					</tr>
				    </table>
				</div>
			    </div>
			    <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2">
				<a href="body-changer-hb-simulation-input" class="btn btn-info btn-lg" role="button">Next</a>
			    </div>
		    	</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
    <script>
	function next(){
	$('#group a[href="#screen4"]').tab('show');
	}
	$("#id_increase").click(function(){
	 localStorage.setItem('hbH', 'increase');
     });

     $("#id_decrease").click(function(){
	 localStorage.setItem('hbH', 'decrease');
     });

     $("#id_noChange").click(function(){
	 localStorage.setItem('hbH', 'no change');
     });
    </script>
</html>
