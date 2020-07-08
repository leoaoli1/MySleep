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
if ($userId == ""){
    header("Location: login.php");
    exit;
}
if(empty($_POST['image_order'])) {
	header("Location:animal-card-test.php");
	exit;
}
$classId = $_SESSION['classId'];
$order = $_POST['image_order'];
$query = $_POST['query'];
$imageList = explode(',', $order);
$orderStr= "";
for($i= 0; $i<12; $i++){
    if($i<11){
	$orderStr .= $imageList[$i];
	$orderStr .= ",";
    }else{
	$orderStr .= $imageList[$i];
    }
}



//$image_db =["T_1", "T_2", "T_3", "T_4", "T_5", "T_6", "T_7", "T_8", "T_9", "T_10", "T_11", "T_12"];

/*-----------------------------------------------*/
/*				Save to MySQL                    */
/*-----------------------------------------------*/

include 'connectdb.php';
    $contributor = $_POST["contributor"];
    $contributors = join(",", $contributor);
    $status = mysql_query("INSERT INTO animal_card_test_answers_table(userId, sortResult, contributors, classId) VALUES ('$userId', '$orderStr', '$contributors', '$classId')");
    if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
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
			    <h2>After you finish, wait and your teacher will show you the results from your class.</h2>
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
