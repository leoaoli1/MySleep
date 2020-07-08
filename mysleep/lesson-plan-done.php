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
            $lessonsRecord = $_POST['lessonsRecord'];
            $lessonsTitle = mysql_real_escape_string(join('&z&',$_POST['lessonTitle']));
            $update_query = "UPDATE class_config SET activity_title = '$lessonsTitle' WHERE config_id = '$lessonsRecord'";
            mysql_query($update_query);

            $activityRecord = $_POST['activityRecord'];
            $activityTitle = $_POST['activityTitle'];
            $groupFeature = $_POST['groupFeature'];

            // $score = $_POST['score'];
            // $comment = $_POST['comment'];
            // $query = $_POST['query'];
            // $recordID = explode(',',ltrim($_POST['records'], ','));
    		    /*-----------------------------------------------*/
    		    /*				Save to MySQL        */
    		    /*-----------------------------------------------*/
            $grabe = '';
            $update_query = "UPDATE class_config SET ";
            $columns = Array('activity_title' => 'activity_title = CASE ', 'group_feature' => 'group_feature = CASE ', 'gradable' => 'gradable = CASE ');
            foreach ($activityRecord as $index => $id) {
              $columns['activity_title'] .= "WHEN config_id='" .$id. "' THEN '" . mysql_real_escape_string($activityTitle[$index]) . "' ";
              $columns['group_feature'] .= "WHEN config_id='" . $id . "' THEN '" . (in_array($id,$groupFeature)?'1':'0') . "' ";
              $columns['gradable'] .= "WHEN config_id='" . $id . "' THEN '" . $_POST[$id.'Gradable'] . "' ";
              $grabe .= $_POST[$id.'Gradable'];
            }
            foreach($columns as $column_name => $query_part){
              $columns[$column_name] .= " ELSE '$column_name' END ";
            }
            $where = " WHERE config_id='" . implode("' OR config_id='", $activityRecord) . "'";
            $update_query .= implode(', ',$columns) . $where;
            $status = mysql_query($update_query);

            /*-----------------------------------------------*/
    		    /*  	Save the activate and deactivate info      */
    		    /*-----------------------------------------------*/
            $lesson = [];
            for ($i=0; $i < 5; $i++){
               $num =$i+1;
               if($_POST['Lesson'.$num.'-checkbox'] == 'on'){
                 $lesson[$i] = '1';
               }else{
                 $lesson[$i] = '0';
               }
             }
             mysql_query("UPDATE class_info_table SET Lesson_1='$lesson[0]', Lesson_2='$lesson[1]', Lesson_3='$lesson[2]', Lesson_4='$lesson[3]', Lesson_5='$lesson[4]' WHERE classId='$classId'");

		         mysql_close($con);
        }
		    ?>
		    <div class="row top">
      			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
                <h2>Lesson Plan Saved!</h2>
      			</div>
      			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
                <a class="btn btn-large btn-block"  name="Continue" href="lesson-plan">Continue</a>
      			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>

</html>
