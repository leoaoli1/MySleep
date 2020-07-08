<?php
#
# Part of the MySleep package
#
# © The University of Arizona
#
#
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
$userType = $_SESSION['userType'];
$config = $_SESSION['current_config'];
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
			<?php if ($config) {
				require_once('partials/nav-links.php');
        navigationLink($config,$userType,['linkable' => true]);
			} else {?>
        <div class="row">
			    <div class="col-xs-offset-1 col-xs-10 col-sm-10">
            <ol class="breadcrumb">
								<li><a class = "exit" data-location="main-page">Home</a></li>
                <li><a class = "exit" data-location="sleep-lesson">Lessons</a></li>
                <li><a class = "exit" data-location="fifth-grade-lesson-menu?lesson=3">Lesson Three</a></li>
								<li><a class = "exit" data-location="fifth-grade-lesson-activity-menu?lesson=3&activity=1">Activity One</a></li>
                <li class="active">Socre Submition</li>
            </ol>
			    </div>
        </div>
			<?php } ?>
	    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
		<h4 class="description">
		    <div class="row" style="color:black">
			<?php
			include 'connectdb.php';

			$result = mysql_query("SELECT * FROM fifthGradeLessonThreeTakeHome WHERE userId='$userId' Order By record DESC limit 1");
			$row = mysql_fetch_array($result);
			$score = $row['score'];
			echo "Previous Score: ".$score, "</br>";
			mysql_close($con);
			?>
		    </div>
		</h4>
	    </div>
	    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
		<form method="post" enctype="multipart/form-data" action="home-activity-score-done" style="margin-top: 2em;">
		    <div class="form-group">
			<div class="form-inline">
			    <label class="control-label" for="score"><h4 style="color:black">Socre:</h4></label>
			    <input class="form-control"; type="number" step="any" name="score" id="score" value="" </input>
			</div>
		    </div>
		    <div class="row" style="padding-top: 1cm">
		    <?php if($userType == "student"){ ?>
			<input class='btn btn-success btn-large btn-block' type='submit' name='submit' value='Submit'  />
			<?php }else{ ?>
			    <a class="btn btn-success btn-large btn-block"  name="submit" id="submit">Submit</a>
			<?php }?>
		    </div>
		</form>
	    </div>
	</div>
    </div>
    <?php include 'partials/scripts.php' ?>
</body>
<?php include 'partials/footer.php' ?>
</html>
