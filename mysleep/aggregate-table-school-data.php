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
require_once('utilities-diary.php');
require_once('diary-data.php');
require_once('activity-diary-data-table.php');
require_once('sleep-diary-data-table.php');
require_once('utilities-actogram.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];
$schoolId = $_SESSION['schoolId'];
checkauth();
include 'connectdb.php';
$grade = 0;
$menuGrade = getClassGrade($classId); //set the student grade
$studentList = getStudentIdsInSchool($schoolId);
$showAll = true;
$stSchoolId = 's'. $schoolId;
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Aggregate Table</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
			<li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
			<?php if($menuGrade ==4){?>
			    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=4'">Lesson Four</a></li>
		            <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=4&activity=3'">Activity Three</a></li>
			<?php }else{?>
			    <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=4'">Lesson Four</a></li>
			    <li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=3'">Activity Three</a></li>
			<?php }?>
			<li class="active">Aggregate Data Table</li>
		    </ol>
		    <div class="row">
			<div class="col-md-11 col-sm-11 col-xs-11">
			    <div id="toolbar">
				<a class="btn btn-sm btn-block" download="MySchoolData.csv" href="#" onclick="return ExcellentExport.csv(this, 'aggregateTable');">Create My File</a>
				<button id="hide" class="btn btn-sm btn-default">Unselect All Variables</button>
				<button id="show" class="btn btn-sm btn-default">Select All Variables</button>
			    </div>
			    <table id="aggregateTable" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-icons-prefix="fa"  data-show-columns="true" data-sort-name="ID" class="table table-striped">
				<?php
				$idCount = 1;
				echo '<thead>';
				echo "<tr>";
				generalHeader();
				sleepStatsSummaryHeader($grade);
				activityStatsSummaryHeader($grade);
				actographSummaryHeader();
				reactionHeader($grade);
				echo "</tr>";
				echo '</thead>';
				echo '<tbody>';
				foreach ($studentList as $studentId){
				    $includeUnsubmitted = false;
				    $grade = getGrade($studentId);
				    $gender = getUserGender($studentId);
				    list($startingDiaryEntryDate, $endingDiaryEntryDate) = getDiarySelection( $studentId, $grade);
				    list($startingActivityEntryDate, $endingActivityEntryDate) = getActivitySelection($studentId, $grade);

				    $statsSleep = array
				    (
					'timeLightsOff' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'timeFellAsleep' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'timeWakeup' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'timeOutOfBed' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'numWokeup' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'minWokeup' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'hourSlept' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array()),
					'wokeupState' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'sleepQuality' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'sleepCompare' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'roomDarkness' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'roomQuietness' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'roomWarmness' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
				    );

				    // Data structure for computing statistics of data displayed
				    $statsActivity = array
				    (
					'napStart' =>             array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'napEnd' =>               array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'napDuration' =>          array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'minExercised' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'numCaffeinatedDrinks' => array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'feltDuringDay' =>        array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'howSleepy' =>            array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'minVideoGame' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'minComputer' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'minTechnology' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'attention' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'behavior' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL),
					'interaction' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
				    );

				    $queryOptionsDiary = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "AND");
				    $queryCommandSleep = "SELECT * FROM diary_data_table WHERE userId='$studentId' AND diaryGrade = '$grade'" . $queryOptionsDiary . " ORDER BY diaryDate";
				    $resultsSleepDiaryToShow = mysql_query($queryCommandSleep);
				    while ($rowSleepDiaryToShow = mysql_fetch_array($resultsSleepDiaryToShow)) {
					accumulateSleepData($rowSleepDiaryToShow, $statsSleep);
				    }	
				    computeSleepStats($statsSleep);
				    //print_r($stats, $return = null);

				    $queryOptionsActivity = getQueryOptionsByDate($includeUnsubmitted, $startingActivityEntryDate, $endingActivityEntryDate, "AND");
				    $queryCommandActivity = "SELECT * FROM activity_diary_data_table WHERE userId='$studentId'  AND diaryGrade = '$grade'" . $queryOptionsActivity . " ORDER BY diaryDate";
				    $resultsActivityDiaryToShow = mysql_query($queryCommandActivity);
				    while ($rowActivityDiaryToShow = mysql_fetch_array($resultsActivityDiaryToShow)) {
					accumulateActivityData($rowActivityDiaryToShow, $statsActivity);
				    }
				    computeActivityStats($statsActivity);
				    
				    $arrStartDate = "0";
				    $arrStartDay = "0";
				    $arrEndDate  = "0";
				    $arrEndDay  = "0";
				    $arrBedTime  = "0";
				    $arrGetUpTime  = "0";
				    $arrTimeInBed  = "0";
				    $arrTotalSleepTime = "0";
				    $arrTimeItTookToFallAsleep = "0";
				    $arrAverageSleepQuality = "0";
				    $arrNumberOfAwak = "0";
				    $arrAwakeTime = "0";
				    //get Actograph data
				    $result = mysql_query("SELECT * FROM my_actogram WHERE userId='$studentId' and grade='$grade' order by resultRow DESC LIMIT 1");
				    $row = mysql_fetch_array($result);
				    if(mysql_num_rows($result)>0) {
					list($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime) = extractActigraphData($row);	    
				    }

				    //get ID, Gender, Grade
				    $currentYearSemester = getStudentSemesterYear($studentId);
 				    //$gender = getUserGender($studentId);

				    
				    echo "<tr>";
				    echo "<td>" .$idCount. "</td>";
				    //echo "<td>" .$grade.'zfactor'.$currentYearSemester.$classId.$studentId. "</td>";
				    //echo "<td>".$gender."</td>";
				    echo "<td>".$grade."</td>";
				    displaySleepStatsSummaryDataAggregate($statsSleep, $grade, $showAll);
				    displayActivityStatsSummaryDataAggregate($statsActivity, $grade, $showAll);
				    displayActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime);


				    //show the recation time
				    if($grade == 5){
					$reactionScore = 0;
					$reactionScore = computeReactionScore($studentId);
					if($reactionScore != 0){
					    echo "<td>".ceil($reactionScore)."</td>";
					}else{
					    echo "<td></td>";
					}
					$memoryScore = 0;
					list($memoryScore, $memoryFlag) = computeMemoryScore($studentId);
					if($memoryFlag != 0){
					    echo "<td>".number_format($memoryScore, '2', '.', ',')."</td>";
					}else{
					    echo "<td></td>";
					}
				    }elseif($showAll){
					echo "<td></td><td></td>";
				    }
				    echo "</tr>";
				    $idCount += 1;
				}
				echo '</tbody>';
				?>
			    </table>
			</div>
		    </div>
		    <div class="row" style="padding-top: 1em">
			<div class="col-md-11 col-sm-11 col-xs-11">
			    <?php
			    showSleepLegends();
			    showActivityLegends();
			    showAdditionalLegends();
			    mysql_close($con);
			    ?>
			</div>
	            </div>
		</div>
	    </div>
	    <?php include 'partials/footer.php' ?>
	</div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     var table = $('#aggregateTable'),
	 hide = $('#hide');
     show = $('#show');
     var  activitySummaryField = ["nap", "ave-caffe", "ave-exerc", "ave-mood", "ave-moodDesc", "ave-sleepness", "sleepness", "ave-attention", "attention", "ave-game", "ave-computer", "ave-tech", "ave-attention", "attention", "ave-behavior", "behavior", "ave-interactions", "interactions"];
     var diarySummaryField = ["early-bed", "last-bed", "ave-bed", "early-wake", "last-wake", "ave-wake", "short-total", "long-total", "ave-total", "ave-inBed", "ave-fall", "ave-awak", "ave-awakeTime", "ave-wakeUp", "ave-quality", "ave-bedroomLight", "ave-noise", "ave-temperature"];
     var watchField = ['early-bed-a', 'last-bed-a', 'ave-bed-a', 'early-wake-a', 'last-wake-a', 'ave-wake-a', 'short-total-a', 'long-total-a', 'ave-total-a', 'ave-awak-a', 'ave-awakeTime-a', 'ave-inBed-a', 'ave-quality-a', 'ave-fall-a'];
     addField = ['reaction', 'memory'];
     $(function () {
	 hide.click(function () {
	     $.each(activitySummaryField, function(index, value){
		 table.bootstrapTable('hideColumn', value);
	     });
	     $.each(diarySummaryField, function(index, value){
		 table.bootstrapTable('hideColumn', value);
	     });
	     $.each(watchField, function(index, value){
		 table.bootstrapTable('hideColumn', value);
	     });
	     $.each(addField, function(index, value){
		 table.bootstrapTable('hideColumn', value);
	     });
	 });
     });

     $(function () {
	 show.click(function () {
	     $.each(activitySummaryField, function(index, value){
		 table.bootstrapTable('showColumn', value);
	     });
	     $.each(diarySummaryField, function(index, value){
		 table.bootstrapTable('showColumn', value);
	     });
	     $.each(watchField, function(index, value){
		 table.bootstrapTable('showColumn', value);
	     });
	     $.each(addField, function(index, value){
		 table.bootstrapTable('showColumn', value);
	     });
	 });
     });
     
     $( document ).ready(function() {
	 $("button").each(function() {
	     if($(this).hasClass("dropdown-toggle")) {
		 $(this).html("Variable Selection");
	     }
	 });
     });
    </script>
