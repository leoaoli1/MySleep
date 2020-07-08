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
   $classGrade = getClassGrade($classId);
}
$classGrade = $_SESSION['classGrade'];

$showToClass = 0;
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
                  if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLinkReview($config,$userType);
                  } ?>
      		    <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-md-offset-0 col-md-12 ">
                  <div style="padding:10px;">
                  
                    <div class="card card-carousel">
                  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false" >
                      <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                      <?php 
                      $iter = ($classGrade==4) ? 8 : 13;
                      for ($i=1; $i <= $iter; $i++) { ?>
                        <div class="item <?php echo ($i==1) ? 'active':''; ?>">
                          <img src="images/color-code/color-code-grade<?php echo $classGrade.'-'.$i; ?>.png" alt="Awesome Image" id="carousalImg" style="width: 100%;">
                        </div>
                      <?php } ?>
                    </div>

                      </div>
                  </div>
                  <!-- End Carousel Card -->
                  <button id="previous" class="btn btn-simple" style="display:none;float:left;"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Previous</button>
                  <button id="next" class="btn btn-simple" style="display:none;float:right;">Next&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                  <!-- End Carousel Card -->
                    </div>
                    <!-- <h3>Color Keys</h3>
                    <embed src="./images/fourthGrade/colorKeys.pdf" width="100%" height="800px">] -->
                  </div>



              </div>
		       </div>
        </div>

		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>

  <script src="https://code.highcharts.com/highcharts.src.js"></script>
  <script src="https://rawgithub.com/highcharts/draggable-points/master/draggable-points.js"></script>
  <script type="text/javascript">
  $(function() {
    var iter = <?php echo $iter;?>;
      $("#next").show();
      $("#previous").hide();
      $("#next").click(function(){
          $("#carousel-example-generic").carousel('next');
          var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
          var from = active.index();
          if (from == iter-2) { 
            $("#next").hide();
          }
          $("#previous").show();
      });
      $("#previous").click(function(){
          $("#carousel-example-generic").carousel('prev');
          var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
          var from = active.index();
          if (from == iter-1) {
            $("#next").show();
          }
          if (from == 1) {
            $("#previous").hide();
          }
      });
      function getSlideIndex(){
          var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
          var from = active.index();
      }
  });
	</script>
  </body>
</html>
