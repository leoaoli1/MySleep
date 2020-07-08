<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$diaryEntryId = $_POST['diaryEntryId'];
$userType = $_SESSION['userType'];
$_SESSION['diaryEntryId'] = $diaryEntryId;
$classId = $_SESSION['classId'];
if($userId==""){
    header("Location: login");
    exit;
}
require_once('connectdb.php');


if($userType == 'student'){
    $currentGrade = getGrade($userId);
}elseif($userType == 'teacher'){
    $currentGrade = getClassGrade($classId);
}

$result = mysql_query("SELECT diaryComputation FROM class_info_table WHERE classId='$classId'");
$row = mysql_fetch_array($result);
$diaryComputation = $row['diaryComputation'];

$lessonNum = $_POST['lesson'];
$activityNum = $_POST['activity'];
$config = array('lesson_num' => $lessonNum, 'activity_title' => 'Sleep Diary');
$query = $_POST['query'];
mysql_close($con);
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
	<link rel='stylesheet' type='text/css' href='assets/css/my-sleep-style.css'>
        <title>MySleep // Sleep Diary</title>

    </head>
    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php
          if ($config) {
            require_once('partials/nav-links.php');
            navigationLinkAddition($config,$userType,'<li><a class = "exit" data-location = "practice-diary-menu?'.$query.'">Practice Diary Menu</a></li>');
          }
          else {
       ?>
  		    <ol class="breadcrumb">
          		<li><a href="#" class = "exit" data-location="main-page">Home</a></li>
          		<li><a href="#" class = "exit" data-location="sleep-lesson">Lessons</a></li>
          		<li><a class = "exit" data-location = "practice-diary-menu">Practice Diary Menu</a></li>
          		<li class="active">Sleep Diary</li>
  		    </ol>
        <?php } ?>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description">Practice Sleep Diary for
				<?php
				echo $diaryEntryId;
				?>
			    </h4> <br>

			    <h4 class="description">Please complete this each morning when you wake up. The information you provide about bedtime/sleep is about the previous night's sleep. If you forget to complete it upon awakening, select the correct date and complete as soon as possible.</h4><br>

			    <div class="collapse-group">
				<p class="collapse description">If you skip a date, please be sure to select the correct date the morning you would have completed the diary. If you enter the wrong date and submit, please ask your teacher to fix the date so you can then enter the dates you need. If you submitted the diary with wrong information, please ask your teacher to release it for you to redo.</p>
				<a class="col-md-offset-5 col-md-2" href="#" id="instruMoreText">More Info</a>
			    </div>
			</div>
		    </div>


		    <form id="diaryForm" name="diaryForm" action="practice-sleep-diary-done" method="post">
          <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
			<div class="prompt_entry" ><label class='prompt_section'>Last night...</label></div>
			<div class="prompt_entry">
			    <label class="prompt">About 1 hour before going to sleep, I did the following activities (Choose all that apply from the options given):</label>
			    <div class="entry">
				<label><input type="checkbox" name='actBefSleepTV' id='actBefSleepTV'/>Watched TV</label><br>
				<label><input type="checkbox" name='actBefSleepMusic' id='actBefSleepMusic'/>Listened to music</label><br>
				<label><input type="checkbox" name='actBefSleepVideoGame' id='actBefSleepVideoGame'/>Played video games</label><br>
				<label><input type="checkbox" name='actBefSleepComp' id='actBefSleepComp'/>Used my laptop/tablet/computer</label><br>
				<label><input type="checkbox" name='actBefSleepRead' id='actBefSleepRead'/>Read</label><br>
				<label><input type="checkbox" name='actBefSleepHomework' id='actBefSleepHomework'/>Homework</label><br>
				<label><input type="checkbox" name='actBefSleepShower' id='actBefSleepShower'/>Showered/Took a warm bath</label><br>
				<label><input type="checkbox" name='actBefSleepPlayWithPeople' id='actBefSleepPlayWithPeople'/>Played with friends/family</label><br>
				<label><input type="checkbox" name='actBefSleepSnack' id='actBefSleepSnack'/>Snack/dessert</label><br>
				<label><input type="checkbox" name='actBefSleepText' id='actBefSleepText'/>Texting</label><br>
				<label><input type="checkbox" name='actBefSleepPhone' id='actBefSleepPhone'/>Talked on the phone</label><br>
				<label><input type="checkbox" name='actBefSleepDrinkCaff' id='actBefSleepDrinkCaff'/>Had caffeinated drink</label><br>
				<label><input type="checkbox" name='actBefSleepExercise' id='actBefSleepExercise'/>Exercised</label><br>
				<label><input type="checkbox" name='actBefSleepMeal' id='actBefSleepMeal'/>Ate a meal</label><br>
				<label><input type='checkbox' name='actBefSleepOther' id='actBefSleepOther' onchange='showTextView(this)'/>Other (Fill in reason)</label><br>
				<input class="entry"; type="text" name="actBefSleepOtherContent" id="actBefSleepOtherContent" </input>
			    </div>
			</div>
			<?php if($currentGrade == 4){ ?>
			    <div class="prompt_entry">
				<label class="prompt">Did your parents set your bed time?</label>
				<div class="entry">
				    <label><input type="radio" name="parentSetBedTime" value="1" />Yes</label><br>
				    <label><input type="radio" name="parentSetBedTime" value="0" />No</label><br>
				</div>
			    </div>
			<?php } ?>
			<div class="prompt_entry">
			    <label class="prompt"> I attempted to fall asleep at: </label>
			    <div class="entry">
				<select  id="lights_off_hour_id" name="lights_off_hour" onchange="update()"><?php showHourOptions(); ?></select>:
				<select  id="lights_off_min_id" name="lights_off_min" onchange="update()"><?php showMinuteOptions(); ?></select>
				<select  id="lights_off_ampm_id" name="lights_off_ampm" onchange="update()"><?php showAmPmOptions('pm'); ?></select>
				<button type="button" class="btn btn-default btn-sm" data-toggle="popover" data-trigger="hover" data-placement="right" title="" data-content="Attempted to fall asleep means you were in bed with the intent to go to sleep---this may mean turning lights off, saying goodnight to someone, or closing your eyes.">Info</button>
			    </div>

			</div>
			<div class="prompt_entry">
			    <label class="prompt">Number of <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" title="Unit minute" data-content="The unit here is minute."><b><mark>minutes</mark></b></a> it took to fall asleep:</label>
			    <div class="entry">
				        <select id="minFallAsleepId" name="minFallAsleep" onchange="update()"><?php showIntertuptMinuteOptions(); ?></select>&nbsp;(MM)
			    </div>
			    <!--<div class="entry">
				 <select id="fell_asleep_hour_id" name="fell_asleep_hour" onchange="update()"><?php showHourOptions(); ?></select>:
				 <select id="fell_asleep_min_id" name="fell_asleep_min" onchange="update()"><?php showMinuteOptions(); ?></select>
				 <select id="fell_asleep_ampm_id" name="fell_asleep_ampm" onchange="update()"><?php showAmPmOptions('pm'); ?></select>
				 <button type="button" class="btn btn-default btn-sm" data-toggle="popover" data-placement="right" title="" data-content="If you do not know the accurate time, you can guess it.">Info</button>
				 </div>-->
			</div>
			<div class="prompt_entry">
			    <label class="prompt">Number of times I woke up during the night:</label>
			    <input class="very_short_entry" name="numWokeup" type="number" min="0" max="50" step="1" value="">
			</div>
			<div class="prompt_entry">
			    <label class="prompt">Total <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" title="Unit minute" data-content="The unit here is minute."><b><mark>minutes</mark></b></a> my sleep was interrupted for across all awakenings:</label>
			    <div class="entry">
				<select id="minIntertuptId" name="minIntertupt" onchange="update()"><?php showIntertuptMinuteOptions(); ?></select>&nbsp;(MM)
			    </div>
			    <!--<input class="very_short_entry" id="minIntertuptId" name="minIntertupt" type="number" min="0" step="1" value="">-->
			</div>
			<div class="prompt_entry">
			    <label class="prompt">My sleep was interrupted by (Choose all that apply from the options given):</label>
			    <div class="entry">
				<label for="noise"><input type="checkbox" name="disturbedByNoise"/>Noise</label><br>
				<label for="pets"><input type="checkbox" name="disturbedBypets"/>Pets</label><br>
				<label for="electronics"><input type="checkbox" name="disturbedByElectronics"/>Electronics</label><br>
				<label for="familyMembers"><input type="checkbox" name="disturbedByFamily"/>Family members</label><br>
				<label for="badDreams"><input type="checkbox" name="disturbedByDream"/>Dreams</label><br>
				<label for="worries"><input type="checkbox" name="disturbedByWorries"/>Worries</label><br>
				<label for="busyMinds"><input type="checkbox" name="disturbedByBusyMinds"/>Busy Minds</label><br>
				<label for="lighting"><input type="checkbox" name="disturbedByLighting"/>Lighting</label><br>
				<label><input type="checkbox" name="disturbedByIllness"/>Illness</label><br>
				<label><input type="checkbox" name="disturbedByBodilyPain"/>Bodily pain</label><br>
				<label for="bathroom"><input type="checkbox" name="disturbedByBathroomNeed"/>Bathroom</label><br>
				<label for="temperature"><input type="checkbox" name="disturbedByTemperature"/>Temperature (too hot/cold)</label><br>
			        <label><input type="checkbox" name="disturbedByNothing"/>Nothing</label><br>
				<label><input type="checkbox" name="disturbedByUnknown"/>Unknown</label><br>
				<label><input type='checkbox' name='disturbedByOther' id='disturbedByOther' onchange='showTextView(this)'/>Other (Fill in reason)</label><br>
				<input class="entry"; type="text" name="disturbedByOtherContent" id="disturbedByOtherContent" </input>
			    </div>
			</div>
			<?php
			if ($currentGrade == 4)     // Special questions for 4th grade
			{
			    addDarknessQuestion();
			    addQuietnessQuestion();
			    addColdnessQuestion();
			}
			?>

			<?php if($currentGrade == 4){ ?>
			    <div class="prompt_entry">
				<label class="prompt">Which of the following statements best reflects how you woke up this morning?</label>
				<div class="entry">
				    <label><input type="radio" name="wakeUpWay" value="1" />I woke up on my own</label><br>
				    <label><input type="radio" name="wakeUpWay" value="2" />Someone else woke me up (parent, sibling, alarm clock, etc.)</label><br>
				</div>
			    </div>
			<?php } ?>

			<div class="prompt_entry">
			    <label class="prompt">Overall, my sleep last night was:</label>
			    <div class="entry">
				<label><input type="radio" name="sleepQuality" value="veryRestless" />(1)Very restless</label><br>
				<label><input type="radio" name="sleepQuality" value="restless" />(2)Restless</label><br>
				<label><input type="radio" name="sleepQuality" value="average" />(3)Fair quality</label><br>
				<label><input type="radio" name="sleepQuality" value="sound" />(4)Sound</label><br>
				<label><input type="radio" name="sleepQuality" value="verySound" />(5)Very sound</label><br>
			    </div>
			</div>
			<div class="prompt_entry" style="display: none">
			    <label class="prompt">Compared to other nights, my sleep last night was:</label>
			    <div class="entry">
				<label><input type="radio" name="sleepCompare" value="worse" />(1)Worse than usual</label><br>
				<label><input type="radio" name="sleepCompare" value="same" checked="checked"/>(2)Same as usual</label><br>
				<label><input type="radio" name="sleepCompare" value="better" />(3)Better than usual</label><br>
			    </div>
			</div>
			<div class="prompt_entry" ><label class='prompt_section'>This morning...</label></div>
			<div class="prompt_entry">
			    <label class="prompt">I woke up this morning at:</label>
			    <div class="entry">
				<select id="wakeuptime_hour_id" name="wakeuptime_hour" onchange="update()"><?php showHourOptions(); ?></select>:
				<select id="wakeuptime_min_id" name="wakeuptime_min" onchange="update()"><?php showMinuteOptions(); ?></select>
				<select id="wakeuptime_ampm_id" name="wakeuptime_ampm" onchange="update()"><?php showAmPmOptions(); ?></select>
				<button type="button" class="btn btn-default btn-sm" data-toggle="popover" data-trigger="hover" data-placement="right" title="" data-content="Final awakening(did not fall back asleep)">Info</button>
			    </div>

			</div>
			<div class="prompt_entry">
			    <label class="prompt">When I woke up, I felt:</label>
			    <div class="entry">
				<label for="tired"><input type="radio" name='wokeup_type' value='tired'/>(1)Tired</label><br>
				<label for="somewhatRefreshed"><input type="radio" name='wokeup_type' value='lessRefreshed'/>(2)Somewhat refreshed</label><br>
				<label for="refreshed"><input type="radio" name='wokeup_type' value='refreshed'/>(3)Refreshed</label><br>
			    </div>
			</div>
			<div style="display: <?php if($currentGrade == 4 && $diaryComputation == 0){ echo 'none';}?>">
			    <div class="prompt_entry" >
				<label class='prompt_section'>Calculate number of hours I slept...</label>
			    </div>
			    <!--<div class="row">
				 <div class="col-md-offset-3 col-md-6" style="padding-top: 1cm;">
				 <h4 class="description">

				 </h4>
				 </div>
				 </div>-->
			    <div class="prompt_entry" style="padding-top: 1cm;">
				<label class='prompt' id='step1Computation' ></label>
				<div class="entry">
				    <select><?php showHourOptions(24); ?></select>:
				    <select><?php showMinuteOptions(); ?></select>&nbsp;(HH:MM)
				</div>
			    </div>
			    <div class="prompt_entry">
				<label class='prompt' id='step2Computation' ></label>
				<div class="entry">
				    <div>
					<select><?php showHourOptions(24); ?></select>:
					<select><?php showMinuteOptions(); ?></select>&nbsp;(HH:MM)
				    </div>
				</div>
			    </div>
			    <div class="prompt_entry">
				<label class='prompt' id='step3Computation' ></label>
				<div class="entry">
				    <div>
					<select id="sleep_hours_id" name="sleep_hours"><?php showHourOptions(24); ?></select>:
					<select id="sleep_min_id" name="sleep_mins"><?php showMinuteOptions(); ?></select>&nbsp;(HH:MM)
				    </div>
				</div>
			    </div>
			    <div class="prompt_entry">
				<label class="prompt">Step 4: Check your step 3 result.</label>
				<input id="computedSleepHours" name="computedSleepHours" class="text" style='font-size:inherit' value="" readonly></input>
				<button class='btn' type='button' id='computeButton' onclick='computeAndShowSleepTime()'>Check</button>
			    </div>
			</div>
		    </form>
		    <div class="row">
			<div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
			    <a class="btn btn-gradpr btn-roundBold btn-large btn-block" id ="submit-form">Submit</a>
			</div>
		    </div>
	        </div>
	    </div>
	</div>
	<!-- Model -->
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
	<div id="alert2" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Alert</h4>
		    </div>
		    <div class="modal-body">
			<p id="alertMessage2"></p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			<button type="button" class="btn btn-success btn-simple" id="show-submit">Yes, Submit</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="submit-modal" role="dialog" data-modal-index="1" aria-labelledby="submitLabel">
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
			<button type="button" class="btn btn-success btn-simple" id="confirm-submit">Yes, Submit</button>
		    </div>
		</div>
	    </div>
	</div>
	<?php 	include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script>
	 //regularUpdate();
	 //setInterval(regularUpdate, 2000);
	 var sleepOtherContent;
	 var disturbedByOtherContent;
	 var showSleepOtherContent = true;
	 var showDisturbedByOtherContent = true;
	 var currentGrade = <?php echo $currentGrade ?>;
	 var diaryComputation = <?php echo $diaryComputation ?>;
	 window.onload = function () {
	     sleepOtherContent = document.getElementById('actBefSleepOtherContent');
	     sleepOtherContent.style.visibility = 'hidden';
	     disturbedByOtherContent = document.getElementById('disturbedByOtherContent');
	     disturbedByOtherContent.style.visibility = 'hidden';
	     update();
	 }

	 function showTextView(element) {
	     var name = element.getAttribute("name");
	     if (name=='actBefSleepOther') {
		 if (showSleepOtherContent) {
		     sleepOtherContent.style.visibility = 'visible';
		     showSleepOtherContent = false;
		 }else {
		     sleepOtherContent.style.visibility = 'hidden';
		     showSleepOtherContent = true;
		 }
	     }

	     if (name=='disturbedByOther') {
		 if (showDisturbedByOtherContent) {
		     disturbedByOtherContent.style.visibility = 'visible';
		     showDisturbedByOtherContent = false;
		 }else {
		     disturbedByOtherContent.style.visibility = 'hidden';
		     showDisturbedByOtherContent = true;
		 }
	     }
	 }

	 function update()
	 {
	     document.getElementById('step1Computation').innerHTML = getStep1Prompt();
	     document.getElementById('step2Computation').innerHTML = getStep2Prompt();
	     document.getElementById('step3Computation').innerHTML = getStep3Prompt();
	 }

	 /*function regularUpdate()
	    {
	    document.getElementById('step1Computation').innerHTML = getStep1Prompt();
	    document.getElementById('step2Computation').innerHTML = getStep2Prompt();
	    document.getElementById('step3Computation').innerHTML = getStep3Prompt();
	    }*/

	 // Function to make up the prompt for step 1 calculation for sleep hours
	 function getStep1Prompt()
	 {
	     var prompt = 'Step 1: The time between I attempted fall asleep';
	     prompt += "(" + document.getElementById('lights_off_hour_id').value + ":";
	     prompt += document.getElementById('lights_off_min_id').value + " ";
	     prompt += document.getElementById('lights_off_ampm_id').value + ")";
	     prompt += ' and when I woke up this morning ';
	     prompt += "(" + document.getElementById('wakeuptime_hour_id').value + ":";
	     prompt += document.getElementById('wakeuptime_min_id').value + " ";
	     prompt += document.getElementById('wakeuptime_ampm_id').value + ")";
	     prompt += 'is :';
	     return prompt;
	 }

	 // Function to make up the prompt for step 2 calculation for sleep hours
	 function getStep2Prompt()
	 {
	     /*var lightOffTimeStr = getTimeString24HourFormat(document.getElementById('lights_off_hour_id').value, document.getElementById('lights_off_min_id').value, "0", document.getElementById('lights_off_ampm_id').value);
		var fellAsleepTimeStr = getTimeString24HourFormat(document.getElementById('fell_asleep_hour_id').value, document.getElementById('fell_asleep_min_id').value, "0", document.getElementById('fell_asleep_ampm_id').value);
		var tookFallSleepSec = computeElapsedTime(lightOffTimeStr, fellAsleepTimeStr);
		var tookFallSleep = Math.floor(tookFallSleepSec/60);
		if (tookFallSleep == '')
		tookFallSleep = 0;*/
	     var tookFallSleep = document.getElementById('minFallAsleepId').value;
	     var prompt = 'Step 2: Subtract “number of minutes it took to fall asleep”';
	     prompt += "(" + tookFallSleep + "Min)";
	     prompt += ' from Step 1:';
	     return prompt;
	 }

	 // Function to make up the prompt for step 3 calculation for sleep hours
	 function getStep3Prompt()
	 {
	     var minIntertupted = document.getElementById('minIntertuptId').value;
	     if (minIntertupted == '')
		 minIntertupted = 0;
	     var prompt = 'Step 3: Subtract total minutes interrupted ';
	     prompt += "(" + minIntertupted + "Min)";
	     prompt += ' from Step 2:';
	     return prompt;
	 }

	 // Function to display instructions on how to calculate sleep time
	 function showSleepHourCalculationHelp()
	 {
	     // window.alert("Total sleep time = " +
	     // "Time woke up - Time fell asleep - Time sleep was interrupted.\n" +
	     // "Remember to account for time before midnight.");
	     window.alert("Total sleep time = " +
			  "Sleep duration - Time sleep was interrupted.");
	 }

	 function padZero(time)
	 {
	     var str = "00" + time;
	     return str.substr(str.length - 2);
	 }

	 function computeElapsedTime(time1, time2)
	 {
	     var t1 = time1.split(":");
	     var time1Sec = t1[0] * 3600 + t1[1] * 60 + t1[2] * 1;
	     var t2 = time2.split(":");
	     var time2Sec = t2[0] * 3600 + t2[1] * 60 + t2[2] * 1;

	     var diffTimeSec;
	     if (time1Sec > time2Sec)      // Cross midnight
		 diffTimeSec = 24 * 60 * 60 - time1Sec + time2Sec;
	     else
		 diffTimeSec = time2Sec - time1Sec;
	     return diffTimeSec;
	 }

	 function toSecond(time1){
	     var t1 = time1.split(":");
	     var time1Sec = t1[0] * 3600 + t1[1] * 60 + t1[2] * 1;
	     return time1Sec;
	 }

	 function roundUp(num, precision)
	 {
	     var temp = num * Math.pow(10, precision);
	     return Math.round(temp) / Math.pow(10, precision);
	 }

	 // Function to compute the sleep time and display it on a pop-up window
	 function computeAndShowSleepTime()
	 {

	     var sleepTime = computeSleepTime();
	     var hours = Math.floor(sleepTime);
	     var minutes = roundUp((sleepTime - hours) * 60, 0);
	     document.getElementById('computedSleepHours').value  = hours + ":" + ("0" + minutes).slice(-2);
	     document.getElementById('computedSleepHours').style.visibility = 'visible';
	     if((diaryComputation == '1') || (currentGrade == '5')){
	     alert("This will compute the actual time you reported to be asleep. If you make an error, the computed value will differ from your calculation. The correct total sleep time will show up in the sleep dairy tables.");
	     }
	     }

	 function computeAndSendSleepTime()
	 {
	     var sleepTime = computeSleepTime();
	     var hours = Math.floor(sleepTime);
	     var minutes = roundUp((sleepTime - hours) * 60, 0);
	     document.getElementById('computedSleepHours').value  = hours + ":" + ("0" + minutes).slice(-2);
	     //document.getElementById('computedSleepHours').style.visibility = 'visible';
	 }

	 function getTimeString24HourFormat(hour, minute, second, ampm)
	 {
	     var hours = Number(hour);
	     var minutes = Number(minute);
	     var seconds = Number(second);
	     if (((ampm == "PM") || (ampm == "pm")) && hours < 12)
		 hours += 12;
	     else if (((ampm == "AM") || (ampm == "am")) && hours >= 12)
		 hours -= 12;
	     return padZero(hours) + ":" + padZero(minutes) + ":" + padZero(seconds);
	 }

	 function computeSleepTime()
	 {
	     var wokeTimeStr = getTimeString24HourFormat(document.getElementById('wakeuptime_hour_id').value, document.getElementById('wakeuptime_min_id').value, "0", document.getElementById('wakeuptime_ampm_id').value);
	     //var fellAsleepTimeStr = getTimeString24HourFormat(document.getElementById('fell_asleep_hour_id').value, document.getElementById('fell_asleep_min_id').value, "0", document.getElementById('fell_asleep_ampm_id').value);
	     var lightOffTimeStr = getTimeString24HourFormat(document.getElementById('lights_off_hour_id').value, document.getElementById('lights_off_min_id').value, "0", document.getElementById('lights_off_ampm_id').value);
	     var minFallAsleep = Number(document.getElementById('minFallAsleepId').value);
	     var minIntertupt = Number(document.getElementById('minIntertuptId').value);

	     var sleepTimeSec = computeElapsedTime(lightOffTimeStr, wokeTimeStr);
	     //sleepTimeSec = toSecond(wokeTimeStr);
	     sleepTimeSec -= minFallAsleep * 60;
	     sleepTimeSec -= minIntertupt * 60.0;
	     return sleepTimeSec / (60 * 60);        // Return difference in hours
	 }

	 // Function to respond to a change in the hours-slept entry box
	 function checkHourSleptEntry()
	 {
	     var entry = document.getElementById('sleepTimeHourId');
	     var computeButton = document.getElementById('computeButton');
	     var computed = document.getElementById('computedSleepHours').innerHTML;
	     computeButton.style.visibility = 'visible';
	 }

	 // Function to respond to the Submit being clicked
	 $("#submit-form").click(function(){
	     var lightOffHour = $('#lights_off_hour_id').val();
	     var lightOffMin = $('#lights_off_min_id').val();
	     var lightOffAmPm = $('#lights_off_ampm_id').val();
	     //alert(lightOffHour+','+lightOffMin+','+lightOffAmPm);
	     if(currentGrade == 4){
		 if(lightOffHour == '00' && lightOffMin == '00' && lightOffAmPm == 'PM'){
		     $("#alertMessage").text("Please check your fall asleep time. 00:00 AM is midnight; 12:00 PM is noon");
		     $("#alert").modal('show');
		     return false;
		 }else if(lightOffHour == '12' && lightOffMin == '00' && lightOffAmPm == 'PM'){
		     $("#alertMessage2").text("12:00 PM is noon. Did you fall asleep at noon?");
		     $("#alert2").modal('show');
		     return false;
		 }
		 if(!$('[name="sleepQuality"]').is(':checked') || !$('[name="sleepCompare"]').is(':checked') || !$('[name="wokeup_type"]').is(':checked') || !$('[name="roomDarkness"]').is(':checked') || !$('[name="roomQuietness"]').is(':checked') || !$('[name="roomWarmness"]').is(':checked') ){
		     $("#alertMessage").text("Please fill in all required fields.");
		     $("#alert").modal('show');
		     return false;
		 }
		 if(diaryComputation == '0'){
		     computeAndShowSleepTime();
		 }else{
		     if($('#computedSleepHours').val() == ""){
			 $("#alertMessage").text("Please click the 'check' button to see the total sleep.");
			 $("#alert").modal('show');
			 return false;
		     }
		 }
		 $("#submit-modal").modal('show');
		 return true;
	     }else{
		 if(lightOffHour == '00' && lightOffMin == '00' && lightOffAmPm == 'PM'){
		     $("#alertMessage").text("Please check your fall asleep time. 00:00 AM is midnight; 12:00 PM is noon");
		     $("#alert").modal('show');
		     return false;
		 }else if(lightOffHour == '12' && lightOffMin == '00' && lightOffAmPm == 'PM'){
		     $("#alertMessage2").text("12:00 PM is noon. Did you fall asleep at noon?");
		     $("#alert2").modal('show');
		     return false;
		 }
		 if($('#computedSleepHours').val() == "" || !$('[name="sleepQuality"]').is(':checked') || !$('[name="sleepCompare"]').is(':checked') || !$('[name="wokeup_type"]').is(':checked') ){
		     $("#alertMessage").text("Please fill in all required fields.");
		     $("#alert").modal('show');
		     return false;
		 }
		 $("#submit-modal").modal('show');
		 return true;
	     }
	     //computeAndSendSleepTime();
	 });
	 $("#confirm-submit").click(function(){
	     $("#diaryForm").submit();
	 });

	 $("#show-submit").click(function(){
	     $("#alert2").modal('hide');
	     $("#submit-modal").modal('show');
	 });

	 $(function () {
	     $('[data-toggle="popover"]').popover()
	 })

	 $("#instruMoreText").on('click', function(e) {
	     e.preventDefault();
	     var $this = $(this);
	     var $collapse = $this.closest('.collapse-group').find('.collapse');
	     $collapse.collapse('toggle');
	     if($this.text()=="More Info"){
		 $this.text("Less Info");
	     }else{
		 $this.text("More Info");
	     }
	 });
	</script>

	<?php
	function addDarknessQuestion()
	{
	    // There are no entries in the database yet for 4th grade questions. Should follow the same way as other degree parameters, use enum, not numerical values in the database.
	    echo '<div class="prompt_entry">
            <label class="prompt">How dark was my bedroom?</label>
	    <div class="entry">
	    <label><input type="radio" name="roomDarkness" value="1" />(1)Very bright</label><br>
	    <label><input type="radio" name="roomDarkness" value="2" />(2)Somewhat bright</label><br>
	    <label><input type="radio" name="roomDarkness" value="3" />(3)Dim</label><br>
	    <label><input type="radio" name="roomDarkness" value="4" />(4)Mostly dark</label><br>
	    <label><input type="radio" name="roomDarkness" value="5" />(5)Very dark</label><br>
	    </div>
	    </div>';
	}

	function addQuietnessQuestion()
	{
	    echo '<div class="prompt_entry">
	    <label class="prompt">How quiet was my bedroom?</label>
	    <div class="entry">
	    <label><input type="radio" name="roomQuietness" value="1" />(1)Very noisy</label><br>
	    <label><input type="radio" name="roomQuietness" value="2" />(2)Mostly noisy</label><br>
	    <label><input type="radio" name="roomQuietness" value="3" />(3)Sometimes noisy/sometimes quiet</label><br>
	    <label><input type="radio" name="roomQuietness" value="4" />(4)Mostly quiet</label><br>
	    <label><input type="radio" name="roomQuietness" value="5" />(5)Very quiet</label><br>
	    </div>
	    </div>';
	}

	function addColdnessQuestion()
	{
	    echo '<div class="prompt_entry">
	    <label class="prompt">How comfortable was the temperature in my bedroom?</label>
	    <div class="entry">
	    <label><input type="radio" name="roomWarmness" value="1" />(1)Very uncomfortable (Too hot/cold)</label><br>
	    <label><input type="radio" name="roomWarmness" value="2" />(2)Somewhat uncomfortable (slightly too warm/chilly)</label><br>
	    <label><input type="radio" name="roomWarmness" value="3" />(3)Comfortable (just the right temperature)</label><br>
	    </div>
	    </div>';
	}


	?>
    </body>
</html>
