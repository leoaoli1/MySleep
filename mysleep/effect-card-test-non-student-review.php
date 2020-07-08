<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
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
if($userType == 'teacher'){
    $showClass = $_GET['showToClass'];
    $lessonNum = $_GET['lesson'];
    $activityNum = $_GET['activity'];
    $config = getActivityConfigWithNumbers($lessonNum, $activityNum);
    $query = $_SERVER['QUERY_STRING'];
}

$showToClass = 0;
$showToClass = $_GET['showToClass'];
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
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLinkReview($config,$userType);
                  } else {
                     ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="main-page">Home</a></li>
                        				<?php if($userType != 'parent'){ ?>
                        				    <li><a href="sleep-lesson">Lessons</a></li>
                                                            <li><a href="fifth-grade-lesson-menu?lesson=1">Lesson One</a></li>
                        				    <li><a href="fifth-grade-lesson-activity-menu?lesson=1&activity=1">Activity One</a></li>
                        				    <li class="pull-right"><a href="#" onClick="studentView()">Student View</a></li>
                        				<?php }else{ ?>
                        				    <li><a href="parent-sleep-lesson">Lessons</a></li>
                        				    <li><a href="parent-lesson-menu?lesson=1">Lesson One</a></li>
                        				    <li><a href="parent-lesson-activity-menu?lesson=1&activity=1">Activity One</a></li>
                        				<?php } ?>
                                <li class="active">Review: Effect Card</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>

		    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                            <div>
				<!-- Nav tabs -->
				<ul id="group" class="nav nav-justified nav-pills nav-pills-info" role="tablist">

				    <li role="presentation" class="active"><a href="#preschool" aria-controls="preschool" role="tab" data-toggle="tab">Preschool</a></li>
				    <li role="presentation"><a href="#school" aria-controls="school" role="tab" data-toggle="tab">School Aged</a></li>
				    <li role="presentation"><a href="#adult" aria-controls="adult" role="tab" data-toggle="tab">Adult</a></li>
				</ul>
			    </div>
			</div>
		    </div>
		    <div class="tab-content" style="margin-top: 2em;">
			<!-- Tab One -->
                        <div role="tabpanel" class="tab-pane active" id="preschool">
			    <form id="pre-school">
				<table id="pre-school-table"  class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table">
				    <thead>
					<tr>
					    <?php if($showToClass == "1"){ ?>
						<th>Preschool Negative Effect</th><th>Preschool  Positive Effect</th>
					    <?php }else{ ?>
						<th>First Name</th><th>Last Name</th><th>Preschool Negative Effect</th><th>Preschool  Positive Effect</th>
					    <?php } ?>
					</tr>
				    </thead>
				    <tbody>

				    </tbody>
				</table>
			    </form>
			</div>
			<!-- Tab Two -->
			<div role="tabpanel" class="tab-pane" id="school">
			    <form id="school-form">
				<table id="school-table" class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table">
				    <thead>
					<tr>
					    <?php if($showToClass == "1"){ ?>
						<th>School Aged Negative Effect</th><th>School Aged Positive Effect</th>
					    <?php }else{ ?>
						<th>First Name</th><th>Last Name</th><th>School Aged Negative Effect</th><th>School Aged Positive Effect</th>
					    <?php } ?>
					</tr>
				    </thead>
				    <tbody>

				    </tbody>
				</table>
			    </form>
			</div>
			<!-- Tab Three -->
			<div role="tabpanel" class="tab-pane" id="adult">
			    <form id="adult-form">
				<table id="adult-table"  class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table">
				    <thead>
					<tr>
					    <?php if($showToClass == "1"){ ?>
						<th>Adult Negative Effect</th><th>Adult  Positive Effect</th>
					    <?php }else{ ?>
						<th>First Name</th><th>Last Name</th><th>Adult Negative Effect</th><th>Adult  Positive Effect</th>
					    <?php } ?>
					</tr>
				    </thead>
				    <tbody>

				    </tbody>
				</table>
			    </form>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script>
	 function studentView(){
             window.open("./effect-card-test");
	 }

	 var prerow, schoolrow, adultrow;
	 var showToClass = <?php echo $showToClass; ?>;
	 setInterval(function(){
	     $.ajax({
		 type: "post",
		 url: "effect-card-test-review-process",
		 dataType: 'json',
	 success: function (response) {
     console.log(response)
	 // console.log(response.row);
	 $("#pre-school-table tbody").empty();
 	 $("#school-table tbody").empty();
	 $("#adult-table tbody").empty();
		     for (var i = 0; i < response.preSchoolID.length; i++) {
			 if(showToClass == "1"){
			     prerow = "<tr><td>" + response.preSchoolNegList[i] + "</td><td>" +response.preSchoolPosList[i] + "</td><td>";
			 }else{
			     prerow ="<tr><td>"+ response.preSchoolFirst[i] +"</td><td>"+ response.preSchoolLast[i] +"</td><td>" + response.preSchoolNegList[i] + "</td><td>" +response.preSchoolPosList[i] + "</td><td>";
			 }
			 $("#pre-school-table tbody").append(prerow);
		     }

		     for (var i = 0; i < response.schoolID.length; i++) {
			 if(showToClass == "1"){
			     schoolrow = "<tr><td>" + response.schoolNegList[i] + "</td><td>" +response.schoolPosList[i] + "</td><td>";
			 }else{
			     schoolrow ="<tr><td>"+ response.schoolFirst[i] +"</td><td>"+ response.schoolLast[i] +"</td><td>" + response.schoolNegList[i] + "</td><td>" +response.schoolPosList[i] + "</td><td>";
			 }
			 $("#school-table tbody").append(schoolrow);
		     }

		     for (var i = 0; i < response.adultID.length; i++) {
			 if(showToClass == "1"){
			     adultrow = "<tr><td>" + response.adultNegList[i] + "</td><td>" +response.adultPosList[i] + "</td><td>";
			 }else{
			     adultrow ="<tr><td>"+ response.adultFirst[i] +"</td><td>"+ response.adultLast[i] +"</td><td>" + response.adultNegList[i] + "</td><td>" +response.adultPosList[i] + "</td><td>";
			 }
			 $("#adult-table tbody").append(adultrow);
		     }
		 }
	     });
	 }, 2000);
	</script>
    </body>
</html>
