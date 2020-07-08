<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');
require_once('assets/mailer/class.phpmailer.php');  
declare(ticks=1);

$pid = pcntl_fork();
if ($pid == -1) {
    error_exit("Failed to fork diary-daemon."); 
}
else if ($pid) {      // Parent process
    log_info("diary-daemon forked. PID = " . $pid);
    exit();
} 
else {                // Child process
    log_info("diary-daemon started.");
}

// Detatch from the controlling terminal
if (posix_setsid() == -1) {
    error_exit("diary-daemon: could not detach from terminal.");
}

// Set up signal handlers
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGHUP, "sig_handler");
$send = true;
// Loop forever 
while (1) {
    include 'connectdb.php';

    $currentDateTime = getLocalDateTime();
    $currentDate = getLocalDate();
    $currentTime = getLocalTime();

    // Check to see if need to create new sleep diary or activity diary entries
    $resultsStudentUsers = mysql_query("SELECT * FROM user_table WHERE type='student'");
    while ($rowStudent = mysql_fetch_array($resultsStudentUsers)) {
        $studentUserId = $rowStudent['userId'];
        $userSettings = getUserSettings($studentUserId);
        if (!$userSettings['diaryEnabled'])         // Diary entry is not enabled for this student
            continue;
        
        // Create a new sleep diary if necessary
        $sleepDiaryAvailableStartTime = $userSettings['diaryAvailableStartTime'];
        if ($sleepDiaryAvailableStartTime <= $currentTime) {         // Sleep diary entry should be available
            //$diaryDate = getDateFromTime(strtotime('-1 day', strtotime($currentDate)));    // The sleep diary date is the previous day
            $diaryDate = getDateFromTime(strtotime($currentDate)); 
            $resultsUserDiaries = mysql_query("SELECT * FROM diary_data_table WHERE userId='$studentUserId' AND diaryDate='$diaryDate'");
            if (mysql_num_rows($resultsUserDiaries) <= 0) {        // Diary entry does not exist
                // Create a new sleep diary entry
		$sumissionDate = getDateFromTime(strtotime('+1 day', strtotime($currentDate)));
                $submissionDeadline = $sumissionDate . " " . $userSettings['diarySubmitByTime'];   // Assume current date and diary date are off by 1 day
                mysql_query("INSERT INTO diary_data_table(userId, diaryDate, submissionDeadline) VALUES ('$studentUserId', '$diaryDate', '$submissionDeadline')");
            }
        }
        
        // Create a new activity diary if necessary
        // Use the sleep diary available time and add 12 hours as the activity diary available time.
        $activityDiaryAvailableStartTime = date('H:i:s', strtotime('+12 hour', strtotime($sleepDiaryAvailableStartTime))); 
        if ($activityDiaryAvailableStartTime <= $currentTime) {         // Activity diary entry should be available
            $diaryDate = $currentDate;
            $resultsUserDiaries = mysql_query("SELECT * FROM activity_diary_data_table WHERE userId='$studentUserId' AND diaryDate='$diaryDate'");
            if (mysql_num_rows($resultsUserDiaries) <= 0) {        // Diary entry does not exist
                // Create a new activity diary entry with submission deadline same as that for sleep diary
                $submissionDeadline = date('Y-m-d H:i:s', strtotime('+24 hour', strtotime($userSettings['diarySubmitByTime']))); 
                mysql_query("INSERT INTO activity_diary_data_table(userId, diaryDate, submissionDeadline) VALUES ('$studentUserId', '$diaryDate', '$submissionDeadline')");
            }
        }
    }
    
    // Check if need to send out alert for incomplete diary entries
    //sendMissingDiaryAlert('diary_data_table', 'sleep');
    //sendMissingDiaryAlert('activity_diary_data_table', 'activity');

    if($currentTime >= '09:00:00' && $currentTime <= '14:00:00' && $send == true){
	$resultClass = mysql_query("SELECT classId, className FROM class_info_table WHERE reminder='1'");
	while($rowClass = mysql_fetch_array($resultClass)){ //loop classes
	    $classId = $rowClass['classId'];
	    $className = $rowClass['className'];
	    $grade = getClassGrade($classId);
	    $studentList = getUserIdsInClass($classId);
	    $emailContentSleep = ' ';
	    $emailContentActivity = ' ';
	    foreach($studentList as $studentId){
		list($firstname, $lastname) = getUserFirstLastNames($studentId);
		$result = mysql_query("SELECT diaryStartDateFour, diaryEndDateFour, diaryStartDateFive, diaryEndDateFive, activityStartDateFour, activityEndDateFour, activityStartDateFive, activityEndDateFive  FROM user_table WHERE userId='$studentId'");
    	  	$row = mysql_fetch_array($result);
		if($grade == 4){
		    $startSleep = $row['diaryStartDateFour'];
		    $endSleep = $row['diaryEndDateFour'];
		    $startActivity = $row['activityStartDateFour'];
		    $endActivity = $row['activityEndDateFour'];
		}else{
		    $startSleep =$row['diaryStartDateFive'];
		    $endSleep = $row['diaryEndDateFive'];
		    $startActivity =$row['activityStartDateFive'];
		    $endActivity = $row['activityEndDateFive'];
		}
		/*Sleep Diary*/
		$resultSleep = mysql_query("SELECT diaryDate FROM diary_data_table WHERE userId='$studentId' And timeCompleted IS NULL AND diaryDate <= '$endSleep' AND diaryDate >= '$startSleep' AND diaryDate <= '$currentDate'");
		if(mysql_num_rows($resultSleep) > 0){
		    $emailContentSleep .= $firstname;
		    $emailContentSleep .= ' ';
		    $emailContentSleep .= $lastname;
		    $emailContentSleep .= ": ";
		}
		while($rowSleep = mysql_fetch_array($resultSleep)){
		    $emailContentSleep .= $rowSleep['diaryDate'];
		    $emailContentSleep .= '; ';
		}
		$emailContentSleep .= '
';
		/*Activity Diary*/
		$resultActivity = mysql_query("SELECT diaryDate FROM activity_diary_data_table WHERE userId='$studentId' And timeCompleted IS NULL AND diaryDate <= '$endActivity' AND diaryDate >= '$startActivity' AND diaryDate <= '$currentDate'");
		if(mysql_num_rows($resultActivity) > 0){
		    $emailContentActivity .= $firstname;
		    $emailContentActivity .= ' ';
		    $emailContentActivity .= $lastname;
		    $emailContentActivity .= ": ";
		}
		while($rowActivity = mysql_fetch_array($resultActivity)){
		    $emailContentActivity .= $rowActivity['diaryDate'];
		    $emailContentActivity .= '; ';
		}
		$emailContentActivity .= '
';
	    }
	    /*get teachers email by class*/
	    $resultTeacher = mysql_query("SELECT class_table.userId FROM class_table  RIGHT JOIN user_table ON user_table.userId = class_table.userId where class_table.classId='$classId' AND type='teacher'");
	    while ($rowTeacher = mysql_fetch_array($resultTeacher)) {
		$Id = $rowTeacher['userId'];
		$resultEmail = mysql_query("SELECT emailAddress FROM user_table WHERE userId='$Id' AND type='teacher'");
		$rowEmail = mysql_fetch_array($resultEmail);
		$emailAddress = $rowEmail['emailAddress'];
		$titleSleep = $currentDate.' '.$className.' Sleep Diary Reminder: ';
		$titleActivity = $currentDate.' '.$className.' Activity Diary Reminder: ';
		sendEmail($emailAddress, $emailContentSleep, $titleSleep);
		sendEmail($emailAddress, $emailContentActivity, $titleActivity);
	    }
	}
	$send = false;
    }

    if($currentTime >= '20:00:00' && $currentTime <= '23:00:00'){
	$send = true;
    }
    
    mysql_close($con);
    sleep(60);      // sleep for 60 seconds
}


