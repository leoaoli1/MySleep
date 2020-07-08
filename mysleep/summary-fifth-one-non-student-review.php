<!DOCTYPE html>
<?php   
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           James Geiger                                                    #
#           Ao Li                                                           #
#                                                                           #
#                                                                           #
# Filename: WorksheetFifthOneNonStudentReview.php                           #
#                                                                           #
# Purpose:                                                                  #
#                                                                           #
#############################################################################

require_once('utilities.php');
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

if ($userType == "teacher"){
    $classId = $_SESSION['classId'];
}
$showToClass = 0;
if(isset($_GET['showToClass'])){
    $showToClass = $_GET['showToClass'];
}

?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Stories Summarizer</title>
    </head>
    
    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="main-page">Home</a></li>
				<?php if($userType != "parent"){?>				    
                                    <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                    <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
				    <li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">Activity Two</a></li>                                    
                                    <li class="active">Review: Stories Summarizer</li>
				    <li class="pull-right"><a href="#" onClick="studentView()">Student View</a></li>
				<?php }else{?>
				    <li><a href="parent-sleep-lesson">Lessons</a></li>
                                    <li><a href="parent-lesson-menu?lesson=1">Lesson One</a></li>
				    <li><a href="parent-lesson-activity-menu?lesson=1&activity=2">Activitie Two</a></li>
                                    <li class="active">Review: Stories Summarizer</li>
				<?php }?>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-to col-sm-10">
			    <?php if($showToClass != 1){?>
				<table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped">
			    <?php }else{?>
				<table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="story" class="table table-striped">
			    <?php }?>						
			    <thead>
                                <tr>
				    <?php 
				    if($showToClass != 1){
					echo '<th data-field="firstName">First Name</th>
                                               <th data-field="lastName">Last Name</th>                                        
                                               <th data-field="summarizer">Summarizer</th>
                                               <th data-field="submitTime">Submitted</th>';
				    }else{
					echo '<th data-field="summarizer">Summarizer</th>';
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
                                            $result = mysql_query("SELECT summary, submitTime FROM fifthGradeLessonOneStorySummary WHERE userId='$studentId' AND submit = '1'");
					    echo "<tr>";
					    echo "<td>".$firstname."</td>";
                                            echo "<td>".$lastname."</td>";
					    echo "</tr>";
					    while($row = mysql_fetch_array($result)){
						
						$submitTime = $row['submitTime'];
						
                                                echo "<tr>";
                                                echo "<td></td>";
                                                echo "<td></td>";
                                                echo "<td>".$row['summary']."</td>";
                                                echo "<td>".$submitTime."</td>";
                                                echo "</tr>";
						
					    }
					}else{
					    $result = mysql_query("SELECT summary, submitTime FROM fifthGradeLessonOneStorySummary WHERE userId='$studentId' AND submit = '1' order by recordId desc limit 1");
					    while($row = mysql_fetch_array($result)){
						$submitTime = $row['submitTime'];
						$group += 1;
						echo "<tr>";                           
						echo "<td>".$row['summary']."</td>";
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
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
      function studentView(){
         window.open("./summary-fifth-one");
	 }
      </script>
</html>
