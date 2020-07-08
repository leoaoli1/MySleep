<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
// Update the current grade for a user (typically a student)
session_start();
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
	<title>MySleep //Update Email Address</title>
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
				<li class="active">Update Student Semester</li>
                            </ol>
			</div>
                    </div>
		    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
			<h4 class="description">
			    <div class="row" style="color:black">
				Update Current Class' Students Semester Information
			    </div>
			</h4>
		    </div>
		   
		    <form method="post" enctype="multipart/form-data" action="set-semester-done">
			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			<table class="table table-striped">
			    <thead>
				<tr>
				    <td>First Name</td><td>Last Name</td><td>Semester</td><td>Year</td>
				</tr>
			    </thead>
			    <tbody>
				<?php
				include 'connectdb.php';
				require_once('utilities.php');
				$result_link = getUserIdsInClass($classId);
				for($j=0; $j<count($result_link); $j++) {
        			    $student_id = $result_link[$j];
    	  			    list($firstname, $lastname) = getUserFirstLastNames($student_id);
    	  			    $result = mysql_query("SELECT * FROM user_table WHERE userId='$student_id'");
    	  			    $row = mysql_fetch_array($result); 
    	  			    $currentSemester = $row['semester'];
    				    $currentYear = $row['year'];
				    if($currentSemester == "S"){
					$currentSemester = "Spring";
				    }elseif($currentSemester == "F"){
					$currentSemester = "Fall";
				    }else{
					$currentSemester = "";
				    }
				    echo "<tr>";
    				    echo "<td>".$firstname."</td><td>".$lastname."</td><td>".$currentSemester."</td><td>".$currentYear."</td>";
				    echo "</tr>";
				}
				mysql_close($con);
				?>
			    </tbody>
			</table>
			</div>
    </br>
    <div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4" style="padding-top: 1em;">
    <p>Semester: <input type="radio" name="semester" id="semester" value="S" /> Spring  <input type="radio" name="semester" id="semester" value="F" /> Fall            &nbsp; &nbsp; 
	<select class="form-control input-lg" name="year">
            <option value="2017"> 2017</option>
            <option value="2018"> 2018</option>
	</select>
    </p>
    </div>
    <input class='btn btn-danger btn-large btn-block' type='submit' name="updateSemester" value="Update"/> 
		    </form>
		</div>
	    </div>
	</div>
	<?php include 'partials/scripts.php' ?>
    </body>
    <?php include 'partials/footer.php' ?>
</html>
