<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li, Wo-Tak Wu
#
// Utility functions

// ************************ Date and time related function ************************
// Function to get a string containing current local date and time.
// Time is in 24-hour format with leading zeros.
// The output format is 'YYYY-MM-DDD HH:MM:SS'.
$defaultClass = '';
function checkauth(){
    session_start();

    $webroot = "Location: login";

    if (!(isset($_SESSION['userId']))){
        header($webroot);
        exit;
    }
}

function get_localtime($format="Y-m-d H:i:s")
{
    date_default_timezone_set('America/Phoenix');
    return date($format);
}

// Function same as get_locatime() above
function getLocalDateTime($format="Y-m-d H:i:s")
{
    date_default_timezone_set('America/Phoenix');
    return date($format);
}

function getLocalDate($format="Y-m-d")
{
    date_default_timezone_set('America/Phoenix');
    return date($format);
}

// Function to get a string containing current local time.
// Time is in 24-hour format with leading zeros.
function getLocalTime($format="H:i:s")
{
    date_default_timezone_set('America/Phoenix');
    return date($format);
}

function getDateFromTime($inputDate)
{
    date_default_timezone_set('America/Phoenix');
    return date('Y-m-d',$inputDate);;
}

// Compute the elapsed time between two times that might cross midnight
// Input: Time strings in 24-hour format: HH:MM:SS.
// Output: time in seconds.
// Note: There is an equivalent function in Javascript in javascripts.js.
function computeElapsedTime($time1, $time2)
{
    if (is_null($time1))
        return NULL;
    if (is_null($time2))
        return NULL;

    $time1Sec = strtotime($time1);
    $time2Sec = strtotime($time2);

    $diffTimeSec = 0;
    if ($time1Sec > $time2Sec)      // Cross midnight
        $diffTimeSec = 24 * 60 * 60 - $time1Sec + $time2Sec;
    else
        $diffTimeSec = $time2Sec - $time1Sec;
    return $diffTimeSec;
}

// Compute the elapsed time in hours
// See details in computeElapsedTime()
function computeElapsedTimeHours($time1, $time2)
{
    $napDurationSeconds = computeElapsedTime($time1, $time2);
    if (is_null($napDurationSeconds))
        return NULL;
    return $napDurationSeconds / (60 * 60);
}

// Function to get time string in "hh:mm am/pm" format from a 24-hr time string in "hh:mm:ss"
function getTimeDisplay($time24Hr)
{
    if ($time24Hr == "")
        return "";
    return date('h:i a', strtotime($time24Hr));     // Hour:Minute am/pm
}

function getUsername($userId)
{
    $result = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    return $row['userName'];
}

