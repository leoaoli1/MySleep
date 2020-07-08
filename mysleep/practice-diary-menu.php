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
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

$result =mysql_query("SELECT * FROM practiceDiaryNote WHERE userId='$userId' LIMIT 1");
$numRow = mysql_num_rows ($result);
unset($_SESSION['current_work']);
if ($numRow>0) {
	$row = mysql_fetch_array($result);
	if (isset($row['note'])) {
	   $note = $row['note'];
	}
	$_SESSION['current_work'] = $row;
  $resultRow = $row['resultRow'];
 }else {
 	$note = "";
	$resultRow = -1;
 }
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
            navigationLink($config,$userType);
          }
          else {
       ?>
		    <div class="row">
      			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
      			    <ol class="breadcrumb">
            				<li><a class = "exit" data-location = "main-page">Home</a></li>
            				<li><a class = "exit" data-location = "sleep-lesson">Lessons</a></li>
            				<li class="active">Practice Diary Menu</li>
      			    </ol>
      			</div>
		    </div>
        <?php } ?>

		    <!-- <div class="row">
      			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
      			    <h5 class="description">In order to collect data about your sleep and the factors that affect it, you need to record your sleep and what you do and how you feel during the day.
                  Follow your teacher’s direction to learn how to keep diary records. After practicing, you will access your diaries on the MySleep home page.
                  You will enter data in the morning and evening every day for a week. For the Sleep Diary enter the data in the morning after you wake up. For the Activity Diary enter the data in the evening before going to sleep.
                  <br><br>You may also collect sleep data with a digital device. Select “Sleep Watch” for care instructions if you are using sleep watch as well.<br><br>
                </h5>
      			</div>
		    </div> -->
        <!-- Nav tabs -->
        <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none;">
          <li role="presentation" class="active"><a href="#coverpage" aria-controls="datagraphs" role="tab" data-toggle="tab" id = "firstTab">1</a></li>
          <li role="presentation" ><a href="#practicediart" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">2</a></li>
          <li role="presentation" ><a href="#instruction" aria-controls="instruction" role="tab" data-toggle="tab" id = "thirdTab">3</a></li>
          <li role="presentation" ><a href="#note" aria-controls="note" role="tab" data-toggle="tab" id = "noteTab">4</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content" style="">
          <!-- Tab pane 1 -->
          <div role="tabpanel" class="tab-pane active" id="coverpage">
            <div class="row">
          			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
          			    <h5 class="description">In order to collect data about your sleep and the factors that affect it, you need to record your sleep and what you do and how you feel during the day.
                      Follow your teacher’s direction to learn how to keep diary records. After practicing, you will access your diaries on the MySleep home page.
                      You will enter data in the morning and evening every day for a week. For the Sleep Diary enter the data in the morning after you wake up. For the Activity Diary enter the data in the evening before going to sleep.
                      <br><br>You may also collect sleep data with a digital device. Select “Sleep Watch” for care instructions if using a sleep watch.<br><br>
                    </h5>
          			</div>
    		    </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="selection selection-gradorange" onclick="selectPage(1)" style="cursor: pointer;text-align: center;">
                    <label class="selectionFont">Practice Diaries</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3"  style="margin-top: 25px;">
                  <div class="selection selection-gradbb" onclick="selectPage(2)" style="cursor: pointer;text-align: center;">
                      <label class="selectionFont">Sleep Watch</label>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3"  style="margin-top: 25px;">
                  <div class="selection selection-gradop" onclick="selectPage(3)" style="cursor: pointer;text-align: center;">
                      <label class="selectionFont">My Notes</label>
                  </div>
              </div>
            </div>
          </div>

          <!-- Tab pane 2 -->
          <div role="tabpanel" class="tab-pane" id="practicediart">
            <div class="row">
          			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
          			    <h5 class="description">In order to collect data about your sleep and the factors that affect it, you need to record your sleep and what you do and how you feel during the day.
                      Follow your teacher’s direction to learn how to keep diary records. After practicing, you will access your diaries on the MySleep home page.
                      You will enter data in the morning and evening every day for a week. For the Sleep Diary enter the data in the morning after you wake up. For the Activity Diary enter the data in the evening before going to sleep.
                      <br><br>You may also collect sleep data with a digital device. Select “Sleep Watch” for care instructions if using a sleep watch.<br><br>
                    </h5>
          			</div>
    		    </div>
		    <!-- *************** Sleep diary *************** -->
		    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10" style="padding-bottom:1em;">
			    <div class="row">
				<div class="col-md-6">
				    <h3>Sleep Diary</h3>
	          <form role="form" name='sleepDiary' action='practice-sleep-diary' method='post'>
                <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
                <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">
  					    <div class="form-group has-feedback">
    			          <h5>Create New Sleep Diary</h5><br>
                    <select class="selectpicker" name='diaryEntryId' data-dropup-auto = "false" data-width="100%" data-style="btn-simple" onchange="form.submit();">
        						    <option selected disabled>Select a Date...</option>
        						    <?php
            						    $time = get_localtime("Y-m-d");
            						    echo '<option value="'.$time.'">Practice Sleep Diary</option>';
        						    ?>
    		            </select>
                </div>
	          </form>
				    <hr>
				    <h5>View Sleep Diary Data</h5>
				    <form name="input" action="practice-show-diary-data" method="post">
                <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
                <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">
      					<label>Start Date:</label>
      					<select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple"  name="startingDiaryEntryDate" id='startingDiaryEntrySelection'>
      					    <?php echo getDiarySelection('practice_diary_data_table', $userId, $userType, $grade, $classId, false); ?>
      					</select>
      					<label>End Date:</label>
      					<select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple" name="endingDiaryEntryDate" id='endingDiaryEntrySelection'>
      					    <?php echo getDiarySelection('practice_diary_data_table', $userId, $userType, $grade, $classId, true); ?>
      					</select>
      					<!--<div class="entry_element">
      					     <label><input type="checkbox" name='includeUnsubmittedSleepDiaries' id='includeUnsubmittedSleepDiaries' onchange='includeUnsubmittedSleep()'/>&nbsp;Include unsubmitted diaries</label>
      					     </div>-->
      					<button type="submit" class="btn btn-gradbg btn-info btn-block">Show Sleep Diary Data</button>
				    </form>
				    <hr>
				    <?php if($userType == 'teacher'){ ?>
					<a class="btn btn-gradbb btn-info btn-block"  name="showActi" href="practice-diary-teacher-review?diary=sleep&<?php echo $query ?>">Student Sleep Diary Submissions (Not Show Class)</a>
				    <?php } ?>
				</div>


				<div class="col-md-6">
				    <h3>Activity Diary</h3>
				    <form role="form" name='activityDiary' action='practice-activity-diary' method='post'>
                <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
                <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">
	              <div class="form-group has-feedback">
					      <h5>Create New Activity Diary</h5><br>
					      <select class="selectpicker" name='diaryEntryId' data-dropup-auto = "false" data-width="100%" data-style="btn-simple" onchange="form.submit();">
						    <option selected disabled>Select a Date...</option>
						<?php
						$time = get_localtime("Y-m-d");
						echo '<option value="'.$time.'">Practice Activity Diary</option>';
						?>
					    </select>
					</div>
				    </form>
				    <hr>
				    <h5>View Activity Diary Data</h5>
				    <form name="input" action="practice-show-activity-diary-data" method="post">
              <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
              <input type="text" name="lesson" value="<?php echo $lessonNum; ?>" style="display: none">
              <input type="text" name="activity" value="<?php echo $activityNum; ?>" style="display: none">
					<label>Start Date:</label>
					<select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple" name="startingActivityDiaryEntryDate" id='startingActivityDiaryEntrySelection'>
					    <?php echo getDiarySelection('practice_activity_diary_data_table', $userId, $userType, $grade, $classId, false); ?>
					</select>
					<label>End Date:</label>
					<select class="selectpicker" data-dropup-auto = "false" data-width="100%" data-style="btn-simple" name="endingActivityDiaryEntryDate" id='endingActivityDiaryEntrySelection'>
					    <?php echo getDiarySelection('practice_activity_diary_data_table', $userId, $userType, $grade, $classId, true); ?>
					</select>
					<!-- <label><input type="checkbox" name='includeUnsubmittedActivityDiaries' id='includeUnsubmittedActivityDiaries' onchange='includeUnsubmittedActivity()'/>&nbsp;Include unsubmitted diaries</label><br>-->
					<button class='btn btn-gradbg btn-info btn-block' type="submit" name="submit">Show Activity Diary Data</button>
				    </form>
				    <hr>
				    <?php if($userType == 'teacher'){ ?>
					<a class="btn btn-gradbb btn-info btn-block"  name="showActi" href="practice-diary-teacher-review?diary=activity">Student Activity Diary Submissions (Not Show Class)</a>
				    <?php } ?>
				</div>
			    </div>
			</div>
		    </div>
        </div>

        <!-- Tab pane 3 -->
        <div role="tabpanel" class="tab-pane" id="instruction">
          <div class="row">

            <img class="col-md-offset-5 col-md-2" src="images/fourthGrade/actiwatch.png">
              <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10">
                  <h5 class="description">
                    You will be collecting your sleep data using “sleep watch”, an instrument used by sleep scientists to collect data on how people sleep. Follow your teacher’s instructions on how to use and care for the “sleep watch”.

                  </h5>
              </div>
          </div>
          <!-- <h4>
            You will be collecting your sleep data with a “sleep watch”, an instrument used by sleep scientists to collect data on how people sleep. Follow your teacher’s instructions on how to use and care for the “sleep watch”.
          </h4> -->
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div style="padding:10px;">
                <!-- <h3>Sleep Watch Instructions and Care</h3> -->
                <embed src="./images/fourthGrade/watchInstruction.pdf" width="100%" height="650px">
              </div>
              <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectPage(0)" style="cursor: pointer;text-align: center;">
                  <label class="info-title" style="color: #fafafa">Back</label>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab pane 4 -->
        <div role="tabpanel" class="tab-pane" id="note">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div style="padding:10px;">
                <h3>My Notes</h3>
                <form action="practice-diary-note-done" method="post">
                  <textarea name="note" id="note" class="form-control" placeholder="Write the procedure you will follow for data collection" rows="10"><?php echo $note ?></textarea>
    					    <button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
                  <div class="btn btn-roundBold btn-gradbb btn-large btn-block" onclick="selectPage(0)" style="cursor: pointer;text-align: center;">
                      <label class="info-title" style="color: #fafafa">Back</label>
                  </div>
                  <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                </form>
              </div>

            </div>
          </div>
        </div>


		    <?php
		    function getDiarySelection($table, $userId, $userType, $currentGrade, $currentClassId, $selectLast)
		    {
			$output = "";
			include 'connectdb.php';


			$queryCommand = "SELECT * FROM " . $table . " where diaryGrade='$currentGrade' AND userId='$userId' AND timeCompleted IS NOT NULL ORDER BY diaryDate";
			$result = mysql_query($queryCommand);
			$output = getDiarySelectionOptions($result, $selectLast);

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

     function selectPage(page){
       if (page==1) {
         $('#secondTab').trigger('click')
       }
       if (page==2) {
         $('#thirdTab').trigger('click')
       }
       if (page==3) {
         $('#noteTab').trigger('click')
       }
       if (page==0) {
         $('#firstTab').trigger('click')
       }
       window.scrollTo({ top: 100, behavior: 'smooth' });
     }
    </script>
</html>
