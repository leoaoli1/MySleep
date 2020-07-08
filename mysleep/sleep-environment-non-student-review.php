<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
#
require_once('utilities.php');
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
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
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
                    <?php
                    require_once('partials/nav-links.php');
                    navigationLinkReview($config,$userType);
                     ?>
                    <div class="row">
                        <div >
                    			    <?php if($showToClass != 1){?>
                                <form action="sleep-environment-review-done" method="post">
                    				    <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="false" data-show-columns="false" class="table table-striped">
                    			    <?php }else{?>
                    				        <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" data-sort-name="environment" class="table table-striped">
                    			    <?php }?>
                          			    <thead>
                                      <tr>
                          				    <?php
                            				   if($showToClass != 1){
                                           echo '<th data-field="group" data-sortable="false">Group</th>
                                                  <th data-field="groupMember">Group Members</th>
                             					            <th data-field="environment">Environment</th>
                                                  <th data-field="promote">Factors that promote good sleep</th>
                                                  <th data-field="prevent">Factors that prevent good sleep</th>
                                                  <th data-field="submitTime">Submit Time</th>';
                                          if ($config && $config['gradable']) {
                                            echo '<th data-field="score">Score</th>
                                            <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                                          }

                            				    }else{
                                					echo '<th data-field="group" data-sortable="true">Group</th>
                                					       <th data-field="environment">Environment</th>
                                                 <th data-field="promote">Factors that promote good sleep</th>
                                                 <th data-field="prevent">Factors that prevent good sleep</th>
                                                 <th data-field="groupMember">Group Members</th>
                                                 <th data-field="submitTime">Submit Time</th>';
                            				    }
                          				    ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'connectdb.php';
                                        if(($userType == 'teacher') || ($userType == 'parent')) {
                                            if($userType == 'teacher') {
                                                $resultLink = getUserIdsInClass($classId);
                                            }else {
                                                $resultLink = getLinkedUserIds($userId);
                                            }
                                				    $group = 0;
                                            $records = '';
                                            foreach($resultLink as $studentId) {
                                    					if($showToClass != 1){
                                                  // list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                  $result = mysql_query("SELECT recordId, pictureId, promoteGoodSleep, preventGoodSleep, groupMember, submitTime, comment, score, contributors  FROM sleepEnvironment WHERE userId='$studentId' AND submit = '1'");
                                                  while($row = mysql_fetch_array($result)){
                                                      $contributors = explode(",", $row['contributors']);
                                          						$group += 1;
                                                      $records = $records.','.$row['recordId'];
                                          						echo "<tr>";
                                          						echo "<td>".$group."</td>";
                                                      echo "<td>";//.count($contributors)."</td>";
                                                      foreach ($contributors as $contributor) {
                                                        if (is_numeric($contributor)) {
                                                          list($firstname, $lastname) = getUserFirstLastNames($contributor);
                                                          echo $firstname.' '.$lastname.'<br>';
                                                        }else {
                                                          echo $row['groupMember'];
                                                          break;
                                                        }
                                                      }
                                                      echo "</td>";
                                          						echo "<td>".$row['pictureId']."</td>";
                                                      echo "<td>".$row['promoteGoodSleep']."</td>";
                                                      echo "<td>".$row['preventGoodSleep']."</td>";
                                                      echo "<td>".$row['submitTime']."</td>";
                                                      if ($config && $config['gradable']) {
                                                        echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['recordId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                                        echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['recordId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                                      }


                                          						echo "</tr>";
                                    					    }
                                    					}else{
                                    					    $result = mysql_query("SELECT pictureId, promoteGoodSleep, preventGoodSleep, groupMember, submitTime, contributors FROM sleepEnvironment WHERE userId='$studentId' AND submit = '1'");
                                    					    while($row = mysql_fetch_array($result)){
                                                      $contributors = explode(",", $row['contributors']);
                                                      $group += 1;
                                          						echo "<tr>";
                                          						echo "<td>".$group."</td>";
                                          						echo "<td>".$row['pictureId']."</td>";
                                                      echo "<td>".$row['promoteGoodSleep']."</td>";
                                                      echo "<td>".$row['preventGoodSleep']."</td>";
                                                      echo "<td>";
                                                      foreach ($contributors as $contributor) {
                                                        if (is_numeric($contributor)) {
                                                          list($firstname, $lastname) = getUserFirstLastNames($contributor);
                                                          echo $firstname.' '.$lastname.'<br>';
                                                        }else {
                                                          echo $row['groupMember'];
                                                          break;
                                                        }
                                                      }
                                                      echo "</td>";
                                                      echo "<td>".$row['submitTime']."</td>";
                                          						echo "</tr>";
                                    					    }
                                    					}
                                				    }
                                				}
        			                           mysql_close($con);
                                        ?>
                                    </tbody>
                                </table>
                                <?php if($showToClass != 1 && $config && $config['gradable']){?>
                                  <input type="text" name="records" value="<?php echo $records; ?>" style="display: none">
                                  <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                                  <div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                      						    <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save">Save</button>
                      						</div>
                                </form>
                              <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
