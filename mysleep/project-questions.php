<!DOCTYPE html>
<?php

require_once 'utilities.php';
require_once 'connectdb.php';

checkauth();

$userId= $_SESSION['userId'];
$classId = $_SESSION['classId'];
$userType = $_SESSION['userType'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

$grade = getGrade($userId);

$result = mysql_query("SELECT questions FROM projectQuestion WHERE userId='$userId'and grade='$grade' ORDER BY recordId DESC LIMIT 1;");
$row = mysql_fetch_array($result);
$questions = $row['questions'];
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
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType);
                  }else {?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=4'">Lesson Four</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=4&activity=3'">Activity Three</a></li>
                                <li class="active">Project Questions</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-6 col-sm-offset-3">
				<div class="form-group">
                                    <label for="id_question"><h4>Questions?</h4></label>
                                    <textarea class="form-control input-lg" id="id_question" name="questions" placeholder="My response" rows="10"><?php echo $questions ?></textarea>
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
		    <?php } ?>
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
        $(function () {
            $("#save-activity").click(function(e) {
				e.preventDefault();
                $.ajax({
                    url: 'project-questions-done',
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
		$("form").attr("action", "project-questions-done")
                $('form').submit();
            });
        });
</script>
    </html>
