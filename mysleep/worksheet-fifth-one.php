<!DOCTYPE html>
<?php

#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li                                                           #
#           James Geiger                                                    #
#           Wo-Tak Wu                                                       #
#                                                                           #
# Filename: WorksheetFifthOne.php                                           #
#                                                                           #
# Purpose:  G5 L1 A1 Worksheet                                              #
#                                                                           #
#############################################################################

require_once 'utilities.php';
require_once 'connectdb.php';

checkauth();

$userId= $_SESSION['userId'];


$result = mysql_query("SELECT story, happen, factor, affect FROM fifthGradeLessonOneWorksheet WHERE userId='$userId' ORDER BY uniqueId DESC LIMIT 1;");
/*Worksheet moved from Activity 1 to Activity 2*/
/*if(mysql_num_rows($result) == 0){
   $rltContent = mysql_query("SELECT story, happen, factor, affect FROM fifthGradeLessonOneWorksheet  RIGHT JOIN student_group ON student_group.linkUserId = fifthGradeLessonOneWorksheet.userId where student_group.activity='2' AND lesson='1' AND tab='g5l1worksheet' AND student_group.userId='$userId' order by uniqueId DESC LIMIT 1;");
   $rwContent = mysql_fetch_array($rltContent);
   $story = $rwContent['story'];
   $happen = $rwContent['happen'];
   $factor = $rwContent['factor'];
   $affect = $rwContent['affect'];	    
   }else{*/
$row = mysql_fetch_array($result);
$story = $row['story'];
$happen = $row['happen'];
$factor = $row['factor'];
$affect = $row['affect'];	   
//}

