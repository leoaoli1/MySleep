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
checkauth();
if($userType != 'parent'){
    header("Location: login");
}
include 'connectdb.php';
$grade = $_SESSION['parentLessonGrade'];
$studentList = getLinkedUserIds($userId);
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
			<li><a href="#" onclick="location.href='parent-sleep-lesson'">Lessons</a></li>
			<li class="active">Aggregate Table</li>
		    </ol>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			    <h4 class="description">
			    </h4>
			</div>
		    </div>
		    <div class="row">
			<div class="col-md-11 col-sm-11 col-xs-11">
			    <div id="toolbar">
				 <a class="btn btn-sm btn-block" download="AggregateTable.csv" href="#" onclick="return ExcellentExport.csv(this, 'aggregateTable');">Create My File</a>
				 <button id="hide" class="btn btn-sm btn-default">Unselect All Variables</button>
				 <button id="show" class="btn btn-sm btn-default">Select All Variables</button>
			    </div>
			    <table id="aggregateTable" data-toggle="table" data-toolbar="#toolbar"  data-icons-prefix="fa"  data-show-columns="true" data-sort-name="ID" class="table table-striped">
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
				    $studentGrade = getGrade($studentId);
				    if($studentGrade == $grade){
					$includeUnsubmitted = false;
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
					    'howAttentive' =>         array('min' => NULL, 'max' => NULL, 'mean' => NULL, 'data' => array(), 'mode' => NULL)
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
					displaySleepStatsSummaryData($statsSleep, $grade);
					displayActivityStatsSummaryData($statsActivity, $grade);
					displayActographSummaryData($arrStartDate, $arrStartDay,  $arrEndDate, $arrEndDay, $arrBedTime, $arrGetUpTime, $arrTimeInBed, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak, $arrAwakeTime);
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
					}
					echo "</tr>";
					$idCount += 1;
				    }
				}
				echo '</tbody>';
				?>
			    </table>
			</div>
		    </div>
		    <div class="row" style="padding-top: 1cm">
			<div class="col-md-11 col-sm-11 col-xs-11">
			    <?php
			    showSleepLegends($grade);
			    showActivityLegends($grade);
			    showAdditionalLegends($grade);
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
     var  activitySummaryField = ["nap", "ave-nape", "ave-exerc", "ave-mood", "ave-moodDesc", "ave-sleepness", "sleepness", "ave-attention", "attention"];
     diarySummaryField = ["early-bed", "last-bed", "ave-bed", "early-wake", "last-wake", "ave-wake", "short-total", "long-total", "ave-total", "ave-inBed", "ave-fall", "ave-awak", "ave-awakeTime", "ave-wakeUp", "ave-quality", "ave-bedroomLight", "ave-noise", "ave-temperature"];
     watchField = ['early-bed-a', 'last-bed-a', 'ave-bed-a', 'early-wake-a', 'last-wake-a', 'ave-wake-a', 'short-total-a', 'long-total-a', 'ave-total-a', 'ave-awak-a', 'ave-awakeTime-a', 'ave-inBed-a', 'ave-quality-a', 'ave-fall-a'];
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
		  <th data-switchable="false">Grade</th>';
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
    if($grade==4){
        echo   "<th data-field='ave-bedroomLight'>Average Bedroom Lighting Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-noise'>Average Bedroom Noise Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-temperature'>Average Bedroom Temperature Rating_Sleep Diary</th>";
    }
    echo   "<th data-field='ave-wakeUp'>Average Wake Up State Rating_Sleep Diary</th>";
    echo   "<th data-field='ave-quality'>Average Sleep Quality (last night) Rating_Sleep Diary</th>";
    //echo   "<th>Average Sleep Quality (compared to usual) Rating_Sleep Diary</th>";
    
}
function activityStatsSummaryHeader($grade){
    echo   "<th data-field='nap'>Number of Days Napped_Activity Diary</th>";
    echo   "<th data-field='ave-nape'>Average Number of Caffeinated Drinks_Activity Diary</th>";
    echo   "<th data-field='ave-exerc'>Average Number of Minutes Exercised_Activity Diary</th>";
    if($grade == 5){
        echo   "<th data-field='ave-mood'>Average Mood Rating_Activity Diary</th>";
        echo   "<th data-field='ave-moodDesc'>Mood Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='ave-sleepness'>Average Sleepiness Rating_Activity Diary</th>";
    echo   "<th data-field='sleepness'>Sleepiness Descriptor Most Often Selected_Activity Diary</th>";
    if($grade == 5){
        echo   "<th data-field='ave-attention'>Average Attention Rating_Activity Diary</th>";
        echo   "<th data-field='attention'>Attention Descriptor Most Often Selected_Activity Diary</th>";
    }
}
function actographSummaryHeader(){
    echo '<th data-field="early-bed-a">Earliest Bed Time_Actigraphy</th>
		  <th data-field="last-bed-a">Latest Bed Time_Actigraphy</th>
		  <th data-field="ave-bed-a">Average Bed Time_Actigraphy</th>
		  <th data-field="early-wake-a">Earliest Wake Time_Actigraphy</th>
		  <th data-field="last-wake-a">Latest Wake Time_Actigraphy</th>
		  <th data-field="ave-wake-a">Average Wake Time_Actigraphy</th>
		  <th data-field="short-total-a">Shortest Total Sleep Time_Actigraphy (hours:Min)</th>
		  <th data-field="long-total-a">Longest Total Sleep Time_Actigraphy (hours:Min)</th>
		  <th data-field="ave-total-a">Average Total Sleep Time_Actigraphy (hours:Min)</th>
		  <th data-field="ave-inBed-a">Average Time in Bed_Actigraphy (hours)</th>
		  <th data-field="ave-fall-a">Average Time it Took to Fall Asleep_Actigraphy (min)</th>
		  <th data-field="ave-quality-a">Average Sleep Quality_Actigraphy (percent)</th>
		  <th data-field="ave-awak-a">Average #Awak._Actigraphy</th>
		  <th data-field="ave-awakeTime-a">Average Awake Time_Actigraphy</th>';
}

function reactionHeader($grade){
    if($grade == 5){
        echo   "<th data-field='reaction'>Reaction Score (ms)</th>";
	echo   "<th data-field='memory'>Memory Score</th>";
    }
		  }

		  function showAdditionalLegends($grade){
    if($grade == 5){
        echo   "Reaction Score = Average Response Time<br>";
	echo   "Memory Score = number of correct responses / number of responses<br>";
    }
}
?>

