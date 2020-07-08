<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Authors: Ao Li <aoli1@email.arizona.edu>
#          James Geiger <jamesgeiger@email.arizona.edu>
#          Siteng Chen <sitengchen@email.arizona.edu>
#

require_once('utilities.php');
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

if ($userType == "teacher"){
    $classId = $_SESSION['classId'];
}

$page = $_GET["name"];

switch ($page) {
    case "whatIsSleep":
        $pageName = "What is Sleep";

        $sql = "select lesson.response, lesson.userId, class.classId FROM fourthGradeLessonOneWhatSleep lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' ORDER BY RAND()";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        break;
    case "whyDoWeSleep":
        $pageName = "Why Do We Sleep";

        $sql = "select lesson.response, lesson.userId, class.classId FROM fourthGradeLessonOneWhySleep lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' ORDER BY RAND()";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        break;
    case "enoughSleepVote":
        // Set the Page Name
        $pageName = "Enough Sleep Voting Results";

        // Get the Data
        $sql = "select lesson.vote,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOneSleepVote lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY vote ORDER BY count DESC";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        $numRow = mysql_num_rows ($result);

        $agreeVotes = 0;
        $disagreeVotes = 0;
        $unsureVotes = 0;

        if ($numRow>0) {
            while($row = mysql_fetch_array($result)){
                switch($row['vote']){
                    case '1':
                        $agreeVotes = $row['count'];
                        break;
                    case '2':
                        $disagreeVotes = $row['count'];
                        break;
                    case '3':
                        $unsureVotes = $row['count'];
                }
            }
        }
        break;
    case "preInterviewAdult":
        $pageName = "Adult Pre-Interview";

        $sql = "select lesson.interviewSubject,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOnePreInterview lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY lesson.interviewSubject ORDER BY count DESC";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        $numRow = mysql_num_rows ($result);

        $motherCount = 0;
        $fatherCount = 0;
        $guardianCount = 0;
        $grandparentCount = 0;
        $otherCount = 0;

        if ($numRow>0) {
            while($row = mysql_fetch_array($result)){
                switch($row['interviewSubject']){
                    case '1':
                        $motherCount = $row['count'];
                        break;
                    case '2':
                        $fatherCount = $row['count'];
                        break;
                    case '3':
                        $guardianCount = $row['count'];
                        break;
                    case '4':
                        $grandparentCount = $row['count'];
                        break;
                    case '5':
                        $otherCount = $row['count'];
                        break;
                }
            }
        }

        $sql = "select lesson.subjectResponse,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOnePreInterview lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY lesson.subjectResponse ORDER BY count DESC";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        $numRow = mysql_num_rows ($result);

        $almostAlways = 0;
        $mostOfTime = 0;
        $sometimes = 0;
        $notVeryOften = 0;
        $hardlyEver = 0;

        if ($numRow>0) {
            while($row = mysql_fetch_array($result)){
                switch($row['subjectResponse']){
                    case '1':
                        $almostAlways = $row['count'];
                        break;
                    case '2':
                        $mostOfTime = $row['count'];
                        break;
                    case '3':
                        $sometimes = $row['count'];
                        break;
                    case '4':
                        $notVeryOften = $row['count'];
                        break;
                    case '5':
                        $hardlyEver = $row['count'];
                        break;
                }
            }
        }
        break;
    case "interviewAdult":
        $pageName = "Adult Interview";

        $sql = "select lesson.interviewSubject,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOneAdultInterview lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY lesson.interviewSubject ORDER BY count DESC";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        $numRow = mysql_num_rows ($result);

        $motherCount = 0;
        $fatherCount = 0;
        $guardianCount = 0;
        $grandparentCount = 0;
        $otherCount = 0;

        if ($numRow>0) {
            while($row = mysql_fetch_array($result)){
                switch($row['interviewSubject']){
                    case '1':
                        $motherCount = $row['count'];
                        break;
                    case '2':
                        $fatherCount = $row['count'];
                        break;
                    case '3':
                        $guardianCount = $row['count'];
                        break;
                    case '4':
                        $grandparentCount = $row['count'];
                        break;
                    case '5':
                        $otherCount = $row['count'];
                        break;
                }
            }
        }

        $sql = "select lesson.A1,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOneAdultInterview lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY lesson.A1 ORDER BY count DESC";
        $result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
        $numRow = mysql_num_rows ($result);

        $almostAlways = 0;
        $mostOfTime = 0;
        $sometimes = 0;
        $notVeryOften = 0;
        $hardlyEver = 0;

        if ($numRow>0) {
            while($row = mysql_fetch_array($result)){
                switch($row['A1']){
                    case '1':
                        $almostAlways = $row['count'];
                        break;
                    case '2':
                        $mostOfTime = $row['count'];
                        break;
                    case '3':
                        $sometimes = $row['count'];
                        break;
                    case '4':
                        $notVeryOften = $row['count'];
                        break;
                    case '5':
                        $hardlyEver = $row['count'];
                        break;
                }
            }
        }
        break;
    default:
        $pageName = "Fourth Grade Lesson";
}

