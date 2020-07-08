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
            navigationLinkAddition($config,$userType,'<li><a class = "exit" data-location = "practice-diary-menu?'.$query.'">Practice Diary Menu</a></li>');
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
    			<li><a class = "exit" data-location = "practice-diary-menu">Practice Diary Menu</a></li>
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

		    echo "<thead>";
		    echo "<tr>";
		    displayCommonHeader($currentGrade);
		    echo "</tr>";
		    echo "</thead>";
		    echo "<tbody>";
		    $queryOptions = getQueryOptionsByDate($includeUnsubmitted, $startingActivityDiaryEntryDate, $endingActivityDiaryEntryDate, "AND");
		    $queryCommand = "SELECT * FROM practice_activity_diary_data_table WHERE userId='$userId'" . $queryOptions . " ORDER BY diaryDate";
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

		    echo "</table>";
		    echo '</div>';
		    echo '</div>';


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
