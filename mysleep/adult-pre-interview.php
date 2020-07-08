<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#					Siteng Chen <sitengchen@email.arizona.edu>
#
	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
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
	$result =mysql_query("SELECT * FROM fourthGradeLessonOnePreInterview WHERE userId='$userId'");
	$numRow = mysql_num_rows($result);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['interviewSubject'])) {
		   $prepInterviewSubject = $row['interviewSubject'];
		}
        if (isset($row['interviewSubjectOther'])){
            $prepInterviewSubjectOther = $row['interviewSubjectOther'];
        }
        if (isset($row['subjectResponse'])){
            $prepInterviewSubjectSleep = $row['subjectResponse'];
        }
   }else {
   	    $prepInterviewSubject = "";
        $prepInterviewSubjectOther = "";
        $prepInterviewSubjectSleep = "";
   }

	$result =mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterviewQuestions WHERE userId='$userId'");
 	$numRow = mysql_num_rows($result);
 	if ($numRow>0) {
 		$row = mysql_fetch_array($result);

		$questionsInsert = "";
		for ($i=4; $i<9 ; $i++) {
			$name = "Q" . trim($i);
			$ques = $row[$name];
			if (strlen($ques)) {
				$questionsInsert .= "<tr><td><div class='form-group' style='padding:0;margin:0;'><input type='text'  class='form-control input-lg' name='question[]' value='" . $ques . "'></div></td></tr>";
			}
		}
	}

   mysql_close($con);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Preparing to Interview</title>
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
																<li><a class = "exit" data-location="fourth-grade-lesson-activity-menu?lesson=1">Activity One</a></li>
																<li><a class = "exit" data-location="fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=prepare">Part Four</a></li>

																<li class="active">Preparing to Interview</li>
                            </ol>
                        </div>
                    </div>
										<?php } ?>
                    <form action="adult-pre-interview-done" method="post">
	                      <input type="text" id="query" name="query" value="<?php echo $query; ?>" style="display: None">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                                <h4>Preparing to interview an adult<br><small>Answer the questions below about an adult you hope to interview.</small></h4>
                                <div class="form-group">
                                    <label for="prepInterviewSubject">Who is it that you want to interview?</label>
                                    <select class="form-control" name="prepInterviewSubject" id="prepInterviewSubject">
                                        <option value="" <?php echo ($prepInterviewSubject=="")? 'selected': '' ?>>Select One...</option>
                                        <option value="1" <?php echo ($prepInterviewSubject=="1")? 'selected': '' ?>>Mother</option>
                                        <option value="2" <?php echo ($prepInterviewSubject=="2")? 'selected': '' ?>>Father</option>
                                        <option value="3" <?php echo ($prepInterviewSubject=="3")? 'selected': '' ?>>Guardian</option>
                                        <option value="4" <?php echo ($prepInterviewSubject=="4")? 'selected': '' ?>>Grandparent</option>
                                        <option value="5" <?php echo ($prepInterviewSubject=="5")? 'selected': '' ?>>Other Adult</option>
                                    </select>
                                </div>
                                <div class="form-group" id="otherIntervieweeType">
                                    <label>Okay, someone else.  How are they related to you?</label>
                                    <input type="text" name="prepInterviewSubjectOther" id="prepInterviewSubjectOther" value="<?php echo htmlspecialchars($prepInterviewSubjectOther);?>" placeholder="Relationship" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="prepInterviewSubjectSleep">How do you think this person will respond when you ask them, "Do you get enough sleep?"</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="prepInterviewSubjectSleep" value="1" <?php echo ($prepInterviewSubjectSleep==1)? 'checked': '' ?>> Almost always
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="prepInterviewSubjectSleep" value="2" <?php echo ($prepInterviewSubjectSleep==2)? 'checked': '' ?>> Most of the time
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="prepInterviewSubjectSleep" value="3" <?php echo ($prepInterviewSubjectSleep==3)? 'checked': '' ?>> Sometimes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="prepInterviewSubjectSleep" value="4" <?php echo ($prepInterviewSubjectSleep==4)? 'checked': '' ?>> Not very often
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="prepInterviewSubjectSleep" value="5" <?php echo ($prepInterviewSubjectSleep==5)? 'checked': '' ?>> Hardly ever
                                        </label>
                                    </div>
                                </div>
																<div class="form-group">
																		<h4>Your interview will include these three questions:</h4>
																		<table class="table">
																				<tbody>
																						<tr><td><label>Do you get enough sleep?</label></td></tr>
																						<tr><td><label>What are some things that help you get a good night's sleep?</label></td></tr>
																						<tr><td><label>What are some things that keep you from getting a good night's sleep?</label></td></tr>
																				</tbody>
																		</table>
																</div>
																<div class="form-group">
																		<h4>Are there other questions about sleep you would like to ask?  If so, type one or more questions below.</h4>
																		<div class="form-group">
																				<h4>Write your question in the space below.  Then click <B>Submit</B>.</h4>
																				<table class="table" id="suppQuestions">
																						<tbody>
																								<?php
																								if(isset($questionsInsert)){
																									echo $questionsInsert;
																								} else {
																									echo '<tr><td><div class="form-group" style="padding:0;margin:0;"><input type="text"  class="form-control input-lg" name="question[]" /></div></td></tr>';
																								}
																								 ?>
																						</tbody>
																				</table>
																		</div>
																		<!-- <a id="addRow" class="btn btn-gradbb btn-roundThin">Add New Question</a> -->
																</div>
                            </div>
                        </div>
											<?php if($_SESSION['userType']=="student"){ ?>
												<div class="row">
													<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
															<a class="btn btn-gradpr btn-roundThin btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Submit</a>
													</div>
												</div>
			    						<?php }else{ ?>
												<div class="row">
													<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
														<a class="btn btn-gradpr btn-roundThin btn-large btn-block">Submit</a>
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
        <h4 class="modal-title" id="submit-modal-label">Do you want to add another question? </h4>
      </div>
      <div class="modal-body">
        If yes, select <B>Yes, add new question</B>. If no, select <B>No, save and submit</B>.
      </div>
      <div class="modal-footer">
        <button id="addRow" type="button" class="btn btn-warning btn-simple" data-dismiss="modal"><B>Yes, add new question</B></button>
        <button id="submit-activity" type="button" class="btn btn-success btn-simple"><B>No, save and submit</B></button>
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

						$("#addRow").click(function() {
							$('#suppQuestions tr:last').after('<tr><td><div class="form-group" style="padding:0;margin:0;"><input type="text"  class="form-control input-lg" name="question[]" /></div></td></tr>');
						});

            if ($("#prepInterviewSubjectOther").val() != ""){
               $("#otherIntervieweeType").show();
            }
            else{
                $("#otherIntervieweeType").hide();
            }

            $('#prepInterviewSubject').on('change',function(){
                if( $(this).val()==="5"){
                    $("#otherIntervieweeType").slideDown();
                }
                else{
                    $("#otherIntervieweeType").slideUp();
                    $("#prepInterviewSubjectOther").val("");
                }
            });
             });
</script>

    </html>