?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: <?php echo $pageName ?></title>
    </head>

<body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <ol class="breadcrumb">
                                    <li><a href="main-page">Home</a></li>
                                    <li><a href="sleep-lesson">Lessons</a></li>
                                    <li><a href="fourth-grade-lesson-menu?lesson=1">Activities</a></li>
                                    <li class="active">Review: <?php echo $pageName ?></li>
				    <li class="pull-right"><a href="#" onClick="studentView()">Student View</a></li>
                                </ol>
                            </div>
                        </div>

                        <?php
                            if($page === "whatIsSleep") { ?>
                            <div class="row">
                                    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered">
                                        <table style="margin: auto; margin-bottom:2em;">
                                            <tbody>
                                               <?php
                                                while($row = mysql_fetch_array($result)){ ?>
                                                    <tr style="line-height: 2em;">
                                                       <td style="font-size: 1.5em;padding-right: .5em;">●</td>
                                                        <td style="font-size: 1.5em;"><?php echo $row['response'] ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered" style="margin-bottom:2em;">
                                <a class="btn btn-simple btn-block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="studentResponses">VIEW IDENTIFIED STUDENT RESPONSES</a>
                                <div class="collapse" id="collapseExample">
                                   <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="lastName" class="table table-striped">
                                       <thead>
                                           <tr>
                                               <th data-field="firstName" data-sortable="true">First Name</th>
                                               <th data-field="lastName" data-sortable="true">Last Name</th>
                                               <th data-field="response" data-sortable="true">Response</th>
                                               <th data-field="submitted" data-sortable="true">Submitted</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            <?php
                                                include 'connectdb.php';
                                                require_once 'utilities.php';
                                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                                    if($userType == 'teacher') {
                                                        $resultLink = getUserIdsInClass($classId);
                                                    }else {
                                                        $resultLink = getLinkedUserIds($userId);
                                                    }
                                                    foreach($resultLink as $studentId) {
                                                        list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                        $result = mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE userId='$studentId'");
                                                        $row = mysql_fetch_array($result);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $firstname ?></td>
                                                        <td><?php echo $lastname ?></td>
                                                        <td><?php echo $row['response']?></td>
                                                        <td><?php if (mysql_num_rows($result) == 0 ){echo "";}else{echo date('g:i A M j Y', strtotime($row['submitted']));}?></td>
                                                    </tr>
                                                    <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                            <?php }} elseif($page === "whyDoWeSleep") { ?>
                                <div class="row">
                                    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                                        <table style="margin: auto; margin-bottom:2em;">
                                            <tbody>
                                               <?php
                                                while($row = mysql_fetch_array($result)){ ?>
                                                    <tr style="line-height: 2em;">
                                                        <td style="font-size: 1.5em;padding-right: .5em;">●</td>
                                                        <td style="font-size: 1.5em;"><?php echo $row['response'] ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered" style="margin-bottom:2em;">
                                <a class="btn btn-simple btn-block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="studentResponses">VIEW IDENTIFIED STUDENT RESPONSES</a>
                                <div class="collapse" id="collapseExample">
                                   <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="lastName" class="table table-striped">
                                       <thead>
                                           <tr>
                                               <th data-field="firstName" data-sortable="true">First Name</th>
                                               <th data-field="lastName" data-sortable="true">Last Name</th>
                                               <th data-field="response" data-sortable="true">Response</th>
                                               <th data-field="submitted" data-sortable="true">Submitted</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            <?php
                                                include 'connectdb.php';
                                                require_once 'utilities.php';
                                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                                    if($userType == 'teacher') {
                                                        $resultLink = getUserIdsInClass($classId);
                                                    }else {
                                                        $resultLink = getLinkedUserIds($userId);
                                                    }
                                                    foreach($resultLink as $studentId) {
                                                        list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                        $result = mysql_query("SELECT * FROM fourthGradeLessonOneWhySleep WHERE userId='$studentId'");
                                                        $row = mysql_fetch_array($result);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $firstname ?></td>
                                                        <td><?php echo $lastname ?></td>
                                                        <td><?php echo $row['response']?></td>
                                                        <td><?php if (mysql_num_rows($result) == 0 ){echo "";}else{echo date('g:i A M j Y', strtotime($row['submitted']));}?></td>
                                                    </tr>
                                                    <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                            <?php } }
                            elseif($page === "enoughSleepVote") { ?>
                                <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered">
                                    <div id="enoughSleepVotesChart" style="width:100%; min-height: 500px;">
                                        <div style="display:flex;justify-content:center;align-items:center;width:100%;">
                                            <div>
                                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left: 1.15em;"></i><br><br><span style="font-size: 24px;">Loading Chart...</span>
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered" style="margin-bottom:2em;">
                                <a class="btn btn-simple btn-block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="studentResponses">VIEW IDENTIFIED STUDENT RESPONSES</a>
                                <div class="collapse" id="collapseExample">
                                   <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="lastName" class="table table-striped">
                                       <thead>
                                           <tr>
                                               <th data-field="firstName" data-sortable="true">First Name</th>
                                               <th data-field="lastName" data-sortable="true">Last Name</th>
                                               <th data-field="response" data-sortable="true">Response</th>
                                               <th data-field="submitted" data-sortable="true">Submitted</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            <?php
                                                include 'connectdb.php';
                                                require_once 'utilities.php';
                                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                                    if($userType == 'teacher') {
                                                        $resultLink = getUserIdsInClass($classId);
                                                    }else {
                                                        $resultLink = getLinkedUserIds($userId);
                                                    }
                                                    foreach($resultLink as $studentId) {
                                                        list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                        $result = mysql_query("SELECT `vote`, `submitted` FROM fourthGradeLessonOneSleepVote WHERE userId='$studentId'");
                                                        $row = mysql_fetch_array($result);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $firstname ?></td>
                                                        <td><?php echo $lastname ?></td>
                                                        <td><?php
                                                            switch($row['vote']){
                                                                case '1':
                                                                    echo "Agree";
                                                                    break;
                                                                case '2':
                                                                    echo "Disagree";
                                                                    break;
                                                                case '3':
                                                                    echo "Unsure";
                                                                    break;
                                                                default:
                                                                    echo "No response";
                                                            }?>
                                                       </td>
                                                        <td><?php if (mysql_num_rows($result) == 0 ){echo "";}else{echo date('g:i A M j Y', strtotime($row['submitted']));}?></td>
                                                    </tr>
                                                    <?php }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                            <?php }
                            elseif($page === "preInterviewAdult"){ ?>
                                <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered">
                                    <div id="preInterviewSubjectChart" style="width:100%; min-height: 500px;">
                                        <div style="display:flex;justify-content:center;align-items:center;width:100%;">
                                            <div>
                                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left: 1.15em;"></i><br><br><span style="font-size: 24px;">Loading Chart...</span>
                                            </div>
                                        </div>

                                </div>
                                <div id="preInterviewSubjectSleepChart" style="width:100%; min-height: 500px;">
                                        <div style="display:flex;justify-content:center;align-items:center;width:100%;">
                                            <div>
                                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left: 1.15em;"></i><br><br><span style="font-size: 24px;">Loading Chart...</span>
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered" style="margin-bottom:2em;">
                                <a class="btn btn-simple btn-block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="studentResponses">VIEW IDENTIFIED STUDENT RESPONSES</a>
                                <div class="collapse" id="collapseExample">
                                   <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="lastName" class="table table-striped">
                                       <thead>
                                           <tr>
                                               <th data-field="firstName" data-sortable="true">First Name</th>
                                               <th data-field="lastName" data-sortable="true">Last Name</th>
                                               <th data-field="interviewSubject" data-sortable="true">Interview Subject</th>
                                               <th data-field="interviewSubjectSleep" data-sortable="true">Interview Subject Sleep</th>
                                               <th data-field="submitted" data-sortable="true">Submitted</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            <?php
                                                include 'connectdb.php';
                                                require_once 'utilities.php';
                                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                                    if($userType == 'teacher') {
                                                        $resultLink = getUserIdsInClass($classId);
                                                    }else {
                                                        $resultLink = getLinkedUserIds($userId);
                                                    }
                                                    foreach($resultLink as $studentId) {
                                                        list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                        $result = mysql_query("SELECT * FROM fourthGradeLessonOnePreInterview WHERE userId='$studentId'");
                                                        $row = mysql_fetch_array($result);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $firstname ?></td>
                                                        <td><?php echo $lastname ?></td>
                                                        <td><?php
                                                            switch($row['interviewSubject']){
                                                                case '1':
                                                                    echo "Mother";
                                                                    break;
                                                                case '2':
                                                                    echo "Father";
                                                                    break;
                                                                case '3':
                                                                    echo "Guardian";
                                                                    break;
                                                                case '4':
                                                                    echo "Grandparent";
                                                                    break;
                                                                case '5':
                                                                    echo "<b>Other: </b>".$row['interviewSubjectOther'];
                                                                    break;
                                                                default:
                                                                    echo "No response";
                                                            }?>
                                                       </td>
                                                       <td><?php
                                                            switch($row['subjectResponse']){
                                                                case '1':
                                                                    echo "Almost always";
                                                                    break;
                                                                case '2':
                                                                    echo "Most of the time";
                                                                    break;
                                                                case '3':
                                                                    echo "Sometimes";
                                                                    break;
                                                                case '4':
                                                                    echo "Not very often";
                                                                    break;
                                                                case '5':
                                                                    echo "Hardly ever";
                                                                    break;
                                                                default:
                                                                    echo "No response";
                                                            }?></td>
                                                        <td><?php if (mysql_num_rows($result) == 0 ){echo "";}else{echo date('g:i A M j Y', strtotime($row['submitted']));}?></td>
                                                    </tr>
                                                    <?php }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                            <?php }
                            elseif($page === "interviewAdult"){ ?>
                               <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered">
                                    <div id="preInterviewSubjectChart" style="width:100%; min-height: 500px;">
                                        <div style="display:flex;justify-content:center;align-items:center;width:100%;">
                                            <div>
                                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left: 1.15em;"></i><br><br><span style="font-size: 24px;">Loading Chart...</span>
                                            </div>
                                        </div>

                                </div>
                                <div id="preInterviewSubjectSleepChart" style="width:100%; min-height: 500px;">
                                        <div style="display:flex;justify-content:center;align-items:center;width:100%;">
                                            <div>
                                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left: 1.15em;"></i><br><br><span style="font-size: 24px;">Loading Chart...</span>
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                                <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2 text-centered" style="margin-bottom:2em;">
                                <a class="btn btn-simple btn-block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="studentResponses">VIEW IDENTIFIED STUDENT RESPONSES</a>
                                <div class="collapse" id="collapseExample">
                                   <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="lastName" class="table table-striped">
                                       <thead>
                                           <tr>
                                               <th data-field="firstName" data-sortable="true">First Name</th>
                                               <th data-field="lastName" data-sortable="true">Last Name</th>
                                               <th data-field="interviewSubject" data-sortable="true">Interview Subject</th>
                                               <th data-field="interviewSubjectSleep" data-sortable="true">Subject's Sleep</th>
                                               <th data-field="interviewSubjectSleepResponse">Subject's Elaboration</th>
                                               <th data-field="goodSleep">Good Sleep Response</th>
                                               <th data-field="badSleep">Poor Sleep Response</th>
                                               <th data-field="q1">Student's Question One</th>
                                               <th data-field="a1">Question One Response</th>
                                               <th data-field="q2">Student's Question Two</th>
                                               <th data-field="a2">Question Two Response</th>
                                               <th data-field="q3">Student's Question Three</th>
                                               <th data-field="a3">Question Three Response</th>
                                               <th data-field="q4">Student's Question Four</th>
                                               <th data-field="a4">Question Four Response</th>
                                               <th data-field="q5">Student's Question Five</th>
                                               <th data-field="a5">Question Five Response</th>
                                               <th data-field="submitted" data-sortable="true">Submitted</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            <?php
                                                include 'connectdb.php';
                                                require_once 'utilities.php';
                                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                                    if($userType == 'teacher') {
                                                        $resultLink = getUserIdsInClass($classId);
                                                    }else {
                                                        $resultLink = getLinkedUserIds($userId);
                                                    }
                                                    foreach($resultLink as $studentId) {
                                                        list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                        $result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterview WHERE userId='$studentId'");
                                                        $numRow = mysql_num_rows($result);





                                                        if ($numRow>0) {
                                                            while($row = mysql_fetch_array($result)){

                                                              $questionArray = array("---","---","---","---","---");
                                                              $answerArray = array("---","---","---","---","---");
                                                              $ind = 0;
                                                              if (strlen($row['Q4'])>0 && strlen($row['A4'])>0) {
                                                                $questionArray[$ind] = $row['Q4'];
                                                                $answerArray[$ind] = $row['A4'];
                                                                $ind ++;
                                                              }else {
                                                                $questionArray[$ind] = "Q4";
                                                                $answerArray[$ind] = "A4";
                                                              }
                                                              if (strlen($row['Q5'])>0 && strlen($row['A5'])>0) {
                                                                $questionArray[$ind] = $row['Q5'];
                                                                $answerArray[$ind] = $row['A5'];
                                                                $ind ++;
                                                              }
                                                              if (strlen($row['Q6'])>0 && strlen($row['A6'])>0) {
                                                                $questionArray[$ind] = $row['Q6'];
                                                                $answerArray[$ind] = $row['A6'];
                                                                $ind ++;
                                                              }
                                                              if (strlen($row['Q7'])>0 && strlen($row['A7'])>0) {
                                                                $questionArray[$ind] = $row['Q7'];
                                                                $answerArray[$ind] = $row['A7'];
                                                                $ind ++;
                                                              }
                                                              if (strlen($row['Q8'])>0 && strlen($row['A8'])>0) {
                                                                $questionArray[$ind] = $row['Q8'];
                                                                $answerArray[$ind] = $row['A8'];
                                                                $ind ++;
                                                              }

                                                                $interviewId = $row['uniqueId'];
                                                                echo "<tr>";
                                                        echo "<td>".$firstname."</td>";
                                                        echo "<td>".$lastname."</td>";
                                                            ?>
                                                                <td><?php
                                                            switch($row['interviewSubject']){
                                                                case '1':
                                                                    echo "Mother";
                                                                    break;
                                                                case '2':
                                                                    echo "Father";
                                                                    break;
                                                                case '3':
                                                                    echo "Guardian";
                                                                    break;
                                                                case '4':
                                                                    echo "Grandparent";
                                                                    break;
                                                                case '5':
                                                                    echo "<b>Other: </b>".$row['Q2'];
                                                                    break;
                                                                default:
                                                                    echo "No response";
                                                            }?></td>
                                                                <td><?php
                                                            switch($row['A1']){
                                                                case '1':
                                                                    echo "Almost always";
                                                                    break;
                                                                case '2':
                                                                    echo "Most of the time";
                                                                    break;
                                                                case '3':
                                                                    echo "Sometimes";
                                                                    break;
                                                                case '4':
                                                                    echo "Not very often";
                                                                    break;
                                                                case '5':
                                                                    echo "Hardly ever";
                                                                    break;
                                                                default:
                                                                    echo "No response";
                                                            }?></td>
                                                                <td><?php echo $row['A1Exp']?></td>
                                                                <td><?php echo $row['A2']?></td>
                                                                <td><?php echo $row['A3']?></td>

                                                                <td> <?php echo $questionArray[0]?></td>
                                                                <td> <?php echo $answerArray[0]?></td>

                                                                <td> <?php echo $questionArray[1]?></td>
                                                                <td> <?php echo $answerArray[1]?></td>
                                                                <td> <?php echo $questionArray[2]?></td>
                                                                <td> <?php echo $answerArray[2]?></td>
                                                                <td> <?php echo $questionArray[3]?></td>
                                                                <td> <?php echo $answerArray[3]?></td>
                                                                <td> <?php echo $questionArray[4]?></td>
                                                                <td> <?php echo $answerArray[4]?></td>

                                                                <td><?php echo date('g:i A M j Y', strtotime($row['submitTime']));?></td>
                                                            <?php }}
                                                            else {
                                                                echo "<tr>";
                                                        echo "<td>".$firstname."</td>";
                                                        echo "<td>".$lastname."</td>";
                                                                echo "
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>";
                                                            }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                            <?php }}
                        ?>
                    </div>
                </div>
                <?php include 'partials/footer.php' ?>
            </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
        $(function(){
            $("#studentResponses").click(function () {
                $(this).text(function(i, text){
                    return text === "VIEW IDENTIFIED STUDENT RESPONSES" ? "HIDE IDENTIFIED STUDENT RESPONSES" : "VIEW IDENTIFIED STUDENT RESPONSES";
                })
            });
        })
    </script>
       <!-- Sleep Vote Chart -->
       <?php if($page === "enoughSleepVote") { ?>
        <script>
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawVisualization);

            function drawVisualization() {
                var data = google.visualization.arrayToDataTable([
                                                ['response', 'Votes', { role: 'style' }]
                                                , ['Agree', <?php echo $agreeVotes ?>, 'color: #fbc02d']
                                                , ['Disagree', <?php echo $disagreeVotes ?>, 'color: #03a9f4']
                                                , ['Unsure', <?php echo $unsureVotes ?>, 'color: #4caf50']
                                            ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

                var options = {
                    title: 'Student Responses to the statement, "People get enough sleep"',
                    legend: 'none',
                    vAxis: {
                        title: 'Votes',
                        viewWindow: {
                            min: [0],

                        }
                    },
                    hAxis: {
                        title: 'Response'
                    },
                    seriesType: 'bars',
                    series: {
                        5: {
                            type: 'line'
                        }
                    }
                };
                var chart = new google.visualization.ComboChart(document.getElementById('enoughSleepVotesChart'));
                chart.draw(view, options);
            }
        </script>
        <?php } ?>
        <!-- Pre Interview Subject Chart -->
        <script>
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawVisualization);

            function drawVisualization() {
                var data = google.visualization.arrayToDataTable([
                                                ['response', 'Votes', { role: 'style' }],
                                                ['Mother', <?php echo $motherCount ?>, 'color: #fbc02d'],
                                                ['Father', <?php echo $fatherCount ?>, 'color: #03a9f4'],
                                                ['Guardian', <?php echo $guardianCount ?>, 'color: #4caf50'],
                                                ['Grandparent', <?php echo $grandparentCount ?>, 'color: #9c27b0'],
                                                ['Other', <?php echo $otherCount ?>, 'color: #f44336'],
                                            ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

                var options = {
                    title: 'Student Responses to Interview Subject',
                    legend: 'none',
                    vAxis: {
                        title: 'Response',
                        viewWindow: {
                            min: [0],

                        }
                    },
                    hAxis: {
                        title: 'Number of Votes'
                    },
                    seriesType: 'bars',
                    series: {
                        5: {
                            type: 'line'
                        }
                    }
                };
                var chart = new google.visualization.ComboChart(document.getElementById('preInterviewSubjectChart'));
                chart.draw(view, options);
            }
        </script>
        <!-- Pre Interview Subject Sleep -->
        <script>
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawVisualization);

            function drawVisualization() {
                var data = google.visualization.arrayToDataTable([
                                                ['response', 'Votes', { role: 'style' }],
                                                ['Almost always', <?php echo $almostAlways ?>, 'color: #fbc02d'],
                                                ['Most of the time', <?php echo $mostOfTime ?>, 'color: #03a9f4'],
                                                ['Sometimes', <?php echo $sometimes ?>, 'color: #4caf50'],
                                                ['Not very often', <?php echo $notVeryOften ?>, 'color: #9c27b0'],
                                                ['Hardly ever', <?php echo $hardlyEver ?>, 'color: #f44336'],
                                            ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

                var options = {
                    title: 'Student Responses to Interview Subject Sleep',
                    legend: 'none',
                    vAxis: {
                        title: 'Response',
                        viewWindow: {
                            min: [0],

                        }
                    },
                    hAxis: {
                        title: 'Number of Votes'
                    },
                    seriesType: 'bars',
                    series: {
                        5: {
                            type: 'line'
                        }
                    }
                };
                var chart = new google.visualization.ComboChart(document.getElementById('preInterviewSubjectSleepChart'));
                chart.draw(view, options);
            }
        </script>
	<!-- Student View -->
	<script>
	 function studentView(){
	     var pages = "<?php echo $page ?>";
	     if(pages == "whatIsSleep"){
		 window.open("./what-is-sleep");
	     }else if(pages == "whyDoWeSleep"){
		 window.open("./why-do-we-sleep");
	     }else if(pages == "enoughSleepVote"){
		 window.open("./enough-sleep-vote");
	     }else if(pages == "preInterviewAdult"){
		 window.open("./adult-pre-interview");
	     }else if(pages == "interviewAdult"){
		 window.open("./interview-adult");
	     }
	 }
	</script>
</html>
