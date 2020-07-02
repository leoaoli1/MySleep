<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen 
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
              				     <table id="why-sleep-table"  class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table">
                  				    <thead>
                        					<tr>
                  						        <th>Why do We Sleep</th>
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
               url: "why-do-we-sleep-rating-done",
               data: {resultRow:button.value,type:'agree',myResultRow:button.name}
             })
             .done(function(respond){refreshList();console.log(respond)})
            }
            function disagreeFunc(button){
              $.ajax({
               type: "POST",
               url: "why-do-we-sleep-rating-done",
               data: {resultRow:button.value,type:'disagree',myResultRow:button.name}
             })
             .done(function(respond){refreshList();})
             }
           function refreshList(){
          	     $.ajax({
              		 type: "post",
              		 url: "why-do-we-sleep-rating",
              		 dataType: 'json',
              	 success: function (response) {
              	 $("#why-sleep-table tbody").empty();
              		     for (var i = 0; i < response.idList.length; i++) {
                         var hasButtons = '';
                         if (response.yourself[i]!=0) {
                           hasButtons = "<button style='font-size:24px' name='"+response.myResultRow+"' value='"+response.resultRows[i]+"' onclick='agreeFunc(this)'><i class='fa fa-thumbs"+response.agree[i]+"-up'></i></button><button style='font-size:24px' name='"+response.myResultRow+"' value='"+response.resultRows[i]+"' onclick='disagreeFunc(this)'><i class='fa fa-thumbs"+response.disagree[i]+"-down'></i></button>";
                         }
              			     prerow = "<tr><td>" + response.whySleepAnswer[i] + "</td><td>"+hasButtons+"</td><tr>";
              			     $("#why-sleep-table tbody").append(prerow);
              		     }
              		   }
              	     });
            }

      	</script>
    </body>
</html>
