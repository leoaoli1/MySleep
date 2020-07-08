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

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

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
                  <li class="active">Body Changer Welcome Page</li>
                </ol>
            </div>
        </div>
      <?php } ?>
		    <div>
	                <div class="row">
			    <div class="col-md-offset-1 col-md-10">
				<h2 class="title text-center"><strong>Does sleep affect health?</strong></h2>
				<h5 class="description" style="color: black;">
				    <p>Researchers have collected data on how hours of sleep affects body systems.  You will simulate their experiments by inputting different amounts of sleep and seeing the effect on the essential function of these systems:</p>
<br>
				    <ul>
					<li>The NERVOUS SYSTEM is a vast network of nerve cells centered on the brain that work together to coordinate muscle function; monitor organs; and detect, process and respond to sensory information.</li>
					<li>The ENDOCRINE SYSTEM is the collection of glands and cells that release hormones to control metabolism, growth and development, blood pressure and heart rate, sleep and mood, and other vital processes.</li>
					<li>The CARDIOVASCULAR SYSTEM is the group of body parts, primarily the heart and blood vessels, responsible for the flow of blood, nutrients, hormones and oxygen to and from cells.</li>
					<li>The IMMUNE SYSTEM is the set of cells, tissues and organs that work together to protect the body from disease and respond to infection.</li>
</ul>
<br>
<p>First, you will get information from a group of simulations. Then you will use the information to select true or false statements about body systems.</p>
				</h5>
			    </div>
			</div>
		    </div>
		    <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
			<a href="body-changer-menu" class="btn btn-info btn-lg" role="button">Next</a>
		    </div>
		</div>
	    </div>
	</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
</html>
