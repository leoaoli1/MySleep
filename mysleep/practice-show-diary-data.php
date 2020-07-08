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
            navigationLinkAddition($config,$userType,'<li><a class = "exit" data-location = "practice-diary-menu?'.$query.'">Practice Diary Menu</a></li>');
          }
          else {
       ?>
		    <ol class="breadcrumb">
	        <li><a href="#" onclick="location.href='main-page';">Home</a></li>
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
    			<li><a class = "exit" data-location = "sleep-lesson">Lessons</a></li>
    			<li><a class = "exit" data-location = "practice-diary-menu">Practice Diary Menu</a></li>
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

echo "<thead>";
echo "<tr>";
displayCommonTableHeader($currentGrade);
echo "</tr>";
echo "</thead>";
echo "<tbody>";
//$queryOptions = getQueryOptions($includeUnsubmitted, $startingDiaryEntryId, $endingDiaryEntryId, "AND");
$queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingDiaryEntryDate, $endingDiaryEntryDate, "AND");
$queryCommand = "SELECT * FROM practice_diary_data_table WHERE diaryGrade = '$currentGrade' and userId='$userId'" . $queryOptions . " ORDER BY diaryDate";
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

echo "</table>";


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
