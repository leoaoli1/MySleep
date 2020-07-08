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
	$classGrade = $_SESSION['classGrade'];
	$lessonNum = $_GET['lesson'];
	$activityNum = $_GET['activity'];
	$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
	$query = $_SERVER['QUERY_STRING'];
	unset($_SESSION['current_config']);
	$_SESSION['current_config'] = $config;

	$DescripDict = array(
    "Average Sleep Duration (Sleep Diary)" => "The recommended duration for Grade ".$classGrade." students is 9-11 hours of sleep. Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned. It also can performance in sports, behavior and relationships with others.",
    "Average Sleep Duration (Sleep Watch)" => "The recommended duration for Grade ".$classGrade." students is 9-11 hours of sleep. Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned. It also can performance in sports, behavior and relationships with others.",
		"Total Minutes Difference between shortest and longest sleep times" => "All of the body systems need a regular sleep-wake schedule.  Irregular and late bedtimes have effects beyond the next day.  They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness. A one-hour difference between shortest and longest sleep is recommended.",
		"Total Minutes Difference between earliest and latest bedtimes" => "All of the body systems need a regular sleep-wake schedule.  Irregular and late bedtimes have effects beyond the next day.  They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness.",
		"Sleep Diary (Sleep Quality ratings)" => "Sleep quality is the feeling you have after you wake up. On the sleep diary, a “5” represented very sound or refreshing sleep, and a “1” indicated very restless or unrefreshing sleep. Many factors can cause poor quality sleep. These include too much noise, use of electronic devices at bedtime, drinking caffeinated beverages and many others. It should be a goal to achieve a Sleep Quality of 4 or 5 every night.",
		"Sleep Watch (Awakenings)" => "The sleep watch records periods of active movement during sleep as “awakenings.” The fewer the awakenings, the more restful the sleep.",
		"Wake-up State" => "Wake-up state is a good measure of sleep duration, consistency and quality.  People who regularly get enough, high quality sleep wake up refreshed daily.",
	);
    // If data has already been saved for this student, place it in the body.
  include 'connectdb.php';
	if ($config) {
		$result =mysql_query("SELECT * FROM ourzzz WHERE contributors LIKE '%$userId%' ORDER BY resultRow DESC LIMIT 1");
	}else {
		$result =mysql_query("SELECT * FROM ourzzz WHERE userId='$userId' ORDER BY resultRow DESC LIMIT 1");
	}



	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		// durationCount, durationDescript, consistencyCount, consistencyDescript, qualityCount, qualityDescript
		$answer1c = explode(',',$row['durationCount']);
		$answer1d = $row['durationDescript'];
		$answer2c = explode(',',$row['consistencyCount']);
		$answer2d = $row['consistencyDescript'];
		$answer3c = explode(',',$row['qualityCount']);
		$answer3d = $row['qualityDescript'];

		$_SESSION['current_work'] = $row;
		$resultRow = $row['resultRow'];
   }else {
		 $answer1c = explode(',',',,,,');
 		$answer1d = "";
 		$answer2c = explode(',',',,,,');
 		$answer2d = "";
 		$answer3c = explode(',',',,,,');
 		$answer3d = "";
		$resultRow = -1;
   }
	 $classId = $_SESSION['classId'];
	 $dataResult =mysql_query("SELECT * FROM ourzzzdata WHERE classId=$classId");
	 $data = mysql_fetch_array($dataResult);
   mysql_close($con);


