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


$result = mysql_query("SELECT summary FROM fifthGradeLessonOneStorySummary WHERE userId='$userId' ORDER BY recordId DESC LIMIT 1;");
/*Worksheet moved from Activity 1 to Activity 2*/
if(mysql_num_rows($result) == 0){
    $rltContent = mysql_query("SELECT summary FROM fifthGradeLessonOneStorySummary  RIGHT JOIN student_group ON student_group.linkUserId = fifthGradeLessonOneStorySummary.userId where student_group.activity='2' AND lesson='1' AND tab='g5l1summary' AND student_group.userId='$userId' order by fifthGradeLessonOneStorySummary.recordId DESC LIMIT 1;");
   $rwContent = mysql_fetch_array($rltContent);
    $summary = $rwContent['summary'];   
}else{
   $row = mysql_fetch_array($result);
    $summary = $row['summary'];      
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Stories Summarizer</title>
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
                                <li class="active">Stories Summarizer</li>
                            </ol>
                        </div>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-6 col-sm-offset-3">
				<div class="form-group">
                                    <label for="id_summary"><h4>Based on the stories you’ve read, briefly describe the risks of not getting enough sleep, and the benefits to rewards to be consistent with lesson theme.</h4></label>
                                    <textarea class="form-control input-lg" id="id_summary" name="summary" placeholder="My response" rows="10"><?php echo $summary ?></textarea>
                                </div>
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
                            <a class="btn btn-success btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
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
        Are you ready to submit your work to your teacher? Your group should submit a single response to your teacher.
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
        $(function () {
            $("#exit-activity").click(function(){
                window.window.location.href = "fifth-grade-lesson-activity-menu?lesson=1&activity=1";
            });
            $("#save-activity").click(function(e) {
				e.preventDefault();
                $.ajax({
                    url: 'summary-fifth-one-done',
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
		$("form").attr("action", "summary-fifth-one-done") 
                $('form').submit();
            });
        });
</script>
    </html>
