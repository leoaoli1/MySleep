<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
// Page to show activity diary data
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login.php");
    exit;
}
if($userType == "student"){
    $currentGrade = getCurrentGrade($userId);
}

$lessonNum = $_POST['lesson'];
$activityNum = $_POST['activity'];
$parentPage = $_POST['parent'];
$config = array('lesson_num' => $lessonNum, 'activity_title' => 'Sleep Diary Review');
$query = $_POST['query'];
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Activity Diary Review</title>

    </head>
    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php
          if ($config) {
            require_once('partials/nav-links.php');
            navigationLink($config,$userType,array('parent'=>$parentPage,'additional' => '<li><a class = "exit" data-location = "diary-menu?'.$query.'">Diary Menu</a></li>') );
          }
          else {
       ?>
		    <ol class="breadcrumb">
		      <li><a href="#" onclick="location.href='main-page';">Home</a></li>

			<?php if($userType != "parent"){ ?>
			    <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
			<?php }else{ ?>
			    <li><a href="#" onclick="location.href='parent-sleep-lesson';">Lessons</a></li>
			<?php } ?>
			<?php
			include 'connectdb.php';
			if($userType == 'student'){
			    $grade = getGrade($userId);
			}elseif($userType == 'teacher'){
			    $classId = $_SESSION['classId'];
			    $grade = getClassGrade($classId);
			}
			mysql_close($con);
			?>
			<?php if($grade == 4){?>
			    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2';">Lesson Two</a></li>
		        <?php }elseif($grade == 5){ ?>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=2';">Lesson Two</a></li>
		        <?php } ?>
			<li><a href="#" onclick="location.href='diary-menu';">Diary Menu</a></li>
			<li class="active">Activity Diary Review</li>
		    </ol>
        <?php } ?>
		    <div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>

		    <?php
		    include 'connectdb.php';
		    require_once('utilities-diary.php');
		    require_once('diary-data.php');
		    require_once('activity-diary-data-table.php');

		    /*$result = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
		       $row = mysql_fetch_array($result);
		       $userType = $row['type'];*/
		    $includeUnsubmitted = isset($_POST['includeUnsubmittedActivityDiaries']) ? true : false;
		    $startingActivityDiaryEntryDate = $_POST['startingActivityDiaryEntryDate'];
		    $endingActivityDiaryEntryDate = $_POST['endingActivityDiaryEntryDate'];

		    // Data structure for computing statistics of data displayed
		    $stats = array
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

		    echo '<div class="row">';
		    echo '<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">';
		    echo '<h3 style="color: black">Acitvity Diary Daily Statistics</h3>';
		    echo '</div>';
		    echo '<div class="col-md-11 col-sm-11 col-xs-11">';
		    echo '<table data-toggle="table"  data-icons-prefix="fa"  data-show-columns="true" data-sort-name="ID" class="table table-striped">';
		    if ($userType == 'student') {
			echo "<thead>";
			echo "<tr>";
			displayCommonHeader($currentGrade);
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			$queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingActivityDiaryEntryDate, $endingActivityDiaryEntryDate, "AND");
			$queryCommand = "SELECT * FROM activity_diary_data_table WHERE userId='$userId'" . $queryOptions . " ORDER BY diaryDate";
			$resultsDiaryToShow = mysql_query($queryCommand);


			$dayCount = 0;
			$symptomCount = 0;
			while ($rowDiaryToShow = mysql_fetch_array($resultsDiaryToShow)) {
			    echo "<tr>";
			    displayCommonData($rowDiaryToShow, $currentGrade);
			    echo "</tr>";
			    accumulateActivityData($rowDiaryToShow, $stats);

			    $symptomCount += computeSymptom($rowActivityDiaryToShow);
			    $dayCount += 1;
			}
			echo "</tbody>";
			//echo "<tr><td></td></tr>";
			// computeActivityStats($stats);
			// displayCommonHeader();
			// displayCommonStatsActivity($stats, 0);
		    }
		    else if (($userType == 'teacher') || ($userType == 'parent')) {
			if($userType == 'teacher') {
			    $classId = $_SESSION['classId'];
			    $currentGrade = getClassGrade($classId);
			    $targetUserIds = getUserIdsInClass($classId);
			}else {
			    $targetUserIds = getLinkedUserIds($userId);
			    $gradeFourFlag = true;
			    foreach ($targetUserIds as $user){
				$result = mysql_query("SELECT * FROM user_table WHERE userId='$user'");
				$row = mysql_fetch_array($result);
				$grade = $row['currentGrade'];
				if($grade == 5){
				    $gradeFourFlag = false;
				}
			    }
			    if(!$gradeFourFlag){
				$currentGrade = 5;
			    }else{
				$currentGrade = 4;
			    }
			}
			echo "<thead>";
			echo "<tr><th>Last Name</th><th>First Name</th>";
			displayCommonHeader($currentGrade);
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($targetUserIds as $userToShowId) {
			    $queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingActivityDiaryEntryDate, $endingActivityDiaryEntryDate, "AND");
			    if($userType=='parent'){
				$result = mysql_query("SELECT * FROM user_table WHERE userId='$userToShowId'");
				$row = mysql_fetch_array($result);
				$currentGrade = $row['currentGrade'];
			    }
			    $queryCommand = "SELECT * FROM activity_diary_data_table WHERE userId='$userToShowId' AND diaryGrade='$currentGrade'" . $queryOptions . " ORDER BY diaryDate";
			    //$queryCommand = "SELECT * FROM activity_diary_data_table WHERE userId='$userToShowId'" . $queryOptions . " ORDER BY diaryDate"; //can see previous grade diary
			    $resultsDiaryToShow = mysql_query($queryCommand);
			    list($firstname, $lastname) = getUserFirstLastNames($userToShowId);
			    echo "<tr>";
			    echo "<td>" . $lastname . "</td>";
			    echo "<td>" . $firstname . "</td>";
			    echo "</tr>";
			    while ($rowDiaryToShow = mysql_fetch_array($resultsDiaryToShow)) {
				$status = "Yes";
				if (is_null($rowDiaryToShow['timeCompleted']))
				    $status = "No";
				echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				displayCommonData($rowDiaryToShow, $currentGrade);
				echo "</tr>";
				accumulateActivityData($rowDiaryToShow, $stats);
			    }
			}
			echo "</tbody>";
			// echo "<tr><td></td><td></td></tr>";
			// computeActivityStats($stats);
			// displayCommonStatsActivity($stats, 2);
		    }
		    else {
			echo "<thead>";
			echo "<tr>";
			echo   "<th>User ID</th>";
			displayCommonHeader();
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			$queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingActivityDiaryEntryDate, $endingActivityDiaryEntryDate, "WHERE");
			$queryCommand = "SELECT * FROM activity_diary_data_table" . $queryOptions . " ORDER BY diaryDate";
			$resultsDiaryToShow = mysql_query($queryCommand);
			while ($rowDiaryToShow = mysql_fetch_array($resultsDiaryToShow)) {
			    $studentId = $rowDiaryToShow['userId'];
			    $grade = $rowDiaryToShow['diaryGrade'];
    			    $result = mysql_query("SELECT * FROM user_table WHERE userId='$studentId'");
    			    $row = mysql_fetch_array($result);
    			    $currentClassNum = $row['classnumber'];
    			    $currentSemester = $row['semester'];
    			    $currentYear = $row['year'];
			    echo "<tr>";
			    echo "<td>" .$grade.'zfactor'.$currentSemester.$currentYear.$currentClassNum.$studentId. "</td>";
			    displayCommonData($rowDiaryToShow);
			    echo "</tr>";
			    accumulateActivityData($rowDiaryToShow, $stats);
			}
			echo "</tbody>";
			// echo "<tr><td></td></tr>";
			// computeActivityStats($stats);
			// displayCommonStatsActivity($stats, 1);
		    }
		    echo "</table>";
		    echo '</div>';
		    echo '</div>';
		    if($userType == 'student'){

			computeActivityStats($stats);
			//displayActivityStatsTable($stats);
			echo '<div class="row" style="padding-top:1cm">';
			echo '<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">';
			echo '<h3 style="color: black">Activity Diary Summary Statistics</h3>';
			echo '</div>';
			echo '<div class="col-md-11 col-sm-11 col-xs-11">';
			echo '<table data-toggle="table"  data-icons-prefix="fa"  data-show-columns="true" data-sort-name="ID" class="table table-striped">';
			echo "<thead>";
			echo "<tr>";
			displayActivityStatsSummaryHeader($currentGrade);
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			echo "<tr>";
			displayActivityStatsSummaryData($stats, $currentGrade);
			if(!empty($dayCount)){
			    echo "<td>".number_format($symptomCount/$dayCount, 2, '.', ',')."</td>"; //compute for symptoms
			}else{
			    echo "<td></td>";
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo '</div>';
			echo '</div>';
		    }
		    mysql_close($con);
		    showActivityLegends($currentGrade);

		    //echo "<button class='button_prompt' onclick='history.go(-1); return false;'>Return</button>";
		    //exit;
		    ?>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
<?php
function displayCommonHeader($grade)
{
    echo   "<th>Diary Date</th>";
    displayCommonHeaderActivity($grade);
}

function displayCommonData($row, $grade)
{
    echo "<td>" . getDisplayDate($row['diaryDate']) . "</td>";
    displayCommonDataActivity($row, $grade);
}
?>
