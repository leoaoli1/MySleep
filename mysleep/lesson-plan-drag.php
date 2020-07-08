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
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
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

                  .draggable-list {
                  	background-color: #FEFEFE;
                  	list-style: none;
                  	margin: 0;
                  	min-height: 10px;
                  	padding: 0px;
                  }
                  .draggable-item {
                  	background-color: transparent;
                  	cursor: move;
                  	display: block;
                  	font-weight: bold;
                  	color:#CC0033;
                  	padding-bottom:  4px;
                    padding-top:  6px;
                  	margin: 0px;
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
                              <button class="btn btn-gradbg btn-roundThin btn-small btn-block" onclick="location.href='lesson-plan'"><b>Edit</b></button>
                            </div>
                          </div>
                          <form action="lesson-plan-drag-done" method="post">
                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <div style="width:100%; padding:0 0px;">
                                     <button class="btn btn-gradpr btn-roundThin btn-large btn-block" id="submit"><b>Save</b></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10" style="color:#50514F">
                            <h3><b>Class Name: <?php echo $className; ?></b></h3>
                            <p><strong>Note:</strong> All activity cards are draggable. Drag and drop the card to the location you want. You can edit lesson title, activity title and other activity features by click the edit button above. Please save your modifications before you leave this page. </p>
                          </div>
                        </div>
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <div class="form-group">
                                    <div class="panel-group" id="accordion">
                                    <?php
                                    if ($hasConfig){
                                      $sortableLessons = 5;
                                      for ($i=1; $i <= $sortableLessons ; $i++) {//assume that lesson five is analysis project
                                      echo "<input type='text' id='actInLesson".$i."' name='actInLesson".$i."' value='' style='display: none;'>";

                                            echo '<div class="row">';
                                            echo '<div class="col-md-12 col-sm-12">';
                                            echo '<div style="width:100%; padding:0 0px;">';
                                            echo '<div class="btn-gradgray btn-roundExThin"><h4><b>Lesson '.ucfirst(num2word($i)).': '.ucfirst($titleArray[$i-1]).'</b></h4>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                        echo '<div class="row">';
                                        echo '<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">';
                                        echo '<div class="draggable-list" id="lesson'.$i.'">';
                                        $configs = getAllActivityConfigWithLesson($i);
                                        while ($row = mysql_fetch_array($configs)) {
                                          echo '<div class="draggable-item" id="'.$row['config_id'].'">';
                                          echo "<input type='text' name='activityRecord[]' value='".$row['config_id']."' style='display: none;'>";
                                          ?>
                                            <div class="card" style="width: 100%;margin-bottom: 1em;">
                                              <div class="card-block col-md-12 col-sm-12">
                                                  <h4 class="card-title"><b><?php echo ucfirst($row['activity_title']); ?></b></h4>
                                                  <!-- <h5 class="card-text"><?php echo $row['description']; ?></h5> -->
                                                  <div class='form-group col-md-offset-1 col-md-11 col-md-offset-1 col-sm-11' style='padding:0;margin:0;padding-top: 0em;'>

                                                      <div class="row">
                                                          <div style='margin-bottom: 1em;'>
                                                              <div class="col-md-offset-1 col-md-7 col-sm-offset-1 col-sm-7" style="color: #B5B5B5;">
                                                                  <b><?php
                                                                  if ($row['activity_type']=='normal') {
                                                                    echo 'Type: Activity';
                                                                  }elseif ($row['activity_type']=='assignment') {
                                                                    echo 'Type: Take home assignment';
                                                                  }else {
                                                                    echo 'Type: Teacher analysis tool';
                                                                  }
                                                                  ?></b>
                                                              </div>
                                                          </div>
                                                      </div>


                                                  </div>
                                              </div>
                                            </div>
                                          <?php
                                          echo '</div>';
                                        }
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                      }

                                      // pool
                                      $i = -2;
                                      echo "<input type='text' id='actInLesson".$i."' name='actInLesson".$i."' value='' style='display: none;'>";

                                            echo '<div class="row">';
                                            echo '<div class="col-md-12 col-sm-12">';
                                            echo '<div style="width:100%; padding:0 0px;">';
                                            echo '<div class="btn-gradgray btn-roundExThin"><h4><b>Activity Pool</b></h4>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';

                                        echo '<div class="row">';
                                        echo '<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">';
                                        echo '<div class="draggable-list" id="lesson'.$i.'">';
                                        $configs = getAllActivityConfigWithLesson($i);
                                        while ($row = mysql_fetch_array($configs)) {
                                          echo '<div class="draggable-item" id="'.$row['config_id'].'">';
                                          echo "<input type='text' name='activityRecord[]' value='".$row['config_id']."' style='display: none;'>";
                                          ?>
                                            <div class="card" style="width: 100%;margin-bottom: 1em;">
                                              <div class="card-block col-md-12 col-sm-12">
                                                  <h4 class="card-title"><b><?php echo ucfirst($row['activity_title']); ?></b></h4>
                                                  <!-- <h5 class="card-text"><?php echo $row['description']; ?></h5> -->
                                                  <div class='form-group col-md-offset-1 col-md-11 col-md-offset-1 col-sm-11' style='padding:0;margin:0;padding-top: 0em;'>

                                                      <div class="row">
                                                          <div style='margin-bottom: 1em;'>
                                                              <div class="col-md-offset-1 col-md-7 col-sm-offset-1 col-sm-7" style="color: #B5B5B5;">
                                                                  <b><?php
                                                                  if ($row['activity_type']=='normal') {
                                                                    echo 'Type: Activity';
                                                                  }elseif ($row['activity_type']=='assignment') {
                                                                    echo 'Type: Take home assignment';
                                                                  }else {
                                                                    echo 'Type: Teacher analysis tool';
                                                                  }
                                                                  ?></b>
                                                              </div>
                                                          </div>
                                                      </div>


                                                  </div>
                                              </div>
                                            </div>
                                          <?php
                                          echo '</div>';
                                        }
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }?>
                                </div>

                                <div class="row">
                              			<div class="col-xs-offset-4 col-xs-4 col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4">
                                      <div style="width:100%; padding:0 0px;">
                                           <button class="btn btn-gradpr btn-roundThin btn-large btn-block" id="submit"><b>Save</b></button>
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
    <?php include 'partials/scripts.php' ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
    $(document).ready(function () {
    	$('.container .draggable-list').sortable({
    	connectWith: '.container .draggable-list',
    	});
       $('#submit').click(function() {
         for (var i = -2; i <= <?php echo $sortableLessons ?>; i++) {
           if (i==-1||i==0) {
             continue;
           }
           var itemOrder = $('#lesson'+i).sortable("toArray");
           $('#actInLesson'+i).val(itemOrder.join(','));
         }
        })
    });
    </script>
    </body>


</html>
