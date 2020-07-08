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
$userId= $_SESSION['userId'];
if ($userId == ""){
    header("Location: login");
    exit;
}
$userType = $_SESSION['userType'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

if ($config) {
  $result = mysql_query("SELECT * FROM age_sleep_hours_test_answers_table WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
}else {
  $result = mysql_query("SELECT * FROM age_sleep_hours_test_answers_table WHERE userId='$userId' order by resultRow DESC LIMIT 1");
}
$numRow = mysql_num_rows ($result);
unset($_SESSION['current_work']);
if ($numRow>0) {
  $row = mysql_fetch_array($result);
  // if (isset($row['response'])) {
  //    $content = $row['response'];
  // }
  $_SESSION['current_work'] = $row;
  $resultRow = $row['resultRow'];
 }else {
  $content = "";
  $resultRow = -1;
 }
?>
<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Predicating Sleep Needs</title>
	<style type="text/css">
	 .content{
	     height: 80px;
	 }
	 .firstLine{
	     height: 80px;
	 }
	 /*.break{
	     width: 20px;
	 }
	 table td{
	     border: 1px solid #ffddaa;
         }*/
	 .selectButton {
	     position: relative;
	     height: 100%;
	     width: 100%;
	     background-size: 100% 100%;
	 }
	</style>
    </head>
    <?php include 'partials/scripts.php' ?>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php if ($config) {
        require_once('partials/nav-links.php');
        navigationLink($config,$userType);
      }else {?>
		    <ol class="breadcrumb">
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='main-page';">Home</a></li>
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='sleep-lesson';">Lessons</a></li>
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fifth-grade-lesson-menu?lesson=1';">Lesson One</a></li>
    			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=1';">Activity One</a></li>
    			<li class="active">Predicting Sleep Needs</li>
		    </ol>
      <?php } ?>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description">Please match the person's age with your prediction about the recommended sleep duration. Click an age card and then the sleep duration card so the pair appears on the right hand side. If you want to change your responses, click the card on the right hand side. Be sure to click submit once you have paired all the age and sleep duration cards.</h4>
			</div>
		    </div>

		    <div class="row" style="padding-top: 1em;">
			<table id="left-table" class="col-md-5 col-sm-5 col-xs-5">
			    <thead>
				<tr class="firstLine">
				    <th class="col-md-2 col-sm-2 col-xs-2">Age Range Cards</th><th class="col-md-1 col-sm-1 col-xs-1">&nbsp</th><th class="col-md-2 col-sm-2 col-xs-2">Sleep Duration Cards</th>
				</tr>
			    </thead>
			    <tbody>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_1" onclick="age_click(0)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_1" onclick="hour_click(0)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_2" onclick="age_click(1)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_2" onclick="hour_click(1)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_3" onclick="age_click(2)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_3" onclick="hour_click(2)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_4" onclick="age_click(3)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_4" onclick="hour_click(3)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_5" onclick="age_click(4)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_5" onclick="hour_click(4)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_6" onclick="age_click(5)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_6" onclick="hour_click(5)"></button>
				    </td>
				</tr>
			    </tbody>
			</table>
			<table id="left-table" class="col-md-offset-2 col-md-5 col-sm-offset-2 col-sm-5 col-xs-offset-2 col-xs-5">
			    <thead>
				<tr class="firstLine">
				    <th class="col-md-2 col-sm-2 col-xs-2">Age Range</th><th class="col-md-1 col-sm-1 col-xs-1">&nbsp</th><th class="col-md-2 col-sm-2 col-xs-2">Recommended Sleep Duration</th>
				</tr>
			    </thead>
			    <tbody>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_1_copy" onclick="undo(0)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_1_copy" onclick="undo(0)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_2_copy" onclick="undo(1)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_2_copy" onclick="undo(1)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_3_copy" onclick="undo(2)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_3_copy" onclick="undo(2)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_4_copy" onclick="undo(3)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_4_copy" onclick="undo(3)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_5_copy" onclick="undo(4)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_5_copy" onclick="undo(4)"></button>
				    </td>
				</tr>
				<tr>
				    <td class="content">
					<button class="selectButton" id="age_6_copy" onclick="undo(5)"></button>
				    </td>
				    <td class="break">
				    </td>
				    <td class="content">
					<button class="selectButton" id="hour_6_copy" onclick="undo(5)"></button>
				    </td>
				</tr>
			    </tbody>
			</table>
		    </div>


		    <form action="age-sleep-hour-test-done" method='post' name='myform' onSubmit='send_value()' >
            <div class="row">
              <div class ="col-xs-offset-1 col-xs-10 col-md-6 col-md-offset-3">
                <?php include 'add-group-member-button.php' ?>
              </div>
            </div>
      			<?php if($_SESSION['userType']=="student"){ ?>
          			<input name='image_order' type='hidden' value=''>
          			<input name='hours_order' type='hidden' value=''>
                <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                <input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
          			<div class="row" style="padding-top: 1em;">
          			    <div class="col-xs-offset-1 col-xs-10 col-md-6 col-md-offset-3">
          				        <button class="btn btn-gradpr btn-roundThin btn-large btn-block" type="submit" name="submit"  id="submit" onclick="return validation()"/>Submit</button>
          			    </div>
          			</div>
      			<?php }else{?>
      			    <div class="row">
          				<div class="col-xs-offset-1 col-xs-10 col-md-6 col-md-offset-3">
          				    <a class="btn btn-gradpr btn-roundThin btn-large btn-block"  name="submit" id="submit">Submit</a>
          				</div>
      			    </div>
      			<?php } ?>
		    </form>
        <div class="row" style="padding-top: 1em;">
    			<div class="col-xs-offset-1 col-xs-10 col-md-6 col-md-offset-3">
    			    <button class="btn btn-gradbb btn-roundThin btn-large btn-block" type="submit" name="erase" onclick="erase()"/>Clear All</button>
    			</div>
		    </div>
		    </div>
	    </div>
	</div>
	<?php include 'partials/scripts.php' ?>
	<script>
	 var chose_hour = [];
	 var chose_age = [];
	 var arrHourButton = [];
	 var hour_order = [0, 1, 2, 3, 4, 5];
	 var hour_random = [];
	 var can_chose_right_flag = false;
	 var can_chose_left_flag = true;

	 var age_length, hour_length;
	 var undo_age, undo_hour, undoAge1, undoHour1;
	 var undo_hour_button;

	 var arrAgeName = ["age_1", "age_2", "age_3", "age_4", "age_5","age_6"];
	 var arrHourName = ["hour_1", "hour_2", "hour_3", "hour_4", "hour_5", "hour_6"];
	 var arrAgeCopyName = ["age_1_copy", "age_2_copy", "age_3_copy", "age_4_copy", "age_5_copy","age_6_copy"];
	 var arrHourCopyName = ["hour_1_copy", "hour_2_copy", "hour_3_copy", "hour_4_copy", "hour_5_copy", "hour_6_copy"];

	 window.onload = function () {
	     //button_submit = document.getElementById("submit");
	     //button_submit.style.visibility = "hidden";
	     for(var i=0; i<arrAgeName.length; i++){
		 arrAgeName[i] = document.getElementById(arrAgeName[i]);
		 arrHourName[i] = document.getElementById(arrHourName[i]);
		 arrAgeCopyName[i] = document.getElementById(arrAgeCopyName[i]);
		 arrHourCopyName[i] = document.getElementById(arrHourCopyName[i]);
	     }

	     for(var i=0; i<arrAgeName.length; i++){
		 arrAgeName[i].style.visibility = "hidden";
		 arrHourName[i].style.visibility = "hidden";
		 arrAgeCopyName[i].style.visibility = "hidden";
		 arrHourCopyName[i].style.visibility = "hidden";
             }
	     hour_random = shuffle(hour_order);
	     init_draw();
	 }


	 function init_draw(){
	     for (var i=0; i<6; i++){
		 arrAgeName[i].style.backgroundImage = getAgeBackground(i);
		 arrAgeName[i].style.backgroundRepeat = "no-repeat";
		 arrHourName[i].style.backgroundImage = getBackground(hour_random[i]);
		 arrHourName[i].style.backgroundRepeat = "no-repeat";
             }

	     for(var i=0; i<6; i++){
		 arrAgeName[i].style.visibility = "visible";
		 arrHourName[i].style.visibility = "visible";
             }
	 }


	 function getBackground(index) {
	     if (index==0) {
		 backgroundURL = "url('images/lessonone_5th/hour_1.png')";
	     }else if (index==1) {
		 backgroundURL = "url('images/lessonone_5th/hour_2.png')";
	     }else if (index==2) {
		 backgroundURL = "url('images/lessonone_5th/hour_3.png')";
	     }else if (index==3) {
		 backgroundURL = "url('images/lessonone_5th/hour_4.png')";
	     }else if (index==4) {
		 backgroundURL = "url('images/lessonone_5th/hour_5.png')";
	     }else if (index==5) {
		 backgroundURL = "url('images/lessonone_5th/hour_6.png')";
	     }
	     return backgroundURL;
	 }

	 function getAgeBackground(index){
	     if (index==0) {
		 backgroundURL = "url('images/lessonone_5th/age_1.png')";
	     }else if (index==1) {
		 backgroundURL = "url('images/lessonone_5th/age_2.png')";
	     }else if (index==2) {
		 backgroundURL = "url('images/lessonone_5th/age_3.png')";
	     }else if (index==3) {
		 backgroundURL = "url('images/lessonone_5th/age_4.png')";
	     }else if (index==4) {
		 backgroundURL = "url('images/lessonone_5th/age_5.png')";
	     }else if (index==5) {
		 backgroundURL = "url('images/lessonone_5th/age_6.png')";
	     }
	     return backgroundURL;
	 }

	 function setAgeBackground(order, urlBackground){
	     var l = order.length;
	     arrAgeCopyName[l].style.backgroundImage = urlBackground;
	     arrAgeCopyName[l].style.backgroundRepeat = "no-repeat";
	     arrAgeCopyName[l].style.visibility="visible";
	     can_chose_right_flag = true;
	     can_chose_left_flag = false;
	 }

	 function setHourBackground(order, urlBackground){
	     var l = order.length;   //befor add new value
	     arrHourCopyName[l].style.backgroundImage = urlBackground;
	     arrHourCopyName[l].style.backgroundRepeat = "no-repeat";
	     arrHourCopyName[l].style.visibility="visible";
	     can_chose_right_flag = false;
	     can_chose_left_flag = true;
	     if(order.length==5){
		 //button_submit.style.visibility="visible";
	     }
	 }

	 function age_click(n) {
	     if(can_chose_left_flag){
		 arrAgeName[n].style.visibility="hidden";
		 ageUrl = getAgeBackground(n)
		 setAgeBackground(chose_age, ageUrl );
		 chose_age.push(n);
	     }
	 }

	 function hour_click(n) {
	     if(can_chose_right_flag){
		 arrHourName[n].style.visibility="hidden";
		 hourUrl = getBackground(hour_random[n]);
		 setHourBackground(chose_hour, hourUrl );
		 chose_hour.push(hour_random[n]);
		 arrHourButton.push(n);
	     }
	 }


	 function undo(n) {
	     age_length = chose_age.length;
	     hour_length = chose_hour.length;
	     undo_age = chose_age[n];
	     setAgeButton(undo_age);
	     if (typeof(arrHourButton[n]) !== 'undefined') {
		 undo_hour = chose_hour[n];
		 undo_hour_button = arrHourButton[n];
		 setHourButton(undo_hour_button);
             }
	     if(age_length>1){
		 for(var i=n; i<age_length-1; i++){
		     undoAge1 = chose_age[i+1];
		     arrAgeCopyName[i].style.backgroundImage = getAgeBackground(undoAge1);
		     arrAgeCopyName[i].backgroundRepeat = "no-repeat";
		     arrAgeCopyName[i].style.visibility="visible";
		     if (typeof(chose_hour[i+1]) !== 'undefined') {
			 undoHour1 = chose_hour[i+1];
			 arrHourCopyName[i].style.backgroundImage = getBackground(undoHour1);
			 arrHourCopyName[i].style.backgroundRepeat = "no-repeat";
			 arrHourCopyName[i].style.visibility="visible";
		     }
		 }
		 arrAgeCopyName[age_length-1].style.visibility = "hidden";
		 arrHourCopyName[age_length-1].style.visibility = "hidden";
		 if((hour_length<age_length)&&(n!=(age_length-1))){
		     arrHourCopyName[age_length-2].style.visibility = "hidden";
		 }
	     }else{
		 arrAgeCopyName[n].style.visibility = "hidden";
		 arrHourCopyName[n].style.visibility = "hidden";
	     }
	     if(hour_length<age_length&&n!=0&&n!=(age_length-1)){
		 can_chose_right_flag = true;
		 can_chose_left_flag = false;
	     }else if(hour_length==age_length){
		 can_chose_right_flag = false;
		 can_chose_left_flag = true;
	     }else if(n==0&&hour_length<age_length&&age_length!=1){
		 can_chose_right_flag = true;
		 can_chose_left_flag = false;
	     }else{
		 can_chose_right_flag = false;
		 can_chose_left_flag = true;
	     }
	     chose_age.splice( $.inArray(undo_age, chose_age), 1 );
	     if (typeof(arrHourButton[n]) !== 'undefined') {
		 chose_hour.splice( $.inArray(undo_hour, chose_hour), 1 );
		 arrHourButton.splice( $.inArray(undo_hour_button, arrHourButton), 1 );
	     }
	     //button_submit.style.visibility = "hidden";
	 }

	 function setAgeButton(selected){
	     arrAgeName[selected].style.visibility = "visible";
	 }

	 function setHourButton(selected){
	     arrHourName[selected].style.visibility = "visible";
	 }

	 /*function singleUndo(){
	    if(chose_age.length > chose_hour.length){
	    var l = chose_age.length; //after add new value
	    arrAgeCopyName[l-1].style.visibility = "hidden";
	    undo_age = chose_age[l-1];
	    setAgeButton(undo_age);
	    chose_age.pop();
	    }else{
	    var l = chose_hour.length;
	    arrHourCopyName[l-1].style.visibility = "hidden";
	    undo_hour_button = arrHourButton[l-1];
	    setHourButton(undo_hour_button);
	    chose_hour.pop();
	    arrHourButton.pop();
	    }
	    }*/
	 function erase() {
	     var m = confirm("Do you want to clear all?");
	     if (m) {
		 chose_age = [];
		 chose_hour = [];
		 arrHourButton = [];
		 for(var i=0; i<arrAgeName.length; i++){
		     arrAgeCopyName[i].style.visibility = "hidden";
		     arrHourCopyName[i].style.visibility = "hidden";
		 }
		 can_chose_right_flag = false;
		 can_chose_left_flag = true;
		 init_draw();
	     }
	 }


	 function shuffle(array) {
	     var currentIndex = array.length, temporaryValue, randomIndex;
	     while (0 !== currentIndex) {
		 randomIndex = Math.floor(Math.random() * currentIndex);
		 currentIndex -= 1;
		 temporaryValue = array[currentIndex];
		 array[currentIndex] = array[randomIndex];
		 array[randomIndex] = temporaryValue;
	     }
	     return array;
	 }


	 function send_value(){
	     document.myform.image_order.value = chose_age.toString();
	     document.myform.hours_order.value = chose_hour.toString();
	 }

	 function validation(){
	     if(chose_hour.length==6){
		 return true;
	     }else{
		 alert("Please Finish it")
		 return false;
	     }
	 }
	</script>
    </body>
</html>
