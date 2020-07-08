<!DOCTYPE html>
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
$userType = $_SESSION['userType'];
if ($userId == ""){
    header("Location: login.php");
    exit;
}
$classId = $_SESSION['classId'];
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
		    <?php
		    if(isset($_POST)){
      			include 'connectdb.php';
            // $lessonsRecord = $_POST['lessonsRecord'];
            // $lessonsTitle = join('&z&',$_POST['lessonTitle']);
            // $update_query = "UPDATE class_config SET activity_title = '$lessonsTitle' WHERE config_id = '$lessonsRecord'";
            // mysql_query($update_query);

            // $activityRecord = $_POST['actInLesson1'];

            // $activityRecord = $_POST['activityRecord'];
            // $activityTitle = $_POST['activityTitle'];
            // $groupFeature = $_POST['groupFeature'];

    		    /*-----------------------------------------------*/
    		    /*				Save to MySQL        */
    		    /*-----------------------------------------------*/
            $allRecord = array();
            $update_query = "UPDATE class_config SET ";
            $columns = Array('lesson_num' => 'lesson_num = CASE ', 'activity_num' => 'activity_num = CASE ');
            for ($i=-2; $i <= 5; $i++) {
              if ($i==-1||$i==0) {
                continue;
              }
            $activityRecord = explode(',',$_POST['actInLesson'.$i]);
              foreach ($activityRecord as $index => $id) {
                if ($id) {
                  $actNum = $index+1;
                  $columns['lesson_num'] .= "WHEN config_id='" .$id. "' THEN '" . $i . "' ";
                  $columns['activity_num'] .= "WHEN config_id='" . $id . "' THEN '" . $actNum . "' ";
                  array_push($allRecord, $id);
                }

              }
            }

            foreach($columns as $column_name => $query_part){
              $columns[$column_name] .= " ELSE '$column_name' END ";
            }
            $where = " WHERE config_id='" . implode("' OR config_id='", $allRecord) . "'";
            $update_query .= implode(', ',$columns) . $where;
            $status = mysql_query($update_query);

  		      mysql_close($con);
        }
		    ?>
		    <div class="row top">
      			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
                <h2>Lesson Plan Saved!</h2>
      			</div>
      			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
                <a class="btn btn-gradbg btn-roundBold btn-large btn-block"  name="Continue" href="lesson-plan-drag">Continue</a>
      			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
