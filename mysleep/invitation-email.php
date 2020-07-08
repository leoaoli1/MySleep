<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#

session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
$classId = $_SESSION['classId'];
require_once('utilities.php'); 
include 'connectdb.php';
$currentGrade = getClassGrade($classId);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep //Invitation</title>
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
						<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
						<li class="active">Invitation</li>
                    </ol>
				</div>
                </div>
				<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
		<form method="post" enctype="multipart/form-data" action="invitation-email-done" style="margin-top: 2em;">   
			<div class="form-inline">
			    <label class="control-label" for="emailAddress"><h4 style="color:black">Your Parent's Email Address:</h4></label>
			    <input class="form-control" type="email" name="emailAddress" id="emailAddress" required>
			</div>
			<div class="form-inline">
			    <label class="control-label" for="name"><h4 style="color:black">Your Name:</h4></label>
			    <input class="form-control" type="text" name="name" id="name" required>
			</div>
			<div class="form-inline">
			    <label class="control-label" for="subject"><h4 style="color:black">Subject:</h4></label>
			    <input class="form-control" type="text" name="subject" id="subject" required>
			</div>
                        <textarea class="form-control input-lg" id="content" name="content" rows="7">
Hello,
   
Please participate in the Zfactor program. For more details, please see attachments.

Best Regards,
UA Zfactor Team

Please do not reply this email.
			</textarea>
			<p>Attachments:</p>
			<?php if($currentGrade == '5'){  ?>
			    <li><a href="docs/parent_letter_5th_grade_implementation_FINAL.pdf" download>Fifth Grade Parent Communication (ENGLISH)
			    </a></li>
			    <li><a href="docs/parent_letter_5th_grade_implementation_FINAL_SPANISH.pdf" download>
				Fifth Grade Parent Communication (SPANISH)
			    </a></li>   
			<?php }elseif($currentGrade == '4'){ ?>
				<li><a href="docs/parent_letter_4th_grade_implementation_FINAL_SPANISH.pdf" download>Fourth Grade Parent Communication (SPANISH)</a></li>
				<li><a href="docs/parent_letter_4th_grade_implementation_FINAL.pdf" download>Fourth Grade Parent Communication (ENGLISH)
				</a></li>
			<?php }?>
		    <div class="row" style="padding-top: 1cm">
			<input class='btn btn-danger btn-large btn-block' type='submit' name='sendInvitation' value='Send' > 
		    </div>
		</form> 
	    </div>
	    </div>
	</div>
    </div>
    <?php include 'partials/scripts.php' ?>
</body>
<?php include 'partials/footer.php' ?>
</html>
