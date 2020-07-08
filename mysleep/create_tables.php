<?php

# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>
#
include 'connectdb.php';

// User table
$drop = "DROP TABLE IF EXISTS user_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE user_table 
(
    userId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    firstId varchar(10),
    secondId varchar(10),
    thirdId varchar(10),
    userName varchar(320),                                     
    password varchar(254),
    type ENUM('admin', 'researcher', 'teacher', 'parent', 'student'),
    firstName varchar(25),
    lastName varchar(25),
    currentGrade tinyint,
    year int(11),
    semester varchar(10),
    classId int(11),
    schoolId int(11),
    diaryStartDateFour date,
    diaryEndDateFour date, 
    diaryStartDateFive date,
    diaryEndDateFive date,
    emailAddress varchar(254),
    changeTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) AUTO_INCREMENT=10001";
mysql_query($sql,$con);

// User linkage table
// Link one user to another. Use for linking parents or teachers to students.
// For example, user_id is for teacher and it can link to multiple link_user_id's that are students.
$drop = "DROP TABLE IF EXISTS user_link_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE user_link_table 
(
    userId int NOT NULL,     
    linkUserId int NOT NULL
)";
mysql_query($sql,$con);

// Student class info table
$drop = "DROP TABLE IF EXISTS class_info_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE class_info_table 
(
    classId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    className varchar(20) NOT NULL,
    grade int NOT NULL,
    initialActiveDate varchar(15),
    schoolName varchar(30),
    schoolNum INT(11),
    active boolean,
    Lesson_1 boolean NOT NULL DEFAULT 0,
    Lesson_2 boolean NOT NULL DEFAULT 0,
    Lesson_3 boolean NOT NULL DEFAULT 0,
    Lesson_4 boolean NOT NULL DEFAULT 0,
    Lesson_5 boolean NOT NULL DEFAULT 0,
    player1 INT(11) NOT NULL DEFAULT 0,
	player2 INT(11) NOT NULL DEFAULT 0,
	player3 INT(11) NOT NULL DEFAULT 0,
	player4 INT(11) NOT NULL DEFAULT 0,
	player5 INT(11) NOT NULL DEFAULT 0,
	player6 INT(11) NOT NULL DEFAULT 0,
	player7 INT(11) NOT NULL DEFAULT 0,
	player8 INT(11) NOT NULL DEFAULT 0,
	player9 INT(11) NOT NULL DEFAULT 0,
	player10 INT(11) NOT NULL DEFAULT 0
	
) AUTO_INCREMENT=4001";
mysql_query($sql,$con);

// Student class table
// This able contains what users have what classes.
// Note: userId can be for a teacher.
$drop = "DROP TABLE IF EXISTS class_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE class_table 
(
    userId int NOT NULL,     
    classId int NOT NULL,
    initialEnrollDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    active boolean
)";
mysql_query($sql,$con);

// Create avatar table
$drop = "DROP TABLE IF EXISTS avatar_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE avatar_table 
(
    avatarId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    image longblob NOT NULL
)";
mysql_query($sql,$con);

/*
// Create waveform table
$drop = "DROP TABLE IF EXISTS waveform_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE waveform_table 
(
    waveformId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    date varchar(15),
    userId int,
    Xaxis longtext,
    Yaxis longtext
)";
mysql_query($sql,$con);
*/

