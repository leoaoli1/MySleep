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

include 'connectdb.php';
$result = mysql_query("SELECT reminder FROM class_info_table WHERE classId='$classId'");
$row = mysql_fetch_array($result);
$reminder = $row['reminder'];

mysql_close($con);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // Turn On/Off Reminder</title>
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
				<li class="active">Turn On/Off Reminder</li>
                            </ol>
			</div>
                    </div>
		</div>
		<?php include 'partials/alerts.php' ?>
		
		<form data-form-location="set-reminder-status-done" data-success-message="" data-error-message="" enctype="multipart/form-data" method="post">
		    <div class="col-xs-offset-2 col-xs-8 col-sm-offset-2 col-sm-8 col-md-offset-4 col-md-4">
			<table class="table table-striped">

			    <tbody>
				<tr>
				    <td>Reminder</td>
				    <td>
					<div class="togglebutton">
					    <label>
						<input type="checkbox" id="reminder-checkbox" name="reminder-checkbox" <?php echo ($reminder== 1 ? 'checked' : '0');?>>
					    </label>
					</div>
				    </td>
				</tr>
			    </tbody>
			</table>
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
		 url: 'set-reminder-status-done',
		 data: $('form').serialize(),
		 success: function () {
                     $("#success-alert-text").html("Done")
		     $("#success-alert").show(500).delay(3000);
                     $("#success-alert").hide(500);
		 },
		 error: function (){
                     $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.")
		     $("#error-alert").show(500).delay(6000);
                     $("#error-alert").hide(500);
		 }
             });

         });

     });
    </script>
</html>

