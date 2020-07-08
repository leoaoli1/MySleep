<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');
session_start();
header("Cache-Control: private, max-age=3600, pre-check=1800");   // private: each user has their own cache; max-age: cache expires in 1 hr; pre-check: check cache every 0.5 hr
//header("Pragma: private");
//header("Expires: " . date(DATE_RFC822,strtotime("+2 day")));
$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
$userType = $_SESSION['userType'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;


//$player= $_POST['basketballPlayer'];    // Get from form
//if ($player == "")
//    $player = $_SESSION['basketballPlayer'];
//$_SESSION['basketballPlayer'] = $player;
if($userId==""){
    header("Location: login");
    exit;
}
if (isset($_POST['quit'])) {
    header("Location: sleep-lesson");
    exit;
}

include 'connectdb.php';
$result =mysql_query("SELECT * FROM basketball_test_table");
$r = 0;
$count = 0;
$typical = array(array());
$extend = array(array());
while($row = mysql_fetch_array($result)){
    $typical[$r][$row['attempt']-1] = $row['after_sleep_made'];
    $extend[$r][$row['attempt']-1] = $row['after_more_sleep_made'];
    $count += 1;
    if($count == 10){
	$count = 0;
	$r += 1;
    }
}
$result =mysql_query("SELECT * FROM gameChanger where userId='$userId' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$response = $row['gameChanger'];
$playerSave = $row['player'];
$hypothesisSave = $row['hypothesis'];
$improvSave = $row['improvement'];
$support = $row['support'];
$points = $row['points'];


if($playerSave == 1){
    $typicalSleep = 9;
    $extendSleep = 9;
}elseif ($playerSave == 2){
    $typicalSleep = 8;
    $extendSleep = 10;
}elseif ($playerSave == 3){
    $typicalSleep = 8;
    $extendSleep = 9;
}elseif ($playerSave == 4){
    $typicalSleep = 8;
    $extendSleep = 8;
}elseif ($playerSave == 5){
    $typicalSleep = 7;
    $extendSleep = 9;
}elseif ($playerSave == 6){
    $typicalSleep = 8;
    $extendSleep = 8;
}elseif ($playerSave == 7){
    $typicalSleep = 7;
    $extendSleep = 9;
}elseif ($playerSave == 8){
    $typicalSleep = 6;
    $extendSleep = 9;
}elseif ($playerSave == 9){
    $typicalSleep = 9;
    $extendSleep = 8;
}elseif ($playerSave == 10){
    $typicalSleep = 8;
    $extendSleep = 9;
}else{
    $typicalSleep = "";
    $extendSleep = "";
}

if(!empty($support)){
    $typicalPercent = 78;
    $extendPercent = 88;
}else{
    $typicalPercent = "";
    $extendPercent = "";
}

if($hypothesisSave == 'Increase'){
    $h = 'Increase.';
}elseif($hypothesisSave == 'Decrease'){
    $h = 'Decrease.';
}elseif($hypothesisSave == 'Same'){
    $h = 'Stay at same.';
}else{
$h = "";
}
//print_r($typical);
//print_r($extend);

?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Game Changer</title>
	<style type="text/css">
	 .attempt{
	     width: 10px;
	 }

	 .select {
	     width: 28px;
	     height: 28px;
	     position: relative;
	     background: #fcfff4;
	     background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     background: linear-gradient(to bottom, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label {
	     width: 20px;
	     height: 20px;
	     cursor: pointer;
	     position: absolute;
	     left: 4px;
	     top: 4px;
	     background: -webkit-linear-gradient(top, #FFFFFF 0%, #FFFFFF 100%);
	     background: linear-gradient(to bottom, #FFFFFF 0%, #FFFFFF 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px white;
	 }
	 .select label:after {
	     content: '';
	     width: 16px;
	     height: 16px;
	     position: absolute;
	     top: 2px;
	     left: 2px;
	     background: #6495ED;
	     background: -webkit-linear-gradient(top, #6495ED 0%, #6495ED 100%);
	     background: linear-gradient(to bottom, #6495ED 0%, #6495ED 100%);
	     opacity: 0;
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label:hover::after {
	     opacity: 0.3;
	 }
	 .select input[type=radio] {
	     visibility: hidden;
	 }
	 .select input[type=radio]:checked + label:after {
	     opacity: 1;
	 }
	</style>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php if ($config) {
        require_once('partials/nav-links.php');
        navigationLink($config,$userType);
      }else {?>

		    <ol class="breadcrumb">
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='main-page';">Home</a></li>
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='sleep-lesson';">Lessons</a></li>
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fifth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
    			<li class="active">Game Changer<?php echo $config; ?></li>
		    </ol>
        <?php } ?>
		    <?php include 'partials/alerts.php' ?>
		    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
				<!-- Nav tabs -->
				<ul id="group" class="nav nav-justified nav-pills nav-pills-info" role="tablist">
				    <li role="presentation" class="active"><a href="#screen1" aria-controls="screen1" role="tab" data-toggle="tab">Introduction</a></li>
				    <li role="presentation"><a href="#screen2" aria-controls="screen2" role="tab" data-toggle="tab">Hypothesize</a></li>
				    <li role="presentation"><a href="#screen3" aria-controls="screen3" role="tab" data-toggle="tab">Data Collection</a></li>
				    <li role="presentation"><a href="#screen4" aria-controls="screen4" role="tab" data-toggle="tab">Test</a></li>
				    <li role="presentation"><a href="#screen5" aria-controls="screen5" role="tab" data-toggle="tab">Conclusions</a></li>
				    <li role="presentation"><a href="#screen6" aria-controls="screen6" role="tab" data-toggle="tab">Recommendations</a></li>
				</ul>
			</div>
		    </div>
		    <div class="tab-content" style="margin-top: 2em;">
			<!-- Tab One -->
                        <div role="tabpanel" class="tab-pane active" id="screen1">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h2 class="title text-center"><strong>Does sleep affect athletic performance?</strong></h2>
				    <h5 class="description" style="color: black;">
					<p>Ten college basketball players took part in a sleep experiment. For three weeks, the players slept for their usual amount of time. Their typical sleep averaged 6.7 hours each night. After three weeks, each player attempted ten free throws. The number of attempts and baskets made was recorded.</p>
					<p>Then, the players increased their sleep. With extended sleep they averaged 8.5 hours. After 6 weeks extended sleep, they each made another ten free throw attempts. The number of attempts and baskets made was recorded.</p>
				    </h5>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
				<div class="next">
				    <button type="button" class="btn btn-default btn-lg" onClick="next(2)">Next</button>
				</div>
			    </div>
			</div>
			<!--Tab Two-->
			<div role="tabpanel" class="tab-pane" id="screen2">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h2 class="title text-center"><strong>Hypothesize</strong></h2>
				    <h5 class="description" style="color: black;">
					<p>Make a prediction by selecting one of the following words to complete the sentence.</p>
				    </h5>
				</div>
			    </div>
			    <div class="row">
    				<div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
    				    <h5>If nightly sleep increases from players' typical sleep, then the number of free throw shots made will:</h5>
    				</div>
    				<table class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
    				    <tr>
    					<td>
    					    <section title="Select"><div class="select"><input type="radio" value="Increase" name="hypo" id="id_increase"  <?php if($hypothesisSave == "Increase")echo "checked"?>><label for="id_increase"></label></div></section>
    					</td>
    					<td>
    					    <span style="font-size: 20px">Increase</span>
    					</td>
    				    </tr>
    				    <tr style="height: 1em">
    				    </tr>
    				    <tr>
    					<td>
    					    <section title="Select"><div class="select"><input type="radio" value="Decrease" name="hypo" id="id_decrease" <?php if($hypothesisSave == "Decrease")echo "checked"?>><label for="id_decrease"></label></div></section>
    					</td>
    					<td>
    					    <span style="font-size: 20px">Decrease</span>
    					</td>
    				    </tr>
    				    <tr  style="height: 1em">
    				    </tr>
    				    <tr>
    					<td>
    					    <section title="Select"><div class="select"><input type="radio" value="Same" name="hypo" id="id_noChange" <?php if($hypothesisSave == "Same")echo "checked"?>><label for="id_noChange"></label></div></section>
    					</td>
    					<td>
    					    <span style="font-size: 20px">Stay at same</span>
    					</td>
    				    </tr>
    				</table>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
    				<div class="previous">
    				    <button type="button" class="btn btn-default btn-lg" onClick="previous(1)">Previous</button>
    				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
    				<div class="next">
    				    <button type="button" class="btn btn-default btn-lg" onClick="next(3)">Save & Next</button>
    				</div>
			    </div>
			</div>
			<!--Tab Three-->
			<div role="tabpanel" class="tab-pane" id="screen3">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h2 class="title text-center"><strong>Collect Data</strong></h2>
				    <h5 class="description" style="color: black;">
					<p><b>Select one Player.</b> Watch the videos for each attempt and record whether the basketball player made or missed the foul shot. <b>Record the total shots made.</b></p>
				    </h5>
				</div>
			    </div>
			    <div class="row">
				<select class="selectpicker" id="player">
				    <option value="0">Please select a player</option>
				    <?php
				    $range10 = range(1, 10);
				    foreach($range10 as $player) {
					if(!empty($playerSave)){
					$selected ='';
					if($player==$playerSave) $selected ='selected="selected"';
					    echo "<option value='".$player."'".$selected.">Player ".$player."</option>";
					}else{
					    echo "<option value='".$player."'>Player ".$player."</option>";
					}
				    }
				    ?>
				</select>
			    </div>
			    <div class="col-md-offset-1 col-md-9 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				<div class="row">
				    <table class='table'>
					<thead>
					    <tr>
						<th class="col-md-3 col-sm-3">Attempt</th><th>Typical Sleep</th>
					    </tr>
					</thead>
					<tbody>
					    <?php
					    foreach($range10 as $attempt) {
						echo "<tr>";
						echo "<td class='attempt'>" . $attempt . "</td>";
						echo "<td>";
						makeVideoButton($attempt, 'Day1');
						makeSelections('typical', $attempt);
						echo "</td>";
						echo "</tr>";
					    }
					    ?>
					    <tr>
						<td>Total</td>
						<td><label for="id_typical" style="color: black;">Enter Typical Sleep Shots Made:</label><input type="number" class="form-control" id="id_typical" value="<?php echo $typicalSleep ?>"></td>
					    </tr>
					</tbody>
				    </table>
				</div>
				<div class="row">
				    <table class='table'>
					<thead>
					    <tr>
						<th class="col-md-3 col-sm-3">Attempt</th><th>Extended Sleep</th>
					    </tr>
					</thead>
					<tbody>
					    <?php
					    foreach($range10 as $attempt) {
						echo "<tr>";
						echo "<td class='attempt'>" . $attempt . "</td>";
						echo "<td>";
						makeVideoButton($attempt, 'Day2');
						makeSelections('extended', $attempt);
						echo "</td>";
						echo "</tr>";
					    }
					    ?>
					    <tr>
						<td>Total</td>
						<td><label for="id_extended" style="color: black;">Enter Extended Sleep Shots Made:</label><input type="number" class="form-control" id="id_extended" value="<?php echo $extendSleep ?>"></td>
					    </tr>
					</tbody>
				    </table>
				</div>
			    </div>
			    <div >
				<div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
				    <h5>Did the player improve?</h5>
				</div>
				<table class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="Yes" name="improv" id="id_yes" <?php if($improvSave == "Yes")echo "checked"?>><label for="id_yes"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 20px">Yes</span>
					</td>
				    </tr>
				    <tr style="height: 1em">
				    </tr>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="No" name="improv" id="id_no"  <?php if($improvSave == "No")echo "checked"?>><label for="id_no"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 20px">No</span>
					</td>
				    </tr>
				    <tr  style="height: 1em">
				    </tr>
				</table>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(2)">Previous</button>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
				<div class="next">
				    <button type="button" class="btn btn-default btn-lg" onClick="next(4)">Save & Next</button>
				</div>
			    </div>
			</div>
			<!--Tab Four-->
			<div role="tabpanel" class="tab-pane" id="screen4">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h2 class="title text-center"><strong>Test your hypothesis</strong></h2>
				    <h5 class="description" style="color: black;">
					<p>Sports performance is often measured in percentages. Since 100 shots were made, the number of baskets made is the players’ shooting percentage.  For example, if they made all of their shots, their shooting percentage would be 100 out of 100, or 100%. If they made 50 shots of 100, their shooting percentage would be 50%. Add up separately the typical sleep shots made and the extended sleep shots made. Divide each sum by 100 to obtain the respective typical sleep and extended sleep shooting percentages.</p>
				    </h5>
				</div>
			    </div>
			    <div class="col-md-offset-1 col-md-9 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				<div class="row">
				    <table class="table">
					<thead>
					    <th>Player #</th><th>Typical Sleep shots made</th><th>Extended Sleep shots made</th>
					</thead>
					<tbody>
					    <tr>
						<td>1</td><td>9</td><td>9</td>
					    </tr>
					    <tr>
						<td>2</td><td>8</td><td>10</td>
					    </tr>
					    <tr>
						<td>3</td><td>8</td><td>9</td>
					    </tr>
					    <tr>
						<td>4</td><td>8</td><td>8</td>
					    </tr>
					    <tr>
						<td>5</td><td>7</td><td>9</td>
					    </tr>
					    <tr>
						<td>6</td><td>8</td><td>8</td>
					    </tr>
					    <tr>
						<td>7</td><td>7</td><td>9</td>
					    </tr>
					    <tr>
						<td>8</td><td>6</td><td>9</td>
					    </tr>
					    <tr>
						<td>9</td><td>9</td><td>8</td>
					    </tr>
					    <tr>
						<td>10</td><td>8</td><td>9</td>
					    </tr>
					</tbody>
				    </table>
				</div>
			    </div>
			    <div class="col-md-offset-1 col-md-9 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				<div class="row">
				    <table class="table">
					<thead>
					    <th>Typical sleep Shooting percentage (%)</th><th>Extended sleep Shooting percentage (%)</th>
					</thead>
					<tbody>
					    <td><input type="number" class="form-control" id="id_typical_perc" value="<?php echo $typicalPercent ?>"></td>
					    <td><input type="number" class="form-control" id="id_extended_perc" value="<?php echo $extendPercent ?>"></td>
					</tbody>
				    </table>
				</div>
			    </div>
			    <div >
				<div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
				    <h4>Your hypothesis was: If nightly sleep increases from players' typical sleep, then the number of free throw shots made will <span id="id_hypothesis" style="color: red"><?php echo $h ?></span></h4>
				    <h4>Did the data support your hypothesis?</h4>
				</div>
				<table class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="Yes" name="support" id="id_yes_4" <?php if($support == "Yes")echo "checked"?>><label for="id_yes_4"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 20px">Yes</span>
					</td>
				    </tr>
				    <tr style="height: 1em">
				    </tr>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="No" name="support" id="id_no_4" <?php if($support == "No")echo "checked"?>><label for="id_no_4"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 20px">No</span>
					</td>
				    </tr>
				    <tr  style="height: 1em">
				    </tr>
				</table>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(3)">Previous</button>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
				<div class="next">
				    <button type="button" class="btn btn-default btn-lg" onClick="next(5)">Save&Next</button>
				</div>
			    </div>
			</div>
			<!--Tab Five-->
			<div role="tabpanel" class="tab-pane" id="screen5">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h2 class="title text-center"><strong>Draw Conclusions from the Data</strong></h2>
				    <h5 class="description" style="color: black;">
					<p>In a typical college basketball game, a team shoots 20 to 24 free throws. Each free throw made is worth 1 point.  Use the table below to estimate how about how many more points a team would get after extended sleep.  Record your answer below the table.</p>
				    </h5>
				</div>
			    </div>

			    <div class="col-md-offset-1 col-md-9 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				<div class="row">
				    <table class="table">
					<thead>
					    <th>Free throws attempted</th><th>Predicted points based on making 78%  of attempts with players' typical sleep</th><th>Predicted points based on making 88% of attempts with players' extended sleep</th>
					</thead>
					<tbody>
					    <tr>
						<td>20</td><td>15.6</td><td>17.6</td>
					    </tr>
					    <tr>
						<td>21</td><td>16.4</td><td>18.5</td>
					    </tr>
					    <tr>
						<td>22</td><td>17.2</td><td>19.3</td>
					    </tr>
					    <tr>
						<td>23</td><td>17.9</td><td>20.2</td>
					    </tr>
					    <tr>
						<td>24</td><td>18.7</td><td>21.1</td>
					    </tr>
					</tbody>
				    </table>
				</div>
			    </div>
			    <div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
				<label for="points" style="color: black">When players increase their sleep, about how many more points (round to a whole number) would their team get?</label>
				<input type="number" class="form-control" id="points" name="points" value="<?php  if($points != 0){echo $points;}?>">
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(4)">Previous</button>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
				<div class="next">
				    <button type="button" class="btn btn-default btn-lg" onClick="next(6)">Save & Next</button>
				</div>
			    </div>
			</div>
			<!--Tab Six-->
			<div role="tabpanel" class="tab-pane" id="screen6">
			    <div class="row">
				<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				    <h2 class="title text-center"><strong>Recommended Sleep and Basketball Free Throws</strong></h2>
				    <!-- <h3><p>Answer the questions in your lab notebook: <a href="https://www.google.com/docs" target="_blank">Google Docs</a></p></h3>
					 <h5 class="description" style="color: black;">
					 <ol>
					 <li>Do you think that the increase in shooting percentage associated with getting extended sleep is limited to shooting free throws or might it also be associated with shooting the basketball during other parts of the game?</li>
					 <li>If you were the coach of a basketball team, how could you convince your players to get 8.5 or more hours of sleep a night?</li>
					 <li>Do you think that the lesson learned by finding an improvement in shooting percentage associated with getting extended sleep applies to other sports? If yes, provide an example in another sport. If not, why doesn’t it apply?</li>
					 </ol>
					 </h5>-->
				    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
					<h4>Implications of the research: Why is sleep called a “game changer?”</h4>
					<textarea class="form-control" rows="5" name="response" id="id_response"><?php echo $response ?></textarea>
					<p><b>Implications are the “take away” statements that help others</b> understand what the research results mean to them. </p>
				    </div>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-left">
				<div class="previous">
				    <button type="button" class="btn btn-default btn-lg" onClick="previous(5)">Previous</button>
				</div>
			    </div>
			    <div class="col-xs-6 col-md-6 col-sm-6 text-right">
				<div class="next">
					<button type="button" class="btn btn-default btn-lg" id="id_submit">Submit</button>
				</div>
			    </div>
			</div>
			<!-- Tab End -->
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="right" role="dialog" data-modal-index="1" data-backdrop="static" data-keyboard="false" aria-labelledby="right">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4>In a close game a 2 point difference can make the difference between
			    winning and losing</h4>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="showSix()">Ok</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="wrong" role="dialog" data-modal-index="1" data-backdrop="static" data-keyboard="false" aria-labelledby="wrong">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Recheck your addition and percent calculations. Multiply % made with typical sleep and extended sleep times 22 shots. Subtract these 2 numbers and estimate the difference by rounding the predicted points to the nearest whole number.</h4>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
		    </div>
		</div>
	    </div>
	</div>
	<div id="alert" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Alert</h4>
		    </div>
		    <div class="modal-body">
			<p id="alertMessage"></p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="confirm" role="dialog" data-modal-index="1" aria-labelledby="submitLabel">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			Are you sure?
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Yes</button>
			<button type="button" class="btn btn-success btn-simple" data-dismiss="modal">No</button>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<?php
	function makeVideoButton($attempt, $day)
	{
	    echo "<button class='btn btn-default btn-sm' type='button' day=" . $day . " attempt=" . $attempt;
	    echo " onclick=playVideo(this.getAttribute('attempt'),this.getAttribute('day'))>Video</button>";
	    echo "&nbsp";
	}

	function makeSelections($namePrefix, $index)
	{
	    echo "<div class='radio radio-info'><label style='color:black'><input type='radio' class='video-radio' name='" . $namePrefix . $index . "' id='" .$index. "' value='1'/>made</label> &nbsp";
	    echo "<label style='color:black'><input class='video-radio' type='radio' name='" . $namePrefix . $index . "' id='" .$index. "' value='0'/>missed</label></div>";
	}
	?>

	<script>
	 // Function triggered upon the video button being pressed

	 var player=0;
	 var show3 = false;
	 var show5 = false;
	 var show6 = false;
	 var typical = <?php echo json_encode($typical); ?>;
	 var extend = <?php echo json_encode($extend); ?>;
	 var id = <?php echo $userId; ?>;
	 var answerT, answerE;
	 var objT, objE;
	 var totalT, totalE;
	 var hypothesis;
	 var improvement;
	 var hypo;

	 $(function() {
	     player = <?php if(!empty($playerSave)){echo $playerSave; }else{echo 0;}?>;
	     if(player != 0){
		 totalT=0;
		 totalE=0;
		 localStorage.setItem('player'+id, player);
		 answerT = getRow(typical, player);
		 answerE = getRow(extend, player);
		 $.each(answerT,function(){totalT+=parseFloat(this) || 0;});
		 $.each(answerE,function(){totalE+=parseFloat(this) || 0;});
		 objT = answerT.reduce(function(acc, cur, i) {
		     acc[i] = cur;
		     return acc;
		 }, {});
		 objE = answerE.reduce(function(acc, cur, i) {
		     acc[i] = cur;
		     return acc;
		 }, {});
		 localStorage.setItem('totalT'+id, totalT);
		 localStorage.setItem('totalE'+id, totalE);
		 localStorage.setItem('objT'+id, JSON.stringify(objT));
		 localStorage.setItem('objE'+id, JSON.stringify(objE));
	     }
	 });

	 $("#id_increase").click(function(){
	     $("#id_hypothesis").text("increase.");
	     localStorage.setItem('hypothesis'+id, 'increase');
	     hypo = 'Increase';
	     $("#confirm").modal('show');
	 });

	 $("#id_decrease").click(function(){
	     $("#id_hypothesis").text("decrease.");
	     localStorage.setItem('hypothesis'+id, 'decrease');
	     hypo = 'Decrease';
	     $("#confirm").modal('show');
	 });

	 $("#id_noChange").click(function(){
	     $("#id_hypothesis").text("stay at same.");
	     localStorage.setItem('hypothesis'+id, 'noChange');
	     hypo = 'Same';
	     $("#confirm").modal('show');
	 });

	 $('#player').on('change', function() {
	     $('.video-radio').removeAttr('checked');
	     totalT=0;
	     totalE=0;
	     player = this.value;
	     localStorage.setItem('player'+id, player);
	     answerT = getRow(typical, player);
	     answerE = getRow(extend, player);
	     $.each(answerT,function(){totalT+=parseFloat(this) || 0;});
	     $.each(answerE,function(){totalE+=parseFloat(this) || 0;});
	     objT = answerT.reduce(function(acc, cur, i) {
		 acc[i] = cur;
		 return acc;
	     }, {});
	     objE = answerE.reduce(function(acc, cur, i) {
		 acc[i] = cur;
		 return acc;
	     }, {});
	     localStorage.setItem('totalT'+id, totalT);
	     localStorage.setItem('totalE'+id, totalE);
	     localStorage.setItem('objT'+id, JSON.stringify(objT));
	     localStorage.setItem('objE'+id, JSON.stringify(objE));
	     //console.log(objT);
	 })

	 function getRow(matrix, r){
	     var row = [];
	     for(var i=0; i<10; i++){
		 row.push(matrix[r-1][i]);
	     }
	     return row;
	 }

	 function playVideo(attempt, day)
	 {
	     if(player==0){
		 $("#alertMessage").text("Please select a player");
		 $("#alert").modal('show');
	     }else{
		 window.open("play-video" + "\?player=" + player + "&day=" + day + "&attempt=" + attempt, '_self');  // Open a new page to play video
	     }
	 }

	 //check selection
	 $('.video-radio').click(function() {
	     var question = $(this).attr('id');
	     var answer = $(this).val();
	     if(player == 0){
		 $("#alertMessage").text("Please select a player");
		 $("#alert").modal('show');
		 $(this).prop('checked', false);
	     }
	     //console.log(answer);
	     if($(this).attr('name').includes("typical")){
    		 if(objT[question-1] != answer){
    		     $("#alertMessage").text("Not right, the answer should be "+ ((answer==0)?'made':'missed') +".");
    		     $("#alert").modal('show');
             $('#' + question).prop('checked', true);
             $(this).prop('checked', false);
    		 }
	     }else{
    		 if(objE[question-1] != answer){
    		     $(this).prop('checked', false);
    		     $("#alertMessage").text("Not right, the answer should be "+ ((answer==0)?'made':'missed') +".");
    		     $("#alert").modal('show');
    		 }
	     }
	 });

	 function next(screen){
	     switch(screen){
		 case 2:
		     $('#group a[href="#screen2"]').tab('show');
		     break;
		 case 3:
		     if(!$("input[name='hypo']").is(":checked")){
			 $("#alertMessage").text("Please finish all questions");
			 $("#alert").modal('show');
		     }else{
			 $('body').scrollTop(0);
			 $('html').scrollTop(0);
			 $('#group a[href="#screen3"]').tab('show');
			 save();
		     }
		     break;
		 case 4:
		     if(!$('#id_typical').val()||!$('#id_extended').val()){
			 $("#alertMessage").text("Please finish all questions");
			 $("#alert").modal('show');
			 $('#id_no').prop('checked', false);
			 $('#id_yes').prop('checked', false);
		     }else if($('#id_typical').val()!= totalT){
			 $("#alertMessage").text("Please check your Typical Sleep Shots Made response");
			 $("#alert").modal('show');
			 $('#id_no').prop('checked', false);
			 $('#id_yes').prop('checked', false);
		     }else if($('#id_extended').val()!=totalE){
			 $("#alertMessage").text("Please check your Extended Sleep Shots Made response");
			 $("#alert").modal('show');
			 $('#id_no').prop('checked', false);
			 $('#id_yes').prop('checked', false);
		     }else if(!$('#id_no').is(":checked")&&!$('#id_yes').is(":checked")){
			 $("#alertMessage").text("Please finish all questions");
			 $("#alert").modal('show');
		     }else{
			 if($('#id_no').prop('checked') == true){
			     improvement = 'No';
			 }else if($('#id_yes').prop('checked') == true){
			     improvement = 'Yes';
			 }
			 $('body').scrollTop(0);
			 $('html').scrollTop(0);
			 $('#group a[href="#screen4"]').tab('show');
			 save();
		     }
		     break;
		 case 5:
		     if((!$('#id_typical_perc').val()||!$('#id_extended_perc').val()) || !$("input[name='improv']").is(":checked")){
			 $("#alertMessage").text("Please finish all questions");
			 $("#alert").modal('show');
			 break;
		     }
		     if($('#id_typical_perc').val() != 78){
			 $("#alertMessage").text("Please check the Total shots made Typical Sleep answer");
			 $("#alert").modal('show');
			 break;
		     }
		     if($('#id_extended_perc').val() != 88){
			 $("#alertMessage").text("Please check the Total shots made Extended Sleep answer");
			 $("#alert").modal('show');
			 break;
		     }
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen5"]').tab('show');
		     save();
		     break;
		 case 6:
		     if(!$('#points').val()){
			 $("#alertMessage").text("Please finish all questions");
			 $("#alert").modal('show');
			 break;
		     }
		     if($('#points').val() == 2 || $('#points').val() == 3 ){
			 $('#right').modal();
		     }else{
			 $('#wrong').modal();
			 break;
		     }
		     break;
	     }
	 }

	 function showSix(){
	     $('body').scrollTop(0);
	     $('html').scrollTop(0);
	     $('#group a[href="#screen6"]').tab('show');
	     save();
	 }

	 function previous(screen){
	     switch(screen){
		 case 1:
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen1"]').tab('show');
		     break;
		 case 2:
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen2"]').tab('show');
		     hypothesis = localStorage.getItem('hypothesis'+id);
		     if(hypothesis == 'increase'){
			 $("#id_increase").attr('checked');
			 hypo = 'Increase';
		     }else if(hypothesis  == 'decrease'){
			 $("#id_decrease").attr('checked');
			 hypo = 'Decrease';
		     }else if(hypothesis  == 'noChange'){
			 $("#id_noChange").attr('checked');
			 hypo = 'Stay at same';
		     }
		     break;
		 case 3:
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen3"]').tab('show');
		     break;
		 case 4:
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen4"]').tab('show');
		     break;
		 case 5:
		     $('body').scrollTop(0);
		     $('html').scrollTop(0);
		     $('#group a[href="#screen5"]').tab('show');
		     break;
	     }
	 }


	 $(function() {
	     $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		 localStorage.setItem('lastTab'+id, $(this).attr('href'));
	     });
	     player = localStorage.getItem('player'+id);
	     totalT = localStorage.getItem('totalT'+id);
	     totalE = localStorage.getItem('totalE'+id);
	     objT = JSON.parse(localStorage.getItem('objT'+id));
	     objE = JSON.parse(localStorage.getItem('objE'+id));

	     //console.log(objT);
	     var lastTab = localStorage.getItem('lastTab'+id);
	     if (lastTab) {
		 $('[href="' + lastTab + '"]').tab('show');
	     }

	     //reload hypothesis
	     hypothesis = localStorage.getItem('hypothesis'+id);
	     if(hypothesis == 'increase'){
		 $("#id_increase").prop('checked', true);
		 hypo = 'Increase';
		 show3= true;
		 //console.log(hypothesis);
	     }else if(hypothesis  == 'decrease'){
		 $("#id_decrease").prop('checked', true);
		 hypo = 'Decrease';
		 show3= true;
	     }else if(hypothesis  == 'noChange'){
		 $("#id_noChange").prop('checked', true);
		 hypo = 'Stay at same';
		 show3= true;
	     }
	     //$("#id_hypothesis").text(hypo+".");
	 });

	 //submit function
	 $('#id_submit').click(function() {
	     var result = confirm('Want to submit?');
	     if(!result){
		 return false;
	    }
	     var formData = {
		 'hypothesis': $("input[name='hypo']:checked").val(),
		 'player': $( "#player" ).val(),
		 'improvement': $("input[name='improv']:checked").val(),
		 'support': $("input[name='support']:checked").val(),
		 'points': $( "#points" ).val(),
		 'response': $('#id_response').val(),
		 'submit': 1
	     };

	     $.ajax({
		 type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		 url         : 'basketball-test-player-done', // the url where we want to POST
		 data        : formData, // our data object
		 dataType    : 'json', // what type of data do we expect back from the server
		 encode      : true
	     })
	      .success(function(data) {
		  if (!data.success) {
		      alert(data.errors);
		  }
		  else {
		      alert(data.message);
		      localStorage.clear();
		      location.href = "lesson-menu?<?php echo $query; ?>";
		  }
	      });
	 });

	 function save(){
	     var formData = {
		 'hypothesis': $("input[name='hypo']:checked").val(),
		 'player': $( "#player" ).val(),
		 'improvement': $("input[name='improv']:checked").val(),
		 'support': $("input[name='support']:checked").val(),
		 'points': $( "#points" ).val(),
		 'response': $('#id_response').val(),
		 'submit': 0
	     };

	     $.ajax({
		 type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		 url         : 'basketball-test-player-done', // the url where we want to POST
		 data        : formData, // our data object
		 dataType    : 'json', // what type of data do we expect back from the server
		 encode      : true,
		 success: function () {
                     $("#success-alert-text").html("Saved")
		     $("#success-alert").show(500).delay(3000);
                     $("#success-alert").hide(500);
		 },
		 error: function (){
                     $("#error-alert-text").html("There was an error processing your request; please try again.  If this error persists, contact the MySleep team.")
		     $("#error-alert").show(500).delay(6000);
                     $("#error-alert").hide(500);
		 }
	     })
	 }
	</script>
    </body>
</html>
