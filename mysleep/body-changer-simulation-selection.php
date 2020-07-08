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
# Reaction Time Session: Record click times, radio clicked, and order
$_SESSION['clickTimesRT'] = 0;
$_SESSION['timeRT'] = [];
$_SESSION['hoursRT'] = [];
$_SESSION['radioRT'] = [];
if(isset($_SESSION['rtAnswer'])){
    unset($_SESSION['rtAnswer']);
}

$_SESSION['clickTimesHB'] = 0;
$_SESSION['timeHB'] = [];
$_SESSION['hoursHB'] = [];
$_SESSION['radioHB'] = [];
if(isset($_SESSION['hbAnswer'])){
    unset($_SESSION['hbAnswer']);
}

$_SESSION['clickTimesBS'] = 0;
$_SESSION['timeBS'] = [];
$_SESSION['hoursBS'] = [];
$_SESSION['radioBS'] = [];
if(isset($_SESSION['bsAnswer'])){
    unset($_SESSION['bsAnswer']);
}

$_SESSION['clickTimesCC'] = 0;
$_SESSION['timeCC'] = [];
$_SESSION['hoursCC'] = [];
$_SESSION['radioCC'] = [];
if(isset($_SESSION['ccAnswer'])){
    unset($_SESSION['ccAnswer']);
   }


   if($_SESSION['hbSim']==1 && $_SESSION['rtSim'] == 1 && $_SESSION['bsSim'] == 1 && $_SESSION['ccSim'] == 1){
   header("Location: body-changer-big-data");
    exit;
   }
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Body Changer</title>
	<style>
	 .btn.btn-lg{
	     width: 100%;
	     padding-top: 40px;
	     padding-right: 40px;
	     padding-bottom: 40px;
	     padding-left: 40px;
	 }
	 .col-sm-2, .col-md-2{
	     padding-left: 0px;
	     padding-right: 0px;
	     padding-top: 0px;
	     padding-bottom:0px;
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
                    				<!--<li><a href="#" onclick="location.href='body-changer-simulator-display'">Body Change Simulator Display</a></li>
                    				<li><a href="#" onclick="location.href='body-changer-menu'">Body Change Menu</a></li>-->
                            <li class="active">Body Changer Simulation Selection</li>
                        </ol>
                    </div>
                </div>
              <?php } ?>

		    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
			<h1 style="font-family:Comic Sans MS; color:black;font-size:300%;"><strong><center>Body System Simulations </center></strong></h1>
			<h4 style="color:black;">The simulations can be done in any order, but all four must be done before you go on to the true false task. Click on a simulation to begin.</h4>
		    </div>


		    <table class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
			<tr>
			    <td class="col-md-3 col-sm-3">
				<a href="body-changer-rt-simulation-description" class="btn btn-success btn-lg" role="button" style="font-size:120%;">Sleep and Reaction Time Simulation</a>
			    </td>
			    <td class="col-md-2 col-sm-2">
			    </td>
			    <td class="col-md-3 col-sm-3">
				<a href="body-changer-cc-simulation-description" class="btn btn-success btn-lg" role="button" style="font-size:120%;">Sleep and Immune System Simulation</a>
			    </td>
			</tr>
			<tr>
			    <td class="col-md-3 col-sm-3">
				<a href="body-changer-hb-simulation-description" class="btn btn-success btn-lg" role="button" style="font-size:120%;">Sleep and Heart Rate Simulation</a>
			    </td>
			    <td class="col-md-2 col-sm-2">
			    </td>
			    <td class="col-md-3 col-sm-3">
				<a href="body-changer-bs-simulation-description" class="btn btn-success btn-lg" role="button" style="font-size:120%;">Sleep and the Endocrine System Simulation </a>
			    </td>
			</tr>
		    </table>
		</div>
	    </div>
	</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
</html>
