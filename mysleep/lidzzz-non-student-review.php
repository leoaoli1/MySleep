<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
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
  $sql = "select AVG(sleepiness1) as s1, AVG(sleepiness2) as s2, AVG(sleepiness3) as s3, AVG(sleepiness4) as s4, AVG(sleepiness5) as s5, AVG(alertness1) as a1, AVG(alertness2) as a2, AVG(alertness3) as a3, AVG(alertness4) as a4, AVG(alertness5) as a5 FROM lidzzz WHERE classId = '$classId' ";
}else {
  $showClass = $_GET['showClass'];
  $sql = "select * FROM lidzzz WHERE classId = '$classId' ";
}

// Set the Page Name
$pageName = "Lidzzz";

// Get the Data
$result = mysql_query($sql) or die("Error in Selecting " . mysql_error($con));
$numRow = mysql_num_rows ($result);

if ($numRow>0) {
  $row = mysql_fetch_array($result);
  $s1 = $row['s1'];
  $s2 = $row['s2'];
  $s3 = $row['s3'];
  $s4 = $row['s4'];
  $s5 = $row['s5'];
  $a1 = $row['a1'];
  $a2 = $row['a2'];
  $a3 = $row['a3'];
  $a4 = $row['a4'];
  $a5 = $row['a5'];
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
      }
      ?>

<?php if ($showClass == '1') {?>
  <div class="col-xs-offset-1 col-xs-10 col-md-offset-1 col-md-10 ">
    <!-- Nav tabs -->
    <!-- <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
      <li role="presentation" class="active"><a href="#datagraphs" aria-controls="datagraphs" role="tab" data-toggle="tab">Class Average</a></li>
      <li role="presentation" ><a href="#diarygraphs" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">Expected Result</a></li>
    </ul> -->
    <!-- Tab panes -->
    <div class="tab-content" style="margin-top: 2em;margin-bottom: 1.5em;">
      <!-- Tab panes -->
      <div role="tabpanel" class="tab-pane active" id="datagraphs">
        <div class="row">
          <div class="row" style="margin-top:2em;">
            <div class="col-xs-12 col-md-12">
              <div id="chart-slide-a">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Tab panes -->
      <div role="tabpanel" class="tab-pane" id="diarygraphs">
        <div class="row">
          <div class="row" style="margin-top:2em;">
            <div class="col-xs-12 col-md-12">
              <div id="chart-slide-c">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
<?php }else{ ?>
      <form action="enough-sleep-vote-review-done" method="post">
          <div class="row">
              <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1 text-centered" style="margin-bottom:2em;">
                <div id="chart-slide-a" style="display:none">
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
                                            if ($config) {
                                                $name = getGroupUserNames($row['contributors']);
                                            } else {
                                                list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                                                $name = $firstname.' '.$lastname;
                                            }
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
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
    <script>

         var chartXAxis = {
             categories: ["Before School", "Morning Classes", "Aternoon Classes", "Ater School","Before Bed Time"],
             labels: {
                style: {
                   fontSize: "15px"
                }
            }
         };
         var YAxis = {
             title: {
                 text: 'Averaged Rating',
             },
             min: 0,
             max: 5,
             tickPositions: [0, 1, 2, 3, 4, 5],
             labels: {
                style: {
                   fontSize: "15px"
                }
            }
         };

         var chartPlotOptions = {
             column: {
               pointPadding: 0.2,
                borderWidth: 0
             },
             line: {
                 cursor: 'ns-resize'
             }
         };

         var chartTooltip = {
             animation: false,
             valueDecimals: 0,
             split: false,
             formatter: function() {
               var result = this.y;
               if (this.y == 0.1) {
                 result = 0;
               }
               return result;
             },
          };
         var s1o = <?php echo $s1; ?>;
         var s2o = <?php echo $s2; ?>;
         var s3o = <?php echo $s3; ?>;
         var s4o = <?php echo $s4; ?>;
         var s5o = <?php echo $s5; ?>;

         var a1o = <?php echo $a1; ?>;
         var a2o = <?php echo $a2; ?>;
         var a3o = <?php echo $a3; ?>;
         var a4o = <?php echo $a4; ?>;
         var a5o = <?php echo $a5; ?>;

        var chartSlideA = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-slide-a',
                        height: 600,
                        animation: false,
                    },

                    title: {
                        text: 'Class Average Sleepiness & Expected Value'
                    },

                    xAxis: chartXAxis,
                    yAxis: YAxis,
                    plotOptions: chartPlotOptions,
                    tooltip: chartTooltip,

                    series: [{
                        name: "Sleepiness",
                        data: [s1o,s2o,s3o,s4o,s5o],
                        draggableY: false,
                        type: 'column',
                    },
                    {
                        name: "Expected",
                        data: [0.2,0.2,1.8,0.2,5],
                        draggableY: false,
                        type: 'column',
                    }]

              });


      var chartSlideC = new Highcharts.Chart({
                chart: {
                    renderTo: 'chart-slide-c',
                    height: 600,
                },
                title: {
                    text: 'Sleepiness and Alertness Comparison',
                },
                xAxis: chartXAxis,
                yAxis: YAxis,
                plotOptions: chartPlotOptions,
                tooltip: chartTooltip,
                series: [{
                    name: "sleepiness",
                    data: [1,2,3,4,5],
                    draggableY: false,
                },{
                    name: "alertness",
                    data: [5,4,3,2,1],
                    draggableY: false,
                }]
        });



    </script>
</html>
