<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu> Siteng Chen <sitengchen@email.arizona.edu>
#
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$userType = $_SESSION['userType'];
	if ($userId == ""){
	    header("Location: login");
	    exit;
	}
  $grade = getCurrentGrade($userId);
	$lessonNum = $_GET['lesson'];
	$activityNum = $_GET['activity'];
	$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
	$query = $_SERVER['QUERY_STRING'];
	unset($_SESSION['current_config']);
	$_SESSION['current_config'] = $config;

    // If data has already been saved for this student, place it in the body.
	include 'connectdb.php';
	if ($config) {
		$result =mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$userId' and grade='$grade' Order by id Desc Limit 1");
	}else {
		$result =mysql_query("SELECT * FROM fifthGradeLessonTwoProfile WHERE userId='$userId' and grade='$grade' Order by id Desc Limit 1");
	}
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['response'])) {
		   $content = $row['response'];
		}
		$_SESSION['current_work'] = $row;
	  $resultRow = $row['id'];
   }else {
   	$content = "";
		$resultRow = -1;
   }
   mysql_close($con);
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
            <title>MySleep // What Is Sleep?</title>
    </head>
		<?php include 'partials/scripts.php' ?>
    <body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
											<?php if ($config){
	                      require_once('partials/nav-links.php');
	                      navigationLink($config,$userType);
	                    } else {
	                    ?>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <ol class="breadcrumb">
                                    <li><a class = "exit" data-location="main-page">Home</a></li>
                                <li><a class = "exit" data-location="sleep-lesson">Lessons</a></li>
                                <li><a class = "exit" data-location="fourth-grade-lesson-menu?lesson=1">Activities</a></li>
                                    <li class="active">What is Sleep?</li>
                                </ol>
                            </div>
                        </div>
												<?php } ?>

												<form action="predict-sleep-profile-done" method="post">
                            <div class="row">
																<div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
	                                  <h4>Z-Identity<br><small>Think about your personal sleep habits in relationship to the profiles of the students you have reviewed. In the box below, write your own sleep profile. Include information on the your sleep duration, consistency and quality and how they might be affecting your daily activities.</small></h4>
																		<?php include 'add-group-member-button.php' ?>
	                                  <textarea name="prediction" id="prediction" class="form-control" rows="10"><?php echo htmlspecialchars($content);?></textarea>
																</div>
                            </div>
														<input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
														<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
														<?php if($_SESSION['userType']=="student"){ ?>
																<div class="row">
																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
																				<button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
																    </div>
																</div>
																<div class="row">
																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
																				<a class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
																    </div>
																</div>
															    <?php }else{?>
																<div class="row">
																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
																				<a class="btn btn-gradbg btn-roundBold btn-large btn-block">Save</a>
																    </div>
																</div>
																<div class="row">
																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
																				<a class="btn btn-gradpr btn-roundBold btn-large btn-block">Save &amp; Submit</a>
																    </div>
																</div>
												    <?php } ?>

                        </form>
                    </div>
                </div>
            </div>
						                <!-- Submit Modal -->
						<div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
						      </div>
						      <div class="modal-body">
						        Are you ready to submit your work to your teacher?
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
						        <button id="submit-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
						      </div>
						    </div>
						  </div>
						</div>
        <?php include 'partials/footer.php' ?>
    </body>

    <script>
        $(function () {
            $("#exit-activity").click(function(){
                window.window.location.href = "fourth-grade-lesson-menu?lesson=1";
            });
            $("#submit-activity").click(function() {
  $( "form" ).submit();
});

             });
</script>

    </html>
