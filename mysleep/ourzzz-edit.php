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
	require_once('utilities-actogram.php');
	session_start();
	$userId= $_SESSION['userId'];
	$userType = $_SESSION['userType'];
	$grade = $_SESSION['grade'];
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
	$classId = $_SESSION['classId'];
	$result = mysql_query("SELECT * FROM ourzzzdata WHERE classId = $classId");
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	$titleArray = [];
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		$titleArray = [$row['durationTitle'],$row['consistencyTitle'],$row['qualityTitle']];
   }else {
		 $titleArray = ['Sleep Watch Hours of Sleep','Total Minutes Difference between shortest and longest sleep times','Sleep Watch Rating'];
   }

   mysql_close($con);

?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep <?php  echo '// '.$config['activity_title']; ?></title>
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
																<div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                  <h3>Choose Data Source</h3>
																		<!-- Nav tabs -->
		                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display: none">
		                                  <li role="presentation" class="active"><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab" id="firstTab">Sleep Duration</a></li>
		                                  <li role="presentation" ><a href="#diarygraphs" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">Sleep Consistency</a></li>
		                                </ul>

		                                <!-- Tab panes -->
		                                <div class="tab-content" style="">
																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane active" id="datagraphs">
                                        <h4>Choose one of the following category to preparing sleep profile data:</h4>
																				<h4><br><b>Sleep Duration:</b> <?php echo $titleArray[0]; ?></h4>
																				<div class="row">
																	        <div class="col-md-6">
																	  				<div class="info info-gradorange" onclick="selectCorner(0)" style="cursor: pointer;text-align: center;">
																			          <h3 class="info-title info-title-white">Sleep Diary</h3>
																	  				</div>
																	        </div>
																	        <div class="col-md-6">
																	            <div class="info info-gradbb" onclick="selectCorner(1)" style="cursor: pointer;text-align: center;">
																	  		          <h3 class="info-title info-title-white">Sleep Watch</h3>
																	    				</div>
																	        </div>
																	      </div>
																				<h4><br><b>Sleep Consistency:</b> <?php echo $titleArray[1]; ?> </h4>
																				<div class="row">
																	        <div class="col-md-6">
																	  				<div class="info info-gradbg" onclick="selectCorner(2)" style="cursor: pointer;text-align: center;">
																			          <h3 class="info-title info-title-white">Sleep Diary</h3>
																	  				</div>
																	        </div>
																	        <div class="col-md-6">
																	            <div class="info info-gradpr" onclick="selectCorner(3)" style="cursor: pointer;text-align: center;">
																	  		          <h3 class="info-title info-title-white">Sleep Watch</h3>
																	    				</div>
																	        </div>
																	      </div>
																				<h4><br><b>Sleep Quality:</b> <?php echo $titleArray[2]; ?> </h4>
																				<div class="row">
																	        <div class="col-md-6">
																	  				<div class="info info-gradorange" onclick="selectCorner(4)" style="cursor: pointer;text-align: center;">
																			          <h3 class="info-title info-title-white">Sleep Diary (Sleep Quality ratings)</h3>
																	  				</div>
																	        </div>
																	        <div class="col-md-6">
																	            <div class="info info-gradbb" onclick="selectCorner(5)" style="cursor: pointer;text-align: center;">
																	  		          <h3 class="info-title info-title-white">Sleep Watch (Awakenings)</h3>
																	    				</div>
																	        </div>
																	      </div>
																			</div>
																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane" id="diarygraphs">
                                        <h3><small id="choseTitle"></small></h3>
                                        <h4 id="choseDescription"></h4>
                                        <table id="sortedTable" class="table table-striped">
                                            <tbody name="staticBody">
                                              <tr>
                                                <td>
                                                  <div class="col-md-8">
                                                    <h5 id='datalist'>
                                                    <?php
                                                    while ($row = mysql_fetch_array($resultsSleepDiaryToShow)) {
                                                      echo number_format($row["sleepDuration"], 2, '.', '').'<br>';
                                                    }?>
                                                  </h5>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="col-md-6">
                                                    <h4><small>Range 1</small></h4>
                                                    <textarea name="answer1" id="range1" class="form-control" rows="2"><?php echo '< 6';?></textarea>
                                                    <h4><small>Range 2</small></h4>
                                                    <textarea name="answer1" id="range2" class="form-control" rows="2"><?php echo htmlspecialchars($answer1);?></textarea>
                                                    <h4><small>Range 3</small></h4>
                                                    <textarea name="answer1" id="range3" class="form-control" rows="2"><?php echo htmlspecialchars($answer1);?></textarea>
                                                    <h4><small>Range 4</small></h4>
                                                    <textarea name="answer1" id="range4" class="form-control" rows="2"><?php echo htmlspecialchars($answer1);?></textarea>
																										<h4><small>Range 5</small></h4>
                                                    <textarea name="answer1" id="range5" class="form-control" rows="2"><?php echo htmlspecialchars($answer1);?></textarea>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                        </table>
																				<input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
																				<input type="text" name="corner" value="" id="corner" style="display: none">
																				<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
                                        <div class="row">
                                            <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                                <a class="btn btn-gradpr btn-roundBold btn-large btn-block" onclick="writeData()">Save &amp; Submit</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                                <a class="btn btn-gradbb btn-roundBold btn-large btn-block" onclick="backToHome()">Back</a>
                                            </div>
                                        </div>
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
				var cornerDict = ["Sleep Duration","Sleep Duration","Sleep Consistency","Sleep Consistency","Sleep Quality","Sleep Quality"];
				var discripDict4 = [
					"The recommended duration for Grade 4 students is 9-11 hours of sleep. Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned. It also can performance in sports, behavior and relationships with others.",
					"The recommended duration for Grade 4 students is 9-11 hours of sleep. Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned. It also can performance in sports, behavior and relationships with others.",
					"All of the body systems need a regular sleep-wake schedule. Irregular and late bedtimes have effects beyond the next day. They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness. A one-hour difference between shortest and longest sleep is recommended.",
					"All of the body systems need a regular sleep-wake schedule. Irregular and late bedtimes have effects beyond the next day. They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness. A one-hour difference between shortest and longest sleep is recommended.",
					"Sleep quality is the feeling you have after you wake up. On the sleep diary, a “5” represented very sound or refreshing sleep, and a “1” indicated very restless or unrefreshing sleep. Many factors can cause poor quality sleep. These include too much noise, use of electronic devices at bedtime, drinking caffeinated beverages and many others.",
					"The sleep watch records periods of active movement during sleep as “awakenings.” The fewer the awakenings, the more restful the sleep.",
					"Wake-up state is a good measure of sleep duration, consistency and quality.  People who regularly get enough, high quality sleep wake up refreshed daily.",
				];
				var discripDict5 = [
					"The recommended duration for Grade 5 students is 9-11 hours of sleep. Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned. It also can performance in sports, behavior and relationships with others.",
					"The recommended duration for Grade 5 students is 9-11 hours of sleep. Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned. It also can performance in sports, behavior and relationships with others.",
					"All of the body systems need a regular sleep-wake schedule. Irregular and late bedtimes have effects beyond the next day. They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness. A one-hour difference between shortest and longest sleep is recommended.",
					"All of the body systems need a regular sleep-wake schedule. Irregular and late bedtimes have effects beyond the next day. They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness. A one-hour difference between shortest and longest sleep is recommended.",
					"Sleep quality is the feeling you have after you wake up. On the sleep diary, a “5” represented very sound or refreshing sleep, and a “1” indicated very restless or unrefreshing sleep. Many factors can cause poor quality sleep. These include too much noise, use of electronic devices at bedtime, drinking caffeinated beverages and many others.",
					"The sleep watch records periods of active movement during sleep as “awakenings.” The fewer the awakenings, the more restful the sleep.",
					"Wake-up state is a good measure of sleep duration, consistency and quality.  People who regularly get enough, high quality sleep wake up refreshed daily.",
				];
				var grade = <?php echo $_SESSION['classGrade']; ?>;
				if (grade == 4) {
					var discripDict = discripDict4;
				}else if (grade ==5) {
					var discripDict = discripDict5;
				}
				var dataDict = ["sleephourdiary","sleephourwatch","consistencyearlylatediary","consistencyearlylate","qualityrating","qualityawaken","qualitywakeupstate"];
				var keyword = '';
				var dataArray = [];
				$(function () {
						$("#submit-activity").click(function() {
							$( "form" ).submit();
						});
				});
				function selectCorner(corner){
					$('#corner').val(corner);
					document.getElementById('choseTitle').innerHTML = "Review and modify grouping ranges for <b>"+ cornerDict[corner] +"</b>.";
					document.getElementById('choseDescription').innerHTML = discripDict[corner];
					keyword = dataDict[corner];
					getData();
					$('#secondTab').trigger('click');
          window.scrollTo({ top: 100, behavior: 'smooth' });
	      }
        function backToHome(){
					$('#firstTab').trigger('click');
          window.scrollTo({ top: 100, behavior: 'smooth' });
	      }
				function writeData(){
					var range = $('#range1').val() + ';' + $('#range2').val() + ';' + $('#range3').val() + ';' + $('#range4').val() + ';' + $('#range5').val();
					console.log(keyword);
						$.ajax({
							type: "post",
							url: "ourzzz-edit-done",
							dataType: 'json',
							data: {
								keyword: keyword,
								dataArray: dataArray,
								range: range
							},
							success: function (response) {
								location.reload();
								// $('#firstTab').trigger('click');
								console.log('success');
								console.log(response);
							}
						});
				}
				function getData(){
							$.ajax({
								type: "post",
								url: "ourzzz-edit-process",
								dataType: 'json',
								data: {content:keyword},
								success: function (response) {
									console.log(response.result);
									dataArray = response.result;
									var content = '';
									for (var i = 0; i < response.result.length; i++) {
										// var num = parseFloat(response.result[i])
										content = content + response.result[i] + '<br>';
									}
									for (var i = 0; i < response.range.length; i++) {
										if (i==0) {
											$('#range1').val(response.range[i]);
										}
										if (i==1) {
											$('#range2').val(response.range[i]);
										}
										if (i==2) {
											$('#range3').val(response.range[i]);
										}
										if (i==3) {
											$('#range4').val(response.range[i]);
										}
										if (i==4) {
											$('#range5').val(response.range[i]);
										}

									}
									document.getElementById('datalist').innerHTML = content +"<br>";
								}
							});
				 }
		</script>
</html>
