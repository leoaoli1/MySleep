<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$userType = $_SESSION['userType'];
	if ($userId == ""){
	    header("Location: login");
	    exit;
	}
	$lessonNum = $_GET['lesson'];
	$activityNum = $_GET['activity'];
	$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
	$query = $_SERVER['QUERY_STRING'];
	unset($_SESSION['current_config']);
	$_SESSION['current_config'] = $config;

    // If data has already been saved for this student, place it in the body.
	include 'connectdb.php';
	if ($config) {
		$result =mysql_query("SELECT * FROM fourthGradeLessonDoAnimalSleep WHERE contributors LIKE '%$userId%' ORDER BY resultRow DESC LIMIT 1");
	}else {
		$result =mysql_query("SELECT * FROM fourthGradeLessonDoAnimalSleep WHERE userId='$userId'");
	}
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	$agree = -1;
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['response'])) {
		   $content = $row['response'];
		}
		if (isset($row['agree'])) {
		   $agree = $row['agree'];
		}
		$_SESSION['current_work'] = $row;
	  $resultRow = $row['resultRow'];
   }else {
   	$content = "";
		$resultRow = -1;
   }
   mysql_close($con);
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
            <title>MySleep // <?php echo $config['activity_title']; ?></title>
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
                                    <li class="active">Do all animals sleep?</li>
                                </ol>
                            </div>
                        </div>
												<?php } ?>

												<form action="do-animal-sleep-done" method="post">

													<!-- Nav tabs -->
													<ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none;">
														<li role="presentation" class="active"><a href="#firstPage" aria-controls="firstPage" role="tab" data-toggle="tab" id = "tab1">1</a></li>
														<li role="presentation" ><a href="#secondPage" aria-controls="secondPage" role="tab" data-toggle="tab" id = "tab2">2</a></li>
													</ul>
													<!-- Tab panes -->
													<div class="tab-content" style="">
														<!-- Tab panes -->
														<div role="tabpanel" class="tab-pane active" id="firstPage">
															<div class="row">
																	<div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
																		<?php include 'add-group-member-button.php' ?>
		                                  <h4>Do all animals sleep?</h4>
																			<div class="text-center">
					                                <ul class="nav nav-pills nav-pills-info btn-group" role="tablist" data-toggle="buttons">
					                                    <li onclick='<?php echo ($userType==teacher)?"":"selectCorner(1)" ?>' style="cursor: pointer;text-align: center;">
					                                        <a role="tab" data-toggle="tab"> <i class="material-icons">check_circle</i> Yes</a>
					                                    </li>
					                                    <li onclick='<?php echo ($userType==teacher)?"":"selectCorner(0)" ?>' style="cursor: pointer;text-align: center;">
					                                        <a role="tab" data-toggle="tab"> <i class="material-icons">cancel</i> No</a>
					                                    </li>
					                                </ul>
					                            </div>
																	</div>
	                            </div>
														</div>
														<!-- Tab panes -->
														<div role="tabpanel" class="tab-pane" id="secondPage">
															<div class="row">
																	<div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
		                                  <h4>What evidence do you have for your answer?</h4>
		                                  <textarea name="doAnimalSleep" id="doAnimalSleep" class="form-control" rows="10" placeholder="Enter, save and submit"><?php echo htmlspecialchars($content);?></textarea>
																	</div>
	                            </div>
															<input type="text" name="selection" value="" id="selection" style="display: none">
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
														</div>
													</div>


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
		function selectCorner(selection){
			$('#selection').val(selection);
			$( "form" ).submit();
			// document.getElementById('choseTitle').innerHTML = "Why you chose <b>"+ cornerDict[corner] +"</b>? Write down some examples.";
			// $('#tab2').trigger('click')
			// window.scrollTo({ top: 100, behavior: 'smooth' });
		}
        $(function () {
            $("#exit-activity").click(function(){
                window.window.location.href = "fourth-grade-lesson-menu?lesson=1";
            });
            $("#submit-activity").click(function() {

});

             });
</script>

    </html>
