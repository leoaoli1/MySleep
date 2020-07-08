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
if($userId==""){
    header("Location: login.php");
    exit;
}
require_once('connectdb.php');


if($userType == 'student'){
    $currentGrade = getGrade($userId);
}elseif($userType == 'teacher'){
    $classId = $_SESSION['classId'];
    $currentGrade = getClassGrade($classId);
   }

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
        <title>MySleep //Sleep Diary</title>

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
      			<li><a href="#" class = "exit" data-location="practice-diary-menu">Practice Diary Menu</a></li>
      			<li class="active">Activity Diary</li>
		    </ol>
        <?php } ?>
		    <div class="row">
		       <div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
           <h4 class="description"> Practice Activity Diary for
				<?php
				echo $diaryEntryId;
				?>
			     </h4>
           <h4 class="description"> Please compete the Activity Diary every evening before you go to bed. The information you provide at bed time is about your day. If you forget, select the correct date and complete it as soon as possible.
           </h4>
			</div>
		    </div>

		    <form id="activityForm" action="practice-activity-diary-done" method="post">

          <div class="prompt_entry" ><label class='prompt_section'>Today...</label></div>
          <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
			<div class="prompt_entry">
			    <label class="prompt">I napped today.</label>
			    <div class="entry">
				<input type='checkbox' id='nappedToday' name='nappedToday' onclick='nappedTodayCheck()'/>
			    </div>
			</div>
			<div id='napTime' class="prompt_entry">
			    <label class="prompt">I napped during the day from:</label>
			    <div class="entry">
				<select name="napStart_hour"><?php showHourOptions(); ?></select>:
				<select name="napStart_min"><?php showMinuteOptions(); ?></select>
				<select name="napStart_ampm"><?php showAmPmOptions(); ?></select>
				to
				<select name="napEnd_hour"><?php showHourOptions(); ?></select>:
				<select name="napEnd_min"><?php showMinuteOptions(); ?></select>
				<select name="napEnd_ampm"><?php showAmPmOptions(); ?></select>
			    </div>
			</div>
			<!--<div class="prompt_entry">
			     <label class="prompt">I consumed caffeinated drinks (e.g., coffee, tea, cola, energy drinks) in the (Check all that apply):</label>
			     <div class="entry">
			     <label for="morning"><input type="checkbox" name='caffDrinkMorning' id='caffMorning' onclick='caffDrinkCheck()'/>Morning</label>
			     <label for="afternoon"><input type="checkbox" name='caffDrinkAfternoon' id='caffAfternoon' onclick='caffDrinkCheck()'/>Afternoon</label><br>
			     <label for="beforeBed"><input type="checkbox" name='caffDrinkWithinBedtime' id='caffWithinBedtime'  onclick='caffDrinkCheck()'/>Within several hours before going to bed</label><br>
			     <label for="nothing"><input type="checkbox" id='caffNothing' onclick='caffDrinkNothingCheck()'/>Did not consume caffeinated drinks today</label><br>
			     </div>
			     </div>-->
			<!--<div class="prompt_entry">
			     <label class="prompt">I exercised today in the (Check all that apply):</label>
			     <div class="entry">
			     <label for="morning"><input type="checkbox" name='exercisedMorning' id='exerMorning' onclick='exerCheck()'/>Morning</label>
			     <label for="afternoon"><input type="checkbox" name='exercisedAfternoon' id='exerAfternoon' onclick='exerCheck()'/>Afternoon</label><br>
			     <label for="beforeBed"><input type="checkbox" name='exercisedWithinBedtime' id='exerWithinBedtime' onclick='exerCheck()'/>Within several hours before going to bed</label><br>
			     <label for="nothing"><input type="checkbox" id='exerNothing' onclick='exerNothingCheck()'/>Did not exercise today</label><br>
			     </div>
			     </div>-->
			<div class="prompt_entry">
			    <label class="prompt">Number of caffeinated drinks (soda, energy drinks, coffee, tea) I had:</label>
			    <input class="very_short_entry" name="numCaffeinatedDrinks" type="number" min="0" step="1" value="">
			</div>
			<div class="prompt_entry">
			    <label class="prompt">Number of <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" title="Unit minute" data-content="The unit here is minute. If you enter 5 here, that means you exercised 5 minutes."><b><mark>minutes</mark></b></a> I exercised for:</label>
			    <input class="very_short_entry" name="numExercised" type="number" min="0" step="1" value="">
			</div>
			<?php if($currentGrade == 4){ ?>
			    <div class="prompt_entry">
				<label class="prompt">Number of <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" title="Unit minute" data-content="The unit here is minute. If you enter 10 here, that means you played 10 minutes video games."><b><mark>minutes</mark></b></a> I played video games today:</label>
				<input class="very_short_entry" name="minVideoGame" type="number" min="0" step="1" value="">
			    </div>

			    <div class="prompt_entry">
				<label class="prompt">Number of <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" title="Unit minute" data-content="The unit here is minute. If you enter 15 here, that means you worked 15 minutes on computer."><b><mark>minutes</mark></b></a> I spent using a computer today:</label>
				<input class="very_short_entry" name="minComputer" type="number" min="0" step="1" value="">
			    </div>

			    <div class="prompt_entry">
				<label class="prompt">Number of <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" title="Unit minute" data-content="The unit here is minute. If you enter 5 here, that means you spent 5 minutes on other technology."><b><mark>minutes</mark></b></a> I spent using other technology today. This could include watching television, using a tablet or smartphone, or other devices:</label>
				<input class="very_short_entry" name="minTechnology" type="number" min="0" step="1" value="">
			    </div>
			    <?php } ?>

			    <div class="prompt_entry">
			    <label class="prompt">Today I experienced the following symptoms (Check all that apply):</label>
			    <div class="entry">
				<label><input type="checkbox" name='symptomRunnyNose' id='symptomRunnyNose'/>Runny Nose🤧</label><br>
				<label><input type="checkbox" name='symptomSoreThroat' id='symptomSoreThroat'/>Sore Throat</label><br>
				<label><input type="checkbox" name='symptomStuffyNose' id='symptomStuffyNose'/>Stuffy Nose (Congestion)</label><br>
				<label><input type="checkbox" name='symptomItchyEyes' id='symptomItchyEyes'/>Itchy Eyes</label><br>
				<label><input type="checkbox" name='symptomHeadache' id='symptomHeadache'/>Headache</label><br>
				<label><input type="checkbox" name='symptomFever' id='symptomFever'/>Fever</label><br>
				<label><input type="checkbox" name='symptomSneezing' id='symptomSneezing'/>Sneezing (more than usual)</label><br>
				<label><input type="checkbox" name='symptomCoughing' id='symptomCoughing'/>Coughing</label><br>
				<label><input type="checkbox" name='symptomBodyAches' id='symptomBodyAches'/>Body/Muscle aches</label><br>
				<label><input type="checkbox" name='symptomStomach' id='symptomStomach'/>Nausea/stomach ache</label><br>
				<label><input type="checkbox" name='symptomUnknown' id='symptomUnknown'/>Unknown</label><br>
				<label><input type="checkbox"/>None</label><br>
			    </div>
			</div>
			<!--<div class="prompt_entry">
			     <label class="prompt">Approximately 2-3 hours before going to bed, I consumed (Check all that apply):</label>
			     <div class="entry">
			     <label for="caffeine"><input type="checkbox" "name=food_type" id="caffeine"/>Caffeine (e.g., coffee, tea, cola, energy drinks)</label><br>
			     <label for="heavyMeal"><input type="checkbox" "name=food_type" id="heavyMeal"/>A heavy meal</label><br>
			     <label for="notApplicable"><input type="checkbox" "name=food_type" id="notApplicable"/>Not applicable</label><br>
			     </div>
			     </div>-->
			<!--<div class="prompt_entry">
			     <label class="prompt">I took medication during the day:</label>
			     <div class="entry">
			     <input type="radio" name="medication" value="yes" />Yes
			     <input type="radio" name="medication" value="no" />No
			     </div>
			     </div>-->
			<!--<div class="prompt_entry">
			     <label class="prompt">About 1 hour before going to sleep, I did the following activity (Check all that apply):</label>
			     <div class="entry">
			     <label for="tv"><input type="checkbox" name='actBefSleepTV' id='actBefSleepTV'/>Watched TV</label><br>
			     <label for="music"><input type="checkbox" name='actBefSleepMusic' id='actBefSleepMusic'/>Listened to music</label><br>
			     <label for="videoGames"><input type="checkbox" name='actBefSleepVideoGame' id='actBefSleepVideoGame'/>Played video games</label><br>
			     <label for="computer"><input type="checkbox" name='actBefSleepComp' id='actBefSleepComp'/>Used my laptop/tablet/computer</label><br>
			     <label for="read"><input type="checkbox" name='actBefSleepRead' id='actBefSleepRead'/>Read</label><br>
			     <label for="homework"><input type="checkbox" name='actBefSleepHomework' id='actBefSleepHomework'/>Homework</label><br>
			     </div>
			     </div>-->
			<?php if ($currentGrade == 5){?>
			    <div class='prompt_entry'>
				<label class='prompt'>How would you rate your mood during the day?</label>
				<div class='entry'>
				    <label><input type='radio' name='feltDuringDay' value='veryUnpleasant' />(1)&#x1f620 Very unpleasant</label><br>
				    <label><input type='radio' name='feltDuringDay' value='unpleasant' />(2)&#x1f61e Unpleasant</label><br>
				    <label><input type='radio' name='feltDuringDay' value='sometimesPleasant' />(3)&#x1f614 Sometimes pleasant, sometimes unpleasant</label><br>
				    <label><input type='radio' name='feltDuringDay' value='pleasant' />(4)&#x1f603 Pleasant</label><br>
				    <label><input type='radio' name='feltDuringDay' value='veryPleasant' />(5)&#x1f601 Very pleasant</label><br>
				</div>
			    </div>


			    <div class='prompt_entry'>
				<label class='prompt'>How well were you able to focus and pay attention in class today?</label>
				<div class='entry'>
				    <label><input type='radio' name='attention' value='never' />(1)I couldn’t focus today</label><br>
				    <label><input type='radio' name='attention' value='little' />(2)I was able to focus occasionally</label><br>
				    <label><input type='radio' name='attention' value='sometimes' />(3)I was able to focus about half of the time</label><br>
				    <label><input type='radio' name='attention' value='mostly' />(4)I was able to focus most of the day</label><br>
				    <label><input type='radio' name='attention' value='always' />(5)I was able to focus all day</label><br>
				</div>
			    </div>


			    <div class='prompt_entry'>
				<label class='prompt'>How would you describe your behavior today?:</label>
				<div class='entry'>
				    <label><input type='radio' name='behavior' value='excellent' />(1)I followed classroom and home rules and never disrupted the activities of others</label><br>
				    <label><input type='radio' name='behavior' value='good' />(2)I mostly followed the classroom rules at home and school and rarely disrupted the activities of others</label><br>
				    <label><input type='radio' name='behavior' value='somewhatDifficult' />(3)I sometimes had trouble following the classroom and home rules and occasionally disrupted the activities of others</label><br>
				    <label><input type='radio' name='behavior' value='challenging' />(4)I had trouble following the classroom and home rules and often disrupted the activities of others</label><br>
				</div>
			    </div>


			    <div class='prompt_entry'>
				<label class='prompt'>Today, my interactions with others were:</label>
				<div class='entry'>
				    <label><input type='radio' name='interaction' value='excellent' />(1)Excellent</label><br>
				    <label><input type='radio' name='interaction' value='good' />(2)Good</label><br>
				    <label><input type='radio' name='interaction' value='somewhatDifficult' />(3)Somewhat Difficult</label><br>
				    <label><input type='radio' name='interaction' value='challenging' />(4)Challenging</label><br>
				</div>
			    </div>

			<?php } ?>
			<div class="prompt_entry">
			    <label class="prompt">Sleepiness during the day:</label>
			    <div class="entry">
				<label><input type="radio" name="howSleepy" value="very" />(1)&#x1f634 Very sleepy (fell asleep during activity)</label><br>
				<label><input type="radio" name="howSleepy" value="sleepy" />(2)&#x1f62e Sleepy (struggled to stay awake)</label><br>
				<label><input type="radio" name="howSleepy" value="somewhat" />(3)&#x1f64d Somewhat sleepy</label><br>
				<label><input type="radio" name="howSleepy" value="not" />(4)&#x1f64c Not sleepy</label><br>
			    </div>
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
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script>
	 document.getElementById('nappedToday').checked = false;
	 nappedTodayCheck();
	 var currentGrade = <?php echo $currentGrade; ?>;



	 function caffDrinkNothingCheck() {
	     if (document.getElementById('caffNothing').checked) {
		 document.getElementById('caffMorning').checked = false;
		 document.getElementById('caffAfternoon').checked = false;
		 document.getElementById('caffWithinBedtime').checked = false;
	     }
	 }

	 function caffDrinkCheck() {
	     if (document.getElementById('caffMorning').checked ||
		 document.getElementById('caffAfternoon').checked ||
		 document.getElementById('caffWithinBedtime').checked)
		 document.getElementById('caffNothing').checked = false;
	 }

	 function exerNothingCheck() {
	     if (document.getElementById('exerNothing').checked) {
		 document.getElementById('exerMorning').checked = false;
		 document.getElementById('exerAfternoon').checked = false;
		 document.getElementById('exerWithinBedtime').checked = false;
	     }
	 }

	 function exerCheck() {
	     if (document.getElementById('exerMorning').checked ||
		 document.getElementById('exerAfternoon').checked ||
		 document.getElementById('exerWithinBedtime').checked)
		 document.getElementById('exerNothing').checked = false;
	 }

	 function nappedTodayCheck() {
	     var napTime = document.getElementById('napTime');
	     var state = true;
	     if (!document.getElementById('nappedToday').checked)
		 state = false;

	     //toggleElementEnableDisable(napTime);
	     if (state == true)
		 napTime.style.visibility = 'visible';
	     else
		 napTime.style.visibility = 'hidden';
	 }

	 // Function to respond to the Submit being clicked
	 $("#submit-form").click(function(){
	     if(currentGrade == 5){
		 if($('[name="feltDuringDay"]').is(':checked') &&  $('[name="howSleepy"]').is(':checked')  && $('[name="attention"]').is(':checked')  && $('[name="behavior"]').is(':checked')  && $('[name="interaction"]').is(':checked')){
		     $("#submit-modal").modal('show');
		     return true;
		 }else{
		     $("#alertMessage").text("Please fill in all required fields.");
		     $("#alert").modal('show');
		     return false;
		 }
	     }else{
		 if($('[name="howSleepy"]').is(':checked')){
		     $("#submit-modal").modal('show');
		     return true;
		 }else{
		     $("#alertMessage").text("Please fill in all required fields.");
		     $("#alert").modal('show');
		     return false;
		 }
	     }
	 });
	 $("#confirm-submit").click(function(){
	     $("#activityForm").submit();
	 });

	</script>

    </body>

</html>
