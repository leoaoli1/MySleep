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
  $sql = "select lesson.vote,COUNT(*) as count FROM fourthGradeLessonOneSleepVote lesson WHERE lesson.classId = '$classId' GROUP BY vote ORDER BY count DESC";
}else {
  $showClass = $_GET['showClass'];
  $sql = "select lesson.vote,COUNT(*) as count, lesson.userId, class.classId FROM fourthGradeLessonOneSleepVote lesson LEFT JOIN user_table user ON user.userId = lesson.userId left join class_table class on user.userId = class.userId WHERE class.classId = '$classId' GROUP BY vote ORDER BY count DESC";
}

// Set the Page Name
$pageName = "Enough Sleep Voting Results";

// Get the Data
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
    			<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=1'">Activity One</a></li>
    			<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=sleepVote'">Part Three</a></li>
    			<li class="active">Sleep Vote</li>
		    </ol>
        <?php } ?>

<?php if ($showClass == '1') {?>
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
<?php }else{ ?>
      <form action="enough-sleep-vote-review-done" method="post">
          <div class="row">
              <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1 text-centered" style="margin-bottom:2em;">
                     <table data-toggle="table" data-buttons-class="white btn-just-icon"class="table table-striped">
                         <thead>
                             <tr>
                                 <th data-field="firstName" data-sortable="true">Name</th>
                                 <th data-field="response" data-sortable="true">Response</th>
                                 <th data-field="submitted" data-sortable="true">Submitted</th>
                                 <?php if ($config && $config['gradable']) {
                                     echo '<th data-field="score">Score</th>
                                     <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
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
                                          $result = mysql_query("SELECT * FROM fourthGradeLessonOneSleepVote WHERE classId='$classId' and submit='1'");

                                        } else {
                                            $resultLink = getUserIdsInClass($classId);
                                            $students = join("','",$resultLink);
                                            $result = mysql_query("SELECT `vote`, `submitted` FROM fourthGradeLessonOneSleepVote WHERE userId IN ('$students')");
                                        }
                                    } else {
                                        $resultLink = getLinkedUserIds($userId);
                                        $students = join("','",$resultLink);
                                        $result = mysql_query("SELECT `vote`, `submitted` FROM fourthGradeLessonOneSleepVote WHERE userId IN ('$students')");
                                    }

                                    while($row = mysql_fetch_array($result)){
                                        $records = $records.','.$row['userId'];
                                        ?>
                                        <tr>
                                          <?php
                                            $name = ($config)? getGroupUserNames($row['contributors']) : getUserFullNames($row['userId']);
                                            echo "<td>".$name."</td>";
                                          ?>
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
                                              <?php
                                              if ($userType == 'teacher' && $config && $config['gradable']) {
                                                echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                                echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                              }
                                              ?>
                                        </tr>
                                        <?php
                                      }

                                  }
                              ?>
                          </tbody>
                      </table>
              </div>
          </div>
          <?php if($userType == 'teacher' && $config && $config['gradable']){?>
              <input type="text" name="records" value="<?php echo $records; ?>" style="display: none">
              <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
              <div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                  <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save">Save</button>
              </div>
            </form>
          <?php } ?>
<?php } ?>




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
</html>