</html>
<?php
function getDiarySelection($userId, $grade)
{
    $result = mysql_query("SELECT diaryStartDateFour, diaryEndDateFour, diaryStartDateFive, diaryEndDateFive FROM user_table where userId='$userId'");
    $row= mysql_fetch_array($result);
    if($grade==4){
	$startDate = $row['diaryStartDateFour'];
	$endDate =  $row['diaryEndDateFour'];
    }else{
	$startDate = $row['diaryStartDateFive'];
	$endDate =  $row['diaryEndDateFive'];
    }
    return array($startDate, $endDate);
}

function getActivitySelection($userId, $grade)
{
    $result = mysql_query("SELECT activityStartDateFour, activityEndDateFour, activityStartDateFive, activityEndDateFive FROM user_table where userId='$userId'");
    $row= mysql_fetch_array($result);
    if($grade==4){
	$startDate = $row['activityStartDateFour'];
	$endDate =  $row['activityEndDateFour'];
    }else{
	$startDate = $row['activityStartDateFive'];
	$endDate =  $row['activityEndDateFive'];
    }
    return array($startDate, $endDate);
}

function computeReactionScore($userId)
{
    $result = mysql_query("SELECT turn FROM identificationTaskResults WHERE userId='$userId' ORDER BY id DESC LIMIT 1");
    $row= mysql_fetch_array($result);
    $turn = $row['turn'];
    //debugToConsole('submitTime', $submitTime);
    $result = mysql_query("SELECT time FROM identificationTaskResults WHERE userId='$userId' AND turn = '$turn'");
    $sum = 0;
    $count = 0;
    $average = 0;
    while($row= mysql_fetch_array($result)){
	$count += 1;
	//debugToConsole('time', $row['time']);
	$sum += $row['time'];
    }
    $average = $sum / $count;
    mysql_free_result($result);
    return $average;
}

