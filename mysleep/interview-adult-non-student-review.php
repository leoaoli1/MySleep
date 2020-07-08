<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$showClass = 1;

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

if ($userType == "teacher"){
    $classId = $_SESSION['classId'];
}

if ($config) {
  $showClass = $_GET['showToClass'];
  $sql1 = "select lesson.interviewSubject,COUNT(*) as count FROM fourthGradeLessonOneAdultInterview lesson WHERE lesson.classId = '$classId' GROUP BY lesson.interviewSubject ORDER BY count DESC";
  $sql2 = "select lesson.A1,COUNT(*) as count FROM fourthGradeLessonOneAdultInterview lesson WHERE lesson.classId = '$classId' GROUP BY lesson.A1 ORDER BY count DESC";

}else {
  $showClass = $_GET['showClass'];
  $sql1 = "select lesson.interviewSubject,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOneAdultInterview lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY lesson.interviewSubject ORDER BY count DESC";
  $sql2 = "select lesson.A1,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOneAdultInterview lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY lesson.A1 ORDER BY count DESC";

}

$result = mysql_query($sql1) or die("Error in Selecting " . mysql_error($con));
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

$result = mysql_query($sql2) or die("Error in Selecting " . mysql_error($con));
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
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep // Animal Card Review</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
      		<div class="container">
              <?php if ($config){
                require_once('partials/nav-links.php');
                navigationLinkReview($config,$userType);
              } else {
              ?>
      		    <ol class="breadcrumb">
          			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
          			<li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
          			<li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
          			<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=15'">Take Home Activity</a></li>
          			<li class="active">Review: Interviewing an Adult</li>
      		    </ol>
              <?php } ?>

              <?php if ($showClass == '1') {?>
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
              <?php } ?>
              <?php if($showClass == "0" && $userType == 'teacher' && $config && $config['gradable']){?>
              <form action="interview-adult-review-done" method="post">
              <?php } ?>
                <div class="row">
                  <div class=" text-centered" style="margin-bottom:2em;">
                     <table data-toggle="table" data-buttons-class="white btn-just-icon" class="table table-striped">
                         <thead>
                             <tr>
                                 <?php if ($showClass == '0'){ ?>
                                 <th data-field="name" data-sortable="true">Name</th>
                                 <?php } ?>
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
                                 <?php if ($showClass == '0'){
                                   if ($config && $config['gradable']) {
                                     echo '<th data-field="score">Score</th>
                                     <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                                   }
                                 } ?>

                             </tr>
                         </thead>
                         <tbody>
                              <?php
                                  include 'connectdb.php';
                                  require_once 'utilities.php';
                                  if(($userType == 'teacher') || ($userType == 'parent')) {
                                      if($userType == 'teacher') {
                                          $classId = $_SESSION['classId'];
                                          if ($config) {
                                              $result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterview WHERE resultRow IN ( SELECT MAX(resultRow) FROM fourthGradeLessonOneAdultInterview GROUP BY contributors) AND classId='$classId' and submit='1' ORDER BY resultRow");

                                          } else {
                                              $resultLink = getUserIdsInClass($classId);
                                              $students = join("','",$resultLink);
                                              $result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterview WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
                                          }
                                      } else {
                                          $resultLink = getLinkedUserIds($userId);
                                          $students = join("','",$resultLink);
                                          $result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterview WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
                                      }

                                      while($row = mysql_fetch_array($result)){
                                          $records = $records.','.$row['resultRow'];
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
                                            if ($showClass == '0'){
                                              if ($config) {
                                                  $name = getGroupUserNames($row['contributors']);
                                              } else {
                                                  list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                                                  $name = $firstname.' '.$lastname;
                                              }
                                              echo "<td>".$name."</td>";
                                            }

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
                                            <?php
                                            if ($showClass == '0' && $userType == 'teacher' && $config && $config['gradable']) {
                                              echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['resultRow'].'" rows="1">'.$row['score'].'</textarea></td>';
                                              echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['resultRow'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                            }
                                      }
                                  } ?>
                          </tbody>
                      </table>
                      <?php if($showClass == "0" && $userType == 'teacher' && $config && $config['gradable']){?>
                          <input type="text" name="records" value="<?php echo $records; ?>" style="display: none">
                          <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                          <div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                              <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save">Save</button>
                          </div>
                        </form>
                      <?php } ?>


                  </div>
                </div>
		         </div>
	        </div>
	    <?php include 'partials/footer.php' ?>
	   </div>
   </body>
    <?php include 'partials/scripts.php' ?>
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
                    title: 'Number of Votes',
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
                    title: 'Number of Votes',
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
            var chart = new google.visualization.ComboChart(document.getElementById('preInterviewSubjectSleepChart'));
            chart.draw(view, options);
        }
    </script>
</html>