/*Old Version*/
/*$sql = "SELECT * FROM fifthGradeLessonOneWorksheet WHERE userId = $userId ORDER BY submitTime DESC LIMIT 1;";

   $result = mysql_query($sql);

   if(mysql_num_rows($result) == 1){
   while($row = mysql_fetch_array($result)){
   $story = $row['story'];
   $Q1 = $row['Q1'];
   $Q2 = $row['Q2'];
   $Q3 = $row['Q3'];
   $Q4 = $row['Q4'];
   $Q5 = $row['Q5'];
   $Q6 = $row['Q6'];
   $Q7 = $row['Q7'];
   $Q8 = $row['Q8'];
   $groupMember = $row['groupMember'];
   }
   }else{
   $story = 0;
   $Q1 = "";
   $Q2 = "";
   $Q3 = "";
   $Q4 = "";
   $Q5 = "";
   $Q6 = "";
   $Q7 = "";
   $Q8 = "";
   $groupMember = "";
   }*/
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Stories Worksheet</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">Activity Two</a></li>                              
                                <li class="active">Stories Worksheet</li>
                            </ol>
                        </div>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-6 col-sm-offset-3">
				<div class="form-group">
				    <label class="control-label" for="story"><h4>What is your story?</h4></label>
				    <select name="story" id="story" class="form-control input-lg" required>
					<option value='0'>Story Number</option>;
					<option value='1' <?php if($story==1) echo 'selected="selected"' ?> >Story 1: Grounded Tanker Spreads Destruction</option>;
					<option value='2' <?php if($story==2) echo 'selected="selected"' ?> >Story 2: Google Replaces Facebook as Best Place to Work</option>;
					<option value='3' <?php if($story==3) echo 'selected="selected"' ?> >Story 3: Explosion Rocks Space Program</option>;
					<option value='4' <?php if($story==4) echo 'selected="selected"' ?> >Story 4: Near Miss for Nuclear Disaster</option>;
					<option value='5' <?php if($story==5) echo 'selected="selected"' ?> >Story 5: School Start Times: It’s Too Early to Get Up!</option>;
				    </select>
				</div>
				<div class="form-group">
                                    <label for="happen"><h4>What happened in the news story? (1-3 sentence summary)</h4></label>
                                    <textarea class="form-control input-lg" id="id_happen" name="happen" placeholder="My response" rows="5"><?php echo $happen ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="factor"><h4>Who in the story had enough or not enough sleep? (one or more people)</h4></label>
				    <textarea class="form-control input-lg" id="id_factor" name="factor" placeholder="My response" rows="5"><?php echo $factor ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="affect"><h4>What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</h4></label>
                                    <textarea class="form-control input-lg" id="id_affect" name="affect" placeholder="My response" rows="5"><?php echo $affect ?></textarea>
                                </div>

				<!-- Old Version -->
				<!-- 
                                     <div class="form-group">
                                     <label for="Q1"><h4>What are the main events in the story?</h4></label>
                                     <textarea class="form-control input-lg" id="Q1" name="Q1" placeholder="My response" rows="5"><?php echo $Q1 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q2"><h4>When did the events take place?</h4></label>
                                     <textarea class="form-control input-lg" id="Q2" name="Q2" placeholder="My response" rows="5"><?php echo $Q2 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q3"><h4>Who was involved in the event?</h4></label>
                                     <textarea class="form-control input-lg" id="Q3" name="Q3" placeholder="My response" rows="5"><?php echo $Q3 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q4"><h4>Where did the event take place?</h4></label>
                                     <textarea class="form-control input-lg" id="Q4" name="Q4" placeholder="My response" rows="5"><?php echo $Q4 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q5"><h4>What factors related to sleep were involved?</h4></label>
                                     <textarea class="form-control input-lg" id="Q5" name="Q5" placeholder="My response" rows="5"><?php echo $Q5 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q6"><h4>What other factors were involved?<br><small>(These should not be sleep related!)</small></h4></label>
                                     <textarea class="form-control input-lg" id="Q6" name="Q6" placeholder="My response" rows="5"><?php echo $Q6 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q7"><h4>What was the impact of the event?</h4></label>
                                     <textarea class="form-control input-lg" id="Q7" name="Q7" placeholder="My response" rows="5"><?php echo $Q7 ?></textarea>
                                     </div>
                                     
                                     <div class="form-group">
                                     <label for="Q8"><h4>What does the news story tell you about the role of sleep in our lives?</h4></label>
                                     <textarea class="form-control input-lg" id="Q8" name="Q8" placeholder="My response" rows="5"><?php echo $Q8 ?></textarea>
                                     </div>
				     
				     <div class="form-group">
                                     <label for="groupMember"><h4>Who are your group members?</h4></label>
                                     <textarea class="form-control input-lg" id="groupMember" name="groupMember" placeholder="My response" rows="5"><?php echo $groupMember ?></textarea>
				     </div>

				   -->
			    </div>
			</div>
                    </form>
		    <?php if($_SESSION['userType']=="student"){ ?>
			<div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				<button class="btn btn-info btn-large btn-block" type="submit" name="btnSave" id="save-activity">Save</button>
                            </div>
			</div>
			<div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				<a class="btn btn-success btn-large btn-block" href="#" onclick="submit()">Save &amp; Submit</a>
                            </div>
			</div>
			<div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				<a class="btn btn-danger btn-large btn-block" data-toggle="modal" data-target="#exit-modal">Exit without Saving</a>
                            </div>
			</div>
		    <?php }else{?>
			<div class="row">
			    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				<a class="btn btn-info btn-large btn-block">Save</a>
			    </div>
			</div>
			<div class="row">
			    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				<a class="btn btn-success btn-large btn-block">Save &amp; Submit</a>
			    </div>
			</div>
			<div class="row">
			    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				<a class="btn btn-danger btn-large btn-block" data-toggle="modal" data-target="#exit-modal">Exit without Saving</a>
			    </div>
			</div>
		    <?php } ?>
                </div>
	    </div>
            <!-- Exit Modal -->
	    <div class="modal fade" id="exit-modal" tabindex="-1" role="dialog" aria-labelledby="exit-modal-label" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title" id="exit-modal-label">Exit the Activity?</h4>
			</div>
			<div class="modal-body">
			    Are you sure you want to exit the activity without saving your work?
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			    <button id="exit-activity" type="button" class="btn btn-danger btn-simple">Exit</button>
			</div>
		    </div>
		</div>
	    </div>
            <!-- Submit Modal -->
	    <div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
			</div>
			<div class="modal-body">
			    Are you ready to submit your work to your teacher?
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
			    <button id="submit-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
			</div>
		    </div>
		</div>
	    </div>
            <?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     function submit(){
	 if($("#story").val() == 0){
	     $.notify({
                 title: '<strong>Error:</strong>',
                 message: 'Please select your story number!'
             },{
                 placement: {
                     from: "top",
                     align: "center"
                 },
                 type: 'danger'
             }
             );
	 }else{
	     $('#submit-modal').modal('show');
	 }
     }
     
     $(function () {
         $("#exit-activity").click(function(){
             window.window.location.href = "fifth-grade-lesson-activity-menu?lesson=1&activity=1";
         });
         $("#save-activity").click(function(e) {
	     e.preventDefault();
             $.ajax({
                 url: 'worksheet-fifth-one-done',
                 method: 'POST',
                 data: $('form').serialize(),
                 success: (function() {
                     $.notify({
                         title: '<strong>Success!</strong>',
                         message: 'Your response has been saved, but has not been submitted.'
                     },{
                         placement: {
                             from: "top",
                             align: "center"
                         },
                         type: 'success'
                     }
                     );
                 }),
                 error:(function(XMLHttpRequest, textStatus, errorThrown){
                     $.notify({
                         title: '<strong>Error:</strong>',
                         message: 'Your work was not saved. Please contact your teacher<br>Code: ' + errorThrown
                     },{
                         placement: {
                             from: "top",
                             align: "center"
                         },
                         type: 'danger'
                     }
                     );
                 })
             });
         });

	 
         $("#submit-activity").click(function() {
	     
             var input = $("<input>")
                 .attr("type", "hidden")
                 .attr("name", "btnSubmit").val("1");
             $('form').append($(input));
	     $("form").attr("action", "worksheet-fifth-one-done") 
             $('form').submit();
         });
     });
    </script>
</html>
