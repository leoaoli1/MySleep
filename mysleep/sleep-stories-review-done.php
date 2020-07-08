<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen 
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
                $score = $_POST['score'];
                $comment = $_POST['comment'];
                $query = $_POST['query'];
                $resultRow = explode(',',ltrim($_POST['records'], ','));
        		    /*-----------------------------------------------*/
        		    /*				Save to MySQL        */
        		    /*-----------------------------------------------*/
                $update_query = "UPDATE fourth_grade_lesson_three_story SET ";
                $columns = Array('score' => 'score = CASE ', 'comment' => 'comment = CASE ');
                foreach ($resultRow as $index => $id) {
                  $columns['score'] .= "WHEN resultRow='" .$id. "' THEN '" . $score[$index] . "' ";
                  $columns['comment'] .= "WHEN resultRow='" . $id . "' THEN '" . $comment[$index] . "' ";
                }
                foreach($columns as $column_name => $query_part){
                  $columns[$column_name] .= " ELSE '$column_name' END ";
                }
                $where = " WHERE resultRow='" . implode("' OR resultRow='", $resultRow) . "'";
                $update_query .= implode(', ',$columns) . $where;
                $status = mysql_query($update_query);
      		      mysql_close($con);
            }
    		    ?>
    		    <div class="row top">
          			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
                    <h2>Score and Comment Saved!</h2>
          			</div>
          			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
                    <a class="btn btn-gradbg btn-large btn-block"  name="Continue" href="sleep-stories-non-student-review<?php echo "?".$query; ?>">Continue</a>
          			</div>
    		    </div>
    		</div>
    	    </div>
    	</div>
  </body>

</html>