function getUserGender($userId)
{
    $result = mysql_query("SELECT gender FROM user_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    return $row['gender'];
}
function getUserFirstLastNames($userId)
{
    $result = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    return array($row['firstName'], $row['lastName']);
}
function getUserFullNames($userId)
{
    $result = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    return $row['firstName'].' '.$row['lastName'];
}
function getUserFirstNames($userId)
{
    $result = mysql_query("SELECT firstName FROM user_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    return $row['firstName'];
}
function getGroupUserNames($contributorsString)
{
    $contributors = explode(",", $contributorsString);
    $contributor = join("','",$contributors);
    $result = mysql_query("SELECT * FROM user_table WHERE userId IN ('$contributor')");
    $groupName = '';
    while ($row = mysql_fetch_array($result)) {
      $groupName .= $row['firstName'].' '.$row['lastName'].'; ';
    }
    return $groupName;
}
function getGroupUserNumber($contributorsString)
{
    $contributors = explode(",", $contributorsString);
    return count($contributors);
}

function log_error($message)
{
    file_put_contents("error_log.txt", get_localtime("Y-m-d H:i:s T ").$message."\n", FILE_APPEND);
}

function log_info($message)
{
    file_put_contents("info_log.txt", get_localtime("Y-m-d H:i:s T ").$message."\n", FILE_APPEND);
}

function error_exit($message)
{
    log_error($message);
    die($message);
}

function getUserSettings($userId)
{
    $result = mysql_query("SELECT * FROM user_setting_table WHERE userId='$userId'");
    $row = mysql_fetch_array($result);
    if ($row)               // Settings are found
        return $row;
    $status = mysql_query("INSERT INTO user_setting_table(userId) VALUES ('$userId')");
    if (!$status) {
        error_exit('Failed to add user settings to the database: ' . mysql_error());
    }
    $result = mysql_query("SELECT * FROM user_setting_table WHERE userId='$userId'");
    return mysql_fetch_array($result);
}

function getLinkedUserIds($userId)
{
    $linkedUsers = [];
    $results = mysql_query("SELECT DISTINCT linkUserId FROM user_link_table where userId='$userId' ORDER BY linkUserId");
    while ($row = mysql_fetch_array($results)) {
        array_push($linkedUsers, $row['linkUserId']);
        //echo $row['linkUserId'];
    }
    return $linkedUsers;
}

function getUserIdsInClass($classNum) {
	 $classUsers = [];
    $results = mysql_query("SELECT DISTINCT class_table.userId FROM class_table  RIGHT JOIN user_table ON user_table.userId = class_table.userId where class_table.classId='$classNum' AND type='student' Order by class_table.userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($classUsers, $row['userId']);
    }
    return $classUsers;
}


function getUserIdsInSchool($schoolId) {
    $users = [];
    $results = mysql_query("SELECT DISTINCT userId FROM user_table where schoolId='$schoolId' ORDER BY userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($users, $row['userId']);
    }
    return $users;
}

function getStudentIdsInSchool($schoolId) {
    $users = [];
    $results = mysql_query("SELECT DISTINCT userId FROM user_table where schoolId='$schoolId' AND type='student' ORDER BY userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($users, $row['userId']);
    }
    return $users;
}

function getUserIdsInSchoolWithSameGrade($grade, $schoolId) {
    $users = [];
    $results = mysql_query("SELECT DISTINCT userId FROM user_table where currentGrade='$grade' AND schoolId='$schoolId' ORDER BY userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($users, $row['userId']);
    }
    return $users;
}

function getUserIdsInSchoolWithSameGradeAndSemester($grade, $schoolId, $year, $semester) {
    $users = [];
    $results = mysql_query("SELECT DISTINCT userId FROM user_table where currentGrade='$grade' AND schoolId='$schoolId' AND year='$year' AND semester='$semester' ORDER BY userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($users, $row['userId']);
    }
    return $users;
}

function getUserIdswithClassId($classId) {
    $users = [];
    $results = mysql_query("SELECT DISTINCT userId FROM user_table where classId='$classId' ORDER BY userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($users, $row['userId']);
    }
    return $users;
}

function getStudentUserIds()
{
    $studentUsers = [];
    $results = mysql_query("SELECT userId FROM user_table where type='student' ORDER BY userId");
    while ($row = mysql_fetch_array($results)) {
        array_push($studentUsers, $row['userId']);
    }
    return $studentUsers;
}

function getStudentClassId($userId) {
	$resultClass = mysql_query("SELECT classId FROM user_table where userId ='$userId'");
   $rowClass = mysql_fetch_array($resultClass);
   $studentClassId = $rowClass['classId'];
   return $studentClassId;
}

function getUserSchoolId($userId){
    $resultSchool = mysql_query("SELECT schoolId FROM user_table where userId ='$userId'");
    $rowSchool = mysql_fetch_array($resultSchool);
    $schoolId = $rowSchool['schoolId'];
    return $schoolId;
    }

function getStudentSemesterYear($userId) {
	$Id_info = mysql_query("SELECT semester, year FROM user_table WHERE userId='$userId'");
 	$row_info = mysql_fetch_array($Id_info);
 	$currentSemester = $row_info['semester'];
    $currentYear = $row_info['year'];
    if($currentSemester == 'S'){
	$currentSemester = 'Spring';
    }else{
	$currentSemester = 'Fall';
    }
        $yearSemester = $currentSemester.' '.$currentYear;
 	return $yearSemester;
}
// Function to find a student's grade level
// Note: This function assumes the database has not bee connected yet.
//   So, better use it only at the beginning of a script for setting up things.
function getCurrentGrade($userId)
{
    include 'connectdb.php';
    $result = mysql_query("SELECT currentGrade FROM user_table WHERE userId='$userId'");
    mysql_close($con);
    $row = mysql_fetch_array($result);
    $grade = $row['currentGrade'];
    return $grade;
}

function getGrade($userId)
{
    $result = mysql_query("SELECT currentGrade FROM user_table WHERE userId='$userId'");
    mysql_close($con);
    $row = mysql_fetch_array($result);
    $grade = $row['currentGrade'];
    return $grade;
}

function getClassGrade($classId){
    $result = mysql_query("SELECT grade FROM class_info_table WHERE classId='$classId'");
    $row = mysql_fetch_array($result);
    $grade = $row['grade'];
    return $grade;
}

function getSchoolName($schoolId){
    $result = mysql_query("SELECT schoolName FROM school_info WHERE schoolId = '$schoolId'");
    $row = mysql_fetch_array($result);
    $schoolName = $row['schoolName'];
    return $schoolName;
}

function getClassName($classId){
    $result = mysql_query("SELECT className FROM class_info_table WHERE classId ='$classId'");
    $row = mysql_fetch_array($result);
    $className = $row['className'];
    return $className;
}

function getDemoMode(){
    $classId = $_SESSION['classId'];
    $schoolId = $_SESSION['schoolId'];
    $demoMode = false;
    # check the demo mode for Science-City-2018
    if ($schoolId == "30001" && ($classId == "50021"||$classId == "50001")) {
      $schoolId = "30002";
      $classId = "50015";
      $demoMode = true;
    }elseif ($schoolId == "30001" && ($classId == "50022"||$classId == "50002")) {
      $schoolId = "30003";
      $classId = "50012";
      $demoMode = true;
    }elseif ($schoolId == "30001" && $classId == "50025") {
      $demoMode = true;
    }
    return array($schoolId, $classId, $demoMode);
}

function getAllActivityConfig(){
  // if ($_SESSION['userType'] == 'teacher') {
    include 'connectdb.php';
    $classId = $_SESSION['classId'];
    $configs = mysql_query("SELECT * FROM class_config WHERE classId = '$classId' AND actived = '1' ORDER BY lesson_num");
    return $configs;
  // }
  //   return 'Access Denied';
}
function getActivityConfigWithLesson($lessonNum){
    include 'connectdb.php';
    $classId = $_SESSION['classId'];
    $result = mysql_query("SELECT * FROM class_config WHERE classId = '$classId' AND lesson_num = '$lessonNum' AND actived = '1'");
    $config = mysql_fetch_array($result);
    return $config;
}
function getAllActivityConfigWithLesson($lessonNum){
    include 'connectdb.php';
    $classId = $_SESSION['classId'];
    $userType = $_SESSION['userType'];
    $configs = mysql_query("SELECT cla.*, act.description
      FROM class_config cla LEFT JOIN activity_info act
      ON cla.activity_id = act.activity_id
      WHERE cla.classId = '$classId' AND cla.lesson_num = '$lessonNum' AND cla.authenticate LIKE '%$userType%' AND cla.actived = '1' ORDER BY cla.activity_num");
    return $configs;
}
function getActivityConfigWithActivity($activityId){
    include 'connectdb.php';
    $classId = $_SESSION['classId'];
    $result = mysql_query("SELECT * FROM class_config WHERE classId = '$classId' AND activity_id = '$activityId' AND actived = '1'");
    $config = mysql_fetch_array($result);
    return $config;
}
function getActivityConfigWithNumbers($lessonNum, $activityNum){
    include 'connectdb.php';
    $classId = $_SESSION['classId'];
    $result = mysql_query("SELECT * FROM class_config WHERE classId = '$classId' AND activity_num = '$activityNum' AND lesson_num = '$lessonNum' AND actived = '1'");
    $config = mysql_fetch_array($result);
    return $config;
}

function num2word($num){
  $dict = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten');
  if (0<=$num && $num<=10) {
    $word = $dict[$num];
  }else {
    $word = $num;
  }
  return $word;
}
function num2color($num){
  $dict = array('danger', 'danger', 'info', 'warning', 'success', 'primary');
  if (0<=$num && $num<=5) {
    $color = $dict[$num];
  }else {
    $color = 'primary';
  }
  return $color;
}
function num2rgb($num){
  $dict = array('#de3a2f', '#de3a2f', '#1798dc', '#e0ab28', '#4baf50', '#9c28b0');
  if (0<=$num && $num<=5) {
    $color = $dict[$num];
  }else {
    $color = 'primary';
  }
  return $color;
}

// Function to show the user list as option elements
function showUserOptionList($userList, $demoMode=false)
{
    $i = 0;
    foreach ($userList as $user) {
      if ($demoMode) {
        $i ++;
        echo "<option value='$user'>" . "ScienceCity" . ", " . $i . "</option>";
      }else {
        list($firstname, $lastname) = getUserFirstLastNames($user);
        echo "<option value='$user'>" . $lastname . ", " . $firstname . "</option>";
      }
    }
}

function showGroupOptionList($workList, $demoMode=false)
{
    // value is the record id, display students names
    while ($work = mysql_fetch_array($workList)) {
      $contributors = explode(",", $work['contributors']);
      $groupName = '';
      $workId = $work['recordRow'];
      foreach ($contributors as $contributor) {
        list($firstname, $lastname) = getUserFirstLastNames($contributor);
        $groupName .= $firstname.' '.$lastname.'; ';
      }
      echo "<option value='$workId'>" . $groupName . "</option>";
    }
}

function showHourOptions($limit=12)
{
    for ($h = 0; $h <= $limit; $h++)
    {
        $str = str_pad(strval($h), 2, '0', STR_PAD_LEFT);
        echo "<option value=". $str . ">" . $str . "</option>";
    }
}

// Function to show a list of number options
function showNumberOptions($start, $end, $inc, $nDigits)
{
    for ($i=$start; $i<=$end; $i+=$inc)
    {
        $str = str_pad(strval($i), $nDigits, '0', STR_PAD_LEFT);
        echo "<option value=". $str . ">" . $str . "</option>";
    }
}

function showMinuteOptions()
{
    echo "<option value='00'> 00 </option>";
    echo "<option value='05'> 05 </option>";
    echo "<option value='10'> 10 </option>";
    echo "<option value='15'> 15 </option>";
    echo "<option value='20'> 20 </option>";
    echo "<option value='25'> 25 </option>";
    echo "<option value='30'> 30 </option>";
    echo "<option value='35'> 35 </option>";
    echo "<option value='40'> 40 </option>";
    echo "<option value='45'> 45 </option>";
    echo "<option value='50'> 50 </option>";
    echo "<option value='55'> 55 </option>";
}

function showIntertuptMinuteOptions()
{
    for ($i=0; $i<360; $i+=5)
    echo "<option value=$i> $i </option>";
}

function showAmPmOptions($default)
{
    if ($default == 'pm')
        echo "<option value='PM'> PM </option><option value='AM'> AM </option>";
    else
        echo "<option value='AM'> AM </option><option value='PM'> PM </option>";
}

// Function to render a common background for all pages
function common_background($pageTitle)
{
    echo "<head>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link rel='stylesheet' type='text/css' href='./assets/css/my-sleep-style.css'>";
    echo "<title>$pageTitle</title>";
    echo "</head>";
}

// Function to render a common header for all pages
function common_header($linkToMain=true)
{
    echo "<div class='header'>";
    if ($linkToMain)
        echo "<a class='header_link'; href='main-page.php'>MySleep</a>";
    else
        echo "<a class='header_link'>MySleep</a>";
    echo "</div>";
}


function debugToConsole( $name, $var ) {

    if ( is_array( $var ) )
        $console = "<script>console.log( '$name: " . implode( ',', $var) . "' );</script>";
    else
        $console = "<script>console.log( '$name: " . $var . "' );</script>";

    echo $console;
}



?>
