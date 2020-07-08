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
if($userId==""){
	header("Location: login");
	exit;
}
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
#echo $schoolId;
#echo $classId;
unset($_SESSION['deleteClass']);
unset($_SESSION['addClass']);
//unset($_SESSION['arrStudentId']);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep //Set Students' Class</title>
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
			    <li class="active">Set Students' Class</li>
                        </ol>
		    </div>
                </div>
	    </div>
	    <?php include 'partials/alerts.php' ?>
	    <div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
		<table class="table">
		    <caption>Current Class:</caption>
		    <thead>
			<tr>
			    <th>Class ID</th><th>Class Name</th><th>Class Grade</th><th>School Name</th>
			</tr>
		    </thead>
		    <tbody>
			<?php
			include 'connectdb.php';
			$result_class = mysql_query("SELECT * FROM class_info_table where classId='$classId'");
			$row_class = mysql_fetch_array($result_class);
			$className = $row_class['className'];
			$schoolNum = $row_class['schoolNum'];
			$schoolName_arr = mysql_query("SELECT * FROM school_info where schoolId='$schoolNum'");
			$row_schoolName = mysql_fetch_array($schoolName_arr);
			$schoolName = $row_schoolName['schoolName'];
			$grade = $row_class['grade'];
			echo "<tr>";
			echo "<td>".$classId."</td><td>".$className."</td><td>".$grade."</td><td>".$schoolName."</td>";
			echo "</tr>";
			mysql_close($con);
			?>
		    </tbody>
		</table>
	    </div>

	    <div class="row">
                <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                    <div>
			<ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
			    <li role="presentation" class="active"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete Students From this Class</a></li>
			    <li role="presentation"><a href="#add" aria-controls="add" role="tab" data-toggle="tab">Add Students to this Class</a></li>
			</ul>
			<!-- For deleting -->
			<div class="tab-content" style="margin-top: 2em;">
                            <div role="tabpanel" class="tab-pane active" id="delete">
				<form action="set-class-done" method="post"> 
				    <div class="row" style="padding-top: 1cm">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
					    <table class="table">
						<tr>
						    <th>First Name</th><th>Last Name</th><th><input type="checkbox" id="selectDeleteAll" /> Select All</th>
						</tr>
						<?php
						include 'connectdb.php';
						$targetUserIds = getUserIdsInSchool($schoolId);
						//$arrId = [];
						foreach ($targetUserIds as $user) {
                				    $result = mysql_query("SELECT * FROM user_table where userId ='$user' And classId = '$classId'");
                				    $row = mysql_fetch_array($result);
        					    if(isset($row['classId'])) {
							//array_push($arrId, $user);
        						list($firstName, $lastName) = getUserFirstLastNames($user);
        						echo "<tr><td>".$firstName."</td><td>".$lastName."</td><td><input type='checkbox' name='checkbox$user'></td></tr>"; 
        					    }	
    						}
						mysql_close($con);
						//$_SESSION['arrStudentId'] = $arrId;
						?>
					    </table>
					</div>
				    </div>
				    <div class="row col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em">
					<button class='btn btn-large btn-block' type="submit" name='deleteClass'>Delete</button>
				    </div>
				</form>
			    </div>

			<!-- For adding -->
                            <div role="tabpanel" class="tab-pane" id="add">
				<form action="set-class-done" method="post">  
				    <div class="row" style="padding-top: 1cm">
					<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
					    <table class="table">
						<tr>
						    <th>First Name</th><th>Last Name</th><th><input type="checkbox" id="selectAddAll" /> Select All</th>
						</tr>
						<?php
						include 'connectdb.php';
						$targetUserIds = getUserIdsInSchool($schoolId);
						//$arrId = [];
						foreach ($targetUserIds as $user) {
                				    $result = mysql_query("SELECT classId, type FROM user_table where userId ='$user'");
						   $row = mysql_fetch_array($result);
						   if($row['type']=='student'){
        					    if(empty($row['classId'])) {
							//array_push($arrId, $user);
        						list($firstName, $lastName) = getUserFirstLastNames($user);
        						echo "<tr><td>".$firstName."</td><td>".$lastName."</td><td><input type='checkbox' name='checkbox$user'></td></tr>"; 
        					   }
						   }
    						}
						mysql_close($con);
						//$_SESSION['arrStudentId'] = $arrId;
						?>
					    </table>
					</div>
				    </div>
				    <div class="row col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em">
					<button class='btn btn-large btn-block' type="submit" name='addClass'>Add</button>
				    </div>
				</form>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
    <script>
     $("#selectDeleteAll").click(function(){
	 $('input:checkbox').not(this).prop('checked', this.checked);
     });
     $("#selectAddAll").click(function(){
	 $('input:checkbox').not(this).prop('checked', this.checked);
     });
    </script>
</body>
</html>

