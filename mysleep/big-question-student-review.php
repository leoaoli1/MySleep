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
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

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
                   <div class="row">
                      <div class="col-xs-10 col-md-10">
              				     <table id="hypothesis-table"  class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table borderless">
                  				    <thead>
                        					<tr>
                  						        <th>Hypothesis and Evidence</th>
                                      <th></th>
                        					</tr>
                  				    </thead>
                              <tbody>
                  				    </tbody>
                  				</table>
                        </div>
                      </div>
		           </div>
	         </div>
	     </div>
	     <?php include 'partials/footer.php' ?>
	     <?php include 'partials/scripts.php' ?>
      	<script>

      	 var prerow, schoolrow, adultrow;

           setInterval(function(){
             refreshList();
        	 }, 2000);

            function agreeFunc(button){
              $.ajax({
               type: "POST",
               url: "big-question-rating-done",
               data: {resultRow:button.value,type:'agree',myResultRow:button.name}
             })
             .done(function(respond){refreshList();console.log(respond)})
            }
           function refreshList(){
          	     $.ajax({
              		 type: "post",
              		 url: "big-question-rating",
              		 dataType: 'json',
              	 success: function (response) {
                   console.log(response)
              	 $("#hypothesis-table tbody").empty();
              		     for (var i = 0; i < response.idList.length; i++) {
                         var color;
                         if (i%2==0) {
                           color = 'bubble-bg';
                         } else {
                           color = 'bubble-bb';
                         }
                         var hasButtons = '';
                         if (response.yourself[i]!=0) {
                           hasButtons = "<button style='font-size:24px; color:#fc6e63' name='"+response.myResultRow+"' value='"+response.resultRows[i]+"' onclick='agreeFunc(this)'><i class='fa fa-thumbs"+response.agree[i]+"-up'></i></button>";
                         }
              			     prerow = "<tr><td style='width: 85%;'><div class='speech-bubble "+color+"'><div class='bubbletext'>" + response.hypothesis[i] + "<Br><small>" + response.evidence[i] + "</small></div></div></td><td style='vertical-align: middle !important;'>"+hasButtons+"</td><tr>";
              			     $("#hypothesis-table tbody").append(prerow);
              		     }
              		   }
              	     });
            }

      	</script>
    </body>
</html>
