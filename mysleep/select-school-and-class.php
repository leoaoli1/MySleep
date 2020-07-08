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
if($userId==""){
    header("Location: login");
    exit;
}
$location = $_GET['location'];
$schoolId = $_SESSION['schoolId'];
include 'connectdb.php';
$res = mysql_query("SELECT classId FROM class_table where userId='$userId'");
$numRow = mysql_num_rows ($res);
if ($numRow == 0) {
  /* if there is no class linked to the teacher, the user will be redirected to
  manage class page to create a new class.*/
  header("Location: set-class-info");
}
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Select Class</title>
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
				<div class="header header-gradpr text-center">
				    <h4>Select your Information</h4>
				</div>
				<div class="content" style="padding: 0 10px 0 10px">
				  <?php
				        if(isset($_GET['class'])){
   if($_GET['class'] = 'null'){
     echo "Please choose your class";
   }
   }
				     ?>
				    <form action="select-school-and-class-done" method="post" id="classForm">
					<div class="form-group">
                                            <label class="control-label">Class</label>
					    <select name="classId" class="form-control input-lg">
						<?php
						echo "<option value='null' disabled selected>Select Class</option>";
						while ($r = mysql_fetch_array($res)) {
						    $clId = $r['classId'];
						    $result = mysql_query("SELECT className FROM class_info_table where classId='$clId'");
						    $row = mysql_fetch_array($result);
						    $clName = $row['className'];
						    echo "<option value='$clId'>" . $clName. "</option>";
						}
						mysql_close($con);
						?>
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
