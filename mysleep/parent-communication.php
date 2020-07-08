<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if($userType!="parent"){
    header("Location: login");
    exit;
}
$currentGrade = $_SESSION['parentGrade'];
debugToConsole('grade', $currentGrade);
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep //Communication</title>
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
				<li class="active">Communication</li>
                            </ol>
                        </div>
                    </div> 
					<div class="col-md-offset-1 col-md-10">
					<ol>
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
						<?php }else{?>
						
						<li><a href="docs/parent_letter_5th_grade_implementation_FINAL.pdf" download>Fifth Grade Parent Communication (ENGLISH)
						</a></li>
						<li><a href="docs/parent_letter_5th_grade_implementation_FINAL_SPANISH.pdf" download>
						Fifth Grade Parent Communication (SPANISH)
						</a></li>
						<li><a href="docs/parent_letter_4th_grade_implementation_FINAL_SPANISH.pdf" download>Fourth Grade Parent Communication (SPANISH)</a></li>
						<li><a href="docs/parent_letter_4th_grade_implementation_FINAL.pdf" download>Fourth Grade Parent Communication (ENGLISH)
						</a></li>
						<?php } ?>
						</ol>
					</div>
                </div>
            </div>
        </div>
		<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
