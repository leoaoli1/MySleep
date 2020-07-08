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
	$classId= $_SESSION['classId'];
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
	$classGrade = getClassGrade($classId);
	if ($config) {
		$result =mysql_query("SELECT * FROM bigQuestions WHERE contributors LIKE '%$userId%' ORDER BY resultRow DESC LIMIT 1");
	}else {
		$result =mysql_query("SELECT * FROM bigQuestions WHERE userId='$userId'");
	}
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['hypothesis'])) {
		   $hypothesis = $row['hypothesis'];
       $evidence = $row['evidence'];
		}
		$_SESSION['current_work'] = $row;
	  $resultRow = $row['resultRow'];
   }else {
   	$hypothesis = "";
    $evidence = "";
		$resultRow = -1;
   }
   mysql_close($con);
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
            <title>MySleep // What Is Sleep?</title>
            <style>
            label {
              white-space: pre-wrap;
              text-transform: capitalize;
            }
						th {
							text-align: center;
						}
						.ui-widget-overlay
						{
						  opacity: .40 !important; /* Make sure to change both of these, as IE only sees the second one */
						  filter: Alpha(Opacity=50) !important;
						  background: rgb(40, 40, 50) !important; /* This will make it darker */
						}
            </style>
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
                      } ?>

												<form action="big-question-done" method="post">
                            <div class="row">
																<div class="col-xs-offset-0 col-xs-12 col-md-10 col-md-offset-1">
																		<h3>Z-Big Questions</h3>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none;">
                                      <li role="presentation" class="active"><a href="#variablePool" aria-controls="variablePool" role="tab" data-toggle="tab" id = "firstTab">1</a></li>
                                      <li role="presentation" ><a href="#hypothesis" aria-controls="hypothesis" role="tab" data-toggle="tab" id = "secondTab">2</a></li>
                                      <!-- <li role="presentation" ><a href="#instruction" aria-controls="instruction" role="tab" data-toggle="tab" id = "thirdTab">3</a></li> -->
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content" style="">
                                      <div role="tabpanel" class="tab-pane active" id="variablePool">
																				<h4>
																					<small>
																						What questions do sleep scientists ask and how would you answer them?
																						<br><br>
																						In this activity, you will select a relationship between a cause variable and effect variable that interests you.  When you select the square where the two variables intersect in the grid below a randomly generated question will appear.  Form a hypothesis about the relationship and give a reason, or evidence from your own experience, for your hypothesis.
																						<br><br>
																						Consider 3 different questions before choosing one to recommend for a class research project.
																					</small>
																				</h4>
																				<?php include 'add-group-member-button.php' ?>
																				<div id="hypothesisDialog">
																				  <p id='question'></p>
																				</div>
                                        <table id="variableTable" class="table table-striped">
                                          <col width="25%">
																					<col width="25%">
                                          <col width="25%">
																					<col width="25%">
																					<thead>
																						<tr>
																							<?php if ($classGrade == 4) { ?>
																								<th>Cause Variables</th><th>Sleep Duration</th><th>Sleep Consistency</th><th>Sleep Quality</th>
																							<?php } else {?>
																								<th>Cause Variables</th><th>Mental Performance</th><th>Physical Health</th><th>Emotional State</th>
																							<?php } ?>
																						</tr>
																					</thead>
                                            <tbody>
                                              <tr>
                                                <td align="center" style="vertical-align:middle" id="iv1">
																									<?php if ($classGrade == 4) { ?>
																										Daytime Activity
																									<?php } else {?>
																										Sleep Duration
																									<?php } ?>
																								</td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectDV(0)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv11">1</label>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradpr btn-large btn-block" onclick="selectDV(1)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv12">2</label>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradbg btn-large btn-block" onclick="selectDV(2)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv13">3</label>
                                                  </div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" style="vertical-align:middle" id="iv2">
																									<?php if ($classGrade == 4) { ?>
																										Physical Wellness
																									<?php } else {?>
																										Sleep Consistency
																									<?php } ?>

																								</td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradorange btn-large btn-block" onclick="selectDV(3)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv21">4</label>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradop btn-large btn-block" onclick="selectDV(4)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv22">5</label>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectDV(5)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv23">6</label>
                                                  </div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" style="vertical-align:middle" id="iv3">
																									<?php if ($classGrade == 4) { ?>
																										Sleep Environment
																									<?php } else {?>
																										Sleep Quality
																									<?php } ?>
																								</td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradpr btn-large btn-block" onclick="selectDV(6)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv31">7</label>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradbg btn-large btn-block" onclick="selectDV(7)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv32">8</label>
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="btn btn-roundBold btn-gradorange btn-large btn-block" onclick="selectDV(8)" style="cursor: pointer;text-align: center;">
                                                    <label style="color: #fafafa" id="dv33">9</label>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                        </table>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="hypothesis">
                                        <div class="row">
                                          <div class="col-md-12 col-md-offset-0">
                                            <h4 id="choseTitle">Your hypothesis:.</h4>
    			                                  <!-- <textarea name="answer1" id="answer1" class="form-control" rows="4" placeholder="Example: As sleep duration increases, reaction time will decrease.  Better sleep quality is associated better memory."><?php echo htmlspecialchars($hypothesis);?></textarea> -->
                                            <h4>Enter the evidence you have to suppport your hypothesis:</h4>
    			                                  <textarea name="answer2" id="answer2" class="form-control" rows="4" ></textarea>

                                            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                														<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
                														<?php if($_SESSION['userType']=="student"){ ?>
                																<div class="row">
                																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                																				<a class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
                																    </div>
                																</div>
                															    <?php }else{?>
                																<div class="row">
                																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                																				<a class="btn btn-gradpr btn-roundBold btn-large btn-block">Save &amp; Submit</a>
                																    </div>
                																</div>
                												    <?php } ?>
                                            <div class="row">
                                                <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                                                    <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="goBack()" style="cursor: pointer;text-align: center;">
                                                        <label class="info-title" style="color: #fafafa">Back</label>
                                                    </div>
                                                </div>
                                            </div>

                                          </div>
                                        </div>
                                      </div>
                                    </div>
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
						        <button id="submit-complete" type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
						        <button id="submit-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
						      </div>
						    </div>
						  </div>
						</div>
        <?php include 'partials/footer.php' ?>
    </body>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function nonrepeatRandom (nums) {
          var randomArray = [],
          i = nums.length,
          j = 0;
          count = 3;
          while (count--) {
              j = Math.floor(Math.random() * i);
              i--;
              randomArray.push(nums[j]);
              nums.splice(j,1);
          }
          return randomArray
        }
        var nums = [0,1,2,3,4,5],
        dvnums = [0,1,2,3,4,5,6,7],
        ranIV = nonrepeatRandom(nums.slice()),
        ranDV = [];
        ranDV = ranDV.concat(nonrepeatRandom(dvnums.slice()));
        ranDV = ranDV.concat(nonrepeatRandom(dvnums.slice()));
        ranDV = ranDV.concat(nonrepeatRandom(dvnums.slice()));

				// used for 4th grade question generation
				var iv4 = [
					['exercise','amount of caffeine consumed','time playing video games'],
					['daytime sleepiness','the number of symptoms of not feeling well'],
					['the amount of noise in the bedroom','the amount of light in the bedroom','the temperature in the bedroom','the bedtime set by parents']
				];
				// used for 5th grade question generation
				var iv5 = [
					['amount of sleep the Sleep Watch records','amount of sleep students report'],
					['amount of variation between the earliest and latest bedtimes the Sleep Watch records','amount of variation between the earliest and latest bedtimes students report'],
					['number of awakenings recorded by the Sleep Watch',"students' reported wake up state"]
				];
				// used for 4th grade hypothesis generation
				var ivhy4 = [
					['amount of exercise increases','the amount of caffeine consumed increases','the amount of time spent playing video games increases'],
					['rating of daytime sleepiness is higher','number of symptoms of not feeling well becomes greater'],
					['rating of bedroom noise becomes greater','rating of the amount of bedroom light becomes greater','bedroom temperature becomes greater','bedtime set by parents becomes later']
				];
				var ivhy5 = [
					['amount of sleep increases','amount of sleep increases'],
					['amount of variation between the earliest and latest bedtimes increases','amount of variation between the earliest and latest bedtimes increases'],
					['number of awakenings becomes greater','wake up state becomes better']
				];
				// used for 5th grade question and hypothesis generation
				var dv5 = [
					['their performance on a memory task','their ability to pay attention in class','their score on a reaction time test','their home and classroom behavior'],
					['the number of physical symptoms (cold, headache, etc.) they report','the average number of minutes they exercise daily'],
					['their ability to get along with others',"students' mood"]
				];
				var dv5s = [
					['memory scores','attention ratings','reaction time scores','behavior ratings'],
					['number of physical symptoms','exercise time'],
					['interpersonal interaction ratings','mood ratings']
				];
				// used for 4th grade question and hypothesis generation
				var dv4 = ['sleep duration','sleep consistency','sleep quality'];
				// used for 4th grade hypothesis generation
				var dvhy4 = [['increases','decreases','is unchanged'],['improves','worsens','is unchanged'],['improves','worsens','is unchanged']]
				var dvhy5 = [['improve','worsen','stay the same'],['increase','decrease','stay the same'],['improve','worsen','stay the same']]

        console.log(ranDV)
				var grade = <?php echo $classGrade; ?>;
				var ivindex;
				var dvindex;
				var hypothesis = "";
        function selectDV(dv){
          var iv = Math.floor(dv/3);
					var ivArray;
					if (grade == 4) {
						ivArray = iv4[iv];
					} else if (grade == 5) {
						ivArray = iv5[iv];
					}
					ivindex = Math.floor(Math.random() * ivArray.length);
					var ivname = ivArray[ivindex];

					if (grade == 4) {
						dvindex = dv%3;
						var dvname = dv4[dvindex];
	          console.log(iv + '-' + dvindex)
					} else if (grade == 5) {
						dvindex = dv%3;
						var dvArray = dv5[dvindex];
						var dvsArray = dv5s[dvindex];
						var dvi = Math.floor(Math.random() * dvArray.length);
						var dvname = dvArray[dvi];
						var dvsname = dvsArray[dvi];
					}

					var question = "What is the relationship between the " + ivname + " and " + dvname + "?";
					document.getElementById('question').innerHTML = "<B>"+question + "</B><br><br>Choose the hypothesis that predicts what you think the relationship will be.";
					document.getElementById('dv'.concat((iv+1).toString(),(dvindex+1).toString())).innerHTML = "<B>"+question+ "</B>";
					var ivhyArray;
					var dvhyArray;
					if (grade == 4) {
						ivhyArray = ivhy4[iv];
						dvhyArray = dvhy4[dvindex];
						$( "#hypothesisDialog" ).dialog('option', 'buttons', [
							{
							text: "As students’ average "+ ivhyArray[ivindex] +" their " + dvname + " " + dvhyArray[0]+".",
								click: function() {
									hypothesis = "As students’ average "+ ivhyArray[ivindex] +" their " + dvname + " " + dvhyArray[0]+".";
									document.getElementById('choseTitle').innerHTML = "Your hypothesis:<br> <B>"+hypothesis+"</B>";
									$('#secondTab').trigger('click')
									$( this ).dialog( "close" );
								}
							},{
							text: "As students’ average "+ ivhyArray[ivindex] +" their " + dvname + " " + dvhyArray[1]+".",
								click: function() {
									hypothesis = "As students’ average "+ ivhyArray[ivindex] +" their " + dvname + " " + dvhyArray[1]+".";
									document.getElementById('choseTitle').innerHTML = "Your hypothesis:<br> <B>"+hypothesis+"</B>";
									$('#secondTab').trigger('click')
									$( this ).dialog( "close" );
								}
							},{
							text: "As students’ average "+ ivhyArray[ivindex] +" their " + dvname + " " + dvhyArray[2]+".",
								click: function() {
									hypothesis = "As students’ average "+ ivhyArray[ivindex] +" their " + dvname + " " + dvhyArray[2]+".";
									document.getElementById('choseTitle').innerHTML = "Your hypothesis:<br> <B>"+hypothesis+"</B>";
									$('#secondTab').trigger('click')
									$( this ).dialog( "close" );
								}
							}
						]);
					} else if (grade == 5) {
						ivhyArray = ivhy5[iv];
						dvhyArray = dvhy5[dvindex];
						$( "#hypothesisDialog" ).dialog('option', 'buttons', [
							{
							text: "As students’ average "+ ivhyArray[ivindex] +" their " + dvsname + " will " + dvhyArray[0]+".",
								click: function() {
									hypothesis = "As students’ average "+ ivhyArray[ivindex] +" their " + dvsname + " will " + dvhyArray[0]+".";
									document.getElementById('choseTitle').innerHTML = "Your hypothesis:<br> <B>"+hypothesis+"</B>";
									$('#secondTab').trigger('click')
									$( this ).dialog( "close" );
								}
							},{
							text: "As students’ average "+ ivhyArray[ivindex] +" their " + dvsname + " will " + dvhyArray[1]+".",
								click: function() {
									hypothesis = "As students’ average "+ ivhyArray[ivindex] +" their " + dvsname + " will " + dvhyArray[1]+".";
									document.getElementById('choseTitle').innerHTML = "Your hypothesis:<br> <B>"+hypothesis+"</B>";
									$('#secondTab').trigger('click')
									$( this ).dialog( "close" );
								}
							},{
							text: "As students’ average "+ ivhyArray[ivindex] +" their " + dvsname + " will " + dvhyArray[2]+".",
								click: function() {
									hypothesis = "As students’ average "+ ivhyArray[ivindex] +" their " + dvsname + " will " + dvhyArray[2]+".";
									document.getElementById('choseTitle').innerHTML = "Your hypothesis:<br> <B>"+hypothesis+"</B>";
									$('#secondTab').trigger('click')
									$( this ).dialog( "close" );
								}
							}
						]);
					}

					$( "#hypothesisDialog" ).dialog( "open" );
					// $('#corner').val(corner);
					// document.getElementById('choseTitle').innerHTML = "What is the relationship beween " + questionPool[ranIV[iv]][ranDV[dv]];
					// $('#secondTab').trigger('click')
          // window.scrollTo({ top: 100, behavior: 'smooth' });
	      }
        function goBack(){
					$('#firstTab').trigger('click')
          window.scrollTo({ top: 100, behavior: 'smooth' });
	      }
        $(function () {
          $("#submit-activity").click(function() {
						var contributors = $("input[name='contributor[]']:checked")
		               .map(function(){return $(this).val();}).get();
									 console.log(contributors)
						var evidence = document.getElementById("answer2").value;
		      $.ajax({
		            type: "POST",
		            url: "big-question-done",
		             data: {hypothesis:hypothesis, evidence:evidence,contributor:contributors}
		            })
		      .done(function(respond){
						console.log("done: "+respond);
						$('#submit-complete').trigger('click')
						goBack();
						document.getElementById("answer2").value = "";
					})

            // $( "form" ).submit();

          });
					var showSettings = {
						effect: "blind",
						duration: 400
					};
					var hideSettings = {
						effect: "explode",
						duration: 400
					};
					$( "#hypothesisDialog" ).dialog({
						height: 350,
						width: 580,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						modal: true
					});
        });
    </script>

</html>
