<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
    header("Location: login");
    exit;
}
$classId = $_SESSION['classId'];
$menuGrade = $_GET['grade'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // How Do I Sleep</title>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php
                        if ($config) {
                          require_once('partials/nav-links.php');
                          navigationLink($config,$userType);
                        } else {
                     ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page';">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
                            <?php if($menuGrade==4){?>
                    				    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                                <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=2'">Activity Two</a></li>
                                <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=sleepdata'">Part 2</a></li>
                    				<?php }else{?>
                    				    <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                    				<?php }?>
                                <li class="active">Upload Actogram</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
		    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
			<h4 class="description">
			    <div class="row" style="color:black">
				Checklist:
				<ol>1. Image file type is .png or .PNG. </ol>
				<ol>2. Raw Data file type is .csv </ol>
				<ol>3. Using the notepad open the raw data file, make sure the text delimiter is double quotes (e.g. "Data"). </ol>
				<ol>4. Make sure column is separated by comma.</ol>
				<ol>5. The total files size, image and raw data, should be smaller than 2MB. If it is larger than 2MB, you can delete all data after line 200 in the raw data file.</ol>
			    </div>
			</h4>
		    </div>
		    <div class="col-md-12 col-sm-12" style="padding-top: 1em;">
			<form name="frm1" method="post" enctype="multipart/form-data" action="upload-my-actogram-result-done?grade=<?php echo $menuGrade; ?>">
			    <table class="table">
				<thead>
        			    <tr>
					<th>Student Name</th><th>Image File</th><th>Raw Data</th>
        			    </tr>
				</thead>
				<tbody>
        			    <tr>
        				<td>
					    <select class="form-control" name='userId'>
						<option value='null'>Please Choose A Student</option>
						<?php
						include 'connectdb.php';
						$resultLink = getUserIdsInClass($classId);
			    			foreach ($resultLink as $user) {
						    list($firstName, $lastName) = getUserFirstLastNames($user);
						    echo "<option value='$user'>" . $lastName ." ". $firstName . "</option>";
			    			}
			    			mysql_close($con);
						?>
					    </select>
					</td>
					<td>
					    <input class="file_input"; type="file" name="actigraphy" />
					</td>
					<td>
					    <input class="file_input"; type="file" name="rawData" />
					</td>
				    </tr>
				</tbody>
			    </table>
			    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em;">
				<div class="row">
				    <input class="btn btn-danger btn-large btn-block"; type="submit" name="submit" value="Import" />
				</div>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	    <?php include 'partials/scripts.php' ?>
    </body>
    <?php include 'partials/footer.php' ?>
</html>
