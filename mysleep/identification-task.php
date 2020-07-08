<!DOCTYPE html>
<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#                                                                           #
#                                                                           #
# Filename: IdentificationTask.php                                          #
#                                                                           #
# Purpose:                                                                  #
#                                                                           #
#############################################################################

require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$config = $_SESSION['current_config'];
if ($userId == ""){
    header("Location: login");
    exit;
   }
   $userType= $_SESSION['userType'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>Sleep Effect Task One</title>
        <style>
         @media only screen and (min-width : 1200px){
             .hide-large {
                 display: none;
             }
         } </style>
    </head>
    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType,['linkable' => true]);
                  } else {?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a class = "exit" data-location="main-page">Home</a></li>
				<li><a class = "exit" data-location="sleep-lesson">Lessons</a></li>
                                <li><a class = "exit" data-location="fifth-grade-lesson-menu?lesson=3">Lesson Three</a></li>
				<li><a class = "exit" data-location="fifth-grade-lesson-activity-menu?lesson=3&activity=1">Activity One</a></li>
                                <li class="active">Task One</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <div class="well well-lg collapse in" id="instructions">
                                <h4>Instructions:</h4>
                                <p>You will be shown a picture of a playing card.  You must decide as quickly as possible.  </p>
                                <p><b>If it is red, press "Yes".  If it is black, press "No".</b></p>
                                <p><b>Note:</b> If you are on a desktop or laptop, you must press the "Y" key on the keyboard for yes, or the "N" key for no.</p>
                                <p>Click the button below to hide the instructions and begin the task.</p>
                                <button class="btn btn-large btn-simple btn-block" id='startButton'>Start Task</button>
                            </div>
                        </div>
                    </div>
                    <div class="row collapse" id="task">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <div class="row" style="height:300px;" id="gameDiv">
                                <div class="col-xs-3 col-lg-0 hide-large" style="height:inherit;">
                                    <button class="btn btn-large btn-info btn-block btn-simple" id="btnYes" style="height:100%;border: solid;border-color: #03a9f4;">Yes</button>
                                </div>
                                <div class="col-xs-6 col-lg-10 col-lg-offset-1" style="height:inherit;" id="drawCanvas">
                                    <center style="height:inherit;">
					<div id='cbox' style='width:100%;height:100%;border:0px solid black;background-color:white'>
					    <canvas tabindex='1' id="exp" width="300px" height="300px" style="position: absolute;top:0;left:0;right:0;bottom:0;margin:auto;"></canvas>
					</div>
				    </center>
                                </div>
                                <div class="col-xs-3 col-lg-0 hide-large" style="height:inherit;">
                                    <button class="btn btn-large btn-info btn-simple btn-block" id="btnNo" style="height:100%;border: solid;border-color: #03a9f4;">No</button>
                                </div>
                            </div>

			    <br>
			    <script src="assets/js/identification.js"></script>
                        </div>
                    </div>
		    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                          <div class="hidden" id="resultsDiv">
			    <?php if($userType == 'student'){ ?>
                                <button class='btn btn-success btn-block btn-simple' id='sendData'>Save Results</button>
				<?php }else{?>
				<button class='btn btn-success btn-block btn-simple'>Save Results</button>
				<?php } ?>
                                <div id='showdata'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script src="assets/js/bililiteRange.js"></script>
    <script src="assets/js/jquery-sendkeys.js"></script>
    <script src="assets/js/jquery-json.min.js"></script>
    <script>
     $(function () {

         $("#btnYes").mousedown(function(){
             triggerKeydownEvent(document.body,89);
         });

         $("#btnYes").mouseup(function(){
             triggerKeyupEvent(document.body,89);
         });

         $("#btnNo").mousedown(function(){
             triggerKeydownEvent(document.body,78);
         });

         $("#btnNo").mouseup(function(){
             triggerKeyupEvent(document.body,78);
         });

         $("#startButton").click(function(){
             $("#instructions").collapse('hide').delay(1000, function(){
                 $("#task").collapse('show');
                 main();
             });
         });

         $("#sendData").click(function(){


             var TableData;
             TableData = storeTblValues()
             TableData = $.toJSON(TableData);

             function storeTblValues(){
                 var TableData = new Array();
                 $('#outputTable tr').each(function(row, tr){
                     TableData[row]={
                         "suit" : $(tr).find('td:eq(0)').text(),
                         "card" :$(tr).find('td:eq(1)').text(),
                         "response" : $(tr).find('td:eq(2)').text(),
                         "time" : $(tr).find('td:eq(3)').text()
                     }
                 });
                 TableData.shift();  // first row will be empty - so remove
                 return TableData;
             }

             $.ajax({
                 type: "POST",
                 url: "identification-task-done",
                 data: "pTableData=" + TableData,
                 success: function(msg){
                     $.notify({
                         title: 'Success!',
	                 message: 'Your results have been saved.'
                     },{
	                 type: 'success',
                         placement: {
			     from: "bottom",
			     align: "center"
			 },
                         offset:20
                     });
                     $("#sendData").prop('disabled', true);
                     $("#sendData").text("Data Already Sumbitted");
                 }
             });
         });
     });
     function triggerKeydownEvent(el, keyCode){
         var eventObj = document.createEventObject ?
			document.createEventObject() : document.createEvent("Events");
         if(eventObj.initEvent){
             eventObj.initEvent("keydown", true, true);
         }
         eventObj.keyCode = keyCode;
         eventObj.which = keyCode;
         el.dispatchEvent ? el.dispatchEvent(eventObj) : el.fireEvent("onkeydown", eventObj);
     }

     function triggerKeyupEvent(el, keyCode){
         var eventObj = document.createEventObject ?
			document.createEventObject() : document.createEvent("Events");
         if(eventObj.initEvent){
             eventObj.initEvent("keyup", true, true);
         }
         eventObj.keyCode = keyCode;
         eventObj.which = keyCode;
         el.dispatchEvent ? el.dispatchEvent(eventObj) : el.fireEvent("onkeyup", eventObj);
     }
    </script>

</html>