function computeMemoryScore($userId){
    $result = mysql_query("SELECT DISTINCT turn FROM memoryTaskResults WHERE userId='$userId' ORDER BY id DESC LIMIT 1");
    while($row= mysql_fetch_array($result)){
	$turn = $row['turn'];
	//debugToConsole('submitTime', $submitTime);
	$resultDetial = mysql_query("SELECT response FROM memoryTaskResults WHERE userId='$userId' AND turn='$turn'");
	$correct = 0;
	$incorrect = 0;
	$score = 0;
	while($rowDetial = mysql_fetch_array($resultDetial)){
	    if($rowDetial['response'] == 'Correct'){
		$correct += 1;
	    }else{
		$incorrect += 1;
	    }
	}
	$dataFlag = 0;
	if(($correct != 0) && ($incorrect != 0)){
	    $score = $correct / 30;
	    $dataFlag = 1;
	}
    }
    return array($score, $dataFlag);
}

function generalHeader(){
    echo '<th data-field="ID" data-sortable="true" data-switchable="false">ID</th>
<th data-switchable="false" data-sortable="true">Grade</th>';
    /*echo '<th data-field="ID" data-sortable="true" data-switchable="false">ID</th>
		  <th data-switchable="false">Gender</th>
		  <th data-switchable="false">Grade</th>';*/
}
function sleepStatsSummaryHeader($grade){
    
    echo   "<th data-field='early-bed'>Earliest Bed Time_Sleep Diary</th>";
    echo   "<th data-field='last-bed'>Latest Bed Time_Sleep Diary</th>";
    echo   "<th data-field='ave-bed'>Average Bed Time_Sleep Diary</th>";
    echo   "<th data-field='early-wake'>Earliest Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='last-wake'>Latest Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='ave-wake'>Average Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='short-total'>Shortest Total Sleep Time_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='long-total'>Longest Total Sleep Time_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='ave-total'>Average Total Sleep Time_Sleep Diary (hourse:min)</th>";
    echo   "<th data-field='ave-inBed'>Average Time in Bed_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='ave-fall'>Average Time it Took to Fall Asleep_Sleep Diary (min)</th>";
    echo   "<th data-field='ave-awak'>Average #Awak._Sleep Diary</th>";
    echo   "<th data-field='ave-awakeTime'>Average Awake Time_Sleep Diary (min)</th>";
    if($grade==4 || $grade == 0){
        echo   "<th data-field='ave-bedroomLight'>Average Bedroom Lighting Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-noise'>Average Bedroom Noise Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-temperature'>Average Bedroom Temperature Rating_Sleep Diary</th>";
    }
    echo   "<th data-field='ave-wakeUp'>Average Wake Up State Rating_Sleep Diary</th>";
    echo   "<th data-field='ave-quality'>Average Sleep Quality (last night) Rating_Sleep Diary</th>";
    //echo   "<th>Average Sleep Quality (compared to usual) Rating_Sleep Diary</th>";
    
}
function activityStatsSummaryHeader($grade){
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }

    echo   "<th data-field='nap'>Number of Days Napped_Activity Diary</th>";
    echo   "<th data-field='ave-caffe'>Average Number of Caffeinated Drinks_Activity Diary</th>";
    echo   "<th data-field='ave-exerc'>Average Number of Minutes Exercised_Activity Diary</th>";
    if($grade==4 || $grade ==0){
	echo   "<th data-field='ave-game'>Average Number of Minutes Played Video Games_Activity Diary</th>";
	echo   "<th data-field='ave-computer'>Average Number of Minutes Spent Using a Computer_Activity Diary</th>";
	echo   "<th data-field='ave-tech'>Average Number of Minutes Using Other Technology_Activity Diary</th>";
    }
    if($grade == 5 || $grade ==0){
        echo   "<th data-field='ave-mood'>Average Mood Rating_Activity Diary</th>";
        echo   "<th data-field='ave-moodDesc'>Mood Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='ave-sleepness'>Average Sleepiness Rating_Activity Diary</th>";
    echo   "<th data-field='sleepness'>Sleepiness Descriptor Most Often Selected_Activity Diary</th>";
    if($grade == 5 || $grade ==0){
        echo   "<th data-field='ave-attention'>Average Attention Rating_Activity Diary</th>";
        echo   "<th data-field='attention'>Attention Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th data-field='ave-behavior'>Average Behavior Rating_Activity Diary</th>";
	echo   "<th data-field='behavior'>Behavior Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th data-field='ave-interactions'>Average Interactions Rating_Activity Diary</th>";
	echo   "<th data-field='interactions'>Interactions Descriptor Most Often Selected_Activity Diary</th>";
    }
}
function actographSummaryHeader(){
    echo '<th data-field="early-bed-a">Earliest Bed Time_Sleep_Watch</th>
		  <th data-field="last-bed-a">Latest Bed Time_Sleep_Watch</th>
		  <th data-field="ave-bed-a">Average Bed Time_Sleep_Watch</th>
		  <th data-field="early-wake-a">Earliest Wake Time_Sleep_Watch</th>
		  <th data-field="last-wake-a">Latest Wake Time_Sleep_Watch</th>
		  <th data-field="ave-wake-a">Average Wake Time_Sleep_Watch</th>
		  <th data-field="short-total-a">Shortest Total Sleep Time_Sleep_Watch (hours:Min)</th>
		  <th data-field="long-total-a">Longest Total Sleep Time_Sleep_Watch (hours:Min)</th>
		  <th data-field="ave-total-a">Average Total Sleep Time_Sleep_Watch (hours:Min)</th>
		  <th data-field="ave-inBed-a">Average Time in Bed_Sleep_Watch (hours)</th>
		  <th data-field="ave-fall-a">Average Time it Took to Fall Asleep_Sleep_Watch (min)</th>
		  <th data-field="ave-quality-a">Average Sleep Quality_Sleep_Watch (percent)</th>
		  <th data-field="ave-awak-a">Average #Awak._Sleep_Watch</th>
		  <th data-field="ave-awakeTime-a">Average Awake Time_Sleep_Watch</th>';
}


