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
        <title>MySleep //Body Changer</title>
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
			    <li><a href="#"  onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4';">Activities Four</a></li>
			<?php }else{ ?>
			    <li><a href="#"  onclick="location.href='parent-sleep-lesson';">Lessons</a></li>
			    <li><a href="#"  onclick="location.href='parent-lesson-menu?lesson=3';">Lesson Three</a></li>
			    <li><a href="#"  onclick="location.href='parent-lesson-activity-menu?lesson=3&activity=4';">Activities Four</a></li>
			<?php } ?>
			<li class="active">Body Changer Review</li>
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
                                               <th>Nervous System</th>                                           
                                               <th>Immune System</th>
                                               <th>Cardiovascular System</th>
                                               <th>Endocrine System</th>';
					}else{
					    echo '<th>Nervous System</th>                                         
                                               <th>Immune System</th>
                                               <th>Cardiovascular System</th>
                                               <th>Endocrine System</th>';
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

						$result =mysql_query("SELECT endocrine FROM bodyChanger where userId='$studentId' AND endocrine!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$endocrine = $row['endocrine'];
						
						$result =mysql_query("SELECT immune FROM bodyChanger where userId='$studentId' AND immune!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$immune = $row['immune'];

						$result =mysql_query("SELECT cardiovascular FROM bodyChanger where userId='$studentId' AND cardiovascular!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$cardiovascular = $row['cardiovascular'];

						$result =mysql_query("SELECT nervous FROM bodyChanger where userId='$studentId' AND nervous!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$nervous = $row['nervous'];
						echo "<tr>";
						echo "<td>".$firstname."</td>";
						echo "<td>".$lastname."</td>";
						echo "<td>".$nervous."</td>";
                                                echo "<td>".$immune."</td>";
                                                echo "<td>".$cardiovascular."</td>";
                                                echo "<td>".$endocrine."</td>";
                                                echo "<td>".$submitTime."</td>";
                                                echo "</tr>";
						
					    }else{
						$result =mysql_query("SELECT endocrine FROM bodyChanger where userId='$studentId' AND endocrine!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$endocrine = $row['endocrine'];
						
						$result =mysql_query("SELECT immune FROM bodyChanger where userId='$studentId' AND immune!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$immune = $row['immune'];

						$result =mysql_query("SELECT cardiovascular FROM bodyChanger where userId='$studentId' AND cardiovascular!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$cardiovascular = $row['cardiovascular'];

						$result =mysql_query("SELECT nervous FROM bodyChanger where userId='$studentId' AND nervous!='null' Order by recordId DESC LIMIT 1");
						$row = mysql_fetch_array($result);
						$nervous = $row['nervous'];

						if(!empty($nervous)||!empty($cardiovascular)||!empty($immune)||!empty($endocrine)){
						    echo "<tr>";
						    echo "<td>".$nervous."</td>";
                                                    echo "<td>".$immune."</td>";
                                                    echo "<td>".$cardiovascular."</td>";
                                                    echo "<td>".$endocrine."</td>";
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
