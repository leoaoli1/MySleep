<!DOCTYPE html>
<?php   
// Show Student's Information
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
if($userId==""){
    header("Location: login");
    exit;
}
$classId = $_SESSION['classId'];
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep //Information.</title>
	<style>
	 caption { 
	     display: table-caption;
	     text-align: center;
	 }
	</style>
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
				<li class="active">All Students' Information</li>
                            </ol>
			</div>
                    </div>

		    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
			<!--<table data-toggle="table" data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="firstName" class="table table-striped" style="padding-top: 1cm">
			<caption><h2>Linked Students Information</h2></caption>
			<thead>
			    <tr>
				<th data-field="firstName" data-sortable="true">First Name</th><th data-field="lastName" data-sortable="true">Last Name</th><th  data-field="grade" data-sortable="true">Grade</th><th  data-field="semester" data-sortable="true">Semester</th><th  data-field="section" data-sortable="true">Section</th><th>School</th>
			    </tr>
			</thead>
			<tbody>
			    <?php
			    include 'connectdb.php';
			    $result_link = getLinkedUserIds($userId);
			    foreach($result_link as $student_id) {
	 	  		list($firstname, $lastname) = getUserFirstLastNames($student_id);
	 	  		$result = mysql_query("SELECT * FROM user_table WHERE userId='$student_id'");
	 	  		$row = mysql_fetch_array($result); 
	 	  		$currentGrade = $row['currentGrade'];
	 	  		$semester = $row['semester'];
	 	  		$year = $row['year'];
	 	  		$result_class = mysql_query("SELECT * FROM class_table where userId ='$student_id'");
        			if(mysql_num_rows($result_class)==0) {
        			    $className = "";
        			    $schoolName = ""; //need add in create account function and user_table
        			}else{
        			    $row_class = mysql_fetch_array($result_class); 
        			    $studentClassId = $row_class['classId'];
        			    $classInfo= mysql_query("SELECT * FROM class_info_table where classId ='$studentClassId'");
        			    $rowClassInfo = mysql_fetch_array($classInfo);
        			    $className = $rowClassInfo['className'];
        			    $studentSchoolId = $rowClassInfo['schoolNum']; //will be replaced start from here
        			    $schoolInfo= mysql_query("SELECT * FROM school_info where schoolId ='$studentSchoolId'");
        			    $rowSchoolInfo = mysql_fetch_array($schoolInfo);
        			    $schoolName = $rowSchoolInfo['schoolName'];
        			}
        			echo "<tr>";	
	 	  		echo "<td>".$firstname."</td><td>".$lastname."</td><td>".$currentGrade."</td><td>".$semester." ".$year."</td><td>".$className."</td><td>".$schoolName."</td>";
	 	  		echo "</tr>";    	
			    }
			    ?>
			</tbody>
		    </table>-->
		   
		    <table data-toggle="table" data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="firstName" class="table table-striped" style="padding-top: 1cm">
			<caption><h2>Current Section's Students</h2></caption>
			<thead>
			    <tr>
				<th data-field="firstName" data-sortable="true">First Name</th><th data-field="lastName" data-sortable="true">Last Name</th><th>Grade</th><th>Semester</th><th>Section</th><th>School</th>
			    </tr>
			</thead>
			<tbody>
			    <?php
			    $result_link = getUserIdsInClass($classId);
			    foreach($result_link as $student_id) {
 	  			list($firstname, $lastname) = getUserFirstLastNames($student_id);
 	  			$result = mysql_query("SELECT * FROM user_table WHERE userId='$student_id'");
 	  			$row = mysql_fetch_array($result); 
 	  			$currentGrade = $row['currentGrade'];
 	  			$semester = $row['semester'];
 	  			$year = $row['year'];
 	  			$result_class = mysql_query("SELECT * FROM class_table where userId ='$student_id'");
				$row_class = mysql_fetch_array($result_class); 
  				$studentClassId = $row_class['classId'];
  				$classInfo= mysql_query("SELECT * FROM class_info_table where classId ='$studentClassId'");
  				$rowClassInfo = mysql_fetch_array($classInfo);
  				$className = $rowClassInfo['className'];
  				$studentSchoolId = $rowClassInfo['schoolNum']; //will be replaced start from here
  				$schoolInfo= mysql_query("SELECT * FROM school_info where schoolId ='$studentSchoolId'");
  				$rowSchoolInfo = mysql_fetch_array($schoolInfo);
  				$schoolName = $rowSchoolInfo['schoolName'];
  				echo "<tr>";	
 	  			echo "<td>".$firstname."</td><td>".$lastname."</td><td>".$currentGrade."</td><td>".$semester." ".$year."</td><td>".$className."</td><td>".$schoolName."</td>";
 	  			echo "</tr>";    	         	
			    }
			    mysql_close($con);
			    ?>
			</tbody>
		    </table>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
