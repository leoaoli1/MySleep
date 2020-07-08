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
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if ($userType == "teacher"){
   $classId = $_SESSION['classId'];
}
$showToClass = 1;
$showToClass = $_GET['showToClass'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Effect Card</title>
	<style>

	 table{
	     font-size:x-large;
	 }
	</style>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php
                  require_once('partials/nav-links.php');
                  navigationLinkReview($config,$userType);
                   ?>
                   <?php if($showToClass == "0" && $userType == 'teacher' && $config && $config['gradable']){?>
                   <form action="comparingzzz-review-done" method="post">
                   <?php } ?>
                   <div class="row">
                     <div class="col-xs-10 col-md-10">
                       <?php if ($showToClass == "1"): ?>
                         <div id="enoughSleepVotesChart" style="width:100%; min-height: 500px;">
                             <div style="display:flex;justify-content:center;align-items:center;width:100%;">
                                 <div>
                                     <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="margin-left: 1.15em;"></i><br><br><span style="font-size: 24px;">Loading Chart...</span>
                                 </div>
                             </div>

                        </div>
                       <?php endif; ?>
              				<table id="why-sleep-table"  class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table">
              				    <thead>
                    					<tr>
                    					    <?php
                                  $factors = ['Physical Wellness', 'Daytime Activities', 'Room Environment', 'Other'];
                                        if($showToClass == "1"){ ?>
                    						        <th>What has the biggest effect on your sleep?</th>
                    					    <?php }else{ ?>
                    						        <th>Name</th><th>Corner Selected</th><th>Factor 1</th><th>Factor 2</th><th>Factor 3</th>
                    					    <?php
                                        if ($config && $config['gradable']) {
                                          echo '<th data-field="score">Score</th>
                                          <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                                        }
                                    } ?>
                    					</tr>
              				    </thead>
                          <tbody>
                              <?php if($showToClass == "0"){
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        if ($config) {
                                          $result = mysql_query("SELECT * FROM fourthGradeFourCorner WHERE classId='$classId' and submit='1'");

                                        } else {
                                            $resultLink = getUserIdsInClass($classId);
                                            $students = join("','",$resultLink);
                                            $result = mysql_query("SELECT * FROM fourthGradeFourCorner WHERE userId IN ('$students') AND submit IS NOT NULL");
                                        }
                                    } else {
                                        $resultLink = getLinkedUserIds($userId);
                                        $students = join("','",$resultLink);
                                        $result = mysql_query("SELECT * FROM fourthGradeFourCorner WHERE userId IN ('$students') AND submit IS NOT NULL");
                                    }
                                    while($row = mysql_fetch_array($result)){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        if ($config) {
                                            $name = getGroupUserNames($row['contributors']);
                                        } else {
                                            list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                                            $name = $firstname.' '.$lastname;
                                        }
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$factors[$row['corner']]."</td><td>".$row['answer1']."</td><td>".$row['answer2']."</td><td>".$row['answer3']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                    }
                              }
                              mysql_close($con);
                            } ?>


                  				    </tbody>
                  				</table>
                        </div>
                      </div>
                      <?php if($showToClass == "0" && $userType == 'teacher' && $config && $config['gradable']){?>
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
	     <?php include 'partials/footer.php' ?>
	     <?php include 'partials/scripts.php' ?>
      	<script>
         <?php
            $js_array = json_encode($factors);
            echo "var factors = ". $js_array . ";\n";
          ?>
          google.charts.load('current', {
              'packages': ['corechart']
          });
      	 var prerow, schoolrow, adultrow, data;
      	 var showToClass = <?php echo $showToClass; ?>;
         if (showToClass) {
           setInterval(function(){
        	     $.ajax({
        		 type: "post",
        		 url: "fourcorner-process",
        		 dataType: 'json',
        	 success: function (response) {
             data = google.visualization.arrayToDataTable([
                                             ['response', 'Votes', { role: 'style' }]
                                             , ['Physical Wellness', parseInt(response.counts[0]), 'color: #fbc02d']
                                             , ['Daytime Activities', parseInt(response.counts[1]), 'color: #03a9f4']
                                             , ['Room Environment', parseInt(response.counts[2]), 'color: #fbc02d']
                                         ]);

                                         google.charts.setOnLoadCallback(drawVisualization);
        	 // console.log(response.row);
        	 $("#why-sleep-table tbody").empty();
        		     for (var i = 0; i < response.answer1.length; i++) {
        			     prerow = "<tr><td>" + response.answer1[i] + "</td></tr>";
        			     $("#why-sleep-table tbody").append(prerow);
        		     }
        		}

        	     });
        	 }, 2000);
         }

         function drawVisualization() {
             var view = new google.visualization.DataView(data);
             view.setColumns([0, 1,
                    { calc: "stringify",
                      sourceColumn: 1,
                      type: "string",
                      role: "annotation" },
                    2]);

             var options = {
                 title: 'What has the biggest effect on your sleep?',
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
    </body>
</html>
