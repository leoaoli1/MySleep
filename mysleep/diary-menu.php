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
   require_once('connectdb.php');

   checkauth();
   $userId= $_SESSION['userId'];
   $firstName = $_SESSION['firstName'];
   $lastName = $_SESSION['lastName'];
   $userType = $_SESSION['userType'];
   if($userId==""){
   header("Location: login");
   exit;
   }

   if($userType == 'student'){
   $grade = getGrade($userId);
   }elseif($userType == 'teacher'){
   $classId = $_SESSION['classId'];
   $grade = getClassGrade($classId);
   }

   $lessonNum = $_GET['lesson'];
   $activityNum = $_GET['activity'];
   $parentPage = $_GET['parent'];
   $additional = $_GET['additional'];
   $config = getActivityConfigWithNumbers($lessonNum, $activityNum);
   if (!$config['activity_title']||$lessonNum==0) {
     $config['activity_title']='Diary Menu';
   }
   $query = $_SERVER['QUERY_STRING'];
   mysql_close($con);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

  <head>
    <?php require 'partials/header.php' ?>
    <title>MySleep // Sleep Diary Menu</title>
  </head>

  <body>
    <?php require 'partials/nav.php' ?>
    <div class="wrapper">
      <div class="main main-raised">
        <div class="container">
          <?php
              if ($config) {
                require_once('partials/nav-links.php');
                navigationLink($config,$userType,array('parent' => $parentPage, 'additional' => $additional ));
              }
              else {
           ?>
            <div class="row">
              <div class="col-xs-offset-1 col-xs-10 col-sm-10">
              		<ol class="breadcrumb">
              		    <li><a class = "exit" data-location = "main-page">Home</a></li>
              		    <?php if($userType != "parent"){ ?>
              			<li><a class = "exit" data-location = "sleep-lesson">Lessons</a></li>
              			<li><a class = "exit" data-location = <?php if($grade == 4){echo '"fourth-grade-lesson-menu?lesson=1">Lesson One';}elseif($grade == 5){echo '"fifth-grade-lesson-menu?lesson=2">Lesson Two';}?></a></li>
              		    <?php }else{ ?>
              			<li><a class = "exit" data-location ='parent-sleep-lesson';">Lessons</a></li>
              			<li><a class = "exit" data-location ='parent-lesson-menu?lesson=2';">Lesson Two</a></li>
              		    <?php } ?>
                      <li class="active">Diary Menu</li>
                </ol>
              </div>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
              <h4 class="description"></h4>
            </div>
	  </div>

	  <!-- *************** Sleep diary *************** -->
	  <div class="row">
            <div class="col-xs-offset-1 col-xs-10 col-sm-10" style="padding-bottom:1em;">
              <div class="row">
		<div class="col-md-6">
		    <h3>Sleep Diary</h3>
		    <?php if($userType == 'student'){ ?>
  		  <form role="form" name='sleepDiary' action='sleep-diary' method='post'>

              <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
              <input type="text" name="parent" value="<?php echo $parentPage; ?>" style="display: none">
              <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
              <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">

  		        <div class="form-group has-feedback">
                <h5>Create New Sleep Diary</h5><br>
                <select class="selectpicker" name='diaryEntryId' data-dropup-auto = "false" data-width="100%" data-style="btn-simple" onchange="form.submit();">
    			      <option selected disabled>Select a Date...</option>
          			<?php
          			   if ($userType == 'student')
          			   {
                       include "connectdb.php";
                       list($startingDiaryEntryDate, $endingDiaryEntryDate) = getDiaryDateSelection($userId, $grade);
                       $result = mysql_query("SELECT * FROM diary_data_table where userId='$userId' AND diaryDate >='$startingDiaryEntryDate' And diaryDate <= '$endingDiaryEntryDate' AND timeCompleted IS NULL ORDER BY diaryDate DESC");
                       while ($row = mysql_fetch_array($result)){
                         echo '<option value="' .$row['diaryId'] .'">' . date('l, F d, Y', strtotime($row['diaryDate'])) .'</option>';
                       }
                       mysql_close($con);
          			   }?>
                </select>
              </div>
  		  </form>
		    <?php } ?>
		    <hr>
		    <h5>View Sleep Diary Data</h5>
		    <form name="input" action="show-diary-data" method="post">
          <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
          <input type="text" name="parent" value="<?php echo $parentPage; ?>" style="display: none">
          <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
          <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">

		    <label>Start Date:</label>
		    <select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple"  name="startingDiaryEntryDate" id='startingDiaryEntrySelection'>
			<?php echo getDiarySelection('diary_data_table', $userId, $userType, $grade, $classId, false); ?>
		    </select>
		    <label>End Date:</label>
		    <select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple" name="endingDiaryEntryDate" id='endingDiaryEntrySelection'>
			<?php echo getDiarySelection('diary_data_table', $userId, $userType, $grade, $classId, true); ?>
		    </select>
		    <!--<div class="entry_element">
			 <label><input type="checkbox" name='includeUnsubmittedSleepDiaries' id='includeUnsubmittedSleepDiaries' onchange='includeUnsubmittedSleep()'/>&nbsp;Include unsubmitted diaries</label>
			 </div>-->
		    <button type="submit" class="btn btn-gradbg btn-block">Show Sleep Diary Data</button>
		  </form>
		  <?php if($userType == 'teacher'){ ?>
		      <a class="btn btn-gradbb btn-large btn-block"  name="sleep" href="diary-submission?<?php echo "parent=".$parentPage."&lesson=".$lessonNum."&activity=".$activityNum; ?>">Sleep Diary Submission Table</a>
		  <?php } ?>
		</div>


		<div class="col-md-6">
		    <h3>Activity Diary</h3>
		    <?php if($userType == 'student'){ ?>
      			<form role="form" name='activityDiary' action='activity-diary' method='post'>
                  <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                  <input type="text" name="parent" value="<?php echo $parentPage; ?>" style="display: none">
                  <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
                  <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">
      			    <div class="form-group has-feedback">
      				<h5>Create New Activity Diary</h5><br>
      				<select class="selectpicker" name='diaryEntryId' data-dropup-auto = "false" data-width="100%" data-style="btn-simple" onchange="form.submit();">
      				    <option selected disabled>Select a Date...</option>
      				    <?php
      				    if ($userType == 'student')
      				    {
      					include 'connectdb.php';
      					list($startingActivityEntryDate, $endingActivityEntryDate) = getActivityDateSelection($userId, $grade);
      					$result = mysql_query("SELECT * FROM activity_diary_data_table where userId='$userId' AND diaryDate >='$startingActivityEntryDate' And diaryDate <= '$endingActivityEntryDate' AND timeCompleted IS NULL ORDER BY diaryDate DESC");
      					while ($row = mysql_fetch_array($result)){
      					    echo '<option  value="' .$row['diaryId'] .'">' . date('l, F j, Y', strtotime($row['diaryDate']))  .'</option>';
      					}
      					mysql_close($con);
      				    }?>
      				</select>
      			    </div>
      			</form>
		    <?php } ?>
		    <hr>
		    <h5>View Activity Diary Data</h5>
		    <form name="input" action="show-activity-diary-data" method="post">
              <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
              <input type="text" name="parent" value="<?php echo $parentPage; ?>" style="display: none">
              <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
              <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">
        			<label>Start Date:</label>
        			<select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple" name="startingActivityDiaryEntryDate" id='startingActivityDiaryEntrySelection'>
        			    <?php echo getDiarySelection('activity_diary_data_table', $userId, $userType, $grade, $classId, false); ?>
        			</select>
        			<label>End Date:</label>
        			<select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple" name="endingActivityDiaryEntryDate" id='endingActivityDiaryEntrySelection'>
        			    <?php echo getDiarySelection('activity_diary_data_table', $userId, $userType, $grade, $classId, true); ?>
      		    </select>
        		    <!-- <label><input type="checkbox" name='includeUnsubmittedActivityDiaries' id='includeUnsubmittedActivityDiaries' onchange='includeUnsubmittedActivity()'/>&nbsp;Include unsubmitted diaries</label><br>-->
      		    <button class='btn btn-gradbg btn-block' type="submit" name="submit">Show Activity Diary Data</button>
		    </form>
		    <?php if($userType == 'teacher'){ ?>
			<a class="btn btn-gradbb btn-large btn-block"  name="sleep" href="activity-submission?<?php echo "parent=".$parentPage."&lesson=".$lessonNum."&activity=".$activityNum; ?>">Activity Diary Submission Table</a>
		    <?php } ?>
		</div>
              </div>
            </div>
          </div>



	  <?php
	  function getDiarySelection($table, $userId, $userType, $currentGrade, $currentClassId, $selectLast)
	  {
	      $output = "";
	      include 'connectdb.php';

	      if ($userType == 'student') {
		  $queryCommand = "SELECT * FROM " . $table . " where diaryGrade='$currentGrade' AND userId='$userId' AND timeCompleted IS NOT NULL ORDER BY diaryDate";
		  $result = mysql_query($queryCommand);
		  $output = getDiarySelectionOptions($result, $selectLast);
	      }
	      else if (($userType == 'teacher') || ($userType == 'parent')) {
		  $targetUserIds = getUserIdsInClass($currentClassId);
		  $linkedUserOptions = "";
		  foreach ($targetUserIds as $user) {
		      $linkedUserOptions .= " OR userId=" . $user;
		  }

		  $queryCommand = "SELECT DISTINCT diaryDate FROM " . $table . " WHERE diaryGrade='$currentGrade' AND timeCompleted IS NOT NULL AND";
		  $queryCommand .= "(userId=0" . $linkedUserOptions . ") ORDER BY diaryDate";
		  $result = mysql_query($queryCommand);
		  $output = getDiarySelectionOptions($result, $selectLast);
	      }
	      else {
		  $queryCommand = "SELECT DISTINCT diaryDate FROM " . $table . " WHERE timeCompleted IS NOT NULL ORDER BY diaryDate";
		  $result = mysql_query($queryCommand);
		  $output = getDiarySelectionOptions($result, $selectLast);
	      }
	      mysql_close($con);
	      return $output;
	  }

	  function getDiarySelectionOptions($result, $selectLast)
	  {
	      $output = "";
	      $nDiary = count($result);
	      while ($row = mysql_fetch_array($result))
	      {
		  $count--;
		  //$output .= '<option  value=' . $row['diaryId'] . ' ';
		  $output .= '<option  value=' . $row['diaryDate'] . ' ';
		  if ($selectLast && $count==0)
		      $output .= 'selected>';
		  else
		      $output .= '>';
		  //$output .= $row['diaryDate'] . date(' D', strtotime($row['diaryDate']));
		  $output .= date('D m-d-y', strtotime($row['diaryDate']));
		  $output .= '</option>';
	      }
	      return $output;
	  }

	  function getDiaryDateSelection($userId, $grade)
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
	      /*debugToConsole("ID", $userIdIn);
		 echo mysql_error();
		 debugToConsole("Flag", mysql_num_rows($row));
		 debugToConsole("StartDate", $startDate);*/
	      return array($startDate, $endDate);
	  }

	  function getActivityDateSelection($userId, $grade)
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
	  ?>


        </div>
      </div>
      <?php include 'partials/footer.php' ?>
    </div>

  </body>
  <?php include 'partials/scripts.php' ?>
  <script>
    //document.getElementById('includeUnsubmittedActivityDiaries').checked = false;
    //enableElement(document.getElementById('activityDiaryRange'), true);
    //document.getElementById('includeUnsubmittedSleepDiaries').checked = false;
    //enableElement(document.getElementById('sleepDiaryRange'), true);

    function includeUnsubmittedSleep()
    {
    var section = document.getElementById('sleepDiaryRange');
    toggleElementEnableDisable(section);
    // if (document.getElementById('includeUnsubmittedSleepDiaries').checked)
    // {
    // document.getElementById('startingDiaryEntrySelection').disabled = true;
    // document.getElementById('endingDiaryEntrySelection').disabled = true;
    // }
    // else
    // {
    // document.getElementById('startingDiaryEntrySelection').disabled = false;
    // document.getElementById('endingDiaryEntrySelection').disabled = false;
    // }
    }

    function includeUnsubmittedActivity()
    {
    var section = document.getElementById('activityDiaryRange');
    toggleElementEnableDisable(section);
    // if (document.getElementById('includeUnsubmittedActivityDiaries').checked)
    // {
    // document.getElementById('startingActivityDiaryEntrySelection').disabled = true;
    // document.getElementById('endingActivityDiaryEntrySelection').disabled = true;
    // }
    // else
    // {
    // document.getElementById('startingActivityDiaryEntrySelection').disabled = false;
    // document.getElementById('endingActivityDiaryEntrySelection').disabled = false;
    // }
    }

    // Function to cursively toggle to enable/disable elements within a section ('div', for example)
    function toggleElementEnableDisable(el) {
    try {
    el.disabled = el.disabled ? false : true;   // Toggle state
    } catch (e) {}
    if (el.childNodes && el.childNodes.length > 0) {
    for (var x = 0; x < el.childNodes.length; x++) {
			toggleElementEnableDisable(el.childNodes[x]);
			}
			}
			}

			// Function to cursively enable/disable elements within a section ('div', for example)
			function enableElement(el, state) {
			try {
			el.disabled = !state;
			} catch (e) {}
			if (el.childNodes && el.childNodes.length > 0) {
      for (var x = 0; x < el.childNodes.length; x++) {
			  enableElement(el.childNodes[x], state);
			  }
			  }
			  }

			  </script>
</html>
