<?php
include 'connectdb.php';
require_once 'utilities.php';
$classId = $_SESSION['classId'];
$classmats = getUserIdsInClass($classId);
$config = $_SESSION['current_config'];
$currentWork = $_SESSION['current_work'];
$contributors = explode(",", $currentWork['contributors']);
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <a id="addContributor" class="btn btn-gradorange btn-roundThin btn-large btn-block" <?php if (!$config||$config['group_feature']!=1){echo 'style="display: none"';}  ?>><i class="material-icons">group_add</i><b> Group Members</b></a>
        <div id="contributorContent" class="popover fade bottom in">
            <div class="arrow" style="left: 9.375%;"></div>
            <div class="popover-content">
              <?php

                foreach($classmats as $studentId) {
                    list($firstname, $lastname) = getUserFirstLastNames($studentId);
                    if ($userId == $studentId || in_array($studentId, $contributors)) {
                      echo '<input type="checkbox" id="contributor_id" name="contributor[]" value="'.$studentId.'" checked>'.$firstname.' '.$lastname.'<br>';
                    }else {
                      echo '<input type="checkbox" id="contributor_id" name="contributor[]" value="'.$studentId.'">'.$firstname.' '.$lastname.'<br>';
                    }
                }
                mysql_close($con);
               ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#addContributor').click(function(){
    var $target = $('#contributorContent');
    $target.toggle(!$target.is(':visible'));
});
</script>
