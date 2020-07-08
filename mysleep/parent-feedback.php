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
        <title>MySleep //Feedback</title>
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
				<li class="active">Feedback</li>
                            </ol>
                        </div>
                    </div>
		    <div class="text-center">
	                <div class="row">
			    <div class="col-md-offset-1 col-md-10">
	                        <h4 class="description" style="color: black;">
				    Please use this <a href="https://docs.google.com/forms/d/e/1FAIpQLSdiedMwjvRLQf4mOe5EzKHWloEVdfH1uBQZES2rJu9ATFgTDA/viewform?c=0&w=1" >feedback form</a>	 to ask any questions or make comments you may have about your child's participation in the Z-Factor program at your child's school.
				</h4>
			    </div>
	                </div>
			
                </div>
            </div>
        </div>
		<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
