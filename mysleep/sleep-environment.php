<!DOCTYPE html>
<?PHP

require_once('utilities.php');
checkAuth();

$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$classId = $_SESSION['classId'];
$userType = $_SESSION['userType'];
$activityId = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);//basename($_SERVER['PHP_SELF']);
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$configs = getActivityConfigWithNumbers($lessonNum, $activityNum);
include "connectdb.php";

$classmats = getUserIdsInClass($classId);

if ($userType == 'teacher') {
    $result = mysql_query("SELECT pictureId, promoteGoodSleep, preventGoodSleep, groupMember, contributors FROM sleepEnvironment WHERE userId='$userId' ORDER BY recordId");
} else {
    $result = mysql_query("SELECT pictureId, promoteGoodSleep, preventGoodSleep, groupMember, contributors FROM sleepEnvironment WHERE contributors LIKE '%$userId%' ORDER BY recordId");
}
$promote = array_fill(1, 8, '');
$prevent = array_fill(1, 8, '');
$contributors = array_fill(1, 8, '');
while($row=mysql_fetch_array($result)){
  $promote[$row['pictureId']] = $row['promoteGoodSleep'];
  $prevent[$row['pictureId']] = $row['preventGoodSleep'];
  $contributors[$row['pictureId']] = explode(",", $row['contributors']);
  // debugToConsole('members', $groupMemberOne);
}

mysql_close($con);
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php require 'partials/header.php' ?>
        <title>MySleep // Sleep Environment</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php
                    require_once('partials/nav-links.php');
                    navigationLink($configs,$userType);
                     ?>
                    <div class="row">
                  			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
                  			    <div class="header header-success">
                        				<div class="nav-tabs-navigation">
                        				    <div class="nav-tabs-wrapper">
                              					<ul class="nav nav-tabs nav-tabs-gradpr" data-tabs="tabs">
                                          <?php
                                          // nav-tabs
                                            for ($i=1; $i <=8 ; $i++) {
                                              $index = num2word($i);
                                              echo ($i==1? '<li class="active">':'<li>');
                                              echo '<a href="#'.$index.'" data-toggle="tab">';
                                              echo '<i class="material-icons">filter_'.$i.'</i>';
                                              echo $index;
                                              echo '</a>';
                                            }
                                           ?>
                              					</ul>
                        				    </div>
                        				</div>
                  			    </div>
                  			    <div class="content">
                    				<div class="tab-content">
                              <?php
                              // nav-tabs
                                for ($i=1; $i <=8 ; $i++) {
                                  $tabIndex = num2word($i);
                                  echo ($i==1? '<div class="tab-pane active"':'<div class="tab-pane"'); echo 'id="'.$tabIndex.'">';
                                  ?>
                                  <div class="row">
                            				<img src="images/environment/environment<?php echo $i; ?>.png" class="img-responsive col-md-offset-1 col-md-10 col-sm-offset-3 col-sm-6" style="padding-top:1em">
                                  </div>
                                  <form action="sleep-environment-done" method="post">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <a id="addContributor<?php echo $i; ?>" class="btn btn-gradorange btn-roundThin btn-large btn-block" <?php if (!$configs||$configs['group_feature']!=1){echo 'style="display: none"';}  ?>><i class="material-icons">group_add</i><b> Group Members</b></a>
                                            <div id="contributorContent<?php echo $i; ?>" class="popover fade bottom in">
                                                <div class="arrow" style="left: 9.375%;"></div>
                                                <div class="popover-content">
                                                  <?php
                                                    include 'connectdb.php';
                                                    require_once 'utilities.php';
                                                    foreach($classmats as $studentId) {
                                                        list($firstname, $lastname) = getUserFirstLastNames($studentId);
                                                        if ($userId == $studentId || in_array($studentId, $contributors[$i])) {
                                                          echo '<input type="checkbox" name="contributor[]" value="'.$studentId.'" checked>'.$firstname.' '.$lastname.'<br>';
                                                        }else {
                                                          echo '<input type="checkbox" name="contributor[]" value="'.$studentId.'">'.$firstname.' '.$lastname.'<br>';
                                                        }
                                                    }
                                                    mysql_close($con);
                                                   ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table" style="padding-top:1em">
                          						<thead>
                        						    <tr>
                        							    <th>Factors that promote good sleep</th><th>Factors that prevent good sleep</th>
                        						    </tr>
                          						</thead>
                          						<tbody>
                        						    <tr>
                    	                    <td><textarea class="form-control input-lg" name="promoteGoodSleep" rows="5"><?php echo $promote[$i] ?></textarea></td><td><textarea class="form-control input-lg" name="preventGoodSleep" rows="5"><?php echo $prevent[$i] ?></textarea></td>
                        						    </tr>
                          						</tbody>
                      					    </table>
                    					    <input type="text" name="pictureId" value="<?php echo $i; ?>" style="display: none">
                    					    <div class="row" style="padding-top: 1cm;">
                        						<div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                        						  <button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="save">Save</button>
                        						</div>
                        						<div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                        						  <button class="btn btn-gradpr btn-roundBold btn-large btn-block" type="submit" name="submit">Submit</button>
                        						</div>
                    					    </div>
                    					   </form>
                    				    </div>
                              <?php } ?>
                    				</div>
                  			 </div>
                  		</div>
		               </div>
                </div>
            </div>
            <?php require 'partials/footer.php' ?>
        </div>
	      <?php require 'partials/scripts.php' ?>
        <script>

            $('#addContributor1').click(function(){
                var $target = $('#contributorContent1');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor2').click(function(){
                var $target = $('#contributorContent2');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor3').click(function(){
                var $target = $('#contributorContent3');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor4').click(function(){
                var $target = $('#contributorContent4');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor5').click(function(){
                var $target = $('#contributorContent5');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor6').click(function(){
                var $target = $('#contributorContent6');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor7').click(function(){
                var $target = $('#contributorContent7');
                $target.toggle(!$target.is(':visible'));
            });
            $('#addContributor8').click(function(){
                var $target = $('#contributorContent8');
                $target.toggle(!$target.is(':visible'));
            });

        </script>
    </body>
</html>
