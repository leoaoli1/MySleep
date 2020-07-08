<!DOCTYPE html>
<?php   
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#############################################################################

require_once('utilities.php');
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];
$diary = $_GET['diary'];
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Practice Diaries</title>
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
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-to col-sm-10">
			    <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" class="table table-striped">			
			    <thead>
                                <tr>
				    <th data-field="firstName">First Name</th>
                                    <th data-field="lastName">Last Name</th>
                                    <th data-field="finish">Finished</th>                                           
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                include 'connectdb.php';
                                require_once 'utilities.php';
				$resultLink = getUserIdsInClass($classId);
				$grade = getClassGrade($classId);
                                foreach($resultLink as $studentId) {
				    list($firstname, $lastname) = getUserFirstLastNames($studentId);
				    
				    if($diary == "activity"){
					$result = mysql_query("SELECT userId FROM practice_activity_diary_data_table where diaryGrade='$grade' AND userId='$studentId' AND timeCompleted IS NOT NULL ORDER BY diaryDate");
				    }elseif($diary == "sleep"){
					$result = mysql_query("SELECT userId FROM practice_diary_data_table where diaryGrade='$grade' AND userId='$studentId' AND timeCompleted IS NOT NULL ORDER BY diaryDate");
				    }
				    echo "<tr>";
				    echo "<td>".$firstname."</td>";
                                    echo "<td>".$lastname."</td>";
				    if(mysql_num_rows($result)>0){
					echo "<td>Yes</td>";
				    }else{
					echo "<td></td>";
				    }
				    echo "</tr>";
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
</html>
