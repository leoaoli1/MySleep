<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#
# Author:   Ao Li 
#           James Geiger <jamesgeiger@email.arizona.edu>
#

require_once('utilities.php');
require_once('utilities-actogram.php');
require_once('sleep-diary-data-table.php');
require_once('activity-diary-data-table.php');
checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$classId = $_SESSION['classId'];
$schoolId = $_SESSION['schoolId'];

# check the demo mode for Science-City-2018
list($schoolId, $classId, $demoMode) = getDemoMode();
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review Actigraph</title>
    </head>

    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page';">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
                            <?php if($grade==4){?>
                    				    <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                                <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=2'">Activity Two</a></li>
                                <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=2&name=sleepdata'">Part 2</a></li>
                    				<?php }else{?>
                    				    <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=2'">Lesson Two</a></li>
                    				<?php }?>
                                <li class="active">Review Students' Actigraph</li>
                            </ol>
                        </div>
                    </div>

		    <form>
			<div class="col-xs-offset-1 col-xs-6 col-md-offset-1 col-md-6 ">
			    <select class="input-lg" name='studentId' id="studentId">
				<option value='null' disabled selected>Please choose a student</option>
				<?php
				include 'connectdb.php';
				$targetUserIds = getUserIdsInClass($classId);
				showUserOptionList($targetUserIds,$demoMode);
				mysql_close($con);
				?>
			    </select>
			</div>
		   </form>

                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                            <div style="padding-top: 1cm">
                                <h3 class="text-center">Actigraph</h3>
                                <img class="img-responsive" id="actigraph">
			    </div>
			    <div style="padding-top: 1cm">
                                <h3 class="text-center">Daily Statistics</h3>
                                <div class="table-responsive" style="margin-top: 1.5em;">
                                    <table class="table">
					<thead>
                                            <tr>
						<th>End Date_Sleep_Watch</th>
						<th>Bed Time_Sleep_Watch</th>
						<th>Wake Up Time_Sleep_Watch</th>
						<th>Time in Bed (hours:min)_Sleep_Watch</th>
						<th>Total Sleep Time (hours:min)_Sleep_Watch</th>
						<th>Time It Took to Fall Asleep (min)_Sleep_Watch</th>
						<th>Average Sleep Quality (precent)_Sleep_Watch</th>
						<th>#Awak._Sleep_Watch</th>
						<th>Awak. Time(min)_Sleep_Watch</th>
                                            </tr>
					</thead>
					<tbody id="dailyBody">

					</tbody>
                                    </table>
				</div>
			    </div>
			    <div style="padding-top: 1cm">
				<h3 class="text-center">Actigraphy Summary Statistic</h3>
                                <div class="table-responsive" style="margin-top: 1.5em;">
				    <table class="table">
					<thead>
					    <tr>
						<th>Earliest Bed Time_Sleep_Watch</th>
						<th>Latest Bed Time_Sleep_Watch</th>
						<th>Average Bed Time_Sleep_Watch</th>
						<th>Earliest Wake Time_Sleep_Watch</th>
						<th>Latest Wake Time_Sleep_Watch</th>
						<th>Average Wake Time_Sleep_Watch</th>
						<th>Shortest Total Sleep Time_Sleep_Watch (hours:Min)</th>
						<th>Longest Total Sleep Time_Sleep_Watch (hours:Min)</th>
						<th>Average Total Sleep Time_Sleep_Watch (hours:Min)</th>
						<th>Average Time in Bed_Sleep_Watch (hours)</th>
						<th>Average Time it Took to Fall Asleep_Sleep_Watch (min)</th>
						<th>Average Sleep Quality_Sleep_Watch (percent)</th>
						<th>Average #Awak._Sleep_Watch</th>
						<th>Average Average Awake Time_Sleep_Watch</th>
					    </tr>
					</thead>
					<tbody>
					    <tr id="summaryTr">

					    </tr>
					</tbody>
				    </table>
                                </div>

          <h3 class="text-center">Sleep Diary Daily Statistics</h3>
          <div class="table-responsive" style="margin-top: 1.5em;">
                <table class="table">
                        <thead>
                          <tr class="success">
                            <?php
                            echo   "<th>Diary Date</th>";
                            displayCommonHeaderSleep($grade);
                            ?>
                          </tr>
                       </thead>
                       <tbody id="sleepCommonBody">
            					 </tbody>
                 </table>
            </div>
            <h3 class="text-center">Sleep Diary Summary Statistics</h3>
            <div class="table-responsive" style="margin-top: 1.5em;">
	                <table class="table">
                          <thead>
                            <tr class="success">
                              <?php
                              sleepStatsSummaryHeader($grade);
                              ?>
                            </tr>
                         </thead>
              					<tbody>
              					    <tr id="sleepStatsBody">
              					    </tr>
              					</tbody>
                   </table>
                   <?php
         					showSleepLegends($grade);
         					?>
              </div>


              <h3 class="text-center">Activity Diary Daily Statistics</h3>
              <div class="table-responsive" style="margin-top: 1.5em;">
                    <table class="table">
                            <thead>
                              <tr class="info">
                                <?php
                                  echo   "<th>Diary Date</th>";
                              	  displayCommonHeaderActivity($grade);
                                ?>
                              </tr>
                           </thead>
                           <tbody id="activityCommonBody">
                					 </tbody>
                     </table>
                </div>
                <h3 class="text-center">Activity Diary Summary Statistics</h3>
                <div class="table-responsive" style="margin-top: 1.5em;">
    	                <table class="table">
                              <thead>
                                <tr class="info">
                                  <?php
                                  activityStatsSummaryHeader($grade);
                                  ?>
                                </tr>
                             </thead>
                  					<tbody>
                  					    <tr id="activityStatsBody">
                  					    </tr>
                  					</tbody>
                       </table>
                       <?php
             					showActivityLegends($grade);
             					?>
                  </div>
			    </div>


				<?php
				mysql_close($con);
				?>
                        </div>
                    </div>
                </div>
            </div>
        <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     $('#studentId').change( function (e) {

    	 e.preventDefault();

    	 $.ajax({
    	     type: 'post',
    	     url: 'actigraph-content',
    	     data: {id: $('#studentId').val()},
    	     dataType: 'json',
    	     success: function (response) {
    		 //console.log(response.summaryTable);
    		 $("#actigraph").attr("src", response.imgSrc);
    		 $("#dailyBody").html(response.dailyTable);
    		 $("#summaryTr").html(response.summaryTable);
    	     }
    	 });

       $.ajax({
    	     type: 'post',
    	     url: 'diary-content',
    	     data: {id: $('#studentId').val()},
    	     dataType: 'json',
    	     success: function (response) {
    		       // console.log(response.activityStatsTable);
    		 $("#sleepCommonBody").html(response.sleepDiaryTable);
    		 $("#sleepStatsBody").html(response.sleepStatsTable);
         $("#activityCommonBody").html(response.activityDiaryTable);
         $("#activityStatsBody").html(response.activityStatsTable);

    	     }
    	 });

     });
    </script>