function displaySleepStatsSummaryDataAggregate($stats, $grade, $show){
    global $enumWokeupState, $enumSleepQuality, $enumSleepCompare, $enumRoomDarkness, $enumRoomQuietness, $enumRoomWarmness;
    if(!isset($grade)){
	$grade = 4;
    }
    echo "<td>" . getDisplayTime($stats['timeLightsOff']['min']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeLightsOff']['max']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeLightsOff']['mean']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup']['min']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup']['max']) . "</td>";
    echo "<td>" . getDisplayTime($stats['timeWakeup']['mean']) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept']['min'], 2) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept']['max'], 2) . "</td>";
    echo "<td>" . getDisplaySleptHours($stats['hourSlept']['mean'], 2) . "</td>";
    if(is_null($stats['timeWakeup']['mean'])){
	echo "<td></td>";
	echo "<td></td>";
    }else{
	echo "<td>" . getDisplaySleptHours(($stats['timeWakeup']['mean']-$stats['timeLightsOff']['mean'])/3600,2) . "</td>";
	echo "<td>" . getDisplayNumber(($stats['timeFellAsleep']['mean']-$stats['timeLightsOff']['mean'])/60,0) . "</td>";
    }
    echo "<td>" . getDisplayNumber($stats['numWokeup']['mean'], 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['minWokeup']['mean'], 2) . "</td>";
    if($grade==4){
	echo "<td>" . getDisplayNumber($stats['roomDarkness']['mean'], 2) . "</td>";
	echo "<td>" . getDisplayNumber($stats['roomQuietness']['mean'], 2) . "</td>";
	echo "<td>" . getDisplayNumber($stats['roomWarmness']['mean'], 2) . "</td>";
    }elseif($show){
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
    }
    echo "<td>" . getDisplayNumber($stats['wokeupState']['mean'], 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['sleepQuality']['mean'], 2) . "</td>";
    //echo "<td>" . getDisplayNumber($stats['sleepCompare']['mean'], 2) . "</td>";
    
    
}