function sendEmail($destination, $bodyText, $subjectSend){  
    $email = new PHPMailer();
    $email->From      = 'mysleep@zfactor.coe.arizona.edu';
    $email->FromName  =  'Zfactor Team';
    $email->Subject   =  $subjectSend;
    $email->Body      =  rtrim($bodyText);
    $email->AddAddress($destination);
    return $email->Send();
}

// Function to get the email address for alerting incomplete diary
function getAlertEmailAddress($userId)
{
    $result = mysql_query("SELECT * FROM user_link_table WHERE linkUserId='$userId'");
    $row = mysql_fetch_array($result);
    $masterUserId = $row['userId'];
    
    $result = mysql_query("SELECT * FROM user_table WHERE userId='$masterUserId' AND type='teacher'");
    $row = mysql_fetch_array($result);
    $emailAddress = $row['emailAddress'];
    return $emailAddress;
}

// Function to handle various signals
function sig_handler($signo) 
{
    switch ($signo) {
        case SIGTERM:                  // Handle shutdown signal
	    log_info("diary-daemon: Terminating process...");
	    exit;
	    break;
        case SIGHUP:                    // Handle restart signal
	    log_info("diary-daemon: Received restart signal. Ignored.");
	    break;
        default:                        // Handle all other signals
	    log_info("diary-daemon: Received unknown signal.");
    }
}

