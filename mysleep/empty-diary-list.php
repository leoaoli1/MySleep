<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
$diary = $_GET['diary'];
echo "<option value='null' disabled selected>Please Choose A Diary Date</option>";
if(isset($_POST['studentId'])){
    include 'connectdb.php';
    $selectId =  $_POST['studentId'];
    
    if($diary == 'sleep'){
	$table = "diary_data_table";
    }else{
	$table = "activity_diary_data_table";
    }
    $queryCommand = "SELECT * FROM " . $table . " where userId='$selectId' AND timeCompleted IS NULL ORDER BY diaryDate";
    $result = mysql_query($queryCommand);
    while ($row = mysql_fetch_array($result))
    {
	$diaryId = $row['diaryId'];
	echo "<option value=".$diaryId.">". date('D m-d-y', strtotime($row['diaryDate']))."</option>";
    }

    mysql_close($con);
}
exit;
?>
