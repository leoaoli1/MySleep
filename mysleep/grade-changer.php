<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) Univeristy of Arizona, College of Education 2016
# Not to be changed, modified, or distributed without express written permission of the entity.
#
# Authors: Ao Li <aoli1@email.arizona.edu>
#          James Geiger <jamesgeiger@email.arizona.edu>
#

require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

checkauth();

include('connectdb.php');

$q = mysql_query("SELECT * FROM gradeChanger WHERE userId = '$userId' AND isSubmitted = 0") or die(mysql_error());

if (mysql_num_rows($q)===1){

    while($row = mysql_fetch_assoc($q)){

	$hypothesis                   = $row["hypothesis"] ? $row["hypothesis"] : null;
  $hypothesisB                   = $row["hypothesisB"] ? $row["hypothesisB"] : null;
  $hypothesisD                   = $row["hypothesisD"] ? $row["hypothesisD"] : null;
	$hypothesizedValueB           = $row["hypothesizedValueB"] ? $row["hypothesizedValueB"] : null;
	$hypothesizedValueCD          = $row["hypothesizedValueCD"] ? $row["hypothesizedValueCD"] : null;
	$hypothesisSupported          = $row["hypothesisSupported"] ? $row["hypothesisSupported"] : null;
	$hypothesisBenefit            = $row["hypothesisBenefit"] ? $row["hypothesisBenefit"] : null;
	$conclusionsCalcOne           = $row["conclusionsCalcOne"] ? $row["conclusionsCalcOne"] : null;
	$conclusionsCalcTwo           = $row["conclusionsCalcTwo"] ? $row["conclusionsCalcTwo"] : null;
	$conclusionsCalcThree         = $row["conclusionsCalcThree"] ? $row["conclusionsCalcThree"] : null;
	$conclusionsCalcFour          = $row["conclusionsCalcFour"] ? $row["conclusionsCalcFour"] : null;
	$conclusionsCalcFive          = $row["conclusionsCalcFive"] ? $row["conclusionsCalcFive"] : null;
	$conclusionsCalcSix           = $row["conclusionsCalcSix"] ? $row["conclusionsCalcSix"] : null;
	$conclusionsDiffGreatest      = $row["conclusionsDiffGreatest"] ? $row["conclusionsDiffGreatest"] : null;
	$conclusionsDiffLeast         = $row["conclusionsDiffLeast"] ? $row["conclusionsDiffLeast"] : null;
	$responseOne                  = $row["responseOne"] ? $row["responseOne"] : null;
	$responseTwo                  = $row["responseTwo"] ? $row["responseTwo"] : null;
	$responseThree                = $row["responseThree"] ? $row["responseThree"] : null;
	$isSubmitted                  = $row["isSubmitted"];
    }
}
else {
    $hypothesis                   = "";
    $hypothesizedValueB           = "";
    $hypothesizedValueCD          = "";
    $hypothesisSupported          = "";
    $hypothesisBenefit            = "";
    $conclusionsCalcOne           = "";
    $conclusionsCalcTwo           = "";
    $conclusionsCalcThree         = "";
    $conclusionsCalcFour          = "";
    $conclusionsCalcFive          = "";
    $conclusionsCalcSix           = "";
    $conclusionsDiffGreatest      = "";
    $conclusionsDiffLeast         = "";
    $responseOne                  = "";
    $responseTwo                  = "";
    $responseThree                = "";
    $isSubmitted                  = "";
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
    </head>
    <body>
	<?php require 'partials/nav.php' ?>
  	<div class="wrapper">
	    <div class="main main-raised">
		<div class="container">
      <?php if ($config) {
        require_once('partials/nav-links.php');
        navigationLink($config,$userType);
      }else {?>
		    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
			    <ol class="breadcrumb">
				<li><a href="#" class = "exit" data-location="main-page">Home</a></li>
				<li><a href="#" class = "exit" data-location="sleep-lesson">Lessons</a></li>
				<li><a href="#" class = "exit" data-location="fifth-grade-lesson-menu?lesson=3">Lesson Three</a></li>
				<li><a href="#" class = "exit" data-location="fifth-grade-lesson-activity-menu?lesson=3&activity=3">Activity Three</a></li>
				<li class="active">Grade Changer</li>
			    </ol>
			</div>
		    </div>
        <?php } ?>
		    <div class="row">
			<div class="col-sm-12">
			    <div id="rootwizard" style="margin-top: 2em;">
				<ul class="nav nav-pills nav-pills-info nav-justified">
				    <li><a href="#intro" data-toggle="tab">Introduction</a></li>
				    <li><a href="#slideA" data-toggle="tab">Display</a></li>
				    <li><a href="#slideB" data-toggle="tab">Hypothesize</a></li>
				    <li><a href="#slideC" data-toggle="tab">Test</a></li>
				    <li><a href="#slideD" data-toggle="tab">Conclusions</a></li>
				    <li><a href="#slideE" data-toggle="tab">Recommendations</a></li>
				</ul>
				<div class="tab-content" style="margin-top: 1.2em;">
				    <div class="tab-pane" id="intro">
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h2>Does sleep affect academic performance?</h2>
						<h4>
						    A group of 3,120 high school students between 13 and 19 years old answered questions about their sleep habits at school over the past two weeks.
						</h4>
					    </div>
					</div>
				    </div>
				    <div class="tab-pane" id="slideA">
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h2>Displaying Information Graphically</h2>
						<h4>This is a data table showing the mostly A and C students’ reported hours of sleep and their grades.  On the bar graph below, slide the bars upward to show the minutes of sleep that the A and C students got.</h4>
					    </div>
					</div>
					<div class="row">
					    <table class="col-md-offset-0 col-md-11 col-sm-offset-0 col-sm-11 table-bordered">
                <col width="16%"><col width="19%"><col width="19%"><col width="19%"><col width="19%">
						<thead>
						    <tr>
							<th class="text-center">Grades</th>
							<th class="text-center">Mostly A's</th>
							<th class="text-center">Mostly B's</th>
							<th class="text-center">Mostly C's</th>
							<th class="text-center">Mostly D's/F's</th>
						    </tr>
						</thead>
						<tbody>
						    <tr>
							<td class="text-center">School Night Sleep<br><br>(Hours and Minutes)</td>
							<td class="text-center">442 minutes<br>or<br>7 hrs 22 mins</td>
							<td class="text-center">&mdash;</td>
							<td class="text-center">424 minues<br>or<br>7 hrs 4 mins</td>
							<td class="text-center">&mdash;</td>
						    </tr>
						</tbody>
					    </table>
					</div>
					<div class="row" style="margin-top:2em;">
					    <div class="col-sm-offset-1 col-sm-10">
						<div id="chart-slide-a">
						</div>
					    </div>
					</div>
				    </div>
				    <div class="tab-pane" id="slideB">
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h2>With the data we have for A and C students, can you make a prediction for B and D/F students?</h2>
            <!-- <h2>Hypothesize</h2> -->
						<!-- <h4>Given the data you have, what would you predict about the amount of sleep the B and D/F students reported?</h4> -->
					    </div>
					    <div class="col-sm-offset-1 col-sm-10">
						<h4>1. Make a prediction about B students by selecting one of the following statements:</h4>
						<div class="radio">
						    <label>
							<input type="radio" name="hypothesisB" <?php if($hypothesisB == 0)echo "checked"?> value="0">
							If students get mostly B’s then their amount of sleep will be more than or the same as students with A’s because there is no relationship between sleep and grades.
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="hypothesisB" <?php if($hypothesisB == 1)echo "checked";?> value="1">
							If students get mostly B’s then their amount of sleep will be less than students with A’s because there is a relationship between sleep and grades.
						    </label>
						</div>
					    </div>
					</div>
					<div class="row">
				    <div class="col-sm-offset-1 col-sm-10">
				      <h4>2. On the bar graph slide the bars upward to show the minutes of sleep that you think the B students reported.</h4>
				    </div>
					</div>
					<div class="row" style="margin-top:2em;">
					    <div class="col-sm-offset-1 col-sm-10">
						<div id="chart-slide-b">
						</div>
					    </div>
					</div>
          <div class="col-sm-offset-1 col-sm-10">
            <h4>3. Make a prediction about D/F students by selecting one of the following statements:</h4>
            <div class="radio">
                <label>
                  <input type="radio" name="hypothesisD" <?php if($hypothesisD == 0)echo "checked"?> value="0">
                  If students get mostly D/F’s then their amount of sleep will be more than or the same as students with higher grades because there is no relationship between sleep and grades.
                </label>
            </div>
            <div class="radio">
                <label>
                  <input type="radio" name="hypothesisD" <?php if($hypothesisD == 1)echo "checked";?> value="1">
                  If students get mostly D/F’s then their amount of sleep will be less than students with higher grades because there is a relationship between sleep and grades.
                </label>
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-10">
            <h4>4. On the bar graph slide the bars upward to show the minutes of sleep that you think the D/F students reported.</h4>
          </div>
				    </div>
				    <div class="tab-pane" id="slideC">
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h2>Test your hypothesis</h2>
						<h4>
						    Compare your prediction to the actual data and answer the question below.
						</h4>
					    </div>
					</div>
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<div id="chart-slide-c">
						</div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h4>1. Did the data support your hypothesis?</h4>
						<div class="radio">
						    <label>
							<input type="radio" name="hypothesisSupported" id="" <?php if($hypothesisSupported == 1)echo "checked"?> value="1">
							Yes
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="hypothesisSupported" id="" <?php if($hypothesisSupported == 0)echo "checked"?> value="0">
							No
						    </label>
						</div>
					    </div>
					</div>
				    </div>
				    <div class="tab-pane" id="slideD">
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
                <h2>Which group has the strongest relationship between sleep and grade?</h2>
						<!-- <h2>Draw Conclusions from the Data Points</h2>
						<h4>Find the actual difference in minutes of sleep for each grade group and answer the questions below to find out if the benefit of sleep is the same for all grade groups?</h4> -->
					    </div>
					</div>
					<div class="row">
					    <table class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table-bordered">
                <col width="15%"><col width="20%"><col width="20%"><col width="20%"><col width="20%">
						<thead>
						    <tr>
							<th class="text-center">Grades</th>
							<th class="text-center">Mostly A's</th>
							<th class="text-center">Mostly B's</th>
							<th class="text-center">Mostly C's</th>
							<th class="text-center">Mostly D's/F's</th>
						    </tr>
						</thead>
						<tbody>
						    <tr>
							<td class="text-center">School Night Sleep<br><br>(Hours and Minutes)</td>
							<td class="text-center">442 minutes<br>-<br>7 hrs 22 mins</td>
							<td class="text-center">441 minutes<br>-<br>7 hrs 21 mins</td>
							<td class="text-center">424 minues<br>-<br>7 hrs 4 mins</td>
							<td class="text-center">408 minutes<br>-<br>6 hrs 48 mins</td>
						    </tr>
                <tr>
    							<td></td>
                  <td></td>
    							<td class="text-center"><b>A - B</b><br>1 min</td>
                  <td class="text-center"><b>A - C</b><br>18 mins</td>
                  <td class="text-center"><b>A - D/F</b><br>34 mins</td>
						    </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="text-center"><b>B - C</b><br>17 mins</td>
                  <td class="text-center"><b>B - D/F</b><br>33 mins</td>
						    </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="text-center"><b>C - D/F</b><br>16 mins</td>
						    </tr>
						</tbody>
					    </table>
					</div>
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<div id="chart-slide-d">
						</div>
					    </div>
					</div>
					<!-- <div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<form class="form-horizontal">
						    <div class="form-group">
							<label for="diffCalcA" class="col-sm-2 control-label" style="font-size: 18pt;color: #000;padding-top: 3pt;margin: 0pt;">A – B = </label>
							<div class="col-sm-2">
							    <input type="number" class="form-control" id="diffCalcA" style="height: auto;font-size: 18pt;line-height: 18pt;margin-bottom: 0pt;padding: 0pt;" value="<?php if($conclusionsCalcOne != "") echo $conclusionsCalcOne ?>">
							</div>
						    </div>
						    <div class="form-group">
							<label for="diffCalcB" class="col-sm-2 control-label" style="font-size: 18pt;color: #000;padding-top: 3pt;margin: 0pt;">B – C = </label>
							<div class="col-sm-2">
							    <input type="number" class="form-control" id="diffCalcB" style="height: auto;font-size: 18pt;line-height: 18pt;margin-bottom: 0pt;padding: 0pt;" value="<?php if($conclusionsCalcTwo != "") echo $conclusionsCalcTwo ?>">
							</div>
						    </div>
						    <div class="form-group">
							<label for="diffCalcC" class="col-sm-2 control-label" style="font-size: 18pt;color: #000;padding-top: 3pt;margin: 0pt;">C – D/F = </label>
							<div class="col-sm-2">
							    <input type="number" class="form-control" id="diffCalcC" style="height: auto;font-size: 18pt;line-height: 18pt;margin-bottom: 0pt;padding: 0pt;" value="<?php if($conclusionsCalcThree != "") echo $conclusionsCalcThree ?>">
							</div>
						    </div>
						    <div class="form-group">
							<label for="diffCalcD" class="col-sm-2 control-label" style="font-size: 18pt;color: #000;padding-top: 3pt;margin: 0pt;">A – C = </label>
							<div class="col-sm-2">
							    <input type="number" class="form-control" id="diffCalcD" style="height: auto;font-size: 18pt;line-height: 18pt;margin-bottom: 0pt;padding: 0pt;" value="<?php if($conclusionsCalcFour != "") echo $conclusionsCalcFour ?>">
							</div>
						    </div>
						    <div class="form-group">
							<label for="diffCalcE" class="col-sm-2 control-label" style="font-size: 18pt;color: #000;padding-top: 3pt;margin: 0pt;">A – D/F = </label>
							<div class="col-sm-2">
							    <input type="number" class="form-control" id="diffCalcE" style="height: auto;font-size: 18pt;line-height: 18pt;margin-bottom: 0pt;padding: 0pt;" value="<?php if($conclusionsCalcFive != "") echo $conclusionsCalcFive ?>">
							</div>
						    </div>
						    <div class="form-group">
							<label for="diffCalcF" class="col-sm-2 control-label" style="font-size: 18pt;color: #000;padding-top: 3pt;margin: 0pt;">B – D/F = </label>
							<div class="col-sm-2">
							    <input type="number" class="form-control" id="diffCalcF" style="height: auto;font-size: 18pt;line-height: 18pt;margin-bottom: 0pt;padding: 0pt;" value="<?php if($conclusionsCalcSix != "") echo $conclusionsCalcSix ?>">
							</div>
						    </div>
						</form>
					    </div>
					</div> -->
          <!--
          <div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
                <h4><small>A - B</small>
                <select>
                  <option value="0">Select an order</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
                </h4>
                <h4><small>A - C</small>
                <select>
                  <option value="0">Select an order</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
                </h4>
                <h4><small>B - C</small>
                <select>
                  <option value="0">Select an order</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
                </h4>
                <h4><small>A - D/F</small>
                <select>
                  <option value="0">Select an order</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
                </h4>
                <h4><small>B - D/F</small>
                <select>
                  <option value="0">Select an order</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
                </h4>
                <h4><small>C - D/F</small>
                <select>
                  <option value="0">Select an order</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
                </h4>
              </div>
          </div> -->
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
    						<h4>Based on the differences shown, for which groups is the difference in time spent asleep the greatest? </h4>
    						<div class="radio">
  						    <label>
      							<input type="radio" name="conclusionsDiffGreatest" <?php if($conclusionsDiffGreatest == 1) echo "checked"?> value="1">
      							A and B students
  						    </label>
    						</div>
    						<div class="radio">
  						    <label>
      							<input type="radio" name="conclusionsDiffGreatest" <?php if($conclusionsDiffGreatest == 2) echo "checked"?> value="2">
      							A and C students
  						    </label>
    						</div>
    						<div class="radio">
  						    <label>
      							<input type="radio" name="conclusionsDiffGreatest" <?php if($conclusionsDiffGreatest == 3) echo "checked"?> value="3">
      							A and D/F students
  						    </label>
    						</div>
    						<div class="radio">
  						    <label>
      							<input type="radio" name="conclusionsDiffGreatest" <?php if($conclusionsDiffGreatest == 4) echo "checked"?> value="4">
      							B and C students
  						    </label>
    						</div>
                <div class="radio">
  						    <label>
      							<input type="radio" name="conclusionsDiffGreatest" <?php if($conclusionsDiffGreatest == 5) echo "checked"?> value="5">
      							B and D/F students
  						    </label>
    						</div>
                <div class="radio">
  						    <label>
      							<input type="radio" name="conclusionsDiffGreatest" <?php if($conclusionsDiffGreatest == 6) echo "checked"?> value="6">
      							C and D/F students
  						    </label>
    						</div>
					    </div>
					</div>
          <!--
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h4>The difference in the amount of sleep is the least between which grade groups?</h4>
						<div class="radio">
						    <label>
							<input type="radio" name="conclusionsDiffLeast" <?php if($conclusionsDiffLeast == 1) echo "checked"?> value="1">
							A – B
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="conclusionsDiffLeast" <?php if($conclusionsDiffLeast == 2) echo "checked"?> value="2">
							B - C
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="conclusionsDiffLeast" <?php if($conclusionsDiffLeast == 3) echo "checked"?> value="3">
							C - D/F
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="conclusionsDiffLeast" <?php if($conclusionsDiffLeast == 4) echo "checked"?> value="4">
							A – C
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="conclusionsDiffLeast" <?php if($conclusionsDiffLeast == 5) echo "checked"?> value="5">
							A – D/F
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="conclusionsDiffLeast" <?php if($conclusionsDiffLeast == 6) echo "checked"?> value="6">
							B – D/F
						    </label>
						</div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<h4>Is the benefit of sleep the same for all grade groups?</h4>
						<div class="radio">
						    <label>
							<input type="radio" name="hypothesisBenefit" id="" <?php if($hypothesisBenefit == 1)echo "checked"?> value="1">
							Yes
						    </label>
						</div>
						<div class="radio">
						    <label>
							<input type="radio" name="hypothesisBenefit" id="" <?php if($hypothesisBenefit == 0)echo "checked"?> value="0">
							No
						    </label>
						</div>
					    </div>
					</div> -->
				    </div>
				    <div class="tab-pane" id="slideE">
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
                <h2>Why is sleep a grade changer?</h2>
						<!-- <h2>Implications of the research: Why is sleep called a grade changer?</h2> -->
						    <h4>The table and bar graph show the actual amount of sleep students got according to their grades.  Answer the question about the data in the box below.</h4>
					    </div>
					</div>
					<div class="row">
					    <table class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8 table-bordered">
						<thead>
						    <tr>
							<th class="text-center">Grades</th>
							<th class="text-center">Mostly A's</th>
							<th class="text-center">Mostly B's</th>
							<th class="text-center">Mostly C's</th>
							<th class="text-center">Mostly D's/F's</th>
						    </tr>
						</thead>
						<tbody>
						    <tr>
							<td class="text-center">School Night Sleep<br><br>(Hours and Minutes)</td>
							<td class="text-center">442 minutes<br>or<br>7 hrs 22 mins</td>
							<td class="text-center">441 minutes<br>or<br>7 hrs 21 mins</td>
							<td class="text-center">424 minues<br>or<br>7 hrs 4 mins</td>
							<td class="text-center">408 minutes<br>or<br>6 hrs 48 mins</td>
						    </tr>
						</tbody>
					    </table>
					</div>
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
						<div id="chart-slide-e">
						</div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-sm-offset-1 col-sm-10">
                <h4>Implications of the research: Why is sleep called a “grade changer?” Write your answer in the box below.</h4>
						<!--<h4>1. Which students are most likely to improve their grades by sleeping more? Why?</h4>-->
						<textarea class="form-control" rows="5" name="responseOne" placeholder="Answers"><?php if($responseOne != "") echo $responseOne ?></textarea>
						<!--<h4>2. Why can sleep be called a grade changer? Explain your answer using data and evidence from the results of the research study.</h4>
						     <textarea class="form-control" rows="5" name="responseTwo"><?php if($responseTwo != "") echo $responseTwo ?></textarea>-->
						<p><b>Implications are the “take away” statements that help others</b> understand what the research results mean to them.</p>
					    </div>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-sm-offset-1 col-sm-10">
					<ul class="pager wizard">
					    <li class="previous"><a href="#">Previous</a></li>
					    <li class="next"><a href="#">Next</a></li>
					    <li class="finish"><a href="#">Finish &amp; Submit</a></li>
					</ul>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
            </div>
	</div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/draggable-points.js"></script>
    <script type="text/javascript">

     $(function() {
	 var studentPredictB = <?php if($hypothesizedValueB > 310 ){ echo $hypothesizedValueB; } else { echo 310; }?>;
	 var studentPredictD = <?php if($hypothesizedValueCD > 310 ){ echo $hypothesizedValueCD; } else { echo 310; }?>;

	 $('#rootwizard').bootstrapWizard({
             'nextSelector': '.next',
             'previousSelector': '.previous',


             onTabShow: function(tab, navigation, index) {
             },
             onPrevious: function(tab, navigation, index) {
               console.log(index);
               if (index == 0) {
                 chartSlideA.series[0].data[0].update(310);
                 chartSlideA.series[0].data[2].update(310);
               }else if (index == 1) {
                 chartSlideB.series[1].data[1].update(310);
                 chartSlideB.series[1].data[3].update(310);
               }
             },
             onNext: function(tab, navigation, index) {
               switch (index) {
                 case 2:
                   // Make sure data was entered on the chart
                   if ( chartSlideA.get("pointA").y < 440 || chartSlideA.get("pointA").y > 450) {
                     swal('Whoops!','You must correctly graph the Mostly As group!  Try to get the value within 5 minutes.','error');
                     return false;
                   }
                   else if ( chartSlideA.get("pointC").y < 420 || chartSlideA.get("pointC").y > 430) {
                     swal('Whoops!','You must correctly graph the Mostly Cs group!  Try to get the value within 5 minutes.','error');
                     return false;
                   }
                   break;
                   case 3:
                     // Make sure data was entered on the chart
                     if ( !($('input[name=hypothesisB]:checked').val()) || !($('input[name=hypothesisD]:checked').val())){
                       swal('Whoops!','You must select a hypothesis.','error');
                       return false;
                     }
                     else if ( chartSlideB.get("pointB").y <= 10 ){
                       swal('Whoops!','You must graph  a hypothesis for the Mostly Bs group!.','error');
                       return false;
                     }
                     else if ( chartSlideB.get("pointD").y <= 10) {
                       swal('Whoops!','You must graph a hypothesis for the Mostly Ds/Fs group.','error');
                       return false;
                     }
                     chartSlideC.series[1].data[1].update(chartSlideB.get("pointB").y);
          					 chartSlideC.series[1].data[3].update(chartSlideB.get("pointD").y);
                   break;
                   case 5:
                     var alert = "Check the following calculations:<br>";
                     if($('input[id=diffCalcA]').val() != 1){
                       alert += "A - B";
                     }
                     if($('input[id=diffCalcB]').val() != 17){
                       alert += "<br>B - C";
                     }
                     if($('input[id=diffCalcC]').val() != 16){
                       alert += "<br>C - D/F";
                     }
                     if($('input[id=diffCalcD]').val() != 18){
                       alert += "<br>A - C";
                     }
                     if($('input[id=diffCalcE]').val() != 34){
                       alert += "<br>A - D/F";
                     }
                     if($('input[id=diffCalcF]').val() != 33){
                       alert += "<br>B - D/F";
                     }
                     if(alert != "Check the following calculations:<br>"){
                       return true;
                       swal({
                           title: 'Whoops!',
                           html: alert,
                           type: 'error',
                           confirmButtonText: 'Cool'
                       });
                       return false
                     }
                     break;
                 default:

               }

		 var formData = {
		     'hypothesis'                      : $('input[name=hypothesis]:checked').val(),
		     'hypothesizedValueB'              : chartSlideB.get("pointB").y,
		     'hypothesizedValueCD'             : chartSlideB.get("pointD").y,
		     'hypothesisSupported'             : $('input[name=hypothesisSupported]:checked').val(),
		     'hypothesisBenefit'               : $('input[name=hypothesisBenefit]:checked').val(),
		     'conclusionsCalcOne'              : $('input[id=diffCalcA]').val(),
		     'conclusionsCalcTwo'              : $('input[id=diffCalcB]').val(),
		     'conclusionsCalcThree'            : $('input[id=diffCalcC]').val(),
		     'conclusionsCalcFour'             : $('input[id=diffCalcD]').val(),
		     'conclusionsCalcFive'             : $('input[id=diffCalcE]').val(),
		     'conclusionsCalcSix'              : $('input[id=diffCalcF]').val(),
		     'conclusionsDiffGreatest'         : $('input[name=conclusionsDiffGreatest]:checked').val(),
		     'conclusionsDiffLeast'            : $('input[name=conclusionsDiffLeast]:checked').val(),
		     'responseOne'                     : $('textarea[name=responseOne]').val(),
		     'responseTwo'                     : $('textarea[name=responseTwo]').val(),
		     'isSubmitted'                     : false,
		 };

		 $.ajax({
		     type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		     url         : 'grade-changer-done', // the url where we want to POST
		     data        : formData, // our data object
		     dataType    : 'json', // what type of data do we expect back from the server
		     encode      : true
		 });
             },
             onTabClick: function(tab, navigation, index) {
		 //return false;
             },
	 });

	 $('#rootwizard .finish').click(function() {
	     var result = confirm('Want to submit?');
	     if(!result){
      		 return false;
	     }
             var formData = {
		 'hypothesis'                      : $('input[name=hypothesis]:checked').val(),
		 'hypothesizedValueB'              : chartSlideB.get("pointB").y,
		 'hypothesizedValueCD'             : chartSlideB.get("pointD").y,
		 'hypothesisSupported'             : $('input[name=hypothesisSupported]:checked').val(),
		 'hypothesisBenefit'               : $('input[name=hypothesisBenefit]:checked').val(),
		 'conclusionsCalcOne'              : $('input[id=diffCalcA]').val(),
		 'conclusionsCalcTwo'              : $('input[id=diffCalcB]').val(),
		 'conclusionsCalcThree'            : $('input[id=diffCalcC]').val(),
		 'conclusionsCalcFour'             : $('input[id=diffCalcD]').val(),
		 'conclusionsCalcFive'             : $('input[id=diffCalcE]').val(),
		 'conclusionsCalcSix'              : $('input[id=diffCalcF]').val(),
		 'conclusionsDiffGreatest'         : $('input[name=conclusionsDiffGreatest]:checked').val(),
		 'conclusionsDiffLeast'            : $('input[name=conclusionsDiffLeast]:checked').val(),
		 'responseOne'                     : $('textarea[name=responseOne]').val(),
		 'responseTwo'                     : $('textarea[name=responseTwo]').val(),
		 'isSubmitted'                     : true,
             };

             $.ajax({
          		 type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
          		 url         : 'grade-changer-done', // the url where we want to POST
          		 data        : formData, // our data object
          		 dataType    : 'json', // what type of data do we expect back from the server
          		 encode      : true
             })
              .success(function(data) {
          		  if ( ! data.success) {
                  alert(data.errors);
          		  }
          		  else {
                  console.log('success')
                  alert(data.message);

                  location.href = '<?php echo "lesson-menu?".$query ?>';
          		  }
              });
      	 });

	 var chartSlideA = new Highcharts.Chart({

	     chart: {
		 renderTo: 'chart-slide-a',
		 animation: false,
	     },

	     title: {
		 text: ''
	     },

	     xAxis: {
		 categories: ["Mostly A's", "Mostly B's", "Mostly C's", "Mostly D's/F's"]
	     },

	     yAxis: {
		 title: {
		     text: 'Minutes of Sleep',
		 },
		 min: 300,
		 max: 500,

	     },

	     plotOptions: {
    		 column: {
    		     stacking: 'normal',
    		 },
    		 line: {
    		     cursor: 'ns-resize'
    		 }
	     },

	     tooltip: {
		 animation: false,
		 valueDecimals: 0,
		 split: false,
	     },

	     series: [{
		 name: "Sleep Time",
		 data: [
		     {
			 name: 'Mostly As',
			 id: 'pointA',
			 y: 310,
		     },{
			 name: 'Mostly Bs',
			 y: '',
			 draggableY: false,
		     },{
			 name: 'Mostly Cs',
			 id: 'pointC',
			 y: 310,
		     },{
			 name: 'Mostly Ds/Fs',
			 y: '',
			 draggableY: false,
		     }
		 ],
     dragDrop: {
       draggableY: true,
  		 dragMinY: 10,
  		 dragMaxY: 499,
  		 dragPrecisionY: 1,
  		 dragHandleFill: '#BC0016',
     },
     type: 'column',
		 color: '#DAF7A6',
	     }]

	 });

	 var chartSlideB = new Highcharts.Chart({

	     chart: {
		 renderTo: 'chart-slide-b',
		 animation: false,
	     },

	     title: {
		 text: ''
	     },

	     xAxis: {
		 categories: ["Mostly A's", "Mostly B's", "Mostly C's", "Mostly D's/F's"]
	     },

	     yAxis: {
		 title: {
		     text: 'Minutes of Sleep',
		 },
		 min: 300,
		 max: 500,

	     },

	     plotOptions: {
		 column: {
		     stacking: 'normal',
		 },
		 line: {
		     cursor: 'ns-resize'
		 }
	     },

	     tooltip: {
		 animation: false,
		 valueDecimals: 0,
		 split: false,
	     },

	     series: [{
		 name: "Actual Sleep Time",
		 data: [
		     {
			 name: 'Mostly As',
			 id: 'pointA',
			 y: 442,
			 draggableY: false,
		     },{
			 name: 'Mostly Bs',
			 id: 'pointBs',
			 y: 0,
		     },{
			 name: 'Mostly Cs',
			 id: 'pointC',
			 y: 424,
			 draggableY: false,
		     },{
			 name: 'Mostly Ds/Fs',
			 id: 'pointDs',
			 y: 0,
		     }
		 ],
		 draggableY: true,
		 dragMinY: 10,
		 dragMaxY: 499,
		 dragPrecisionY: 1,
		 type: 'column',
		 dragHandleFill: '#BC0016',
		 color: '#DAF7A6',
   },
   {
  name: "Predict Sleep Time",
  data: [
     {
   name: 'Mostly As',
   id: 'pointA',
   y: 0,
   draggableY: false,
     },{
   name: 'Mostly Bs',
   id: 'pointB',
   y: studentPredictB,
     },{
   name: 'Mostly Cs',
   id: 'pointC',
   y: 0,
   draggableY: false,
     },{
   name: 'Mostly Ds/Fs',
   id: 'pointD',
   y: studentPredictD,
     }
  ],
  dragDrop: {
    draggableY: true,
    dragMinY: 310,
    dragMaxY: 499,
    dragPrecisionY: 1,
    dragHandleFill: '#BC0016',
  },
  type: 'column',
  color: '#FFC300',
   }]

	 });

	 var chartSlideC = new Highcharts.Chart({

	     chart: {
		 renderTo: 'chart-slide-c',
		 animation: false,
		 type: 'column',
	     },

	     title: {
		 text: ''
	     },

	     xAxis: {
		 categories: ["Mostly A's", "Mostly B's", "Mostly C's", "Mostly D's/F's"]
	     },

	     yAxis: {
		 title: {
		     text: 'Minutes of Sleep',
		 },
		 min: 300,
		 max: 500,

	     },

	     plotOptions: {
		 line: {
		     cursor: 'ns-resize'
		 }
	     },

	     tooltip: {
		 animation: false,
		 valueDecimals: 0,
		 split: false,
	     },

	     series: [{
		 name: "Actual Sleep Time",
		 data: [
		     {
			 name: 'Mostly As',
			 y: 442,
		     },{
			 name: 'Mostly Bs',
			 y: 441,
		     },{
			 name: 'Mostly Cs',
			 y: 424,
		     },{
			 name: 'Mostly Ds/Fs',
			 y: 408,
		     }
		 ],
		 type: 'column',
		 color: '#DAF7A6',
	     },
		      {
			  name: "Predicted Sleep Time",
			  data: [
			      {
				  name: '',
				  y: 0,
			      },{
				  name: 'Mostly Bs',
				  y: studentPredictB,
			      },{
				  name: '',
				  y: 0,
			      },{
				  name: 'Mostly Ds/Fs',
				  y: studentPredictD,
			      }
			  ],
			  type: 'column',
			  color: '#FFC300',
		      }]

	 });


	 var chartSlideE = new Highcharts.Chart({

	     chart: {
		 renderTo: 'chart-slide-e',
		 animation: false,
	     },

	     title: {
		 text: ''
	     },

	     xAxis: {
		 categories: ["Mostly A's", "Mostly B's", "Mostly C's", "Mostly D's/F's"]
	     },

	     yAxis: {
		 title: {
		     text: 'Minutes of Sleep',
		 },
		 min: 300,
		 max: 500,

	     },

	     plotOptions: {
		 line: {
		     cursor: 'ns-resize'
		 }
	     },

	     tooltip: {
		 animation: false,
		 valueDecimals: 0,
		 split: false,
	     },

	     series: [{
		 name: "Actual Sleep Time",
		 data: [
		     {
			 name: 'Mostly As',
			 y: 442,
		     },{
			 name: 'Mostly Bs',
			 y: 441,
		     },{
			 name: 'Mostly Cs',
			 y: 424,
		     },{
			 name: 'Mostly Ds/Fs',
			 y: 408,
		     }
		 ],
		 type: 'column',
		 color: '#DAF7A6',
	     }]

	 });

     });
    </script>
</html>