function displayActivityStatsSummaryDataAggregate($stats, $grade, $show)
{
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 5;
    }
    if(is_null($stats['numCaffeinatedDrinks']['mean'])){
	echo "<td></td>";
    }else{
	echo "<td>" . getNumDataGreaterThan($stats['napDuration']['data'], 0) . "</td>";
    }
    echo "<td>" . getDisplayNumber($stats['numCaffeinatedDrinks']['mean'], 2) . "</td>";
    echo "<td>" . getDisplayNumber($stats['minExercised']['mean'], 0) . "</td>";
    if($grade == 4){
	echo "<td>" . getDisplayNumber($stats['minVideoGame']['mean'], 0) . "</td>";
	echo "<td>" . getDisplayNumber($stats['minComputer']['mean'], 0) . "</td>";
	echo "<td>" . getDisplayNumber($stats['minTechnology']['mean'], 0) . "</td>";
    }elseif($show){
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
    }
    if($grade == 5){
        echo "<td>" . getDisplayNumber($stats['feltDuringDay']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumFeltDuringDay, $stats['feltDuringDay']['mode']) . "</td>";
    }
    elseif($show){
	echo "<td></td>";
	echo "<td></td>";
		  }
		  
    echo "<td>" . getDisplayNumber($stats['howSleepy']['mean'], 2) . "</td>";
    echo "<td>" . getDescriptorList($enumHowSleepy, $stats['howSleepy']['mode']) . "</td>";
    if($grade == 5){
        echo "<td>" . getDisplayNumber($stats['attention']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumAttention, $stats['attention']['mode']) . "</td>";

	echo "<td>" . getDisplayNumber($stats['behavior']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumBehavior, $stats['behavior']['mode']) . "</td>";

	echo "<td>" . getDisplayNumber($stats['interaction']['mean'], 2) . "</td>";
        echo "<td>" . getDescriptorList($enumInteraction, $stats['interaction']['mode']) . "</td>";
    }elseif($show){
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
    }
}

function reactionHeader($grade){
    if($grade == 5 || $grade == 0){
        echo   "<th data-field='reaction'>Reaction Score (ms)</th>";
	echo   "<th data-field='memory'>Memory Score</th>";
    }
		  }

		  function showAdditionalLegends(){
        echo   "Reaction Score = Average Response Time<br>";
	echo   "Memory Score = number of correct responses / number of responses<br>";
}
?>
