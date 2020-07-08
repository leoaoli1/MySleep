<!DOCTYPE html>
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
if($userType != "parent"){
    header("Location: login");
    exit;
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Select Grade</title>
    </head>
    
    <body class="signup-page">
	<nav class="navbar navbar-transparent navbar-absolute">
    	    <div class="container">
        	<!-- Brand and toggle get grouped for better mobile display -->
        	<div class="navbar-header">
        	    <a class="navbar-brand" href="#">MySleep</a>
        	</div>
    	    </div>
	</nav>

	<div class="wrapper">
	    <div class="header header-filter">
		<div class="container">
		    <div class="row">
			<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			    <div class="card card-signup">
				<div class="header header-primary text-center">
				    <h4>Select Grade</h4>
				</div>
				<div class="content" style="padding: 0 10px 0 10px">
				    <?php
				    if(isset($_GET['grade'])){
					if($_GET['grade'] = 'null'){
					    echo "Please choose a grade";
					}
				    }
				    ?>
				    <form action="parent-sleep-lesson-grade-done" method="post" id="gradeForm">
					<div class="form-group">
                                            <label class="control-label">Grade</label>
					    <select name="grade" class="form-control input-lg">
						<option value='null' disabled selected>Please Choose Grade</option>
						<option value='4' >Fourth Grade</option>
						<option value='5' >Fifth Grade</option>
					    </select>
					</div>
				</div>
				<div class="footer text-center">
				    <button class="btn btn-simple btn-primary btn-lg" type="submit">Continue</button>
				</div>
				    </form>
			    </div>
			</div>
		    </div>
		</div>
	    </div>

	</div>


    </body>

    
    <?php require 'partials/scripts.php' ?>    


</html>
