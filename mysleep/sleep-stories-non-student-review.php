<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li 
#
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if(isset($_GET['showToClass'])) {
    $classFlag = $_GET['showToClass'];
}elseif (isset($_GET['showClass'])) {
    $classFlag = $_GET['showClass'];
}
else {
    $classFlag = "0";
}

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

# check the demo mode for Science-City-2018
list($schoolId, $classId, $demoMode) = getDemoMode();
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Purpose of Sleep Story</title>
    </head>
    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php
                        if ($config) {
                          require_once('partials/nav-links.php');
                          navigationLinkReview($config,$userType);
                        } else {
                     ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page';">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson';">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=2';">Lesson Two</a></li>
                        				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=3';">Activities Three</a></li>
                        				<li><a href="#" onclick="location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=3&name=story';">Part 1</a></li>
				                        <li class="active">Purpose of Sleep Story Review</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
		    <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
          <form action="sleep-stories-review-done" method="post">
	        <table class="table">
    			    <thead>
          				<tr>
          				    <?php
          				    if(($userType == 'teacher') || ($userType == 'parent')) {
                					if($classFlag=="0"){
                					    echo "<th>Name</th><th>Function Story</th><th>Answer</th><th>Submit Time</th>";
                              if ($config && $config['gradable']) {
                                echo '<th data-field="score">Score</th>
                                <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                              }
                					}else{
                					    echo "<th>ID</th><th>Answer</th>";
                					}
          				    }else {
          					      echo "<th>User Id</th><th>Function Story</th><th>Answer</th><th>Submit Time</th>";
          				    }
          				    ?>
          				</tr>
    			    </thead>
			        <tbody>
			    <?php

        	include 'connectdb.php';
			    require_once('utilities.php');

			  if(($userType == 'teacher') || ($userType == 'parent')) {

              if($userType == 'teacher') {
                  $classId = $_SESSION['classId'];
                  if ($config) {
                      $result = mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE resultRow IN ( SELECT MAX(resultRow) FROM fourth_grade_lesson_three_story GROUP BY contributors) AND classId='$classId' and submit='1' ORDER BY resultRow");

                  } else {
                      $resultLink = getUserIdsInClass($classId);
                      $students = join("','",$resultLink);
                      $result = mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
                  }
              } else {
                  $resultLink = getLinkedUserIds($userId);
                  $students = join("','",$resultLink);
                  $result = mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId IN ('$students') and submit='1' ORDER BY resultRow");
              }
              $paragraphNum = "0";
              $parsedSpanNameNum = "";
              $count = 1;
              while($row = mysql_fetch_array($result)){
                  $records = $records.','.$row['resultRow'];
                  $note = nl2br($row['storyNotes']);
                  $strSpanName = $row['highlightWordSpanName'];
                  $parsedSpanNameNum = parseSpanName($paragraphNum, $strSpanName, $parsedSpanNameNum);
                  $storyId = $row['storyId'];
                  $storyText = getStoryContentArr($storyId);
                  list($strStory, $paragraphNum) = setSpanName($storyText, $paragraphNum);
                  if($classFlag=="0") {
                      if ($config) {
                          $name = getGroupUserNames($row['contributors']);
                      } else {
                          list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                          $name = $firstname.' '.$lastname;
                      }
                      echo "<tr>";
                      echo "<td>".$name."</td><td>".$strStory."</td><td>".$note."</td><td>".$row['submitTime']."</td>";
                      if ($userType == 'teacher' && $config && $config['gradable']) {
                        echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['resultRow'].'" rows="1">'.$row['score'].'</textarea></td>';
                        echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['resultRow'].'" rows="3">'.$row['comment'].'</textarea></td>';
                      }
                      echo "</tr>";
                  }else {
                    echo "<tr>";
                    echo "<td>".$count."</td><td>".$note."</td>";
                    echo "</tr>";
                    $count += 1;
                      /*$currentClassNum = getStudentClassId($studentId);
                           $currentYearSemester = getStudentSemesterYear($studentId);
                           echo "<td>" .'5zfactor'.$currentYearSemester.$currentClassNum.$studentId. "</td>";*/
                  }
              }

              // foreach($resultLink as $studentId){
              //
              //   list($firstname, $lastname) = getUserFirstLastNames($studentId);
              //   if($classFlag=="0") {
              //       echo "<tr>";
              //       $result = mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId='$studentId' and submit='1' ORDER BY resultRow");
              //       echo "<td>".$firstname."</td><td>".$lastname."</td>";
              //       echo "</tr>";
              //   }else {
              //       $result = mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId='$studentId' and submit='1' ORDER BY resultRow DESC  LIMIT 1");
              // /*$currentClassNum = getStudentClassId($studentId);
              //      $currentYearSemester = getStudentSemesterYear($studentId);
              //      echo "<td>" .'5zfactor'.$currentYearSemester.$currentClassNum.$studentId. "</td>";*/
              //   }
              //
              //     while($row = mysql_fetch_array($result)){
              //         echo "<tr>";
              //         if($classFlag == "0"){
              //             echo "<td></td><td></td>";
              //         }else{
              //             echo "<td>".$count."</td>";
              //             $count += 1;
              //         }
              //         $note = nl2br($row['storyNotes']);
              //         $strSpanName = $row['highlightWordSpanName'];
              //         $parsedSpanNameNum = parseSpanName($paragraphNum, $strSpanName, $parsedSpanNameNum);
              //         $storyId = $row['storyId'];
              //         $storyText = getStoryContentArr($storyId);
              //         list($strStory, $paragraphNum) = setSpanName($storyText, $paragraphNum);
              //         if($classFlag=="0") {
              //             echo "<td>".$strStory."</td><td>".$note."</td><td>".$row['submitTime']."</td>";
              //                   //echo "<td>".$strStory."</td><td>".$note."</td><td>".$row['storyId']."</td>";
              //         }else{
              //             echo "<td>".$note."</td>";
              //         }
              //               echo "</tr>";
              //     }
              //   }


     			}else{
     				$result = mysql_query("SELECT * FROM fourth_grade_lesson_three_story ORDER BY resultRow");
        				while($row = mysql_fetch_array($result)) {
        				    echo "<tr>";
        				    $studentId = $row['userId'];
         				    $currentClassNum = getStudentClassId($studentId);
         				    $currentYearSemester = getStudentSemesterYear($studentId);
        				    $note = nl2br($row['storyNotes']);
         				    echo "<td>" .'5zfactor'.$currentYearSemester.$currentClassNum.$studentId. "</td>";
        	            		    $strSpanName = $row['highlightWordSpanName'];
        				    $parsedSpanNameNum = parseSpanName($paragraphNum, $strSpanName, $parsedSpanNameNum);
        				    $storyId = $row['storyId'];
        				    $storyText = getStoryContentArr($storyId);
        				    list($strStory, $paragraphNum) = setSpanName($storyText, $paragraphNum);
        				    echo "<td>".$strStory."</td><td>".$note."</td>";
        	    	  		    //echo "<td>".$strStory."</td><td>".$note."</td><td>".$row['storyId']."</td>";
        	      			    echo "</tr>";
        				}
     			}
     			mysql_free_result($result);
			    mysql_close($con);

			    function getStoryContentArr($id){
      				$stroyContent = [];
      				if($id == 1){
      				    $storyContent[0] = "This question doesn’t have a simple answer. Sleep scientists have come up with evidence that supports more than one answer to this important question. One idea is that we sleep to lower our energy use during part of the day or night. For example, at night it may be difficult for an animal to see or catch its food. In this case, night might be a good time to sleep and save energy. People use about 10 percent less energy when they are sleeping.";

      				    $storyContent[1] = "Another idea is that sleep lets the body refresh and repair itself. Animal studies have shown that a complete loss of sleep leads to failure of the immune system and death after a few weeks. Other studies have found that muscle growth and the repair of body parts happen mostly during sleep.";

      				    $storyContent[2] = "Sleep is important for the development of the brain in babies and young children. Babies sleep about 13 to 14 hours per day and seem to need this much sleep for healthy brain development. In adults, a healthy amount of sleep improves people’s memory and ability to learn";

      				    $storyContent[3] = "A recent study with mice showed that during sleep the spaces between brain cells increased. This extra room allowed the brain to flush out toxins (damaging molecules) that build up during the day.";

      				    $storyContent[4] = "Still another idea suggests that sleep helps keep organisms safe at times when they are more likely to be harmed. Predators are more likely to catch prey when the prey are moving about.";
      				}elseif($id == 2){
      				    $storyContent = "Function story 2, we will have more function stories.";
      				}elseif($id == 3){
      				    $storyContent = "Function story 3, we will have more function stories.";
      				}elseif($id == 4){
      				    $storyContent = "Function Sotry 4, we will have more function sotries.";
      				}
      				$n = 0;
      				$storyCountentArr = [];
      				foreach ($storyContent as $storyContentPar){
      				    $storyContentArr[$n] = explode(" ", $storyContentPar);
      				    $n += 1;
      				}
      				return 	$storyContentArr;
			    }

			    function setSpanName($array, $nameNum){
				$contentStr = " ";
				foreach($array as $paragraph){
				    $contentStr .= "<p>";
				    foreach($paragraph as $cellContent){
					$spanName = "word-".$nameNum;
					$appendPart = "<span name='".$spanName."'>".$cellContent." </span>";
					$contentStr .= $appendPart;
					$nameNum+=1;
				    }
				    $contentStr .= "</p><br>";
				}
				return array($contentStr, $nameNum);
			    }

			    function parseSpanName($num, $name, $string){
				$arrName = explode(",", $name);
				foreach($arrName as $item){
				    $numItem = preg_replace("/[^0-9]/","",$item);
				    $numItem += $num;
				    $numItem .= ",";
				    $string.=$numItem;
				}
				return $string;
			    }
			    ?>
			    </tbody>
			</table>
          <?php if($classFlag == "0" && $config && $config['gradable']){?>
              <input type="text" name="records" value="<?php echo $records; ?>" style="display: none">
              <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
              <div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                  <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save">Save</button>
              </div>
          <?php } ?>
      </form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script>
	 $(function() {
	     var spanNameNum =  "<?php echo $parsedSpanNameNum; ?>";
	     arrSpanNameNum = spanNameNum.split(',');
	     for (var i=0; i<arrSpanNameNum.length; i++){
		 console.log(arrSpanNameNum[i]);
		 $("span[name=word-" + arrSpanNameNum[i] + "]").css('background-color', 'rgb(255, 255, 0)');
	     }
	 });
	</script>
	<script>
	 function studentView(){
             window.open("./sleep-stories?storyId=1");
	 }
	</script>
    </body>
</html>
