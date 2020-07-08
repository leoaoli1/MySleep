<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
require_once('utilities-diary.php');

include 'connectdb.php';
$result = mysql_query("SELECT * FROM my_actogram");
$totalActIndividual = mysql_num_rows($result)
echo "Total acti individual set: ".$totalActIndividual."!\n"
while ($originalRow = mysql_fetch_array($result)) {
  echo "Processing student with first ID: ".$originalRow[]."!\n"
  accumulateSleepData($rowSleepDiaryToShow, $statsSleep);
}
$row = mysql_fetch_array($result);
if(mysql_num_rows($result)>0) {
list($arrBedTime, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak) = extractSleepWatchData($row);
list($diffBedTime, $diffTotalSleepTime,  $meanTotalSleepTime, $meanTimeItTookToFallAsleep, $meanAverageSleepQuality, $meanNumberOfAwak) = computeSleepWatch($arrBedTime, $arrTotalSleepTime, $arrTimeItTookToFallAsleep, $arrAverageSleepQuality,  $arrNumberOfAwak);
}

$sql = "DELETE FROM my_actogram";
mysql_query($sql,$con);

mysql_close($con);
echo "Done!\n"
?>
