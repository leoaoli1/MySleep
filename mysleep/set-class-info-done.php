<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$currentClass = $_SESSION['className'];
if($userId==""){
    header("Location: login.php");
    exit;
}

if (isset($_POST['quit'])) {
    header("Location: admin-tools.php");
    exit;
}
?>
<html>
    <head>
      <?php if (isset($currentClass)): ?>
        <script type="text/javascript">
      	 window.onload = function () {
      	     window.history.go(-1);
      	 }
      	</script>
      <?php endif; ?>
    </head>
    <body>
	<?php
	$className = $_POST['className'];
	if($userType != "teacher"){
	    $schoolId = $_POST['schoolId'];
	}else{
	    $schoolId = $_SESSION['schoolId'];
	}
	$classGrade = $_POST['classGrade'];
	$semester = $_POST['semester'];
	$year = $_POST['year'];
	include 'connectdb.php';

	// Look up the class from table
	$result = mysql_query("SELECT * FROM class_info_table WHERE className='$className' AND schoolNum='$schoolId'");
	$rowCount = mysql_num_rows($result);

	if ($rowCount > 0) {
    echo "Class already exists: ", $className, "</br>";
	}
	else {
    mysql_query("INSERT INTO class_info_table (className, schoolNum, grade, semester, year, active) VALUES ('$className', '$schoolId', '$classGrade', '$semester', '$year', '1')");
    if($userType == "teacher"){
      // auto connect the current teacher to the new class
  		$result = mysql_query("SELECT classId FROM class_info_table WHERE className='$className'");
  		$row = mysql_fetch_array($result);
  		$classId = $row['classId'];
  		mysql_query("INSERT INTO class_table (userId, classId) VALUES ('$userId','$classId')");
    }
      /* add class config using template */
      $query = '';
      $filename = 'assets/json/class_config_'.$classGrade.'.json';

      //Read the JSON file and stored in a variable
      $data = file_get_contents($filename);
      //Convert JSON string into PHP array format
      $data_array = json_decode($data, true);
      foreach($data_array as $key => $item) {
        $activityTitle = mysql_real_escape_string($item['activity_title']);
        $query = "INSERT INTO class_config (classId, lesson_num, activity_num, activity_type, activity_id, activity_db, activity_title, parent_id, group_feature, gradable, authenticate, actived) VALUES ('$classId','".$item['lesson_num']."','".$item['activity_num']."','".$item['activity_type']."','".$item['activity_id']."','".$item['activity_db']."','$activityTitle','".$item['parent_id']."','".$item['group_feature']."','".$item['gradable']."','".$item['authenticate']."','".$item['actived']."')";
        // echo $query;
        $status = mysql_query($query);
        // echo $status;
      }

	}
	mysql_close($con);
  if (!isset($currentClass)) {
    header("Location: select-school-and-class");
    exit;
  }
	exit;

	?>
    </body>
</html>
