<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
require_once('utilities.php');
include 'connectdb.php';
session_start();

$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$userDisplayName = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
if($userId==""){
    header("Location: login");
    exit;
}
$classGrade = $_SESSION['classGrade'];
$classId = $_SESSION['classId'];
$className = getClassName($classId);
if(($userType=='student')&&($classId == null)){
    $message = "Cannot find you class, Please contact your teacher!";
    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'main-page';</script>";
}

$currentGrade = getGrade($userId);
$result = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$row = mysql_fetch_array($result);

$hasConfig = False;
if ($config0 = getActivityConfigWithLesson(0)) {
  $hasConfig = True;
  $titleArray = explode("&z&", $config0['activity_title']);
  $lessonsRecord = $config0['config_id'];
}

$activateInfo = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$activateRow = mysql_fetch_array($activateInfo);
$lessonActivate = [];
$lessonActivate[0] = $activateRow['Lesson_1'];
$lessonActivate[1] = $activateRow['Lesson_2'];
$lessonActivate[2] = $activateRow['Lesson_3'];
$lessonActivate[3] = $activateRow['Lesson_4'];
$lessonActivate[4] = $activateRow['Lesson_5'];
// debugToConsole("ID", $lessonActivate);
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- Material Design Bootstrap -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">

        <?php require 'partials/header.php' ?>
            <title>MySleep // Select Lesson</title>
            <style>
                .btn-rounded{
                    border-radius: 17px;
                }
                .form-control, .form-group .form-control {
                  border-radius: 20px;
                }
                .panel.panel-warning > .panel-heading {
                    background-color: #fff;
                }
                .card {
                    background: #fafafa;
                }

            </style>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <ol class="breadcrumb">
                                    <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                    <li class="active">Lesson Plan</li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-offset-1 col-sm-5 col-md-offset-1 col-md-5">
                            <div style="width:100%; padding:0 0px;">
                              <button class="btn btn-gradbg btn-roundThin btn-block" onclick="location.href='lesson-plan-drag'"><b>Rearrange</b></button>
                            </div>
                          </div>
                          <form action="lesson-plan-done" method="post">
                          <div class="col-xs-5 col-sm-5 col-md-5">
                              <div style="width:100%; padding:0 0px;">
                                   <button class="btn btn-gradpr btn-roundThin btn-large btn-block" id="submit" type="submit"><b>Save</b></button>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
                            <h3><b>Class Name: <?php echo $className; ?></b></h3>
                            <p><strong>Note:</strong> Each lesson can be collapsed and expanded by click <strong>Lesson XX</strong> on the left side.</p>
                            <?php echo $hasConfig; ?>
                          </div>
                        </div>
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <div class="form-group">
                                    <div class="panel-group" id="accordion">
                                    <?php
                                    if ($hasConfig){
                                      echo "<input type='text' name='lessonsRecord' value='".$lessonsRecord."' style='display: none;'>";

                                      for ($i=1; $i <= 5 ; $i++) {
                                        echo '<div class="panel panel-warning">';
                                        echo '<div class="panel-heading panel-gradgray">';

                                            echo '<div class="row">';

                                            echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" style="color:'.num2rgb($i).'"><div class="col-md-3 col-sm-3">';
                                            echo '<h3><b>Lesson '.ucfirst(num2word($i)).'</b></h3>';
                                            echo '</div></a>';
                                            echo '<div class="form-group col-md-9 col-sm-9" style="padding-top: 1em;margin:0;"><input type="text" style="text-align:center;" class="form-control input-lg" name="lessonTitle[]" value="'.$titleArray[$i-1].'"></div>';
                                            echo '</div>';
                                            echo '<div class="togglebutton"><label>Activate/Deactivate this lesson: ';
                                            echo '<input type="checkbox" name="Lesson'.$i.'-checkbox"'.($lessonActivate[$i-1]==1 ? 'checked' : '0').'>';
                                            echo '</label></div>';

                                        echo '</div>';
                                        echo '</div>';

                                        echo '<div id="collapse'.$i.'" class="panel-collapse collapse in">';
                                        echo '<div class="panel-body">';
                                        echo '<div class="row">';
                                        $configs = getAllActivityConfigWithLesson($i);
                                        while ($row = mysql_fetch_array($configs)) {
                                          echo "<input type='text' name='activityRecord[]' value='".$row['config_id']."' style='display: none;'>";
                                          ?>
                                          <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
                                            <div class="card" style="width: 100%;margin-bottom: 1em;">
                                              <div class="card-block col-md-12 col-sm-12">
                                                  <h4 class="card-title">Activity <?php echo ucfirst(num2word($row['activity_num'])); ?></h4>
                                                  <h4 class="card-text"><?php echo $row['description']; ?></h4>
                                                  <?php
                                                    $isPortal = $row['activity_type']=='portal';
                                                  ?>
                                                  <div class='form-group col-md-offset-1 col-md-11 col-md-offset-1 col-sm-11' style='padding:0;margin:0;padding-top: 1em;'>

                                                      <div class="row">
                                                          <div style='margin-bottom: 1em;'>
                                                              <div class="col-md-3 col-sm-3" style="padding-top: 0.8em;">
                                                                  <b>Activity Title</b>
                                                              </div>
                                                              <div class="col-md-9 col-sm-9">
                                                                  <input type='text' style="text-align:center;" class='form-control input-lg' name='activityTitle[]' value="<?php echo ucfirst($row['activity_title']); ?>" />
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row" style='margin-bottom: 1em;<?php if ($isPortal) {echo "display: none;";} ?>'>
                                                          <div class="col-md-3 col-sm-3" style="padding-top: 0.8em;">
                                                              <b>Team Work</b>
                                                          </div>
                                                          <div class="togglebutton col-md-9 col-sm-9" style="padding-top: 0.8em;">
                                                					    <label>
                                                                Off
                                                						      <input type="checkbox" name="groupFeature[] " value="<?php echo $row['config_id'];?>" <?php echo ($row['group_feature']==1 ? 'checked' : '0');?>>
                                                                On
                                                					    </label>
                                                					</div>
                                                      </div>

                                                      <div class="row" style='margin-bottom: 1em;<?php if ($isPortal) {echo "display: none;";} ?>'>
                                                          <div class="col-md-3 col-sm-3" style="padding-top: 0.8em;">
                                                              <b>Grade Type</b>
                                                          </div>
                                                          <div class="col-md-9 col-sm-9">
                                                              <div class="btn-group" data-toggle="buttons">
                                                                  <label class="btn btn-primary btn-rounded btn-sm <?php echo ($row['gradable']==0 ? 'active' : '');?> form-check-label">
                                                                      <input class="form-check-input" type="radio" name="<?php echo $row['config_id'];?>Gradable" value=0 <?php echo ($row['gradable']==0 ? 'checked' : '');?>>None
                                                                  </label>
                                                                  <label class="btn btn-primary btn-rounded  btn-sm <?php echo ($row['gradable']==1 ? 'active' : '');?> form-check-label">
                                                                      <input class="form-check-input" type="radio" name="<?php echo $row['config_id'];?>Gradable" value=1 <?php echo ($row['gradable']==1 ? 'checked' : '');?>>Score
                                                                  </label>
                                                                  <!-- <label class="btn btn-primary btn-rounded  btn-sm <?php echo ($row['gradable']==2 ? 'active' : '');?> form-check-label">
                                                                      <input class="form-check-input" type="radio" name="<?php echo $row['config_id'];?>Gradable" value=2 <?php echo ($row['gradable']==2 ? 'checked' : '');?>>Complete
                                                                  </label> -->
                                                              </div>
                                                          </div>
                                                      </div>

                                                  </div>
                                              </div>
                                            </div>
                                    			</div>
                                          <?php
                                        }
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                      }
                                    }?>
                                </div>
                                <div class="row">
                              			<div class="col-xs-offset-4 col-xs-4 col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4">
                                      <div style="width:100%; padding:0 0px;">
                                           <input class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="submit" value="Save"/>
                                      </div>
                              			</div>
                        		    </div>
                            </div>
                        </form>
                  </div>
             </div>
        <?php include 'partials/footer.php' ?>
        </div>

		<?php mysql_close($con); ?>
    </body>
    <?php include 'partials/scripts.php' ?>

</html>