?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep <?php  echo '// '.$config['activity_title']; ?></title>
    </head>
    <!-- CSS start -->
    <style type="text/css">
    .parent_div{
      width:100%;
      border:1px solid red;
      margin-right:10px;
      float:left;
    }
    .child_div_1{
      float:left;
      margin-right:5px;
    }
    </style>
    <!-- CSS end -->
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
                        <form action="ourzzz-done" method="post">
                            <div class="row">
																<div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">

																		<!-- Nav tabs -->
		                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
		                                  <li role="presentation" class="active"><a href="#Duration" aria-controls="Duration" role="tab" data-toggle="tab" id="firstTab">Sleep Duration</a></li>
		                                  <li role="presentation" ><a href="#Consistency" aria-controls="Consistency" role="tab" data-toggle="tab" id = "secondTab">Sleep Consistency</a></li>
                                      <li role="presentation" ><a href="#Quality" aria-controls="Quality" role="tab" data-toggle="tab" id = "thirdTab">Sleep Quality</a></li>
		                                </ul>
																		<h3>How well does our class sleep?</h3>
																		<h3><small>
																			For each tab at the top of the page you will find your class’s data for one of the sleep variables. The table below shows several categories related to the sleep variable.  Use the class data list on the left to find out how many in your class fit into each category.   Count and record the number in the boxes in the table.
																			Save and submit before selecting another tab.
																		</small></h3>
																		<?php include 'add-group-member-button.php' ?>
		                                <!-- Tab panes -->
		                                <div class="tab-content" style="">
																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane active" id="Duration">
																				<h4 class="text-center"> <?php echo $data['durationTitle']; ?> </h4>
																					<!-- <a class="btn btn-sm btn-block" id='export' href="#">Create My File</a> -->
																				<table id="sortedTable" class="table table-striped">
																					<col width="30%">
																					<col width="70%">
                                            <tbody name="staticBody">
                                              <tr>
                                                <td align="center">
                                                    <h5 id='datalist'>
	                                                    <?php
																											foreach (explode(';',$data['duration']) as $duration) {
				                                              	echo $duration.' <br>';
				                                              }
																											?>
                                                  	</h5>
                                                </td>
                                                <td>
																										<?php $range = explode(';', $data['durationRange']); ?>
																										<a href="#" class="export" id="duration">Export duration data table</a>
																										<table id="durationTable" style="width:100%; border: 1px solid black;">

																												<col width="40%">
																												<col width="60%">
																												<tr>
																											    <td colspan="2" style="text-align:center;"><B><?php echo $data['durationTitle']; ?></B></td>
																											  </tr>
																												<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[0]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input11'><textarea name="answer11" id="range11" class="form-control" rows="1"><?php echo $answer1c[0]; ?> </textarea></div></td></tr>
																												<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[1]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input12'><textarea name="answer12" id="range12" class="form-control" rows="1"><?php echo $answer1c[1]; ?> </textarea></div></td></tr>
																												<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[2]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input13'><textarea name="answer13" id="range13" class="form-control" rows="1"><?php echo $answer1c[2]; ?> </textarea></div></td></tr>
																												<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[3]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input14'><textarea name="answer14" id="range14" class="form-control" rows="1"><?php echo $answer1c[3]; ?> </textarea></div></td></tr>
																												<?php if (strlen($range[4])>0): ?>
																												<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[4]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input15'><textarea name="answer15" id="range15" class="form-control" rows="1"><?php echo $answer1c[4]; ?> </textarea></div></td></tr>
																												<?php endif; ?>
																										</table>
                                                </td>
                                              </tr>
                                            </tbody>
                                        </table>
																				<h4>
																					<p>
																						The recommended duration for Grade <?php echo $classGrade; ?> students is 9-11 hours of sleep.
																						Getting less than 8 hours nightly makes it more difficult for students to focus in class and remember what is learned.
																						It also can affect performance in sports, behavior and relationships with others.
																					</p>
																					<p>
																						Describe your class’s sleep duration using words like: few, some, most to tell how many are in each category.
																					</p>
																				</h4>
			                                  <textarea name="answer1d" id="answer1d" class="form-control" rows="4"><?php echo htmlspecialchars($answer1d);?></textarea>
																				<input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
																				<input type="text" name="corner" value="" id="corner" style="display: none">
																				<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
																				<?php if($_SESSION['userType']=="student"){ ?>
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
																						    </div>
																						</div>
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<button class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal" name="durationSubmit">Save &amp; Submit</button>
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


																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane" id="Consistency">
																				<h4 class="text-center"> <?php echo $data['consistencyTitle']; ?> </h4>
																				<table id="sortedTable" class="table table-striped">
																					<col width="30%">
																					<col width="70%">
                                            <tbody name="staticBody">
                                              <tr>
                                                <td align="center">
                                                    <h5 id='datalist'>
	                                                    <?php
																											foreach (explode(';',$data['consistency']) as $duration) {
				                                              	echo number_format($duration, 0, '.', '').' mins <br>';
				                                              }
																											?>
                                                  	</h5>
                                                </td>
                                                <td>
																										<?php $range = explode(';', $data['consistencyRange']); ?>
																										<a href="#" class="export" id="consistency">Export consistency data table</a>
																										<table id="consistencyTable" style="width:100%; border: 1px solid black;">
																											<tr>
																												<td colspan="2" style="text-align:center;"><B><?php echo $data['consistencyTitle']; ?></B></td>
																											</tr>
																											<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[0]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input21'><textarea name="answer21" id="range21" class="form-control" rows="1"><?php echo $answer2c[0]; ?> </textarea></div></td></tr>
																											<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[1]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input22'><textarea name="answer22" id="range22" class="form-control" rows="1"><?php echo $answer2c[1]; ?> </textarea></div></td></tr>
																											<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[2]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input23'><textarea name="answer23" id="range23" class="form-control" rows="1"><?php echo $answer2c[2]; ?> </textarea></div></td></tr>
																											<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[3]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input24'><textarea name="answer24" id="range24" class="form-control" rows="1"><?php echo $answer2c[3]; ?> </textarea></div></td></tr>
																											<?php if (strlen($range[4])>0): ?>
																											<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[4]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input25'><textarea name="answer25" id="range25" class="form-control" rows="1"><?php echo $answer2c[4]; ?> </textarea></div></td></tr>
																											<?php endif; ?>
																										</table>
                                                </td>
                                              </tr>
                                            </tbody>
                                        </table>
																				<h4>
																					<p>
																						All of the body systems need a regular sleep-wake schedule.
																						Irregular and late bedtimes have effects beyond the next day. They make it more difficult to fall asleep and wake up at the right times and affect daytime alertness.
																						A one-hour difference between shortest and longest sleep is recommended.
																					</p>
																					<p>
																						Describe your class’s sleep consistency using words like: few, some, most to tell how many are in each category.
																					</p>
																				</h4>
			                                  <textarea name="answer2d" id="answer2d" class="form-control" rows="4"><?php echo htmlspecialchars($answer2d);?></textarea>
																				<!-- <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
																				<input type="text" name="corner" value="" id="corner" style="display: none">
																				<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none"> -->
																				<?php if($_SESSION['userType']=="student"){ ?>
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
																						    </div>
																						</div>
																						<div class="row">
																						    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																										<button class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal" name="consistencySubmit">Save &amp; Submit</button>
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

																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane" id="Quality">

																						<!-- <h3>Sleep Quality</h3>
																						<h4><small><?php echo $DescripDict[$data['qualityTitle']];?></small></h4> -->
																						<h4 class="text-center"> <?php echo $data['qualityTitle']; ?> </h4>
																						<table id="sortedTable" class="table table-striped">
																							<col width="30%">
																							<col width="70%">
		                                            <tbody name="staticBody">
		                                              <tr>
		                                                <td align="center">
		                                                    <h5 id='datalist'>
			                                                    <?php
																													foreach (explode(';',$data['quality']) as $duration) {
																														if ($data['qualityTitle'] == 'Sleep Watch Rating') {
																															echo number_format($duration, 0, '.', '').'%<br>';
																														}else {
																															echo number_format($duration, 2, '.', '').'<br>';
																														}
						                                              }
																													if ($data['qualityTitle'] == 'Sleep Diary (Sleep Quality ratings)') {
																														echo '<br>(1)Very restless<br>(2)Restless<br>(3)Fair quality<br>(4)Sound<br>(5)Very sound';
																													}
																													?>
		                                                  	</h5>
		                                                </td>
		                                                <td>
																												<?php $range = explode(';', $data['qualityRange']); ?>
																												<a href="#" class="export" id="quality">Export quality data table</a>
																												<table id="qualityTable" style="width:100%; border: 1px solid black;">
																													<tr>
																														<td colspan="2" style="text-align:center;"><B><?php echo $data['qualityTitle']; ?></B></td>
																													</tr>
																													<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[0]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input31'><textarea name="answer31" id="range31" class="form-control" rows="1"><?php echo $answer3c[0]; ?> </textarea></div></td></tr>
																													<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[1]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input32'><textarea name="answer32" id="range32" class="form-control" rows="1"><?php echo $answer3c[1]; ?> </textarea></div></td></tr>
																													<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[2]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input33'><textarea name="answer33" id="range33" class="form-control" rows="1"><?php echo $answer3c[2]; ?> </textarea></div></td></tr>
																													<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[3]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input34'><textarea name="answer34" id="range34" class="form-control" rows="1"><?php echo $answer3c[3]; ?> </textarea></div></td></tr>
																													<?php if (strlen($range[4])>0): ?>
																													<tr style="border: 1px solid black;"><td align="center" style="border: 1px solid black;"><h4><small> <?php echo $range[4]; ?> </small></h4></td><td><div class="col-md-10 col-md-offset-1" id='input35'><textarea name="answer35" id="range35" class="form-control" rows="1"><?php echo $answer3c[4]; ?> </textarea></div></td></tr>
																													<?php endif; ?>
																												</table>
		                                                </td>
		                                              </tr>
		                                            </tbody>
		                                        </table>

																						<h4>
																							<p><?php echo $DescripDict[$data['qualityTitle']]; ?>
																							</p>
																							<p>
																								Describe your class’s sleep quality using words like: few, some, most to tell how many are in each category.
																							</p>
																						</h4>
					                                  <textarea name="answer3d" id="answer3d" class="form-control" rows="4"><?php echo htmlspecialchars($answer3d);?></textarea>
																						<!-- <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
																						<input type="text" name="corner" value="" id="corner" style="display: none">
																						<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none"> -->
																						<?php if($_SESSION['userType']=="student"){ ?>
																								<div class="row">
																								    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																												<button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
																								    </div>
																								</div>
																								<div class="row">
																								    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
																												<button class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal" name="qualitySubmit">Save &amp; Submit</button>
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
				$(function () {
						$("#submit-activity").click(function() {
							$( "form" ).submit();
						});
				});
				$(document).ready(function() {

				  function exportTableToCSV($table, filename) {
				    var $rows = $table.find('tr:has(td)'),

				      // Temporary delimiter characters unlikely to be typed by keyboard
				      // This is to avoid accidentally splitting the actual contents
				      tmpColDelim = String.fromCharCode(11), // vertical tab character
				      tmpRowDelim = String.fromCharCode(0), // null character

				      // actual delimiter characters for CSV format
				      colDelim = '","',
				      rowDelim = '"\r\n"',

				      // Grab text from table into CSV formatted string
				      csv = '"' + $rows.map(function(i, row) {
				        var $row = $(row),
				          $cols = $row.find('td');

				        return $cols.map(function(j, col) {
				          var $col = $(col),
				            text = $col.text();

				          return text.replace(/"/g, '""'); // escape double quotes

				        }).get().join(tmpColDelim);

				      }).get().join(tmpRowDelim)
				      .split(tmpRowDelim).join(rowDelim)
				      .split(tmpColDelim).join(colDelim) + '"';

				    // Deliberate 'false', see comment below
				    if (false && window.navigator.msSaveBlob) {

				      var blob = new Blob([decodeURIComponent(csv)], {
				        type: 'text/csv;charset=utf8'
				      });

				      // Crashes in IE 10, IE 11 and Microsoft Edge
				      // See MS Edge Issue #10396033
				      // Hence, the deliberate 'false'
				      // This is here just for completeness
				      // Remove the 'false' at your own risk
				      window.navigator.msSaveBlob(blob, filename);

				    } else if (window.Blob && window.URL) {
				      // HTML5 Blob
				      var blob = new Blob([csv], {
				        type: 'text/csv;charset=utf-8'
				      });
				      var csvUrl = URL.createObjectURL(blob);

				      $(this)
				        .attr({
				          'download': filename,
				          'href': csvUrl
				        });
				    } else {
				      // Data URI
				      var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

				      $(this)
				        .attr({
				          'download': filename,
				          'href': csvData,
				          'target': '_blank'
				        });
				    }
				  }

					// This must be a hyperlink
				  $(".export").on('click', function(event) {
						var downloadID = $(event.target).attr('id');
						var args;
						if (downloadID=='duration') {
							var title = "<?php echo $data['durationTitle']; ?>";
							console.log(title);
							var value1 = $("#range11").val();
							var value2 = $("#range12").val();
							var value3 = $("#range13").val();
							var value4 = $("#range14").val();
							var value5 = $("#range15").val();
							$('#input11').html($("#range11").val());
							$('#input12').html($("#range12").val());
							$('#input13').html($("#range13").val());
							$('#input14').html($("#range14").val());
							$('#input15').html($("#range15").val());
							args = [$('#durationTable'), title+'.csv'];
							$('#input11').html('<textarea name="answer11" id="range11" class="form-control" rows="1">' + value1 + '</textarea>');
							$('#input12').html('<textarea name="answer12" id="range12" class="form-control" rows="1">' + value2 + '</textarea>');
							$('#input13').html('<textarea name="answer13" id="range13" class="form-control" rows="1">' + value3 + '</textarea>');
							$('#input14').html('<textarea name="answer14" id="range14" class="form-control" rows="1">' + value4 + '</textarea>');
							$('#input15').html('<textarea name="answer15" id="range15" class="form-control" rows="1">' + value5 + '</textarea>');
						} else if (downloadID=='consistency') {
							var title = "<?php echo $data['consistencyTitle']; ?>";
							console.log(title);
							var value1 = $("#range21").val();
							var value2 = $("#range22").val();
							var value3 = $("#range23").val();
							var value4 = $("#range24").val();
							var value5 = $("#range25").val();
							$('#input21').html($("#range21").val());
							$('#input22').html($("#range22").val());
							$('#input23').html($("#range23").val());
							$('#input24').html($("#range24").val());
							$('#input25').html($("#range25").val());
							args = [$('#consistencyTable'), title+'.csv'];
							$('#input21').html('<textarea name="answer21" id="range21" class="form-control" rows="1">' + value1 + '</textarea>');
							$('#input22').html('<textarea name="answer22" id="range22" class="form-control" rows="1">' + value2 + '</textarea>');
							$('#input23').html('<textarea name="answer23" id="range23" class="form-control" rows="1">' + value3 + '</textarea>');
							$('#input24').html('<textarea name="answer24" id="range24" class="form-control" rows="1">' + value4 + '</textarea>');
							$('#input25').html('<textarea name="answer25" id="range25" class="form-control" rows="1">' + value5 + '</textarea>');
						} else if (downloadID=='quality') {
							var title = "<?php echo $data['qualityTitle']; ?>";
							console.log(title);
							var value1 = $("#range31").val();
							var value2 = $("#range32").val();
							var value3 = $("#range33").val();
							var value4 = $("#range34").val();
							var value5 = $("#range35").val();
							$('#input31').html($("#range31").val());
							$('#input32').html($("#range32").val());
							$('#input33').html($("#range33").val());
							$('#input34').html($("#range34").val());
							$('#input35').html($("#range35").val());
							args = [$('#qualityTable'), title+'.csv'];
							$('#input31').html('<textarea name="answer31" id="range31" class="form-control" rows="1">' + value1 + '</textarea>');
							$('#input32').html('<textarea name="answer32" id="range32" class="form-control" rows="1">' + value2 + '</textarea>');
							$('#input33').html('<textarea name="answer33" id="range33" class="form-control" rows="1">' + value3 + '</textarea>');
							$('#input34').html('<textarea name="answer34" id="range34" class="form-control" rows="1">' + value4 + '</textarea>');
							$('#input35').html('<textarea name="answer35" id="range35" class="form-control" rows="1">' + value5 + '</textarea>');
						}
				    exportTableToCSV.apply(this, args);
					
					
				    // If CSV, don't do event.preventDefault() or return false
				    // We actually need this to be a typical hyperlink
				  });
				});
		</script>
</html>
