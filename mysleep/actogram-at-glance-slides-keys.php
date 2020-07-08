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
	require_once('utilities-actogram.php');
	session_start();
	$userId= $_SESSION['userId'];
	$userType = $_SESSION['userType'];
	if ($userId == ""){
	    header("Location: login");
	    exit;
  }
  $classGrade = $_SESSION['classGrade'];
	$lessonNum = $_GET['lesson'];
	$activityNum = $_GET['activity'];
	$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
	$query = $_SERVER['QUERY_STRING'];
	unset($_SESSION['current_config']);
	$_SESSION['current_config'] = $config;

    // If data has already been saved for this student, place it in the body.
  include 'connectdb.php';
	$classId = $_SESSION['classId'];
	$result = mysql_query("SELECT * FROM ourzzzdata WHERE classId = $classId");
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	$titleArray = [];
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		$titleArray = [$row['durationTitle'],$row['consistencyTitle'],$row['qualityTitle']];
   }else {
		 $titleArray = ['Sleep Watch Hours of Sleep','Total Minutes Difference between shortest and longest sleep times','Sleep Watch Rating'];
   }

   mysql_close($con);

?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep <?php  echo '// '.$config['activity_title']; ?></title>
    </head>

		<?php include 'partials/scripts.php' ?>
<body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
												<?php
												require_once('partials/nav-links.php');
												navigationLink($config,$userType);
												 ?>
                         <div class="row">
                           <div class="col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8 ">
                             <div style="padding:10px;">
                             <?php if ($classGrade==4) { ?>
                              <embed src="./images/color-code/color-code-key-grade4-1.png" width="100%">]
                             <?php } else { ?>
                              <embed src="./images/color-code/color-code-key-grade5.pdf" width="100%" height="800px">]
                             <?php } ?>
                               
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
              var firstPage = 0;
              var lastPage = 1;
                $("#next").hide();
                $("#previous").hide();
                $("#next").click(function(){
                    $("#carousel-example-generic").carousel('next');
                    var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
                    var from = active.index();
                    if (from == lastPage-1) {
                      $("#next").hide();
                    }
                    $("#previous").show();
                });
                $("#previous").click(function(){
                    $("#carousel-example-generic").carousel('prev');
                    var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
                    var from = active.index();
                    if (from == firstPage+1) {
                      $("#previous").hide();
                      $("#next").show();
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
