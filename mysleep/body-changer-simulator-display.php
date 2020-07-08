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
if($userId==""){
    header("Location: login");
    exit;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Body Changer</title>
    </head>

    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                              <li><a href="#" onclick="location.href='main-page'">Home</a></li>
			      <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                              <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=3'">Lesson Three</a></li>
			      <li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">Activity Four</a></li>
			      <li><a href="#" onclick="location.href='body-changer-index'">Body Change Welcome Page</a></li>
                                <li class="active">Body Changer Simulator Display</li>
                            </ol>
                        </div>
		    </div>
		    <article id="main">
			<h1 class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="font-family:Comic Sans MS; border:solid; border-color:green; border-width: 2px; padding:10px; padding-left:5px; padding-right:5px; background:#79C584; color:white; font-size:300%;"> <center>Body System Simulator</center> </h1>
			<p> </p>
		    </article>
		    <div class="container">
			<div class="row">
			    <div class="col-md-4">
				<div class="thumbnail"><img src="images/body-changer/pvt_mri.gif" alt="Thumbnail Image 1" class="thumb">
				    <div class="caption">
					<h3 style="font-family:Comic Sans MS; color:red;font-size:200%;">Psychomotor Vigilance Task </h3>
					<p style="font-family:Comic Sans MS; color:blue;font-size:150%;">The psychomotor vigilance task (PVT) is a sustained-attention, reaction-timed task that measures the speed with which subjects respond to a visual stimulus. 
					    (c) </p>
				    </div>
				</div>
			    </div>
			    <div class="col-md-4" style="background:#79C584">
				<div class="thumbnail" style="background:#79C584; border-color:#79C584"><class="thumb">
				    <div class="caption" style="background:#79C584; border-color:#79C584">
					<p style="font-family:Comic Sans MS; color:white;font-size:150%; border-color: #79C584; background:#79C584"; >Simulation is a way of testing the operation of a real-life system. In this activity, you will be observing how various amounts of sleep during the night, including your own, affect the function of 4 organ systems in your body: neurologic (brain), cardiovascular (heart), immune (infection) and metabolic (blood sugar).</p>
					<p style="font-family:Comic Sans MS; color:white;font-size:150%;background:#79C584"> Read the descriptions of the processes that will be simulated when you choose different amounts of sleep. Then click next to continue to the simulator. </p>

				    </div>
				</div>
			    </div>
			    <div class="col-md-4">
				<div class="thumbnail"><img src="images/body-changer/gm.gif" alt="Thumbnail Image 1" class="thumb">
				    <div class="caption">
					<h3 style="font-family:Comic Sans MS; color:red;font-size:200%;">Blood Sugar and Glucose</h3>
					<p style="font-family:Comic Sans MS; color:blue;font-size:150%;">
					    After we eat, blood sugar concentrations rise, the pancreas releases insulin automatically so that the glucose enters cells, as more and more cells receive glucose, blood sugar levels come down to normal again.  </p>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		    <div class="container">
			<div class="row">
			    <div class="col-md-4">
				<div class="thumbnail"><img src="images/body-changer/heart_beat.gif" alt="Thumbnail Image 1" class="thumb">
				    <div class="caption">
					<h3 style="font-family:Comic Sans MS; color:red;font-size:200%;">Heartbeat Rate</h3>
					<p style="font-family:Comic Sans MS; color:blue;font-size:150%;">
					    Your heart rate, or pulse, is the number of times your heart beats per minute. Normal heart rate varies from person to person. Knowing yours can be an important heart-health gauge.
					</p>
				    </div>
				</div>
			    </div>
			    <div class="col-md-4">
				<div class="thumbnail"><img src="images/body-changer/fast.gif"  alt="Thumbnail Image 1" class="thumb"> <img src="images/body-changer/median.gif"  alt="Thumbnail Image 1" class="thumb"> <img src="images/body-changer/veryslow.gif"  alt="Thumbnail Image 1" class="thumb">
				    <div class="caption">
					<h3 style="font-family:Comic Sans MS; color:red;font-size:200%;" >Changing Heartbeat Rate</h3>
					<p> </p>
				    </div>
				</div>
			    </div>
			    <div class="col-md-4">
				<div class="thumbnail"><img src="images/body-changer/germ.gif" alt="Thumbnail Image 1" class="thumb">
				    <div class="caption">
					<h3 style="font-family:Comic Sans MS; color:red;font-size:200%; border-color:#9BF0B2">Probability to Catch Cold </h3>
					<p style="font-family:Comic Sans MS; color:blue;font-size:150%;">A cold begins when a virus attaches to the lining of your nose or throat. Your immune system -- the body's defense against germs -- sends out white blood cells  to attack this invader. </p>
				    </div>
				</div>
			    </div>
			    <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
				<a href="body-changer-menu" class="btn btn-info btn-lg" role="button">Continue</a>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
</html>
