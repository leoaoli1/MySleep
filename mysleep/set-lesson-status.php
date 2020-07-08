<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
// Establish link from one user to classes
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
checkauth();
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
$classGrade = $_SESSION['classGrade'];
include 'connectdb.php';
$result = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
   $row = mysql_fetch_array($result);
   $lesson1 = $row['Lesson_1'];
   $lesson2 = $row['Lesson_2'];
   $lesson3 = $row['Lesson_3'];
   $lesson4 = $row['Lesson_4'];
   $lesson5 = $row['Lesson_5'];

   $EstrellaDataHuntBar = $row["EstrellaDataHuntBar"] ? $row["EstrellaDataHuntBar"] : 0;

mysql_close($con);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // Activate Lessons</title>
    </head>

    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">

                    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
				<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
				<li class="active">Activate Lessons</li>
                            </ol>
			</div>
                    </div>
		</div>
		<?php include 'partials/alerts.php' ?>

		<form data-form-location="set-lesson-status-done" data-success-message="The lessons have been processed." data-error-message="" enctype="multipart/form-data" method="post">
		    <div class="col-xs-offset-2 col-xs-8 col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
			<table class="table table-striped">
			    <tbody>
				<tr>
				    <th>Lesson Name</th><th>Activate/Deactivate</th>
				</tr>
				<tr>
				    <td>Lesson 1</td>
				    <td>
					<div class="togglebutton">
					    <label>
						<input type="checkbox" id="Lesson1-checkbox" name="Lesson1-checkbox" <?php echo ($lesson1==1 ? 'checked' : '0');?>>
					    </label>
					</div>
				    </td>
				</tr>
				<tr>
				    <td>Lesson 2</td>
				    <td>
					<div class="togglebutton">
					    <label>
						<input type="checkbox" id="Lesson2-checkbox" name="Lesson2-checkbox" <?php echo ($lesson2==1 ? 'checked' : '0');?>>
					    </label>
					</div>
				    </td>
				</tr>
				<tr>
				    <td>Lesson 3</td>
				    <td>
					<div class="togglebutton">
					    <label>
						<input type="checkbox" id="Lesson3-checkbox" name="Lesson3-checkbox" <?php echo ($lesson3==1 ? 'checked' : '0');?>>
					    </label>
					</div>
				    </td>
				</tr>
				<tr>
				    <td>Lesson 4</td>
				    <td>
					<div class="togglebutton">
					    <label>
						<input type="checkbox" id="Lesson4-checkbox" name="Lesson4-checkbox" <?php echo ($lesson4==1 ? 'checked' : '0');?>>
					    </label>
					</div>
				    </td>
				</tr>
				<tr>
				    <td>Lesson 5</td>
				    <td>
					<div class="togglebutton">
					    <label>
						<input type="checkbox" id="Lesson5-checkbox" name="Lesson5-checkbox" <?php echo ($lesson5==1 ? 'checked' : '0');?>>
					    </label>
					</div>
				    </td>
				</tr>
			    </tbody>
			</table>
      <?php if ($classGrade == 4) { ?>
        <table class="table table-striped">
  			    <tbody>
  				<tr>
  				    <th>Activity Features</th><th>Activate/Deactivate</th>
  				</tr>
  				<tr>
  				    <td>Estrella's Data Hunt Bar Editable</td>
  				    <td>
  					<div class="togglebutton">
  					    <label>
  						<input type="checkbox" id="estrella-checkbox" name="estrella-checkbox" <?php echo ($EstrellaDataHuntBar==1 ? 'checked' : '0');?>>
  					    </label>
  					</div>
  				    </td>
  				</tr>
  			    </tbody>
  			</table>
      <?php } ?>

		    </div>
		    <div class="row">
			<div class="col-xs-offset-5 col-xs-2 col-sm-offset-5 col-sm-2 col-md-offset-5 col-md-2">
			    <input class="btn btn-primary btn-large btn-block" type="submit" name="submit" value="Save"/>
			</div>
		    </div>
		</form>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     $(function () {
         $('form').on('submit', function (e) {

             e.preventDefault();

             $.ajax({
		 type: 'post',
		 url: 'set-lesson-status-done',
		 data: $('form').serialize(),
		 success: function () {
       console.log('success');
                     $("#success-alert-text").html("It all seemed to work okay.")
		     $("#success-alert").show(500).delay(3000);
                     $("#success-alert").hide(500);
		 },
		 error: function (){
       console.log('error');
                     $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.")
		     $("#error-alert").show(500).delay(6000);
                     $("#error-alert").hide(500);
		 }
             });

         });

     });
     <?php if ($classGrade == 4) { ?>
       $(function () {
           $('form').on('submit', function (e) {

               e.preventDefault();

               $.ajax({
  		 type: 'post',
  		 url: 'set-activity-feature-status-done',
  		 data: $('form').serialize(),
  		 error: function (){
                       $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.")
  		     $("#error-alert").show(500).delay(6000);
                       $("#error-alert").hide(500);
  		 }
               });

           });

       });
     <?php } ?>

    </script>
</html>
