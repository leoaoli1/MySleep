<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
require_once('utilities.php');
session_start();
unset($_SESSION['current_config']);
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if($userType == 'teacher'){
    $showClass = $_GET['showToClass'];
    $lessonNum = $_GET['lesson'];
    $activityNum = $_GET['activity'];
    $config = getActivityConfigWithNumbers($lessonNum, $activityNum);
    $query = $_SERVER['QUERY_STRING'];
}
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep // Animal Card Review</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php
      require_once('partials/nav-links.php');
      navigationLinkReview($config,$userType);
       ?>
        <!-- <form action="sleep-environment-review-done" method="post"> -->
        <?php if($showClass == "0" && $config && $config['gradable']){?>
            <form action="animal-card-test-review-done" method="post">
        <?php } ?>
		    <table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" id="result" class="table table-striped table-hover">
    			<thead>
    			    <tr>
        				<?php
        				if(($userType == 'teacher' && $showClass == 0) || ($userType == 'parent')) {
        				    echo "<th>Name</th><th>1st</th><th>2nd</th><th>3rd</th><th>4th</th><th>5th</th><th>6th</th><th>7th</th><th>8th</th><th>9th</th><th>10th</th><th>11th</th><th>12th</th><th>Submit Time</th>";
                    if ($userType == 'teacher' && $config && $config['gradable']) {
                      echo '<th data-field="score">Score</th>
                      <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                    }
        				}elseif(($userType == 'researcher')){
        		  		    echo "<th>User ID</th><th>1st</th><th>2nd</th><th>3rd</th><th>4th</th><th>5th</th><th>6th</th><th>7th</th><th>8th</th><th>9th</th><th>10th</th><th>11th</th><th>12th</th><th>Submit Time</th>";
        				}elseif(($userType == 'teacher' && $showClass == 1)){
        				    echo "<th></th><th>1st</th><th>2nd</th><th>3rd</th><th>4th</th><th>5th</th><th>6th</th><th>7th</th><th>8th</th><th>9th</th><th>10th</th><th>11th</th><th>12th</th>";
        				}
        				?>
    			    </tr>
    			</thead>
			<tbody>
			    <?php
        		    include 'connectdb.php';
			    require_once('utilities.php');
			    if(($userType == 'teacher' && $showClass == 0) || ($userType == 'parent')) {
              if($userType == 'teacher') {
                  $classId = $_SESSION['classId'];
                  if ($config) {
                      $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE resultRow IN ( SELECT MAX(resultRow) FROM animal_card_test_answers_table GROUP BY contributors) AND classId='$classId' and submit='1' ORDER BY resultRow");

                  } else {
                      $resultLink = getUserIdsInClass($classId);
                      $students = join("','",$resultLink);
                      $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
                  }
              } else {
                  $resultLink = getLinkedUserIds($userId);
                  $students = join("','",$resultLink);
                  $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
              }
              while($row = mysql_fetch_array($result)) {
                    $records = $records.','.$row['resultRow'];
                    echo "<tr>";
                    if ($config) {
                        $name = getGroupUserNames($row['contributors']);
                    } else {
                        list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                        $name = $firstname.' '.$lastname;
                    }
                    echo "<td>".$name."</td>";

                   $order = explode(",", $row['sortResult']);
                    foreach($order as $animalName){
                          echo "<td>".$animalName."</td>";
                    }
                    echo "<td>".$row['submitTime']."</td>";
                    if ($userType == 'teacher' && $config && $config['gradable']) {
                      echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['resultRow'].'" rows="1">'.$row['score'].'</textarea></td>';
                      echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['resultRow'].'" rows="3">'.$row['comment'].'</textarea></td>';
                    }
                    echo "</tr>";
               }

	    		    }elseif($userType == 'researcher'){
				$resultLink = getStudentUserIds();
	    	 		foreach($resultLink as $studentId) {
		        	    echo "<tr>";
		    	  	    $student_id = $row['userId'];
       				    $currentClassNum = getStudentClassId($studentId);
       				    $currentYearSemester = getStudentSemesterYear($studentId);
       				    echo "<td>" .'4zfactor'.$currentYearSemester.$currentClassNum.$studentId. "</td>";
      				    echo "</tr>";
		    	  	    $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId='$studentId' order by resultRow");
      				    while($row = mysql_fetch_array($result)){
        					echo "<tr>";
        					echo "<td></td>";
        		    			$order = explode(",", $row['sortResult']);
        		            		foreach($order as $animalName){
        			                    echo "<td>".$animalName."</td>";

        					}
        					echo "<td>".$row['submitTime']."</td>";
        					echo "</tr>";
				    }
				}
      }elseif($userType == 'teacher' && $showClass == 1){
        $classId = $_SESSION['classId'];
        if ($config) {
            $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE resultRow IN ( SELECT MAX(resultRow) FROM animal_card_test_answers_table GROUP BY contributors) AND classId='$classId' and submit='1' ORDER BY resultRow");

        } else {
            $resultLink = getUserIdsInClass($classId);
            $students = join("','",$resultLink);
            $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
        }
				// Data structure
				$statistic = array(
				    'cow' => array_fill(0, 12, 0),
				    'duck' => array_fill(0, 12, 0),
				    'horse' => array_fill(0, 12, 0),
				    'elephant' => array_fill(0, 12, 0),
				    'dog' => array_fill(0, 12, 0),
				    'rat' => array_fill(0, 12, 0),
				    'pig' => array_fill(0, 12, 0),
				    'rabbit' => array_fill(0, 12, 0),
				    'cat' => array_fill(0, 12, 0),
				    'chimpanzee' => array_fill(0, 12, 0),
				    'brown bat' => array_fill(0, 12, 0),
				    'tiger' => array_fill(0, 12, 0)
				);
				//print_r($statistic);
				// foreach($resultLink as $studentId) {
				//     $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId='$studentId' order by resultRow Desc LIMIT 1");
				    while($row = mysql_fetch_array($result)){
  			    $order = explode(",", $row['sortResult']);
            if ($config) {
                $groupNumber = getGroupUserNumber($row['contributors']);
            } else {
                $groupNumber = 1;
            }
            for($i=0; $i<12; $i++){
  						$animalName = $order[$i];
  						if(($animalName == "COW") || ($animalName == "COW &nbsp;")){
  						    $statistic['cow'][$i] += $groupNumber;
  						}elseif(($animalName == "DUCK") || ($animalName == "DUCK &nbsp;")){
  						    $statistic['duck'][$i] += $groupNumber;
  						}elseif(($animalName == "HORSE") || ($animalName == "HORSE &nbsp;")){
  						    $statistic['horse'][$i] += $groupNumber;
  						}elseif(($animalName == "ELEPHANT") || ($animalName == "ELEPHANT &nbsp;")){
  						    $statistic['elephant'][$i] += $groupNumber;
  						}elseif(($animalName == "DOG") || ($animalName == "DOG &nbsp;")){
  						    $statistic['dog'][$i] += $groupNumber;
  						}elseif(($animalName == "RAT") || ($animalName == "RAT &nbsp;")){
  						    $statistic['rat'][$i] += $groupNumber;
  						}elseif(($animalName == "PIG") || ($animalName == "PIG &nbsp;")){
  						    $statistic['pig'][$i] += $groupNumber;
  						}elseif(($animalName == "RABBIT") || ($animalName == "RABBIT &nbsp;")){
  						    $statistic['rabbit'][$i] += $groupNumber;
  						}elseif(($animalName == "CAT") || ($animalName == "CAT &nbsp;")){
  						    $statistic['cat'][$i] += $groupNumber;
  						}elseif(($animalName == "CHIMPANZEE") || ($animalName == "CHIMPANZEE &nbsp;")){
  						    $statistic['chimpanzee'][$i] += $groupNumber;
  						}elseif(($animalName == "BROWN BAT") || ($animalName == "BROWN BAT &nbsp;")){
  						    $statistic['brown bat'][$i] += $groupNumber;
  						}elseif(($animalName == "TIGER") || ($animalName == "TIGER &nbsp;")){
  						    $statistic['tiger'][$i] += $groupNumber;
  						}
				    }
				    }
    				//print_r($statistic);
    				$animal = ["COW", "DUCK", "HORSE", "ELEPHANT", "DOG", "RAT", "PIG", "RABBIT", "CAT", "CHIMPANZEE", "BROWN BAT", "TIGER"];
    				$i = 0;
    				foreach($animal as $item){
    				    echo "<tr>";
    				    echo "<td>".$item."</td>";
    				    for($j=0; $j<12; $j++){
    					echo "<td>".$statistic[strtolower($item)][$j]."</td>";
    				    }
    				    echo "</tr>";
    				    $i+=1;
    				}
			    }
			    mysql_close($con);
			    ?>
			</tbody>
		    </table>
        <?php if($showClass == "0" && $config && $config['gradable']){?>
            <input type="text" name="records" value="<?php echo $records; ?>" style="display: none">
            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
            <div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save">Save</button>
            </div>
            </form>
        <?php } ?>
		</div>
	    </div>
	    <?php include 'partials/footer.php' ?>
	</div>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
    $(function(){
        $('td').click(function() {

            if ($(this).hasClass("danger")) {
                $(this).removeClass("danger");
            } else {
                $(this).addClass("danger");
            }
        });
    });
     function studentView(){
         window.open("./animal-card-test");
     }
    </script>
</html>
