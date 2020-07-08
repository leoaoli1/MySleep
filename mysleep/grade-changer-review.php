<?php
require_once('utilities.php');
require_once('utilities-diary.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];
if($userId==""){
    header("Location: login");
    exit;
}
$showToClass = 0;
$showToClass = $_GET['showToClass'];
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Grade Changer</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick=" location.href='main-page';">Home</a></li>
			<?php if($userType != "parent"){ ?>
			    <li><a href="#"  onclick="location.href='sleep-lesson';">Lessons</a></li>
			    <li><a href="#"  onclick="location.href='fifth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
			    <li><a href="#"  onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=3';">Activities Three</a></li>
			<?php }else{ ?>
			    <li><a href="#"  onclick="location.href='parent-sleep-lesson';">Lessons</a></li>
			    <li><a href="#"  onclick="location.href='parent-lesson-menu?lesson=3';">Lesson Three</a></li>
			    <li><a href="#"  onclick="location.href='parent-lesson-activity-menu?lesson=3&activity=3';">Activities Three</a></li>
			<?php } ?>
			<li class="active">Grade Changer Review</li>
		    </ol>
		    <div class="col-md-offset-1 col-md-9 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			<div class="row">
			    <table class='table'>
				<thead>
                                    <tr>
					<?php
					if($showToClass != 1){
					    echo '<th data-field="firstName">First Name</th>
                   <th data-field="lastName">Last Name</th>
                   <th data-field="gradeChanger">Why is sleep called a grade changer?</th>
                   <th data-field="gradeChanger">Hypothesize</th>
                   <th data-field="gradeChanger">Predict B</th>
                   <th data-field="gradeChanger">Predict D/F</th>
                   <th data-field="submitTime">Submitted</th>';
					}else{
					    echo '<th data-field="id" data-sortable="true">ID</th>
                    <th data-field="gradeChanger">Why is sleep called a grade changer?</th>
                    <th data-field="gradeChanger">Hypothesize</th>
                    <th data-field="gradeChanger">Predict B</th>
                    <th data-field="gradeChanger">Predict D/F</th>';
					}
					?>
                                    </tr>
				</thead>
				<tbody>
        <?php
        include 'connectdb.php';
        require_once 'utilities.php';
        if(($userType == 'teacher') || ($userType == 'parent')) {
					if($userType == 'teacher') {
                $resultLink = getUserIdsInClass($classId);
					}else {
                $resultLink = getLinkedUserIds($userId);
					}
					$group = 0;
					foreach($resultLink as $studentId) {
					    if($showToClass != 1){
      						list($firstname, $lastname) = getUserFirstLastNames($studentId);
      						$result = mysql_query("SELECT  *  FROM gradeChanger WHERE userId='$studentId'");
                  echo "<tr>";
                  echo "<td>".$firstname."</td>";
                  echo "<td>".$lastname."</td>";
                  if ($row = mysql_fetch_array($result)) {
                    echo "<td>".$row['responseOne']."</td>";
                    echo "<td>".($row['hypothesis']=='1'? 'Has Relationship':'No Relationship')."</td>";
                    echo "<td>".$row['hypothesizedValueB']."</td>";
                    echo "<td>".$row['hypothesizedValueCD']."</td>";
                    echo "<td>".$row['submitTime']."</td>";
                  }else{
                    echo "<td></td><td></td><td></td><td></td><td>No Submission</td>";
                  }
                  echo "</tr>";
					    }else{
      						$result = mysql_query("SELECT * FROM gradeChanger WHERE userId='$studentId' order by id desc limit 1");
      						while($row = mysql_fetch_array($result)){
      						    $submitTime = $row['submitTime'];
      						    $id += 1;
      						    echo "<tr>";
      						    echo "<td>".$id."</td>";
                      echo "<td>".$row['responseOne']."</td>";
                      echo "<td>".($row['hypothesis']=='1'? 'Has Relationship':'No Relationship')."</td>";
                      echo "<td>".$row['hypothesizedValueB']."</td>";
                      echo "<td>".$row['hypothesizedValueCD']."</td>";
      						    echo "</tr>";
      						}
					    }

					}
				    }

				    mysql_close($con);
                                    ?>
				</tbody>
			    </table>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
    </body>
</html>
