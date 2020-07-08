<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
// Manage classes;
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
checkauth();
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
$userType = $_SESSION['userType'];
$currentClass = $_SESSION['className'];
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // Create New Classes</title>
	<style>
	 caption {
	     font-size: 30pt;
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
      <?php if (isset($currentClass)): ?>
        <div class="row">

            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
              <ol class="breadcrumb">
        				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
        				<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
        				<li class="active">Create New Classes</li>
              </ol>
      			</div>

        </div>

		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <div class="row col-md-12 col-sm-12">
			<table class="table table-striped table-border">
			    <caption> Current Classes </caption>
			    <thead>
				<tr>
				    <?php if($userType != "teacher"){ ?>
					<th> Class Number </th><th>Class Name</th><th> Grade </th><th> School ID </th><th> School Name </th><th>Semester</th><th>Year</th>
			            <?php }else{ ?>
					<th>Class Name</th><th> Grade </th><th> School Name </th><th>Semester</th><th>Year</th>
				    <?php } ?>
				</tr>
			    </thead>
			    <tbody>
				<?php
				include 'connectdb.php';
				if($userType == "teacher"){
				    $result = mysql_query("SELECT * FROM class_info_table where schoolNum='$schoolId'");
				    while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
					$classId = $row['classId'];
					$className = $row['className'];
					$schoolNum = $row['schoolNum'];
					$grade = $row['grade'];
					$semester = $row['semester'];
					$year = $row['year'];
					$schoolName_arr = mysql_query("SELECT * FROM school_info where schoolId='$schoolNum'");
					$row_schoolName = mysql_fetch_array($schoolName_arr);
					$schoolName = $row_schoolName['schoolName'];
					echo "<td>".$className."</td><td>".$grade."</td><td>".$schoolName."</td><td>".$semester."</td><td>".$year."</td>";
					echo "</tr>";
				    }
				}else{
				    $result = mysql_query("SELECT * FROM class_info_table");
				    while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
					$classId = $row['classId'];
					$className = $row['className'];
					$schoolNum = $row['schoolNum'];
					$grade = $row['grade'];
					$semester = $row['semester'];
					$year = $row['year'];
					$schoolName_arr = mysql_query("SELECT * FROM school_info where schoolId='$schoolNum'");
					$row_schoolName = mysql_fetch_array($schoolName_arr);
					$schoolName = $row_schoolName['schoolName'];
					echo "<td>".$classId."</td><td>".$className."</td><td>".$grade."</td><td>".$schoolNum."</td><td>".$schoolName."</td><td>".$semester."</td><td>".$year."</td>";
					echo "</tr>";
				    }
				}

				mysql_close($con);
				?>
			    </tbody>
			</table>
		    </div>
		    <?php if($userType != "teacher"){ ?>
		    <div class="row col-md-12 col-sm-12" style="padding-top: 1cm">
			<table class="table table-striped table-border">
			    <tr>
				<th> School ID </th><th> School Name </th>
			    </tr>
			    <?php
			    include 'connectdb.php';
			    $result = mysql_query("SELECT * FROM school_info");
			    while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
				$schoolId = $row['schoolId'];
				$schoolName = $row['schoolName'];
				echo "<td>".$schoolId."</td><td>".$schoolName."</td>";
				echo "</tr>";
			    }
			    mysql_close($con);
			    ?>
			</table>
		    </div>
		    <?php } ?>
        <?php endif; ?>
        <div class="row">
    			<div class="col-md-offset-3 col-md-6">
            <h2 style="text-align: center"> Create A Class </h2>
          </div>
        </div>
		    <form method="post" enctype="multipart/form-data" action="set-class-info-done">
			<div class="row">
 			    <div class="form-group">
				<label for="className" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">Class Name (e.g. Science G4):</label>
				<div class="col-md-5 col-sm-5">
				    <input class="form-control" name="className" id="className" type="text" value="">
				</div>
			    </div>
			</div>
			<div class="row">
			    <div class="form-group">
				<label for="classGrade" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">Class Grade:</label>
				<div class="col-md-5 col-sm-5">
				    <!-- <input class="form-control" id="classGrade" name="classGrade" type="text" value=""> -->
				    <select name='classGrade' id='classGrade' class='form-control input-lg'>
					<option value='' disabled selected>Class Grade</option>
					<option value='4'>Fourth Grade</option>
					<option value='5'>Fifth Grade</option>
				    </select>
				</div>
			    </div>
			</div>
			<div class="row">
			    <div class="form-group">
				<label for="semester" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">Semester:</label>
				<div class="col-md-5 col-sm-5">
				    <!-- <input class="form-control" id="classGrade" name="classGrade" type="text" value=""> -->
				    <select name='semester' id='id-semester' class='form-control input-lg'>
					<option value='' disabled selected>Semester</option>
					<option value='F'>Fall</option>
					<option value='S'>Spring</option>
				    </select>
				</div>
			    </div>
			</div>
			<div class="row">
			    <div class="form-group">
				<label for="year" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">Year:</label>
				<div class="col-md-5 col-sm-5">
				    <!-- <input class="form-control" id="classGrade" name="classGrade" type="text" value=""> -->
				    <select name='year' id='id-year' class='form-control input-lg'>
					<option value='' disabled selected>Year</option>
					<option value='2017'>2017</option>
					<option value='2018'>2018</option>
          <option value='2019'>2019</option>
					<option value='2020'>2020</option>
          <option value='2021'>2021</option>
					<option value='2022'>2022</option>
				    </select>
				</div>
			    </div>
			</div>
			<?php if($userType != "teacher"){ ?>
			    <div class="row">
				<div class="form-group">
				    <label for="schoolId" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">School ID:</label>
				    <div class="col-md-5 col-sm-5">
					<!-- <input class="form-control" id="schoolId" name="schoolId" type="text" value="">-->
					<select name='schoolId' id='schoolId' class='form-control input-lg'>
					    <option value='' disabled selected>School Name</option>
					    <?php
					    include 'connectdb.php';
					    $result = mysql_query("SELECT * FROM school_info");
					    while ($row = mysql_fetch_array($result)) {
						$schoolId = $row['schoolId'];
						$schoolName = $row['schoolName'];
						echo "<option value='". $schoolId."'>".$schoolName;
						echo "</option>";
					    }
					    mysql_close($con);
					    ?>
					</select>
				    </div>
				</div>
			    </div>
			<?php } ?>
  			<div class="row" style="padding-top: 1cm">
			    <div class="col-md-offset-3 col-md-2">
		        <input class="btn btn-primary btn-large btn-block" type="submit" name="addNewClass" value="Create" onclick="return validation()"/>
			    </div>
          <?php if (isset($currentClass)): ?>
            <div class="col-md-offset-1 col-md-2">
			        <input class="btn btn-primary btn-large btn-block" type="submit" name="quit" value="Return" onclick="return confirm('Are you sure you want to return?')"/>
  			    </div>
          <?php endif; ?>
   			</div>
			<!--<input type="submit" name="deleteExistingClass" value="Delete" />-->
		    </form>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     var type = "<?php echo $userType; ?>";
  	 function validation(){
       if(type == "teacher"){
    		 if((!$("#classGrade").val()) || (!$("#className").val())){
    		     alert("Please fill in all fields");
    		     return false;
    		 }else{
    		     if (!confirm("Are you sure you want to create new class?")){
    			 return false;
    		     }else{
    			 return true;
    		     }
    		 }
       }else{
    		 if(!$("#classGrade").val()|| !$("#className").val() || !$("#schoolId").val()){
    		     alert("Please fill in all fields");
    		     return false;
    		 }else{
    		     return true;
    		 }
       }
  	 }
    </script>
</html>
