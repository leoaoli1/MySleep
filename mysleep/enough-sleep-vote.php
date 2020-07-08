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
	$userType = $_SESSION['userType'];
	if ($userId == ""){
	    header("Location: login");
	    exit;
	}

    // If data has already been saved for this student, place it in the body.
	include 'connectdb.php';
	$result =mysql_query("SELECT * FROM fourthGradeLessonOneSleepVote WHERE userId='$userId'");
	$numRow = mysql_num_rows($result);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['vote'])) {
		   $content = $row['vote'];
		}
   }else {
   	$content = "";
   }

	 $lessonNum = $_GET['lesson'];
	 $activityNum = $_GET['activity'];
	 $config = getActivityConfigWithNumbers($lessonNum, $activityNum);
	 $query = $_SERVER['QUERY_STRING'];
	 unset($_SESSION['current_config']);
	 $_SESSION['current_config'] = $config;

   mysql_close($con);
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg')">

    <head>
        <?php include 'partials/header.php' ?>
            <title>MySleep // Enough Sleep Voting</title>
    </head>
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
																<li><a class = "exit" data-location="fourth-grade-lesson-activity-menu?lesson=1&activity=1">Activity One</a></li>
																<?php if($userType == 'teacher'){ ?>
																	<li><a class = "exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=sleepVote">Part Three</a></li>
																<?php } ?>
                                    <li class="active">Enough Sleep Voting</li>
                                </ol>
                            </div>
                        </div>
												<?php } ?>
                        <form action="enough-sleep-vote-done" method="post">
			                      <input type="text" id="query" name="query" value="<?php echo $query; ?>" style="display: none">
                            <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                            <h4>People do not get enough sleep.<br><br><small>Decide whether you agree, disagree, or are unsure. Click to record your response.</small></h4>
                            <br>
                            <div class="text-center">
                                <ul class="nav nav-pills nav-pills-info btn-group" role="tablist" data-toggle="buttons">
                                    <li class="btn <?php echo ($content==1)?'active':'' ?>">
                                        <a href="#dashboard" role="tab" data-toggle="tab"> <i class="material-icons">check_circle</i> Agree
                                            <input type="radio" name="enoughSleepVote" value="1" autocomplete="off" <?php echo ($content==1)? 'checked': '' ?>> </a>
                                    </li>
                                    <li class="btn <?php echo ($content==2)?'active':'' ?>">
                                        <a href="#schedule" role="tab" data-toggle="tab"> <i class="material-icons">cancel</i> Disagree
                                            <input type="radio" name="enoughSleepVote" value="2" autocomplete="off" <?php echo ($content==2)? 'checked': '' ?>> </a>
                                    </li>
                                    <li class="btn <?php echo ($content==3)?'active':'' ?>">
                                        <a href="#schedule" role="tab" data-toggle="tab"> <i class="material-icons">help</i> Unsure
                                            <input type="radio" name="enoughSleepVote" value="3" autocomplete="off" <?php echo ($content==3)? 'checked': '' ?>> </a>
                                    </li>
                                </ul>
                            </div>
                                </div>
															</div>
											<?php if($_SESSION['userType']=="student"){ ?>
                            <div class="row">
	                            <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
	                                <a class="btn btn-gradpr btn-roundThin btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
	                            </div>
                            </div>
											<?php }else{?>
                            <div class="row">
															<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                                <a class="btn btn-gradpr btn-roundThin btn-large btn-block">Save &amp; Submit</a>
															</div>
                            </div>
			    						<?php } ?>
                        </form>
                </div>
            </div>
            <!-- Exit Modal -->
<div class="modal fade" id="exit-modal" tabindex="-1" role="dialog" aria-labelledby="exit-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="exit-modal-label">Exit the Activity?</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to exit the activity without saving your work?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
        <button id="exit-activity" type="button" class="btn btn-danger btn-simple">Exit</button>
      </div>
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
    <?php include 'partials/scripts.php' ?>
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
