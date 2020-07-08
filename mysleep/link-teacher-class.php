
<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
# Will delete this file in the future
// Establish link from one user to another
// Currently, user can be linked to other student users so that he/she can access the students' data,
//   for example, sleep and activity diaries.
// This concept can be expanded to build, for example, groups within a class, so that
//   a group of students may share each other's lesson data.
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
$schoolId = $_SESSION['schoolId'];
if($userId==""){
    header("Location: login");
    exit;
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Link Teachers</title>
    </head>
    

    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                        <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
                        <li class="active">Link Teachers and Classes</li>
		    </ol>
<div class="row col-md-12 col-sm-12">
			<table class="table table-striped table-border">
			    <caption> <h2>Current Linked Teacher:</h2> </caption>
			    <thead>
				<tr>
				    <th>First Name</th><th>Last Name</th><th>Class Name</th>
				</tr>
			    </thead>
			    <tbody>
				<?php
				include 'connectdb.php';
				$result = mysql_query("SELECT class_table.userId FROM class_table  RIGHT JOIN user_table ON user_table.userId = class_table.userId where class_table.classId='$classId' AND type='teacher'");
				while ($row = mysql_fetch_array($result)) {
				    $Id = $row['userId'];
				    list($firstName, $lastName) = getUserFirstLastNames($Id);
				    $classNameResult = mysql_query("SELECT * FROM class_info_table where classId='$classId'");
				    $rowClass = mysql_fetch_array($classNameResult);
				    $className = $rowClass['className'];
					echo "<tr>";            
					echo "<td>".$firstName."</td><td>".$lastName."</td><td>".$className."</td>";
					echo "</tr>";
				}
				mysql_close($con);
				?>
			    </tbody>
			</table>
		    </div>
		    <!-- For deleting link -->
		    <div class="content" style="padding: 1cm">
			<form action="link-teacher-class-down" method="post" id="nameForm" enctype="multipart/form-data">
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>Name</h2></label>
				    <select class="form-control input-lg" name='linkUserId'>
					<option value='null' disabled selected>Please choose a teacher to link</option>
					<?php
					include 'connectdb.php';
					$result = mysql_query("SELECT userId, firstName, lastName FROM user_table WHERE type='teacher' and schoolId='$schoolId'");
					while($row=mysql_fetch_array($result)){
					    echo "<option value='".$row['userId']."'>".$row['firstName']." ".$row['lastName']."</option>";
					}
					mysql_close($con);
					?>
				    </select>
				</div>
				<button class="btn btn-primary btn-large btn-block" type="submit" onclick="return confirm('Are you sure you want to link?')">Link</button>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/scripts.php' ?>
    </body>
    <?php include 'partials/footer.php' ?>
</html>
