<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright


  $databaseName = 'zprofile';
  $homePage = 'zprofile';

	require_once('utilities.php');
	session_start();
	$userId= $_SESSION['userId'];
	$classId=$_SESSION['classId'];

	 $query = $_POST['query'];
	 $resultRow = $_POST['resultRow'];
	 $contributor = $_POST["contributor"];
	 $contributors = join(",", $contributor);
   $submit = 1;

   include 'connectdb.php';
   $caseID = $_POST["caseID"];
  	$q1 ="";
  	$q1 = mysql_real_escape_string($_POST["q1"]);
    $q2 ="";
  	$q2 = mysql_real_escape_string($_POST['q2']);
    $q3 ="";
  	$q3 = mysql_real_escape_string($_POST["q3"]);
    $q4 ="";
  	$q4 = mysql_real_escape_string($_POST["q4"]);
    $q5 ="";
  	$q5 = mysql_real_escape_string($_POST["q5"]);
    $q6 ="";
  	$q6 = mysql_real_escape_string($_POST["q6"]);
    $pattern = $_POST["patternDiv"];

	$result = mysql_query("SELECT * FROM $databaseName WHERE resultRow='$resultRow'");
	$numRow = mysql_num_rows ($result);

	if ($numRow>0) {
    $row = mysql_fetch_array($result);
    $submit = $row['submit'] || $submit;
    	$status = mysql_query("UPDATE $databaseName SET caseID='$caseID', q1='$q1', q2='$q2', q3='$q3', q4='$q4', q5='$q5', q6='$q6', contributors='$contributors', submit = '$submit'  WHERE resultRow='$resultRow'");
    	if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
   	 }
	}
	else {
    	$status = mysql_query("INSERT INTO $databaseName(userId, caseID, q1, q2, q3, q4, q5, q6, pattern, contributors, classId, submit) VALUES ('$userId', '$caseID', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$pattern', '$contributors', '$classId', '$submit')");
    	if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
   	}
	}
	mysql_close($con);

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
