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
checkauth();
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$parentPage = $_GET['parent'];
$additional = $_GET['additional'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
if (!$config['activity_title']||$lessonNum==0) {
  $config['activity_title']='Activity Diary Submission Table';
}
$query = $_SERVER['QUERY_STRING'];

?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep //Sleep Diary Submission Table</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php
                        if ($config) {
                          require_once('partials/nav-links.php');
                          navigationLink($config,$userType,array('parent'=>$parentPage,'additional' => '<li><a class = "exit" data-location = "diary-menu?'.$query.'">Diary Menu</a></li>') );
                        }
                        else {
                     ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="main-page">Home</a></li>
                                <li class="active">Sleep Diary Submission Table</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <table class='table table-bordered text-center table-striped' id=''>
                                <tbody>
                                    <?php
				    include 'connectdb.php';
				    $studentList = getUserIdsInClass($classId);
				    //debugToConsole('class', $classId);
				    //debugToConsole('student', $studentList);
				    $grade = getClassGrade($classId);
				    foreach($studentList as $studentId){
					//debugToConsole('studentId', $studentId);
					list($firstname, $lastname) = getUserFirstLastNames($studentId);
					$result = mysql_query("SELECT diaryStartDateFour, diaryEndDateFour, diaryStartDateFive, diaryEndDateFive FROM user_table WHERE userId='$studentId'");
    	  				$row = mysql_fetch_array($result);
					if($grade == 4){
					    $start = $row['diaryStartDateFour'];
					    $end = $row['diaryEndDateFour'];
					}else{
					    $start =$row['diaryStartDateFive'];
					    $end = $row['diaryEndDateFive'];
					}
					$resultDiary = mysql_query("SELECT diaryDate FROM diary_data_table WHERE userId='$studentId' And timeCompleted!='null'AND diaryDate <= '$end' AND diaryDate >= '$start'");
					echo '<tr><td>'.$firstname.' '.$lastname.'</td>';
    	  				while($rowDiary = mysql_fetch_array($resultDiary)){
					    echo '<td>'.$rowDiary['diaryDate'].'</td>';
					}
					echo '</tr>';
				    }
				    mysql_close($con);
				    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
