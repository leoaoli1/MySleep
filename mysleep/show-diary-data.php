<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
// Page to show sleep diary data in the database
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
        <title>MySleep //Sleep Diary Review</title>

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
			<li class="active">Sleep Diary Review</li>
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
require_once('sleep-diary-data-table.php');

$includeUnsubmitted = isset($_POST['includeUnsubmittedSleepDiaries']) ? true : false;
//$startingDiaryEntryId = $_POST['startingDiaryEntryId'];
//$endingDiaryEntryId = $_POST['endingDiaryEntryId'];
$startingDiaryEntryDate = $_POST['startingDiaryEntryDate'];
$endingDiaryEntryDate = $_POST['endingDiaryEntryDate'];

// Data structure for computing statistics of data displayed
$stats = array
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

echo '<div class="row">';
echo '<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">';
echo '<h3 style="color: black">Sleep Diary Daily Statistics</h3>';
echo '</div>';
echo '<div class="col-md-11 col-sm-11 col-xs-11">';
echo '<table data-toggle="table"  data-icons-prefix="fa"  data-show-columns="true" data-sort-name="ID" class="table table-striped">';
if ($userType == 'student') {
    echo "<thead>";
    echo "<tr>";
    displayCommonTableHeader($currentGrade);
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    //$queryOptions = getQueryOptions($includeUnsubmitted, $startingDiaryEntryId, $endingDiaryEntryId, "AND");
    $queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "AND");
    $queryCommand = "SELECT * FROM diary_data_table WHERE diaryGrade = '$currentGrade' and userId='$userId'" . $queryOptions . " ORDER BY diaryDate";
    $resultsDiaryToShow = mysql_query($queryCommand);
    while ($rowDiaryToShow = mysql_fetch_array($resultsDiaryToShow)) {

        echo "<tr>";
        displayCommonData($rowDiaryToShow);
        echo "</tr>";

        accumulateSleepData($rowDiaryToShow, $stats);
    }
    echo "</tbody>";
    //echo "<tr><td></td></tr>";
    // computeSleepStats($stats);
    // echo "<tr>";
    // displayCommonTableHeader();
    // echo "</tr>";
    // displayCommonStatsSleep($stats, 1);
}
elseif (($userType == 'teacher') || ($userType == 'parent')) {
    if($userType == 'teacher') {
	$classId = $_SESSION['classId'];
	$currentGrade = getClassGrade($classId);
	$targetUserIds = getUserIdsInClass($classId);
    }else {
	$targetUserIds = getLinkedUserIds($userId);
	$gradeFourFlag = false;
	foreach ($targetUserIds as $user){
	    $result = mysql_query("SELECT * FROM user_table WHERE userId='$user'");
	    $row = mysql_fetch_array($result);
	    $grade = $row['currentGrade'];
	    if($grade == 4){
		$gradeFourFlag = true;
	    }
	}
	if($gradeFourFlag){
	    $currentGrade = 4;
	}else{
	    $currentGrade = 5;
	}
    }
    echo "<thead>";
    echo "<tr>";
    echo   "<th>Last Name</th>";
    echo   "<th>First Name</th>";
    displayCommonTableHeader($currentGrade);
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($targetUserIds as $userToShowId) {
        $queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "AND");
	if($userType == 'parent'){
	    $result = mysql_query("SELECT * FROM user_table WHERE userId='$userToShowId'");
	    $row = mysql_fetch_array($result);
	    $currentGrade = $row['currentGrade'];
	}
        $queryCommand = "SELECT * FROM diary_data_table WHERE userId='$userToShowId' AND diaryGrade='$currentGrade'" . $queryOptions . " ORDER BY diaryDate";
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
            accumulateSleepData($rowDiaryToShow, $stats);
        }
    }
    echo "</tbody>";
    //echo "<tr><td></td><td></td></tr>";
    // computeSleepStats($stats);
    // echo "<tr><th></th><th></th>";
    // displayCommonTableHeader();
    // echo "</tr>";
    // displayCommonStatsSleep($stats, 3);
}else {
    echo "<thead>";
    echo "<tr>";
    echo   "<th>User ID</th>";
    displayCommonTableHeader();
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    $queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "WHERE");
    $queryCommand = "SELECT * FROM diary_data_table" . $queryOptions . " ORDER BY diaryDate";
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
	accumulateSleepData($rowDiaryToShow, $stats);
    }
    echo "</tbody>";
    //echo "<tr><td></td></tr>";
    // computeSleepStats($stats);
    // echo "<tr><th></th>";
    // displayCommonTableHeader();
    // echo "</tr>";
    // displayCommonStatsSleep($stats, 2);
}
echo "</table>";

if ($userType == 'student') {
    computeSleepStats($stats);
    //displaySleepStatsTable($stats, $currentGrade);
    echo '<div class="row" style="padding-top:1cm">';
    echo '<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">';
    echo '<h3 style="color: black">Sleep Diary Summary Statistics</h3>';
    echo '</div>';
    echo '<div class="col-md-11 col-sm-11 col-xs-11">';
    echo '<table data-toggle="table"  data-icons-prefix="fa"  data-show-columns="true" data-sort-name="ID" class="table table-striped">';
    echo "<thead>";
    echo "<tr>";
    displaySleepStatsSummaryHeader($currentGrade);
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    displaySleepStatsSummaryData($stats, $currentGrade);
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo '</div>';
    echo '</div>';
}

mysql_close($con);
showSleepLegends($currentGrade);

//echo "<a href='MainPage.php'>Return</a>";
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
function displayCommonTableHeader($grade)
{
    echo   "<th>Diary Date</th>";
    displayCommonHeaderSleep($grade);
}

function displayCommonData($row)
{
    echo "<td>" . getDisplayDate($row['diaryDate']) . "</td>";
    displayCommonDataSleep($row);
}

?>
