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
checkauth();
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
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
                            <li class="active">Set Activity Dairy Date</li>
                        </ol>
                    </div>
                </div>
            </div>
			<div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
            <?php include 'partials/alerts.php' ?>

        <form action="set-activity-date-done" id="dateForm"  enctype="multipart/form-data" method="post">
	    <div class="row" style="padding-top: 1cm">
		<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
		<table class="table">
		<tr>
		<th>First Name</th><th>Last Name</th><th>Diary Start Date</th><th>Diary End Date</th><th><input type="checkbox" id="selectAll" /> Select All</th>
		</tr>
		<?php
		include 'connectdb.php';
        $resultLink = getUserIdsInClass($classId);
		$grade = getClassGrade($classId);
        foreach ($resultLink as $studentId){
    	  			list($firstname, $lastname) = getUserFirstLastNames($studentId);
    	  	$result = mysql_query("SELECT activityStartDateFour, activityEndDateFour, activityStartDateFive, activityEndDateFive FROM user_table WHERE userId='$studentId'");
    	  			$row = mysql_fetch_array($result); 
					if($grade == 4){
						$diaryStartDate = $row['activityStartDateFour'];
						$diaryEndDate = $row['activityEndDateFour'];
					}else{
						$diaryStartDate = $row['activityStartDateFive'];
						$diaryEndDate = $row['activityEndDateFive'];
					}
    	  			echo "<tr><td>".$firstname."</td><td>".$lastname."</td><td id='currentStartDate$studentId'>".$diaryStartDate."</td><td id='currentEndDate$studentId'>".$diaryEndDate."</td><td><input type='checkbox' name='checkbox$studentId'></td></tr>";            	
        }
        mysql_close($con);
		?>
		</table>
		</div
	    </div>
	   
		<div class="row" style="padding-top: 1cm">
		    <div class="col-md-offset-2 col-md-2 col-sm-offset-2 col-sm-2">
			<label>Start Date:</label>
			<input type="text" class="class="form-control" name="startDate" id="startDate"/>
		    </div>
		    <div class="col-md-offset-3 col-md-2 col-sm-offset-3 col-sm-2">
			<label>End Date:</label>
			<input type="text" class="class="form-control" name="endDate" id="endDate"/>
		    </div>
		</div>
		
		<div class="row" style="padding-top: 5cm">
		    <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2">
			<input class="btn btn-primary btn-large btn-block" type="submit" name="submit" value="Save" onclick="return confirm('Are you sure you want to update?')"/>
		    </div>
		</div>
	    </form>
	</div>
    </div>
    <?php include 'partials/footer.php' ?>
</body>
<?php include 'partials/scripts.php' ?>
<script>
     $("#selectAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
}); 

     $(function() {
	 $('#startDate').datepicker({
	     autoclose: true, 
             format: 'yyyy-mm-dd'
	 })
	 $('#endDate').datepicker({
	     autoclose: true, 
             format: 'yyyy-mm-dd'
	 })
     });
    </script>
</html>



