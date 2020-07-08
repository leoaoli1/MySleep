<!DOCTYPE html>
<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           James Geiger                                                    #
#           Ao Li                                                           #
#                                                                           #
#                                                                           #
# Filename: WorksheetFifthOneNonStudentReview.php                           #
#                                                                           #
# Purpose:                                                                  #
#                                                                           #
#############################################################################

require_once('utilities.php');
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

if ($userType == "teacher"){
    $classId = $_SESSION['classId'];
}
if($userType == 'teacher'){
    $showClass = $_GET['showToClass'];
    $lessonNum = $_GET['lesson'];
    $activityNum = $_GET['activity'];
    $config = getActivityConfigWithNumbers($lessonNum, $activityNum);
    $query = $_SERVER['QUERY_STRING'];
}
$showToClass = 0;
if(isset($_GET['showToClass'])){
    $showToClass = $_GET['showToClass'];
}

?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Stories Worksheet</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLinkReview($config,$userType);
                  } else { ?>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                        <ol class="breadcrumb">
                            <li><a href="main-page">Home</a></li>
			    <?php if($userType != "parent"){?>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">Activity Two</a></li>
                                <li class="active">Review: Stories Worksheet</li>
				<li class="pull-right"><a href="#" onClick="studentView()">Student View</a></li>
			    <?php }else{?>
				<li><a href="parent-sleep-lesson">Lessons</a></li>
                                <li><a href="parent-lesson-menu?lesson=1">Lesson One</a></li>
				<li><a href="parent-lesson-activity-menu?lesson=1&activity=2">Activitie Two</a></li>
                                <li class="active">Review: Stories Worksheet</li>
			    <?php }?>
                        </ol>
                    </div>
                  <?php } ?>
                    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                        <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                            <li role="presentation" class="active"><a href="#one" aria-controls="datagraphs" role="tab" data-toggle="tab">Story One</a></li>
                            <li role="presentation"><a href="#two" aria-controls="actigraphy" role="tab" data-toggle="tab">Story Two</a></li>
                            <li role="presentation"><a href="#three" aria-controls="sleepWatch" role="tab" data-toggle="tab">Story Three</a></li>
                            <li role="presentation"><a href="#four" aria-controls="sleepDiary" role="tab" data-toggle="tab">Story Four</a></li>
                            <li role="presentation"><a href="#five" aria-controls="activityDiary" role="tab" data-toggle="tab">Story Five</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content" style="margin-top: 2em;">

                          <!-- Tab panes 1 -->
                          <div role="tabpanel" class="tab-pane active" id="one">
                            <a class="btn btn-sm btn-block" download="story_1_answers.csv" href="#" onclick="return ExcellentExport.csv(this, 'table1');">Export story one answers</a>
                            <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped" id='table1'>
                        			<thead>
                                <tr>
                                  <th data-field="firstName"><?php
                                    if ($showToClass != 1){
                                      echo "Group Names";
                                    } else {
                                      echo "Group Id";
                                    } ?>
                                  </th>
                                  <th data-field="happen">What happened in the news story?</th>
                                  <th data-field="factor">Who in the story had enough or not enough sleep?</th>
                                  <th data-field="effect">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>
                                  <?php if ($showToClass != 1 && $config && $config['gradable']): ?>
                                    <th data-field="score">Score</th>
                                    <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                                  <?php endif; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if($config){
                                  $story = 1;
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE classId='$classId' and isSubmitted='1' and story=$story");
                                    } else {
                                      $resultLink = getLinkedUserIds($userId);
                                      $students = join("','",$resultLink);
                                      $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE userId IN ('$students') AND isSubmitted IS NOT NULL and story=$story");
                                    }
                                    $rowIndex = 1;
                                    while($row = mysql_fetch_array($result)){
                                      if($showToClass == "0"){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        $name = getGroupUserNames($row['contributors']);
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                      } else {
                                        // show to class
                                        echo "<tr>";
                                        echo "<td>".$rowIndex++."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        echo "</tr>";
                                      }
                                    }
                                  }
                                } else {
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                  if($userType == 'teacher') {
                                  $resultLink = getUserIdsInClass($classId);
                                  }else {
                                  $resultLink = getLinkedUserIds($userId);
                                  }
                                  $group = 0;
                                  foreach($resultLink as $studentId) {
                                  if($showToClass != 1){
                                  list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                  $result = mysql_query("SELECT story, happen, factor, affect, submitTime FROM fifthGradeLessonOneWorksheet WHERE userId='$studentId' AND isSubmitted = '1'");
                                  echo "<tr>";
                                  echo "<td>".$firstname."</td>";
                                  echo "<td>".$lastname."</td>";
                                  echo "</tr>";
                                  while($row = mysql_fetch_array($result)){

                                  $submitTime = $row['submitTime'];

                                  echo "<tr>";
                                  echo "<td></td>";
                                  echo "<td></td>";
                                  echo "<td>".$row['story']."</td>";
                                  echo "<td>".$row['happen']."</td>";
                                  echo "<td>".$row['factor']."</td>";
                                  echo "<td>".$row['affect']."</td>";
                                  echo "<td>".$submitTime."</td>";
                                  echo "</tr>";

                                  }
                                  }else{
                                  $result = mysql_query("SELECT story, happen, factor, affect, submitTime FROM fifthGradeLessonOneWorksheet WHERE userId='$studentId' AND isSubmitted = '1' order by uniqueId desc limit 1");
                                  while($row = mysql_fetch_array($result)){
                                  $submitTime = $row['submitTime'];
                                  $group += 1;
                                  echo "<tr>";
                                  echo "<td class='col-md-1 col-sm-1'>".$row['story']."</td>";
                                  echo "<td class='col-md-3 col-sm-3'>".$row['happen']."</td>";
                                  echo "<td class='col-md-3 col-sm-3'>".$row['factor']."</td>";
                                  echo "<td class='col-md-3 col-sm-3'>".$row['affect']."</td>";
                                  echo "</tr>";
                                  }
                                  }

                                  }
                                  }
                                }
                                mysql_close($con);
                                ?>
                              </tbody>
                            </table>
                          </div>

                          <!-- Tab panes 2 -->
                          <div role="tabpanel" class="tab-pane" id="two">
                            <a class="btn btn-sm btn-block" download="story_2_answers.csv" href="#" onclick="return ExcellentExport.csv(this, 'table2');">Export story two answers</a>
                            <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped" id='table2'>
                        			<thead>
                                <tr>
                                  <th data-field="firstName"><?php
                                    if ($showToClass != 1){
                                      echo "Group Names";
                                    } else {
                                      echo "Group Id";
                                    } ?>
                                  </th>
                                  <th data-field="happen">What happened in the news story?</th>
                                  <th data-field="factor">Who in the story had enough or not enough sleep?</th>
                                  <th data-field="effect">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>
                                  <?php if ($showToClass != 1 && $config && $config['gradable']): ?>
                                    <th data-field="score">Score</th>
                                    <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                                  <?php endif; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if($config){
                                  $story = 2;
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE classId='$classId' and isSubmitted='1' and story=$story");
                                    } else {
                                      $resultLink = getLinkedUserIds($userId);
                                      $students = join("','",$resultLink);
                                      $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE userId IN ('$students') AND isSubmitted IS NOT NULL and story=$story");
                                    }
                                    $rowIndex = 1;
                                    while($row = mysql_fetch_array($result)){
                                      if($showToClass == "0"){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        $name = getGroupUserNames($row['contributors']);
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                      } else {
                                        // show to class
                                        echo "<tr>";
                                        echo "<td>".$rowIndex++."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        echo "</tr>";
                                      }
                                    }
                                  }
                                }
                                mysql_close($con);
                                ?>
                              </tbody>
                            </table>
                          </div>

                          <!-- Tab panes 3 -->
                          <div role="tabpanel" class="tab-pane" id="three">
                            <a class="btn btn-sm btn-block" download="story_3_answers.csv" href="#" onclick="return ExcellentExport.csv(this, 'table3');">Export story three answers</a>
                            <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped" id='table3'>
                        			<thead>
                                <tr>
                                  <th data-field="firstName"><?php
                                    if ($showToClass != 1){
                                      echo "Group Names";
                                    } else {
                                      echo "Group Id";
                                    } ?>
                                  </th>
                                  <th data-field="happen">What happened in the news story?</th>
                                  <th data-field="factor">Who in the story had enough or not enough sleep?</th>
                                  <th data-field="effect">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>
                                  <?php if ($showToClass != 1 && $config && $config['gradable']): ?>
                                    <th data-field="score">Score</th>
                                    <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                                  <?php endif; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if($config){
                                  $story = 3;
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE classId='$classId' and isSubmitted='1' and story=$story");
                                    } else {
                                      $resultLink = getLinkedUserIds($userId);
                                      $students = join("','",$resultLink);
                                      $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE userId IN ('$students') AND isSubmitted IS NOT NULL and story=$story");
                                    }
                                    $rowIndex = 1;
                                    while($row = mysql_fetch_array($result)){
                                      if($showToClass == "0"){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        $name = getGroupUserNames($row['contributors']);
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                      } else {
                                        // show to class
                                        echo "<tr>";
                                        echo "<td>".$rowIndex++."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        echo "</tr>";
                                      }
                                    }
                                  }
                                }
                                mysql_close($con);
                                ?>
                              </tbody>
                            </table>
                          </div>

                          <!-- Tab panes 4 -->
                          <div role="tabpanel" class="tab-pane" id="four">
                            <a class="btn btn-sm btn-block" download="story_4_answers.csv" href="#" onclick="return ExcellentExport.csv(this, 'table4');">Export story four answers</a>
                            <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped" id='table4'>
                        			<thead>
                                <tr>
                                  <th data-field="firstName"><?php
                                    if ($showToClass != 1){
                                      echo "Group Names";
                                    } else {
                                      echo "Group Id";
                                    } ?>
                                  </th>
                                  <th data-field="happen">What happened in the news story?</th>
                                  <th data-field="factor">Who in the story had enough or not enough sleep?</th>
                                  <th data-field="effect">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>
                                  <?php if ($showToClass != 1 && $config && $config['gradable']): ?>
                                    <th data-field="score">Score</th>
                                    <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                                  <?php endif; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if($config){
                                  $story = 4;
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE classId='$classId' and isSubmitted='1' and story=$story");
                                    } else {
                                      $resultLink = getLinkedUserIds($userId);
                                      $students = join("','",$resultLink);
                                      $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE userId IN ('$students') AND isSubmitted IS NOT NULL and story=$story");
                                    }
                                    $rowIndex = 1;
                                    while($row = mysql_fetch_array($result)){
                                      if($showToClass == "0"){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        $name = getGroupUserNames($row['contributors']);
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                      } else {
                                        // show to class
                                        echo "<tr>";
                                        echo "<td>".$rowIndex++."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        echo "</tr>";
                                      }
                                    }
                                  }
                                }
                                mysql_close($con);
                                ?>
                              </tbody>
                            </table>
                          </div>

                          <!-- Tab panes 5 -->
                          <div role="tabpanel" class="tab-pane" id="five">
                            <a class="btn btn-sm btn-block" download="story_5_answers.csv" href="#" onclick="return ExcellentExport.csv(this, 'table5');">Export story five answers</a>
                            <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped" id='table5'>
                        			<thead>
                                <tr>
                                  <th data-field="firstName"><?php
                                    if ($showToClass != 1){
                                      echo "Group Names";
                                    } else {
                                      echo "Group Id";
                                    } ?>
                                  </th>
                                  <th data-field="happen">What happened in the news story?</th>
                                  <th data-field="factor">Who in the story had enough or not enough sleep?</th>
                                  <th data-field="effect">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>
                                  <?php if ($showToClass != 1 && $config && $config['gradable']): ?>
                                    <th data-field="score">Score</th>
                                    <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                                  <?php endif; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if($config){
                                  $story = 5;
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE classId='$classId' and isSubmitted='1' and story=$story");
                                    } else {
                                      $resultLink = getLinkedUserIds($userId);
                                      $students = join("','",$resultLink);
                                      $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE userId IN ('$students') AND isSubmitted IS NOT NULL and story=$story");
                                    }
                                    $rowIndex = 1;
                                    while($row = mysql_fetch_array($result)){
                                      if($showToClass == "0"){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        $name = getGroupUserNames($row['contributors']);
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                      } else {
                                        // show to class
                                        echo "<tr>";
                                        echo "<td>".$rowIndex++."</td>";
                                        echo "<td>".$row['happen']."</td><td>".$row['factor']."</td><td>".$row['affect']."</td>";
                                        echo "</tr>";
                                      }
                                    }
                                  }
                                }
                                mysql_close($con);
                                ?>
                              </tbody>
                            </table>
                          </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
    </script>
</html>
