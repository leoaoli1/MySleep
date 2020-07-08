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

if (isset($_POST['quit'])) {
    header("Location: fifth-grade-lesson-activity-menu?lesson=1&activity=2");
    exit;
   }
if(empty($_POST['image_order'])) {
	header("Location:age-sleep-hour-test.php");
	exit;
}

$classId = $_SESSION['classId'];
$query = $_POST['query'];
$resultRow = $_POST['resultRow'];
$contributor = $_POST["contributor"];
$contributors = join(",", $contributor);
$location = "age-sleep-hour-test?".$query;

$image_order = $_POST['image_order'];
$image_list=explode(',',$image_order);
//print_r($image_list);
$hours_order = $_POST['hours_order'];
$hours_list=explode(',',$hours_order);
//print_r($hours_list);

$image_age_db =[];
$hours_db =[];

for($i = 0, $size = count($image_list); $i < $size; $i++) {
   if ($image_list[$i] == 0){
	   $image_age_db[]='S_1_2_years_old';
	   $hours_db[] = get_age($hours_list[$i]);
   }
   elseif($image_list[$i] == 1){
	   $image_age_db[]='S_3_5_years_old';
	   $hours_db[] = get_age($hours_list[$i]);
   }
   elseif($image_list[$i] == 2){
	   $image_age_db[]='S_6_13_years_old';
	   $hours_db[] = get_age($hours_list[$i]);
   }
   elseif($image_list[$i] == 3){
	   $image_age_db[]='S_14_17_years_old';
	   $hours_db[] = get_age($hours_list[$i]);
   }
   elseif($image_list[$i] == 4){
	   $image_age_db[]='S_18_64_years_old';
	   $hours_db[] = get_age($hours_list[$i]);
   }
   elseif($image_list[$i] == 5){
	   $image_age_db[]='S_65_years_and_older';
	   $hours_db[] = get_age($hours_list[$i]);
   }
}
/*
print_r($image_age_db);
print_r($hours_db);
echo $image_age_db[0];
echo $image_age_db[1];
echo $hours_db[0];
echo $hours_db[1];
*/
/*-----------------------------------------------*/
/*				Save to MySQL                    */
/*-----------------------------------------------*/
include 'connectdb.php';
$result = mysql_query("SELECT * FROM age_sleep_hours_test_answers_table WHERE userId='$userId'");
$row = mysql_fetch_array($result);
if ($row) {
    $status = mysql_query("UPDATE age_sleep_hours_test_answers_table SET $image_age_db[0]='$hours_db[0]', $image_age_db[1]='$hours_db[1]', $image_age_db[2]='$hours_db[2]', $image_age_db[3]='$hours_db[3]', $image_age_db[4]='$hours_db[4]', $image_age_db[5]='$hours_db[5]', contributors='$contributors', classId='$classId' WHERE resultRow='$resultRow'");
    if (!$status) {
        $message = 'Could not update answers to the database: ' . mysql_error();
        error_exit($message);
    }
}
else {
    $status = mysql_query("INSERT INTO age_sleep_hours_test_answers_table(userId, $image_age_db[0], $image_age_db[1], $image_age_db[2], $image_age_db[3], $image_age_db[4], $image_age_db[5], classId, contributors) VALUES ('$userId','$hours_db[0]','$hours_db[1]', '$hours_db[2]','$hours_db[3]', '$hours_db[4]','$hours_db[5]', '$classId', '$contributors')");
    if (!$status) {
        $message = 'Could not enter answers to the database: ' . mysql_error();
        error_exit($message);
    }
}

mysql_close($con);

/*-----------------------------------------------*/
/*				Function	                     */
/*-----------------------------------------------*/
function get_age($index){
	if($index==0){
		$hours = '7-8';
	}
	elseif($index==1){
		$hours = '7-9';
	}
	elseif($index==2){
		$hours = '8-10';
	}
	elseif($index==3){
		$hours = '9-11';
	}
	elseif($index==4){
		$hours = '10-13';
	}
	elseif($index==5) {
		$hours = '11-14';
	}
	else{
		$hours = '0';
	}
	return $hours;
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
			    <?php

				echo '<h2>Submit successful</h2>';


			    ?>
			</div>
			<div class="col-sm-offset-2 col-sm-8 col-md-6 col-md-offset-3">
        <a class="btn btn-gradbb btn-roundThin btn-large btn-block"  name="Continue" href="<?php echo "lesson-menu?".$query; ?>">Continue</a>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
