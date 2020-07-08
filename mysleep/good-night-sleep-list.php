<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
session_start();
$userId= $_SESSION['userId'];
if(isset($_POST['categories'])){
    include 'connectdb.php';
    $categories = $_POST['categories'];
    if($categories == '1'){
	$category = 'familyRoutines';
	$resultPrivous = mysql_query("SELECT familyRoutinesHardChange, familyRoutinesEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$userId' AND familyRoutinesHardChange IS NOT NULL order by recordId DESC Limit 1");
	$rowPrivous = mysql_fetch_array($resultPrivous); 
	$arrPrivousHardList = $rowPrivous["familyRoutinesHardChange"];
	$arrPrivousEasyList = $rowPrivous["familyRoutinesEasyChange"];
	$hardPrivous = unserialize(base64_decode($arrPrivousHardList));
	$easyPrivous = unserialize(base64_decode($arrPrivousEasyList));
	$resultSubmit = mysql_query("SELECT familyRoutinesHardChange, familyRoutinesEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$userId' AND familyRoutinesHardChange IS NOT NULL AND submit='1'");
	$submitTimes = mysql_num_rows($resultSubmit);
    }elseif($categories == '2'){
	$category = 'activities';
	$resultPrivous = mysql_query("SELECT activitiesHardChange, activitiesEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$userId' AND activitiesEasyChange IS NOT NULL order by recordId DESC Limit 1");
	$rowPrivous = mysql_fetch_array($resultPrivous); 
	$arrPrivousHardList = $rowPrivous["activitiesHardChange"];
	$arrPrivousEasyList = $rowPrivous["activitiesEasyChange"];
	$hardPrivous = unserialize(base64_decode($arrPrivousHardList));
	$easyPrivous = unserialize(base64_decode($arrPrivousEasyList));
	$resultSubmit = mysql_query("SELECT activitiesHardChange, activitiesEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$userId' AND activitiesEasyChange IS NOT NULL AND submit='1'");
	$submitTimes = mysql_num_rows($resultSubmit);
    }elseif($categories == '3'){
	$category = 'environment';
	$resultPrivous = mysql_query("SELECT environmentHardChange, environmentEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$userId' AND environmentEasyChange IS NOT NULL order by recordId DESC Limit 1");
	$rowPrivous = mysql_fetch_array($resultPrivous); 
	$arrPrivousHardList = $rowPrivous["environmentHardChange"];
	$arrPrivousEasyList = $rowPrivous["environmentEasyChange"];
	$hardPrivous = unserialize(base64_decode($arrPrivousHardList));
	$easyPrivous = unserialize(base64_decode($arrPrivousEasyList));
	$resultSubmit = mysql_query("SELECT environmentHardChange, environmentEasyChange FROM fourthGradeLessonThreeTableThree WHERE userId='$userId' AND environmentEasyChange IS NOT NULL AND submit='1'");
	$submitTimes = mysql_num_rows($resultSubmit);
    }
    if(empty($arrPrivousHardList)&&empty($arrPrivousHardList)){
	$easyOneList = "<option value='null' disabled selected>Please Select</option>";
	$easyTwoList = "<option value='null' disabled selected>Please Select</option>";
	$easyThreeList = "<option value='null' disabled selected>Please Select</option>";
	$hardOneList = "<option value='null' disabled selected>Please Select</option>";
	$hardTwoList = "<option value='null' disabled selected>Please Select</option>";
	$hardThreeList = "<option value='null' disabled selected>Please Select</option>";
    }else{
	$easyOneList = "<option value='".$easyPrivous[0]."'>".$easyPrivous[0]."</option>";
	$easyTwoList = "<option value='".$easyPrivous[1]."'>".$easyPrivous[1]."</option>";
	$easyThreeList = "<option value='".$easyPrivous[2]."'>".$easyPrivous[2]."</option>";
	$hardOneList = "<option value='".$hardPrivous[0]."'>".$hardPrivous[0]."</option>";
	$hardTwoList = "<option value='".$hardPrivous[1]."'>".$hardPrivous[1]."</option>";
	$hardThreeList = "<option value='".$hardPrivous[2]."'>".$hardPrivous[2]."</option>";
    }
    $query = "SELECT ".$category." FROM fourthGradeLessonThreeTableTwo WHERE userId='$userId' AND submit='1' order by recordId DESC Limit 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result); 
    $arrList = $row[$category];
    $answers = unserialize(base64_decode($arrList));
    
    foreach($answers as $answer){
	$tmpList = "<option value='".$answer."'>".$answer."</option>";
	$stList .= $tmpList;
    }
    $easyOneList .= $stList;
    $easyTwoList .= $stList;
    $easyThreeList .= $stList;
    $hardOneList .= $stList;
    $hardTwoList .= $stList;
    $hardThreeList .= $stList;
    echo json_encode(
	array("easyOneList" => $easyOneList,
	    "easyTwoList" => $easyTwoList,
	    "easyThreeList" => $easyThreeList,
	    "hardOneList" => $hardOneList,
	      "hardTwoList" => $hardTwoList,
	      "hardThreeList" => $hardThreeList,
	      "submitTimes" => $submitTimes
	)
	);
    mysql_close($con);
}
exit;
?>
