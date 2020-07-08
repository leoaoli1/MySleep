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
		$result =mysql_query("SELECT * FROM fourthGradeFourCorner WHERE contributors LIKE '%$userId%' ORDER BY resultRow DESC LIMIT 1");
	}else {
		$result =mysql_query("SELECT * FROM fourthGradeFourCorner WHERE userId='$userId' ORDER BY resultRow DESC LIMIT 1");
	}

	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['answer1'])) {
		   $answer1 = $row['answer1'];
			 $answer2 = $row['answer2'];
			 $answer3 = $row['answer3'];
		}

		$_SESSION['current_work'] = $row;
		$resultRow = $row['resultRow'];
   }else {
   	$answer1 ="";
		$answer2 ="";
		$answer3 ="";
		$resultRow = -1;
   }
   mysql_close($con);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Four Corner Discuss</title>
    </head>
		<?php include 'partials/scripts.php' ?>
<body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
												<?php
												require_once('partials/nav-links.php');
												navigationLink($config,$userType);
												 ?>
                        <form action="fourcorner-done" method="post">
                            <div class="row">
																<div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
																		<?php include 'add-group-member-button.php' ?>
																		<!-- Nav tabs -->
		                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none;">
		                                  <li role="presentation" class="active"><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">1</a></li>
		                                  <li role="presentation" ><a href="#diarygraphs" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">2</a></li>
		                                </ul>

		                                <!-- Tab panes -->
		                                <div class="tab-content" style="">
																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane active" id="datagraphs">

			                                  <h4>What has the biggest effect on your sleep?<br><small>Each of the squares represents a category of causes that affect sleep.   Vote for the category that has the biggest effect on your sleep by selecting a square.  Your teacher will show the votes for each.</small><br></h4>

																				<div class="row">
																	        <div class="col-xs-6 col-md-5">
																	  				<div class="info info-gradorange" onclick="selectCorner(0)" style="cursor: pointer;text-align: center;">
																			          <h3 class="info-title info-title-white">Physical Wellness</h3>
																	  				</div>
																	        </div>
																	        <div class="col-xs-6 col-md-offset-2 col-md-5">
																	            <div class="info info-gradbb" onclick="selectCorner(1)" style="cursor: pointer;text-align: center;">
																	  		          <h3 class="info-title info-title-white">Daytime Activities</h3>
																	    				</div>
																	        </div>
																	      </div>
																				<div class="row">
																	        <div class="col-xs-6 col-md-offset-3 col-md-5">
																	  				<div class="info info-gradbg" onclick="selectCorner(2)" style="cursor: pointer;text-align: center;">
																			          <h3 class="info-title info-title-white">Room Environment</h3>
																	  				</div>
																	        </div>
																	      </div>
																			</div>
																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane" id="diarygraphs">

																				<h4><small id="choseTitle">Meet with the others who chose the same square. Discuss the factors and come to an agreement on the 3 factors in the category that most affect your sleep. Choose one student in each group to record the group's decision.
																					</small></h4>
			                                  <textarea name="answer1" id="answer1" class="form-control" rows="1"><?php echo htmlspecialchars($answer1);?></textarea>
																				<textarea name="answer2" id="answer2" class="form-control" rows="1"><?php echo htmlspecialchars($answer2);?></textarea>
																				<textarea name="answer3" id="answer3" class="form-control" rows="1"><?php echo htmlspecialchars($answer3);?></textarea>
																				<input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
																				<input type="text" name="corner" value="" id="corner" style="display: none">
																				<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
																				<?php if($_SESSION['userType']=="student"){ ?>
																						<!-- <div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
																						    </div>
																						</div> -->
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<a class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
																						    </div>
																						</div>
																					    <?php }else{?>
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<a class="btn btn-gradbg btn-roundBold btn-large btn-block">Save</a>
																						    </div>
																						</div>
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<a class="btn btn-gradpr btn-roundBold btn-large btn-block">Save &amp; Submit</a>
																						    </div>
																						</div>
																		    <?php } ?>
																			</div>
																		</div>




																		<!-- <h4><small>Why you chose it? Write down some examples.</small></h4>
	                                  <textarea name="answer1" id="answer1" class="form-control" rows="4"><?php echo htmlspecialchars($answer1);?></textarea> -->

																		<!-- <h4><small>Factor 2</small></h4>
																		<textarea name="answer2" id="answer2" class="form-control" rows="4"><?php echo htmlspecialchars($answer2);?></textarea>

																		<h4><small>Factor 3</small></h4>
																		<textarea name="answer3" id="answer3" class="form-control" rows="4"><?php echo htmlspecialchars($answer3);?></textarea> -->

																</div>
                            </div>


                        </form>

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
				var cornerDict = ["Physical Wellness","Daytime Activities","Room Environment","Other"];
				$(function () {
						$("#submit-activity").click(function() {
							$( "form" ).submit();
						});
				});
				function selectCorner(corner){
					$('#corner').val(corner);
					// document.getElementById('choseTitle').innerHTML = "Meet with the others who chose the same square.   Discuss and then record one or more examples that tell how <b>"+ cornerDict[corner] +"</b> affected your sleep.";
					$('#secondTab').trigger('click')
          window.scrollTo({ top: 100, behavior: 'smooth' });
	      }
		</script>
</html>
