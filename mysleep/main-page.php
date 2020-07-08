<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>, Wo-Tak Wu <wotakwu@email.arizona.edu>, Siteng Chen <sitengchen@email.arizona.edu>
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];
$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
if($userId==""){
    header("Location: login");
    exit;
}
if($userType == 'teacher') {
    if(!isset($_GET['choseSchoolClass'])&&!isset($_SESSION['choseSchoolClassDone'])) {
	header("Location: select-school-and-class");
        exit;
    }elseif(!isset($_SESSION['choseSchoolClassDone'])){
	$_SESSION['choseSchoolClassDone'] = $_GET['choseSchoolClass'];
    }
}elseif($userType == 'parent'){
    $parentGrade = $_SESSION['parentGrade'];
    //debugToConsole( 'ParentGrade', $parentGrade );
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">

    <head>
        <?php include 'partials/header.php' ?>
        <title>My Sleep // Main Page</title>
    </head>

    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">

		    <div class="text-center">
	         <div class="row">
    			    <div class="col-md-offset-1 col-md-10">
                  <h2 class="title">
                      <?php
                          if ($userType == "teacher") {
                            $classGrade = $_SESSION['classGrade'];
                            echo 'Welcome '.$classGrade.'th Grade Teacher to MySleep!';
                          } else {
                            $currentGrade = getCurrentGrade($userId);
                            echo 'Welcome to MySleep '.ucwords($_SESSION['userDisplayName']).'!';
                          }
                      ?>
                  </h2>
    	            <h5 class="description" style="color: black;">
          				    <?php
              				    if($userType == "parent"){
                    					echo "Welcome to the Z-factor Project!  The University of Arizona (UA) has partnered with the Catalina Foothills School District (CFSD) to develop, implement, and evaluate a new Science, Technology, Engineering, and Math (STEM) interdisciplinary unit called “The Z-Factor,” funded by a grant from the National Science Foundation.  The Z-Factor, involves five sleep science lessons; project-based learning experiences; webinars and interactive presentations with STEM professionals; and opportunities for students to participate in community STEM events and present their own science projects such as at SARSEF.   The new curriculum is designed to engage students and to bring the excitement of scientific investigation home.  Caregivers should participate in the learning and will play a vital role in evaluating the program.  Collaboration is an essential component of a program that aims to inspire deep learning and prepare a new generation of young scholars to use their skills well in the 21st Century.";
              				    }
          				    ?>
            			</h5>
          				<h5 class="description" style="padding-top: 1cm">
          				    <?php
              				    if($userType == "parent"){
          					         echo "Please check the tabs below to be informed of key dates and upcoming events; your child’s project work and data; lesson extensions and activities at home; and additional informational resources.";
              				    }
          				    ?>
          				</h5>
    			    </div>
          </div>

			<?php if($userType == 'teacher') { ?>
			<div class="row">
        <div class="col-md-4 col-md-offset-2">
  				<div class="info info-gradorange" onclick="location.href='sleep-lesson'" style="cursor: pointer;">
  				    <div class="icon icon-white">
  		            <i class="material-icons">assignment</i>
  				    </div>
		          <h3 class="info-title info-title-white">Lessons</h3>
  				</div>
        </div>
        <div class="col-md-4">
          <?php if ($userType == "student"): ?>
            <div class="info info-gradbb" onclick="location.href='my-score-list'" style="cursor: pointer;">
    				    <div class="icon icon-white">
    		            <i class="material-icons">assessment</i>
    				    </div>
  		          <h3 class="info-title info-title-white">Gradebook</h3>
    				</div>
            <?php else: ?>
            <div class="info info-gradbb" onclick="location.href='lesson-plan'" style="cursor: pointer;">
    				    <div class="icon icon-white">
    		            <i class="material-icons">featured_play_list</i>
    				    </div>
  		          <h3 class="info-title info-title-white">Lesson Plan</h3>
    				</div>
          <?php endif; ?>
        </div>
      </div>
      <div class="row" style="padding-top: 2em; padding-bottom: 2em">
		    <div class="col-md-4 col-md-offset-2">
  				<div class="info info-gradbg" onclick="location.href='diary-menu?<?php echo 'parent='.$currentPage ?>'" style="cursor: pointer;">
  				    <div class="icon icon-white">
				         <i class="material-icons">snooze</i>
  				    </div>
  				    <h3 class="info-title info-title-white">Sleep &amp; Activity Diary</h3>
  				    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
  				</div>
		    </div>
		            <div class="col-md-4">
				<div class="info info-gradop" onclick="location.href='admin-tools'" style="cursor: pointer;">
				    <div class="icon icon-white">
					<i class="material-icons">settings</i>
				    </div>
				    <h3 class="info-title info-title-white">Settings</h3>
				    <!-- <p>Update your email, add a picture, change your password.</p> -->
				</div>
		            </div>
		        </div>
			  <?php }elseif($userType == "student"){ ?>
          <?php if ($currentGrade == 4): ?>
            <div class="row">
              <div class="col-md-4">
        				<div class="info info-gradorange" onclick="location.href='sleep-lesson'" style="cursor: pointer;">
        				    <div class="icon icon-white">
        		            <i class="material-icons">assignment</i>
        				    </div>
      		          <h3 class="info-title info-title-white">Lessons</h3>
        				</div>
              </div>
              <div class="col-md-4">
                <div class="info info-gradbb" onclick="location.href='my-score-list'" style="cursor: pointer;">
                    <div class="icon icon-white">
                        <i class="material-icons">assessment</i>
                    </div>
                    <h3 class="info-title info-title-white">Gradebook</h3>
                </div>
              </div>
              <div class="col-md-4">
        				<div class="info info-gradpr" onclick="location.href='diary-menu?<?php echo 'parent='.$currentPage ?>'" style="cursor: pointer;">
        				    <div class="icon icon-white">
      				         <i class="material-icons">snooze</i>
        				    </div>
        				    <h3 class="info-title info-title-white">Sleep &amp; Activity Diary</h3>
        				    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
        				</div>
      		    </div>
            </div>
              <div class="row" style="padding-top: 2em; padding-bottom: 2em">
  		            <div class="col-md-4">
              				<div class="info info-gradop" onclick="location.href='interview-adult'" style="cursor: pointer;">
              				    <div class="icon icon-white">
              					<i class="material-icons">supervisor_account</i>
              				    </div>
              				    <h3 class="info-title info-title-white">Parent ZZZ Interview</h3>
              				    <!-- <p>Update your email, add a picture, change your password.</p> -->
              				</div>
  		            </div>
    		            <div class="col-md-4">
                				<div class="info info-gradbg" onclick="location.href='admin-tools'" style="cursor: pointer;">
                				    <div class="icon icon-white">
                					<i class="material-icons">settings</i>
                				    </div>
                				    <h3 class="info-title info-title-white">Settings</h3>
                				    <!-- <p>Update your email, add a picture, change your password.</p> -->
                				</div>
    		            </div>
        		      </div>
          <?php else: ?>
            <div class="row">
              <div class="col-md-4 col-md-offset-2">
        				<div class="info info-gradorange" onclick="location.href='sleep-lesson'" style="cursor: pointer;">
        				    <div class="icon icon-white">
        		            <i class="material-icons">assignment</i>
        				    </div>
      		          <h3 class="info-title info-title-white">Lessons</h3>
        				</div>
              </div>
              <div class="col-md-4">
                <div class="info info-gradbb" onclick="location.href='my-score-list'" style="cursor: pointer;">
                    <div class="icon icon-white">
                        <i class="material-icons">assessment</i>
                    </div>
                    <h3 class="info-title info-title-white">Gradebook</h3>
                </div>
              </div>
            </div>
            <div class="row" style="padding-top: 2em; padding-bottom: 2em">
      		    <div class="col-md-4 col-md-offset-2">
        				<div class="info info-gradbg" onclick="location.href='diary-menu?<?php echo 'parent='.$currentPage ?>'" style="cursor: pointer;">
        				    <div class="icon icon-white">
      				         <i class="material-icons">snooze</i>
        				    </div>
        				    <h3 class="info-title info-title-white">Sleep &amp; Activity Diary</h3>
        				    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
        				</div>
      		    </div>
  		            <div class="col-md-4">
              				<div class="info info-gradop" onclick="location.href='admin-tools'" style="cursor: pointer;">
              				    <div class="icon icon-white">
              					<i class="material-icons">settings</i>
              				    </div>
              				    <h3 class="info-title info-title-white">Settings</h3>
              				    <!-- <p>Update your email, add a picture, change your password.</p> -->
              				</div>
  		            </div>
      		      </div>
          <?php endif; ?>

        <?php }elseif($userType == "parent"){ ?>
				<div class="row">
				    <div class="col-md-4">
					<div class="info" onclick="comingSoon()" style="cursor: pointer;">
					    <div class="icon icon-warning">
						<i class="material-icons">fingerprint</i>
					    </div>
					    <h3 class="info-title">About the Z-Factor</h3>
					    <!-- <p>Begin working on MySleep activities</p> -->
					</div>
				    </div>
				    <div class="col-md-4">
					<div class="info" onclick="location.href='parent-communication'" style="cursor: pointer;">
					    <div class="icon icon-success">
						<i class="material-icons">email</i>
					    </div>
					    <h3 class="info-title">Parent Communication</h3>
					    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
					</div>
				    </div>
				    <div class="col-md-4">
					<div class="info" onclick="location.href='parent-calendar'" style="cursor: pointer;">
					    <div class="icon icon-danger">
						<i class="material-icons">event</i>
					    </div>
					    <h3 class="info-title">Z-Factor Program Calendar</h3>
					    <!-- <p>Update your email, add a picture, change your password.</p> -->
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-4">
					<?php
					$currentGrade = $_SESSION['parentGrade'];
					if($currentGrade == "both"){
					?>
					    <div class="info" onclick="location.href='parent-sleep-lesson-grade'" style="cursor: pointer;">
					<?php }else{?>
					    <div class="info" onclick="location.href='parent-sleep-lesson'" style="cursor: pointer;">
					<?php } ?>
					    <div class="icon icon-warning">
						<i class="material-icons">assignment</i>
					    </div>
					    <h3 class="info-title">Lessons</h3>
					    <!-- <p>Begin working on MySleep activities</p> -->
					</div>
				    </div>
				    <div class="col-md-4">
					<div class="info" onclick="location.href='parent-resource'" style="cursor: pointer;">
					    <div class="icon icon-success">
						<i class="material-icons">more</i>
					    </div>
					    <h3 class="info-title">Resources/Additional Info</h3>
					    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
					</div>
				    </div>
				    <div class="col-md-4">
					<div class="info" onclick="location.href='parent-feedback'" style="cursor: pointer;">
					    <div class="icon icon-success">
						<i class="material-icons">feedback</i>
					    </div>
					    <h3 class="info-title">Submit Questions/Feedback</h3>
					    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-4">
					<div class="info" onclick="comingSoon()" style="cursor: pointer;">
					    <div class="icon icon-danger">
						<i class="material-icons">forum</i>
					    </div>
					    <h3 class="info-title">FAQ</h3>
					    <!-- <p>Update your email, add a picture, change your password.</p> -->
					</div>
				    </div>
				    <div class="col-md-4">
					<div class="info" onclick="location.href='admin-tools'" style="cursor: pointer;">
					    <div class="icon icon-danger">
						<i class="material-icons">build</i>
					    </div>
					    <h3 class="info-title">Settings</h3>
					    <!-- <p>Update your email, add a picture, change your password.</p> -->
					</div>
				    </div>
				</div>
                        <?php }elseif($userType == "researcher"){ ?>
				<div class="row">
				    <!-- <div class="col-md-4">
					<div class="info" onclick="location.href='sleep-lesson'" style="cursor: pointer;">
					    <div class="icon icon-warning">
						<i class="material-icons">assignment</i>
					    </div>
					    <h3 class="info-title">Lessons</h3>
					</div>
				    </div> -->
				    <div class="col-md-6">
					<div class="info" onclick="location.href='diary-menu'" style="cursor: pointer;">
					    <div class="icon icon-success">
						<i class="material-icons">book</i>
					    </div>
					    <h3 class="info-title">Sleep &amp; Activity Diary</h3>
					    <!-- <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p> -->
					</div>
				    </div>
				    <div class="col-md-6">
					<div class="info" onclick="location.href='admin-tools'" style="cursor: pointer;">
					    <div class="icon icon-danger">
						<i class="material-icons">build</i>
					    </div>
					    <h3 class="info-title">Settings</h3>
					    <!-- <p>Update your email, add a picture, change your password.</p> -->
					</div>
				    </div>
				</div>
			<?php }else{
			    $message = "Wrong User Type. Please Connect Zfactor Team";
			    echo "<script type='text/javascript'>alert('$message');</script>";
			}?>
		    </div>
		</div>
	    </div>
	    <?php include 'partials/footer.php' ?>
	</div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     function comingSoon(){
	 alert('Coming Soon!');
	 }
    </script>
</html>
