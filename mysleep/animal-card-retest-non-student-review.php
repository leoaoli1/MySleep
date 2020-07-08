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
       <?php if($showClass == "0" && $config && $config['gradable']){?>
           <form action="animal-card-retest-review-done" method="post">
       <?php } ?>
        <!-- <form action="sleep-environment-review-done" method="post"> -->
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
        				    echo "<th>Least Sleep</th><th>Hours of sleep</th><th>Moderate Sleep</th><th>Hours of sleep</th><th>Most</th><th>Hours of sleep</th>";
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
                            $result = mysql_query("SELECT * FROM animal_card_retest WHERE resultRow IN ( SELECT MAX(resultRow) FROM animal_card_retest GROUP BY contributors) AND classId='$classId' and submit='1' ORDER BY resultRow");

                        } else {
                            $resultLink = getUserIdsInClass($classId);
                            $students = join("','",$resultLink);
                            $result = mysql_query("SELECT * FROM animal_card_retest WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
                        }
                    } else {
                        $resultLink = getLinkedUserIds($userId);
                        $students = join("','",$resultLink);
                        $result = mysql_query("SELECT * FROM animal_card_retest WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
                    }
                    while($row = mysql_fetch_array($result)) {
                        $records = $records.','.$row['resultRow'];
                        if ($config) {
                            $name = getGroupUserNames($row['contributors']);
                        } else {
                            list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                            $name = $firstname.' '.$lastname;
                        }
                        echo "<tr>";
                        echo "<td>".$name."</td>";
                        $order = explode(",", $row['sortResult']);
                        foreach($order as $animalName){
                            echo "<td>".$animalName."</td>";
                        }
                        echo "<td>".$row['submitTime']."</td>";
                        if ($userType == 'teacher' && $config && $config['gradable']) {
                            echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['recordId'].'" rows="1">'.$row['score'].'</textarea></td>';
                            echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['recordId'].'" rows="3">'.$row['comment'].'</textarea></td>';
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
		    	  	    $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId='$studentId' order by recordId");
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
            echo "<tr>
          <td>Horse</td><td>2.9</td><td>Pig</td><td>7.8</td><td>Cat</td><td>12.5</td>
        </tr>
        <tr>
          <td>Elephant</td><td>3.5</td><td>Rabbit</td><td>8.4</td><td>Rat</td><td>12.6</td>
        </tr>
        <tr>
          <td>Cow</td><td>4.0</td><td>Chimpanzee</td><td>9.7</td><td>Tiger</td><td>15.8</td>
        </tr>
        <tr>
          <td></td><td></td><td>Dog</td><td>10.1</td><td></td><td></td>
        </tr>
        <tr>
          <td></td><td></td><td>Duck</td><td>10.8</td><td></td><td></td>
        </tr>";
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
