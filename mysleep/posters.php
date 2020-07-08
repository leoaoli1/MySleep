<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author:Siteng Chen <sitengchen@email.arizona.edu>
#
	require_once('utilities.php');
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
?>

<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Why Do We Sleep?</title>
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
                     <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                         <h3>Putting ZZZ Pieces Together</h3>
                         <h4>You now have some of the pieces you need to present a research project on your class’s sleep.<br><br>
                           <small>1. Background on the importance of sleep<br>
                                  2. A survey of your class sleep<br>
                                  3. A question and hypothesis about the causes for your sleep duration, consistency and quality<br>
                                  4. Data comparing one or more causes and effects<br><br>
                           </small>
                           It is important for you to share what you have found out about your class’s sleep with others. To do so, you can create a class poster or slide show of the materials from the work you submitted in MySleep. Below is a sample of a poster from an actual research project. It contains the same sections that you have worked on as part of your class’s study of sleep.
                         </h4>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-xs-offset-0 col-xs-12 col-md-12 col-md-offset-0">
                       <embed src="./images/<?php echo ($classGrade==4)?'fourthGrade':'fifthgrade'; ?>/sample-poster.png" width="100%">
                     </div>
                 </div>

            </div>
        </div>
    </div>
    <?php include 'partials/footer.php' ?>
</body>
</html>
