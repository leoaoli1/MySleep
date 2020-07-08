<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author:Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');
require_once('utilities-diary.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;


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
        <title>MySleep //Game Changer</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php if ($config) {
        require_once('partials/nav-links.php');
        navigationLinkReview($config,$userType);

      }else {?>
		    <ol class="breadcrumb">
    			<li><a href="#" onclick=" location.href='main-page';">Home</a></li>
    			<?php if($userType != "parent"){ ?>
    			    <li><a href="#"  onclick="location.href='sleep-lesson';">Lessons</a></li>
    			    <li><a href="#"  onclick="location.href='fifth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
    			    <li><a href="#"  onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
    			<?php }else{ ?>
    			    <li><a href="#"  onclick="location.href='parent-sleep-lesson';">Lessons</a></li>
    			    <li><a href="#"  onclick="location.href='parent-lesson-menu?lesson=3';">Lesson Three</a></li>
    			    <li><a href="#"  onclick="location.href='parent-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
    			<?php } ?>
    			<li class="active">Game Changer Review</li>
		    </ol>
        <?php } ?>
		    <div class="col-md-offset-1 col-md-9 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			<div class="row">
			    <table class='table'>
				<thead>
                                    <tr>
					<?php
					if($showToClass != 1){
					    echo '<th data-field="firstName">First Name</th>
                                               <th data-field="lastName">Last Name</th>
                                               <th data-field="hypo">Hypothesis</th>
                                               <th data-field="player">Player</th>
                                               <th data-field="improvement">Did the player improve?</th>
                                               <th data-field="support">Did the data support your hypothesis?</th>
                                               <th data-field="gameChanger">Why can sleep be called a game changer?</th>
                                               <th data-field="submitTime">Submitted</th>';
					}else{
					    echo '<th data-field="id" data-sortable="true">ID</th>
                                               <th data-field="hypo">Hypothesis</th>
                                               <th data-field="player">Player</th>
                                               <th data-field="improvement">Did the player improve?</th>
                                               <th data-field="support">Did the data support your hypothesis?</th>
                                               <th data-field="gameChanger">Why can sleep be called a game changer?</th>';
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
						$result = mysql_query("SELECT  *  FROM gameChanger WHERE userId='$studentId' and submit=1");
						echo "<tr>";
						echo "<td>".$firstname."</td>";
						echo "<td>".$lastname."</td>";
						echo "</tr>";
						while($row = mysql_fetch_array($result)){

						    $submitTime = $row['submitTime'];

                                                    echo "<tr>";
                                                    echo "<td></td>";
                                                    echo "<td></td>";
						    echo "<td>".$row['hypothesis']."</td>";
                                                    echo "<td>".$row['player']."</td>";
                                                    echo "<td>".$row['improvement']."</td>";
						    echo "<td>".$row['support']."</td>";
                                                    echo "<td>".$row['gameChanger']."</td>";
                                                    echo "<td>".$submitTime."</td>";
                                                    echo "</tr>";

						}
					    }else{
						$result = mysql_query("SELECT * FROM gameChanger WHERE userId='$studentId' and submit=1 order by recordId desc limit 1");
						while($row = mysql_fetch_array($result)){
						    $submitTime = $row['submitTime'];
						    $id += 1;
						    echo "<tr>";
						    echo "<td>".$id."</td>";
						    echo "<td>".$row['hypothesis']."</td>";
                                                    echo "<td>".$row['player']."</td>";
                                                    echo "<td>".$row['improvement']."</td>";
						    echo "<td>".$row['support']."</td>";
                                                    echo "<td>".$row['gameChanger']."</td>";
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
