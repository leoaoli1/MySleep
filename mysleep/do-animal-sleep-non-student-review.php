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
        <title>MySleep // <?php echo $config['activity_title']; ?></title>
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
                   <?php if ($showToClass == '1') {?>
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
                                                <th>Name</th><th>Do all animals sleep?</th>

                                                  <?php
                                                        if ($config && $config['gradable']) {
                                                          echo '<th data-field="score">Score</th>
                                                          <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                                                        }
                                                    ?>
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
                                                            $result = mysql_query("SELECT * FROM fourthGradeLessonDoAnimalSleep WHERE classId='$classId' and submit='1'");

                                                          } else {
                                                              $resultLink = getUserIdsInClass($classId);
                                                              $students = join("','",$resultLink);
                                                              $result = mysql_query("SELECT * FROM fourthGradeLessonDoAnimalSleep WHERE userId IN ('$students') AND submit IS NOT NULL");
                                                          }
                                                      } else {
                                                          $resultLink = getLinkedUserIds($userId);
                                                          $students = join("','",$resultLink);
                                                          $result = mysql_query("SELECT * FROM fourthGradeLessonDoAnimalSleep WHERE userId IN ('$students') AND submit IS NOT NULL");
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
                                                          echo "<td>".$row['response']."</td>";
                                                          if ($userType == 'teacher' && $config && $config['gradable']) {
                                                            echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                                            echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                                          }
                                                          echo "</tr>";
                                                      }
                                                }
                                                mysql_close($con);
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
	     </div>
	     <?php include 'partials/footer.php' ?>
	     <?php include 'partials/scripts.php' ?>
      	<script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
      	 var prerow, schoolrow, adultrow, data;
      	 var showToClass = <?php echo $showToClass; ?>;
         if (showToClass) {
           setInterval(function(){
        	     $.ajax({
        		 type: "post",
        		 url: "do-animal-sleep-process",
        		 dataType: 'json',
        	 success: function (response) {
             console.log(response);
             data = google.visualization.arrayToDataTable([
                                             ['response', 'Votes', { role: 'style' }]
                                             , ['Yes', response.agrees, 'color: #fbc02d']
                                             , ['No', response.disagree, 'color: #03a9f4']
                                         ]);

                                         google.charts.setOnLoadCallback(drawVisualization);
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
                 title: 'Student Responses to the statement, "Do all animals sleep?"',
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
