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
	$classId=$_SESSION['classId'];
	$query = $_POST['query'];
	if ($userId == ""){
	    header("Location: login.php");
	    exit;
	}
	if(empty($_POST["content"])) {
		header("Location:bottom-line?".$query);
		exit;
   }
	 $resultRow = $_POST['resultRow'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
	 $submit = 0;
	 if (isset($_POST['btnSave'])) {
	         // return the user to the page
	         $location = "Location:bottom-line?".$query;
	 } else {
		 $submit = 1;
	         //return the user to the activity selector
	         $location = "Location:bottom-line?".$query;
	 }
   include 'connectdb.php';
	$content ="";
	$content = mysql_real_escape_string($_POST["content"]);

	$result = mysql_query("SELECT * FROM bottomLine WHERE resultRow='$resultRow'");
	$numRow = mysql_num_rows ($result);
	if ($numRow>0) {
    	$status = mysql_query("UPDATE bottomLine SET content='$content', contributors='$contributors'  WHERE resultRow='$resultRow'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO bottomLine (userId, content, contributors, classId, submit) VALUES ('$userId', '$content', '$contributors', '$classId', '1')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);
	if ($submit==0) {
		header($location);
		exit;
	}
?>
<html>
    <head>
	<?php include 'partials/header.php' ?>
	<style type="text/css">
	 .top{
	     margin-top: 200px;
	 }
	</style>
    </head>
    <body>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
		    <div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <h2>Your answer has been submitted. Your teacher will give you further instructions.</h2>
			</div>
      <div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
          <a class="btn btn-large btn-block"  name="Continue" href="<?php echo "lesson-menu?".$query; ?>">Continue</a>
      </div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