</html>
<?php
function sleepStatsSummaryHeader($grade){

    echo   "<th data-field='early-bed'>Earliest Bed Time_Sleep Diary</th>";
    echo   "<th data-field='last-bed'>Latest Bed Time_Sleep Diary</th>";
    echo   "<th data-field='ave-bed'>Average Bed Time_Sleep Diary</th>";
    echo   "<th data-field='early-wake'>Earliest Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='last-wake'>Latest Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='ave-wake'>Average Wake Up Time_Sleep Diary</th>";
    echo   "<th data-field='short-total'>Shortest Total Sleep Time_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='long-total'>Longest Total Sleep Time_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='ave-total'>Average Total Sleep Time_Sleep Diary (hourse:min)</th>";
    echo   "<th data-field='ave-inBed'>Average Time in Bed_Sleep Diary (hours:min)</th>";
    echo   "<th data-field='ave-fall'>Average Time it Took to Fall Asleep_Sleep Diary (min)</th>";
    echo   "<th data-field='ave-awak'>Average #Awak._Sleep Diary</th>";
    echo   "<th data-field='ave-awakeTime'>Average Awake Time_Sleep Diary (min)</th>";
    if($grade==4){
        echo   "<th data-field='ave-bedroomLight'>Average Bedroom Lighting Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-noise'>Average Bedroom Noise Rating_Sleep Diary</th>";
        echo   "<th data-field='ave-temperature'>Average Bedroom Temperature Rating_Sleep Diary</th>";
    }
    echo   "<th data-field='ave-wakeUp'>Average Wake Up State Rating_Sleep Diary</th>";
    echo   "<th data-field='ave-quality'>Average Sleep Quality (last night) Rating_Sleep Diary</th>";
    //echo   "<th>Average Sleep Quality (compared to usual) Rating_Sleep Diary</th>";

}
function activityStatsSummaryHeader($grade){
    global $enumFeltDuringDay, $enumHowSleepy, $enumAttention, $enumBehavior, $enumInteraction;
    if(!isset($grade)){
	$grade = 0;
    }

    echo   "<th data-field='nap'>Number of Days Napped_Activity Diary</th>";
    echo   "<th data-field='ave-caffe'>Average Number of Caffeinated Drinks_Activity Diary</th>";
    echo   "<th data-field='ave-exerc'>Average Number of Minutes Exercised_Activity Diary</th>";
    if($grade==4 || $grade ==0){
	echo   "<th data-field='ave-game'>Average Number of Minutes Played Video Games_Activity Diary</th>";
	echo   "<th data-field='ave-computer'>Average Number of Minutes Spent Using a Computer_Activity Diary</th>";
	echo   "<th data-field='ave-tech'>Average Number of Minutes Using Other Technology_Activity Diary</th>";
    }
    if($grade == 5 || $grade ==0){
        echo   "<th data-field='ave-mood'>Average Mood Rating_Activity Diary</th>";
        echo   "<th data-field='ave-moodDesc'>Mood Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='ave-sleepness'>Average Sleepiness Rating_Activity Diary</th>";
    echo   "<th data-field='sleepness'>Sleepiness Descriptor Most Often Selected_Activity Diary</th>";
    if($grade == 5 || $grade ==0){
        echo   "<th data-field='ave-attention'>Average Attention Rating_Activity Diary</th>";
        echo   "<th data-field='attention'>Attention Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th data-field='ave-behavior'>Average Behavior Rating_Activity Diary</th>";
	echo   "<th data-field='behavior'>Behavior Descriptor Most Often Selected_Activity Diary</th>";

	echo   "<th data-field='ave-interactions'>Average Interactions Rating_Activity Diary</th>";
	echo   "<th data-field='interactions'>Interactions Descriptor Most Often Selected_Activity Diary</th>";
    }
    echo   "<th data-field='symptoms'>Physical Symptoms_Activity Diary</th>";
}
 ?>
