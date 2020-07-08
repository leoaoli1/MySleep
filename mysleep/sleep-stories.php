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
$storyId = $_GET['storyId'];
$storyId = 1;
$_SESSION['sleepStoryId'] = $storyId;


$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

include 'connectdb.php';
if ($config) {
  $result =mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE contributors LIKE '%$userId%' and storyId ='$storyId' ORDER BY resultRow DESC LIMIT 1");
}else {
  $result =mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId='$userId' and storyId ='$storyId' ORDER BY resultRow DESC LIMIT 1");
}

$numRow = mysql_num_rows($result);
$row = mysql_fetch_array($result);
unset($_SESSION['current_work']);
$_SESSION['current_work'] = $row;
//$counter = 0;
if ($numRow>0) {
    $content = $row['storyNotes'];
    $lastTimeHighlight = $row['highlightWord'];
    $lastTimeSpanName = $row['highlightWordSpanName'];
    $subResult =mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId='$userId' and storyId ='$storyId' and submit='1'");
    $submitTimes = mysql_num_rows($subResult);
    $saveResult =mysql_query("SELECT * FROM fourth_grade_lesson_three_story WHERE userId='$userId' and storyId ='$storyId' and submit='0'");
    $saveTimes = mysql_num_rows($saveResult);
}else {
    $content = "";
    $lastTimeHighlight = "";
    $lastTimeSpanName = "";
    $submitTimes = 0;
    $saveTimes = 0;
}
mysql_close($con);
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep // Purpose of Sleep Story</title>
	<script type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script>
	 var highlight = "<?php echo $lastTimeHighlight; ?>";
	 var spanName =  "<?php echo $lastTimeSpanName; ?>";
	 var highlightArr = [];
	 var spanNameArr = [];
	 function send_value() {
	     document.myform.highlightOrder.value = highlightArr.toString();
	     document.myform.spanName.value = spanNameArr.toString();
	 }

	 $(document).ready(function(){
	     $("span").click(function(){
		 if ($(this).css('background-color') === 'rgb(255, 255, 0)') {
		     $(this).css('background-color', 'rgb(255, 255, 255)');
		     highlightArr.splice( $.inArray($(this).text(), highlightArr), 1 );
		     spanNameArr.splice( $.inArray($(this).attr("name"), spanNameArr), 1 );
		     //highlightArr.pop($(this).text());
		     //spanNameArr.pop($(this).attr("name"));
		 }else {
		     $(this).css('background-color', 'rgb(255, 255, 0)');
  		     highlightArr.push($(this).text());
  		     spanNameArr.push($(this).attr("name"));
  		     //alert(spanNameArr);
		 }
		 //alert(highlightArr);
	     });
	 });

	</script>
    </head>
    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php
                      if ($config) {
                        require_once('partials/nav-links.php');
                        navigationLink($config,$userType);
                      } else {
                   ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='main-page';">Home</a></li>
                                <li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='sleep-lesson';">Lessons</a></li>
                        				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-menu?lesson=2';">Lesson Two</a></li>
                        				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-menu?lesson=2&activity=3';">Activities Three</a></li>
                                <?php if ($userType == 'teacher') { ?>
                                <li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-sub-menu?lesson=2&activity=3&name=story';">Part 1</a></li>
                              <?php } ?>
                        				<li class="active">
                                 <?php
                                   if($storyId == 1){
			                               echo "Purpose of Sleep Story";
			                             }
					                       ?>
			                         </li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
		    <div class="row">
      			<div class="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2">
              <h2 >What is the purpose of sleep?</h2>
      			    <h4>
            				<ol>
            				    <li>Read about what scientists have to say about the purpose of sleep.</li>
            				    <li>Highlight key words or phrases that provide evidence about the purpose of sleep by clicking on the words. Don’t highlight complete sentences.</li>
            				    <li>Write in your own words an answer to the question, “What is the purpose of sleep?"</li>
            				</ol>
                </h4>
      			</div>
		    </div>
        <form action="sleep-stories-done" method='post' name='myform' onSubmit="send_value()">
          <div class ="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2">
            <?php include 'add-group-member-button.php' ?>
          </div>
		    <div class="row" style="padding-top: 2cm;">
			<div class ="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2">

    				<?php
            $stroyContent = [];
    				if($storyId == 1){
    				    $storyContent[0] = "This question doesn’t have a simple answer. Sleep scientists have evidence that supports more than one answer to this important question. Some of the evidence comes from studying how animals sleep. One idea is that we sleep to lower our energy use during a part of the day or night when it is not useful to be active. For example, at night it may be difficult for an animal to see or catch its food. In this case, night might be a good time to sleep and save energy. People use 5 to 10 percent less energy when they are sleeping.";

    				    $storyContent[1] = "Another possible answer suggests that sleep helps keep animals and people safe. By keeping quiet and hidden during sleep, harm is less likely to occur. For example, predators are more likely to catch prey when the prey are moving about.";

    				    $storyContent[2] = "Scientists also believe that sleep lets the body refresh and repair itself. Animal studies have shown that a complete loss of sleep leads to failure of the immune system and death after a few weeks. Other studies have found that muscle growth and the repair of cells and tissues in the body happen mostly during sleep.";

    				    $storyContent[3] = 'Sleep is important for the development of the brain in babies and young children. Babies sleep about 13 to 14 hours per day and seem to need this much sleep for healthy brain development. In adults, a healthy amount of sleep improves people’s memory and ability to learn. <Br><Br>Recent studies help explain why sleep is important for the brain. During wakefulness, the connections between brain cells multiply as new information is learned. If this were to occur without stopping, these connections would get tangled and overloaded. Sleep allows useless connections to be eliminated and important ones to be strengthened.';

    				    $storyContent[4] = "Finally, sleep has been shown to be important for removing waste products from the brain. During sleep the spaces between brain cells increase. This extra room allows the brain to flush out toxins (damaging molecules) that build up during the day.";
    				}elseif($storyId == 2){
    				    $storyContent = "Please See Master 1.1b";
    				}elseif($storyId == 3){
    				    $storyContent = "Please See Master 1.1c";
    				}elseif($storyId == 4){
    				    $storyContent = "Please See proposed Master 1.1d";
    				}
    				$nameNum = 0;
    				$contentStr = " ";
                                    foreach ($storyContent as $storyContentPar){
    				    $storyContentArr = explode(" ", $storyContentPar);
    				    //print_r($storyContentArr, $return = null);

    				    $contentStr .= "<p>";
    				    foreach($storyContentArr as $cellContent){
    					$spanName = "word-".$nameNum;
    					$appendPart = "<span name='".$spanName."'>".$cellContent." </span>";
    					$contentStr .= $appendPart;
    					$nameNum+=1;

    				    }
    				    $contentStr .= "</p><br>";
    				}
    				?>
    			    <div>
    				        <h3><?php echo $contentStr;?></h3>
    			    </div>
			     </div>
		    </div>
          <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
      <div class ="col-sm-offset-1 col-sm-10 col-md-8 col-md-offset-2" style="padding-top: 2cm;">
			    <div class="row">
				<h4>Answer the question <b>What is the purpose of sleep?</b> in the following text area.</h4>
			    </div>
			    <div class="row">
	 			       <textarea name="storyNotes" id="storyNotes" class="form-control" rows="7"><?php echo htmlspecialchars($content);?></textarea>
			    </div>
			</div>
			<?php if($_SESSION['userType']=="student"){ ?>
			<input name='highlightOrder' type='hidden' value=''>
			<input name='spanName' type='hidden' value=''>
			<div class="row boundary">
          <div class="col-sm-offset-1 col-sm-5 col-md-1">
				      <small>Saved Times: <?php echo $saveTimes?></small>
			    </div>
			    <div class="col-sm-offset-1 col-sm-5 col-md-1 col-md-offset-1" >
				      <small>Submitted Times: <?php echo $submitTimes?></small>
			    </div>
			</div>
			<div class="row boundary">
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
				<button class="btn btn-gradbg btn-roundBold btn-large btn-block" type="submit" name="save">Save</button>
			    </div>
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
				<button class="btn btn-gradpr btn-roundBold btn-large btn-block" type="submit" name="submit">Submit</a>
			    </div>
			</div>
			<!--<div class="row">
			    <div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
				<button class="btn btn-danger btn-large btn-block" type="submit" name="quit" onclick=" return confirm('Are you sure you want to exit?  Your work will not be saved!')">Exit without Saving</a>
			    </div>
			</div>-->
			<?php }else{?>
			    <div class="row">
				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				    <a class="btn btn-info btn-large btn-block">Save</a>
				</div>
			    </div>
			    <div class="row">
				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
				    <a class="btn btn-success btn-large btn-block">Submit</a>
				</div>
			    </div>
			<?php } ?>
		    </form>
		    <script>
		     $(function() {
			 if (highlight.trim() != '') {
			     highlightArr = highlight.split(',');
			     //alert(highlightArr);
			 }
			 if (spanName.trim() != '') {
			     spanNameArr = spanName.split(',');
			     var singleSpanName;
			     for (var i=0; i<spanNameArr.length; i++){
				 singleSpanName = spanNameArr[i];
				 //console.log(singleSpanName);
				 $("span[name=" + spanNameArr[i] + "]").css('background-color', 'rgb(255, 255, 0)');
			     }
			 }
		     });
		    </script>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