// Create activity data table
// This table contains all the activity data of all users. There is a dataHeader field
//   that index to another table that contains the data file header extracted during
//   data file import.
// The data format models the Actiwatch data format.
$drop = "DROP TABLE IF EXISTS activity_data_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE activity_data_table 
(
    userId int,
    recordNum int,
    date varchar(15),
    time varchar(15),
    offWrist boolean,
    activity int,
    marker int,
    whiteLight float,
    redLight float,
    greenLight float,
    blueLight float,
    awake boolean,
    intervalStatus varchar(10),
    dataHeader int,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

// Create data header table
// This table the data file header extracted during data file import.
// It should not be needed for normal data processing. It is just used a place holder to
//   provide extra information about a particular data set when needed.
$drop = "DROP TABLE IF EXISTS data_header_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE data_header_table 
(
    dataHeaderId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    contents longtext,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

// Create sleep diary data table
// This table contains all the sleep diaries of all users.
// Note: diaryDate is the date after the night of sleeping occurred.
//       timeCompleted should be one day after diaryDate.
//			diaryGrade is the grade when student fill the diary
$drop = "DROP TABLE IF EXISTS diary_data_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE diary_data_table 
(
    diaryId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    diaryGrade INT(11),
    diaryDate date,
    submissionDeadline datetime,
    alertSent int DEFAULT 0,
    timeCompleted datetime,
    timeToBed time,
    timeWakeup time,
    numWokeup int,
    minFallAsleep int,
    medTaken boolean,
    timeFellAsleep time,
    timeLightsOff time,
    timeElectronicsOff time,
    timeOutOfBed time,
    minWokeup int,
        disturbedByNoise boolean,
        disturbedBypets boolean,
        disturbedByElectronics boolean,
        disturbedByFamily boolean,
        disturbedByDream boolean,
        disturbedByBathroomNeed boolean,
        disturbedByTemperature boolean,
        disturbedByIllness boolean,
        disturbedByBodilyPain boolean,
        disturbedByWorries boolean,
        disturbedByBusyMinds boolean,
        disturbedByLighting boolean,
        disturbedByUnknown boolean,
        disturbedByNothing boolean,
        disturbedByOther boolean,
        disturbedByOtherContent longtext,   
    hourSlept float,
        actBefSleepTV boolean,
        actBefSleepMusic boolean,
        actBefSleepVideoGame boolean,
        actBefSleepComp boolean,
        actBefSleepRead boolean,
        actBefSleepHomework boolean,
        actBefSleepShower boolean,
        actBefSleepPlayWithPeople boolean,
        actBefSleepSnack boolean,
        actBefSleepText boolean,
        actBefSleepPhone boolean,
        actBefSleepDrinkCaff boolean,
        actBefSleepExercise boolean,
        actBefSleepMeal boolean,
        actBefSleepOther boolean, 
        actBefSleepOtherContent longtext,
    wokeupState ENUM('refreshed', 'lessRefreshed', 'tired'),
    sleepQuality ENUM('veryRestless', 'restless', 'average', 'sound', 'verySound'),
    sleepCompare ENUM('worse', 'same', 'better'),
    roomDarkness int,
    roomQuietness int,
    roomWarmness int,
    practice boolean
)";
mysql_query($sql,$con);

// Create activity diary data table
// This table contains all the activity diaries of all users.
// Note: diaryDate is the same date of the night for the sleep diary.
//       timeCompleted should be the same day as diaryDate.
//			diaryGrade is the grade when student fill the diary
$drop = "DROP TABLE IF EXISTS activity_diary_data_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE activity_diary_data_table 
(
    diaryId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    diaryGrade INT(11),
    diaryDate date,
    submissionDeadline datetime,
    alertSent int DEFAULT 0,
    timeCompleted datetime,
    napStart time,
    napEnd time,
    minExercised int,
    numCaffeinatedDrinks int,
    feltDuringDay ENUM('veryPleasant', 'pleasant', 'sometimesPleasant', 'unpleasant', 'veryUnpleasant'),
    howSleepy ENUM('not', 'somewhat', 'sleepy', 'very'),
    howAttentive ENUM('very', 'mostly', 'not'),
    practice boolean
)";
mysql_query($sql,$con);

// Create user setting table
// This table contains each user's settings for various purposes.
// Note: diarySubmitByTime and diaryAvailableStartTime should be in the day after diaryDate in the diary_data_table.
//       diaryDailyEntryNum is for testing purpose only. It has the number of diaries to fill out each day.
$drop = "DROP TABLE IF EXISTS user_setting_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE user_setting_table 
(
    userId int,
    diaryEnabled boolean DEFAULT true,
    diarySubmitByTime time DEFAULT '9:00',
    diaryAvailableStartTime time DEFAULT '3:00',
    diaryDailyEntryNum int DEFAULT 1,
    diaryMissingAlertEnabled boolean DEFAULT true
)";
mysql_query($sql,$con);

// Create basketball tests table
// This table contains data for computing free throw percentages of players.
$drop = "DROP TABLE IF EXISTS basketball_test_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE basketball_test_table 
(
    player int,
    attempt int,
    after_sleep_made boolean,
    after_more_sleep_made boolean,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);
for ($player=1; $player<=10; $player++) {
    for ($attempt=1; $attempt<=10; $attempt++) {
        $sql = "INSERT INTO basketball_test_table (player,attempt,after_sleep_made,after_more_sleep_made) VALUES ($player,$attempt,1,1)";
        mysql_query($sql,$con);
    }
}
$misses = array(
    array(1,6,0,1),    array(1,10,1,0),
    array(2,1,0,1),    array(2,6,0,1),
    array(3,2,0,1),    array(3,3,0,1),     array(3,6,1,0),
    array(4,1,0,0),    array(4,9,0,1),     array(4,10,1,0),
    array(5,1,0,1),    array(5,2,0,1),     array(5,6,0,1),    array(5,8,1,0),
    array(6,2,1,0),    array(6,5,1,0),     array(6,6,0,1),    array(6,10,0,1),
    array(7,6,0,1),    array(7,8,0,1),     array(7,9,0,1),    array(7,10,1,0),
    array(8,2,0,1),    array(8,3,1,0),     array(8,6,0,1),    array(8,7,0,1),    array(8,9,0,1),
    array(9,1,1,0),    array(9,8,0,1),     array(9,10,1,0),   
    array(10,4,0,1),   array(10,6,0,1),    array(10,8,1,0)
);
for ($i=0; $i<count($misses); $i++) {
    $player = $misses[$i][0];
    $attempt = $misses[$i][1];
    $result1 = $misses[$i][2];
    $result2 = $misses[$i][3];
    $sql = "UPDATE basketball_test_table SET after_sleep_made='$result1', after_more_sleep_made='$result2' WHERE player='$player' AND attempt='$attempt'";
    mysql_query($sql,$con);
}
// Create basketball test answers table
// This table contains the answers entered by the users
$drop = "DROP TABLE IF EXISTS basketball_test_answers_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE basketball_test_answers_table 
(
    userId int,
    player int,
    percentage_after_sleep_made float,
    percentage_after_more_sleep_made float,
    grade int,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);


//****************************Create Age Sleep Hours Table*******************************
// Create new Age Sleep Hours table for lesson Test

$drop = "DROP TABLE IF EXISTS age_sleep_hours_test_answers_table";
   mysql_query($drop,$con);
   $sql = "CREATE TABLE age_sleep_hours_test_answers_table
   (
   userId int NOT NULL PRIMARY KEY, 
   S_1_2_years_old mediumtext,
   S_3_5_years_old mediumtext,
   S_6_13_years_old mediumtext,
   S_14_17_years_old mediumtext,
   S_18_64_years_old mediumtext,
   S_65_years_and_older mediumtext,
   submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   )";
   mysql_query($sql,$con);


//****************************Create Effect Card Test Table******************************
//Create Table for effect card
   $drop = "DROP TABLE IF EXISTS effect_card_test_table";
   mysql_query($drop,$con);
   $sql = "CREATE TABLE effect_card_test_table
   (
   recordId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
   userId int,
   preSchoolPos longtext,
   preSchoolNeg longtext,
   schoolAgePos longtext,
   schoolAgeNeg longtext,
   adultPos longtext,
   adultNeg longtext,
   submit boolean,
   submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   )";
   mysql_query($sql,$con);

//****************************Create Animal Card Test Table******************************
//Create Table for animal card
$drop = "DROP TABLE IF EXISTS animal_card_test_answers_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE animal_card_test_answers_table
( 
    recordId  int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userId int, 
    sortResult mediumtext,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

//****************************Create School Information Table******************************
$drop = "DROP TABLE IF EXISTS school_info";
mysql_query($drop,$con);
$sql = "CREATE TABLE school_info
(
    schoolId int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    schoolName longtext,
     createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);
$sql = "ALTER TABLE school_info AUTO_INCREMENT=3001";
mysql_query($sql,$con);


//Create 4th Grade Lesson One Table
$sql = "CREATE TABLE fourthGradeLessonOneWhatSleep ( userId INT PRIMARY KEY, response longtext, submitted timestamp )";
mysql_query($sql,$con);


$sql = "CREATE TABLE fourthGradeLessonOneWhySleep ( userId INT PRIMARY KEY, response longtext, submitted timestamp )"; 
mysql_query($sql,$con);

$sql = "CREATE TABLE fourthGradeLessonOneSleepVote ( userId INT PRIMARY KEY, vote INT, submitted timestamp )"; 
mysql_query($sql,$con);

$sql = "CREATE TABLE fourthGradeLessonOnePreInterview ( userId INT PRIMARY KEY AUTO_INCREMENT, interviewSubject varchar(255), interviewSubjectOther varchar(255), subjectResponse INT, submitted timestamp )";
mysql_query($sql,$con);


$sql = "CREATE TABLE fourthGradeLessonOneInterview ( uniqueId INT PRIMARY KEY AUTO_INCREMENT, userId INT NOT NULL, Q1 varchar(255), Q2 varchar(255), Q3 varchar(255), Q3Response longtext, Q4 longtext, Q5 longtext, submitTime timestamp, isSubmitted tinyint(1) )";
mysql_query($sql,$con);


$sql = "CREATE TABLE fourthGradeLessonOneInterviewQuestions ( uniqueId INT PRIMARY KEY AUTO_INCREMENT, userId INT NOT NULL, question longtext, response longtext, interviewId INT )";
mysql_query($sql,$con);

//Create 4th Grade Lesson Three Sleep Story
$drop = "DROP TABLE IF EXISTS fourth_grade_lesson_three_story";
mysql_query($drop,$con);
$sql = "CREATE TABLE fourth_grade_lesson_three_story
(
	 resultRow int NOT NULL PRIMARY KEY AUTO_INCREMENT,  
    userId int NOT NULL, 
    highlightWord longtext,
    storyNotes longtext,
    storyId int,
    highlightWordSpanName longtext,
    submit boolean,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)";
mysql_query($sql,$con);

//Create My Actogram Table
$drop = "DROP TABLE IF EXISTS watch_challenge";
mysql_query($drop,$con);
$drop = "DROP TABLE IF EXISTS my_actogram";
mysql_query($drop,$con);
$sql = "CREATE TABLE my_actogram
   (
   resultRow int NOT NULL PRIMARY KEY AUTO_INCREMENT,  
   userId int NOT NULL, 
   grade int,
   imgSrc longblob,
   myActogramNote longblob,
   startDate longtext,
   startDay longtext,
   endDate longtext,
   endDay longtext,
   bedTime longtext,
   getUpTime longtext,
   timeInBed longtext,
   totalSleepTime longtext,
   timeItTookToFallAsleep longtext,
   averageSleepQuality longtext,
   numberOfAwak longtext,
   awakeTime longtext,
   submit boolean,
   submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

   )";
mysql_query($sql,$con);



// Create waveform table
$drop = "DROP TABLE IF EXISTS watch_challenge_waveform_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE watch_challenge_waveform_table 
(
    userId int NOT NULL PRIMARY KEY, 
    second longtext,
    offWrist longtext,
    activity longtext,
    whiteLight longtext,
    redLight longtext,
    greenLight longtext,
    blueLight longtext,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

// Create watch challenge data table
// This table contains all the watch challenge data of all users. There is a dataHeader field
//   that index to watch challenge header table that contains the data file header extracted during
//   data file import.
// The data format models the Actiwatch data format.
$drop = "DROP TABLE IF EXISTS watch_challenge_data_table";
mysql_query($drop,$con);
$sql = "CREATE TABLE watch_challenge_data_table 
(
    userId int,
    recordNum int,
    epoch int,
    second int,
    date varchar(15),
    time varchar(15),
    offWrist boolean,
    activity int,
    marker int,
    whiteLight float,
    redLight float,
    greenLight float,
    blueLight float,
    awake boolean,
    intervalStatus varchar(10),
    dataHeader int,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);


$drop = "DROP TABLE fifth_grade_lesson_one_worksheet";
mysql_query($drop,$con);
$sql = "CREATE TABLE fifthGradeLessonOneWorksheet
(
    uniqueId INT(11) AUTO_INCREMENT PRIMARY KEY ,
    userId INT(11) NOT NULL ,
    Q1 longtext ,
    Q2 longtext ,
    Q3 longtext ,
    Q4 longtext ,
    Q5 longtext ,
    Q6 longtext ,
    Q7 longtext ,
    Q8 longtext ,
    submitTime timestamp NOT NULL ,
    isSubmitted tinyint(1)
)";
mysql_query($sql,$con);

//G4 Lesson 3
$drop = "DROP TABLE IF EXISTS fourthGradeLessonThreeTableOne";
mysql_query($drop,$con);
$sql = "CREATE TABLE fourthGradeLessonThreeTableOne
(
    recordId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    classId int,
    facilitatorAnswers mediumtext,
    competitorAnswers mediumtext,
    submit boolean,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);


$drop = "DROP TABLE IF EXISTS fourthGradeLessonThreeTableTwo";
mysql_query($drop,$con);
$sql = "CREATE TABLE fourthGradeLessonThreeTableTwo
(
    recordId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    familyRoutines mediumtext,
    activities mediumtext,
    environment mediumtext,
    submit boolean,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

$drop = "DROP TABLE IF EXISTS fourthGradeLessonThreeTableThree";
mysql_query($drop,$con);
$sql = "CREATE TABLE fourthGradeLessonThreeTableThree
(
    recordId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    familyRoutinesHardChange mediumtext,
    familyRoutinesEasyChange mediumtext,
    activitiesHardChange mediumtext,
    activitiesEasyChange mediumtext,
    environmentHardChange mediumtext,
    environmentEasyChange mediumtext,
    submit boolean,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

$drop = "DROP TABLE IF EXISTS sleepEnvironment";
mysql_query($drop,$con);
$sql = "CREATE TABLE sleepEnvironment
(
    recordId int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    userId int,
    pictureId int,
    promoteGoodSleep mediumtext,
    preventGoodSleep mediumtext,
    groupMember mediumtext,
    submit boolean,
    submitTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysql_query($sql,$con);

echo "Done!\n"           
?>
