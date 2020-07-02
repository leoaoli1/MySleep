<!DOCTYPE html>
<?php   
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #                          #
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
        <title>MySleep // Review: Stories Worksheet</title>
    </head>
    
    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                        <ol class="breadcrumb">
                            <li><a href="main-page">Home</a></li>
			    <?php if($userType != "parent"){?>				    
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">Activity Two</a></li>                                    
                                <li class="active">Review: Stories Worksheet</li>
				<li class="pull-right"><a href="#" onClick="studentView()">Student View</a></li>
			    <?php }else{?>
				<li><a href="parent-sleep-lesson">Lessons</a></li>
                                <li><a href="parent-lesson-menu?lesson=1">Lesson One</a></li>
				<li><a href="parent-lesson-activity-menu?lesson=1&activity=2">Activitie Two</a></li>
                                <li class="active">Review: Stories Worksheet</li>
			    <?php }?>
                        </ol>
                    </div>
                    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
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
                                               <th data-field="story">Story Number</th>                                           
                                               <th data-field="happen">What happened in the news story?</th>
                                               <th data-field="factor">Who in the story had enough or not enough sleep?</th>
                                               <th data-field="effect">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>
                                               <th data-field="submitTime">Submitted</th>';
				}else{
				    echo '<th data-field="story" data-sortable="true" class="col-md-1 col-sm-1">Story Number</th>                                           
                                               <th data-field="happen" class="col-md-3 col-sm-3">What happened in the news story?</th>
                                               <th data-field="factor" class="col-md-3 col-sm-3">Who in the story had enough or not enough sleep?</th>
                                               <th data-field="effect" class="col-md-3 col-sm-3">What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</th>';
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
                                        $result = mysql_query("SELECT story, happen, factor, affect, submitTime FROM fifthGradeLessonOneWorksheet WHERE userId='$studentId' AND isSubmitted = '1'");
					echo "<tr>";
					echo "<td>".$firstname."</td>";
                                        echo "<td>".$lastname."</td>";
					echo "</tr>";
					while($row = mysql_fetch_array($result)){
					    
					    $submitTime = $row['submitTime'];
					    
                                            echo "<tr>";
                                            echo "<td></td>";
                                            echo "<td></td>";
					    echo "<td>".$row['story']."</td>";
                                            echo "<td>".$row['happen']."</td>";
                                            echo "<td>".$row['factor']."</td>";
                                            echo "<td>".$row['affect']."</td>";
                                            echo "<td>".$submitTime."</td>";
                                            echo "</tr>";
					    
					}
				    }else{
					$result = mysql_query("SELECT story, happen, factor, affect, submitTime FROM fifthGradeLessonOneWorksheet WHERE userId='$studentId' AND isSubmitted = '1' order by uniqueId desc limit 1");
					while($row = mysql_fetch_array($result)){
					    $submitTime = $row['submitTime'];
					    $group += 1;
					    echo "<tr>";                                          
					    echo "<td class='col-md-1 col-sm-1'>".$row['story']."</td>";
					    echo "<td class='col-md-3 col-sm-3'>".$row['happen']."</td>";
                                            echo "<td class='col-md-3 col-sm-3'>".$row['factor']."</td>";
                                            echo "<td class='col-md-3 col-sm-3'>".$row['affect']."</td>";
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
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     function studentView(){
         window.open("./worksheet-fifth-one");
     }
    </script>
</html>
