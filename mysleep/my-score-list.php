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
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];

?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Sleep Environment</title>
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
                                <li class="active">My Gradebook</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10 text-center">
                            <h3 class="title">My Gradebook</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                    			    <?php if($showToClass != 1){?>
                    				    <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="false" data-show-columns="false" class="table table-striped">
                    			    <?php }else{?>
                    				        <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="environment" class="table table-striped">
                    			    <?php }?>
                          			    <thead>
                                      <tr>
                                         <th data-field="lesson" data-sortable="false">Lesson</th>
                                         <th data-field="activity">Activity</th>
                                         <th data-field="score">Score</th>
                                         <th data-field="comment"> Comment </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                          include 'connectdb.php';

                                          $gradable = mysql_query("SELECT lesson_num, activity_id, activity_db, activity_title FROM class_config WHERE classId = '$classId' AND gradable = '1' AND actived = '1' ORDER BY lesson_num, activity_num");
                                          while ($activity_config = mysql_fetch_array($gradable)) {
                                            $activityTitle = $activity_config['activity_title'];
                                            $lessonNum = $activity_config['lesson_num'];
                                            $activityDB = $activity_config['activity_db'];
                                            $result = mysql_query("SELECT comment, score  FROM $activityDB WHERE contributors LIKE '%$userId%' AND submit = '1'");
                                            $allRows = mysql_num_rows($result);
                                            $currentRow = 1;
                                            while($row = mysql_fetch_array($result)){
                                              if ($currentRow == $allRows) {
                                                $lessonString = $lessonNum;
                                                if ($lessonNum<=0) {
                                                  $lessonString = '';
                                                }
                                                echo "<tr>";
                                                echo "<td>".$lessonString." </td>";
                                                echo "<td>$activityTitle</td>";
                                                echo "<td>".$row['score']."</td>";
                                                echo "<td>".$row['comment']."</td>";
                                                echo "</tr>";
                                              }
                                              $currentRow++;
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
</html>