// Check if need to send out alert for incomplete diary entries
function sendMissingDiaryAlert($table, $type)
{
    $currentDateTime = getLocalDateTime();
    $queryCommand = "SELECT * FROM ". $table . " WHERE timeCompleted IS NULL";
    $resultsIncompleteDiary = mysql_query($queryCommand);

    while ($rowDiary = mysql_fetch_array($resultsIncompleteDiary)) {
        if ($rowDiary['submissionDeadline'] > $currentDateTime)     // Time is not up yet
	    continue;
        if ($rowDiary['alertSent'] > 0)     // Alert has been sent
	    continue;
        $userId = $rowDiary['userId'];
        $userSettings = getUserSettings($userId);
        if (!$userSettings['diaryEnabled'])         // Diary entry is not enabled for this user
	    continue;
	$resultUser = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
    	$rowUser = mysql_fetch_array($resultUser); 
	if($rowUser['currentGrade'] == '4'){
	    $diaryStartDate = new DateTime($rowUser['diaryStartDateFour']);
	    $diaryEndDate = new DateTime($rowUser['diaryEndDateFour']);
	}else{
	    $diaryStartDate = new DateTime($rowUser['diaryStartDateFive']);
	    $diaryEndDate = new DateTime($rowUser['diaryEndDateFive']);
	}
	$diaryDate = new DateTime($rowDiary['diaryDate']);
        if($diaryDate > $diaryEndDate || $diaryDate < $diaryStartDate)
	    continue;
        // Set out a reminder email
        $emailAddress = getAlertEmailAddress($userId);
        if (!$emailAddress)         // No email address available
	    continue;
        $diaryId = $rowDiary['diaryId'];

        // Construct the email
        list($firstname, $lastname) = getUserFirstLastNames($userId);
        $subject = $firstname . ' ' . $lastname . '\'s ' . $type . ' diary ' . $rowDiary['diaryDate'] . ' is overdue.';
        $message = 'Due date is ' . $rowDiary['submissionDeadline'] . '.';
        $headers = 'From: mysleep@zfactor.coe.arizona.edu';

        $result = mail($emailAddress, $subject, $message, $headers);
        if ($result == true)
        {
	    $queryCommand = "UPDATE " . $table . " SET alertSent=alertSent+1 WHERE diaryId='$diaryId'";
	    mysql_query($queryCommand);
        }
        else
	    log_error("Failed to send alert email to " . $emailAddress);
    }
}

?>
