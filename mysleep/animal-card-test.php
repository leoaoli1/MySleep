<!DOCTYPR html>
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
if($userId==""){
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
unset($_SESSION['current_work']);
# check the demo mode for Science-City-2018
list($ssd, $ccd, $demoMode) = getDemoMode();
if ($demoMode) {
  // $userType = 'teacher';
}

?>

<html>
    <head>
	      <?php include 'partials/header.php' ?>
        <title>MySleep //Animal Card</title>

      	<style type="text/css">
      	 #unsorted{
      	     background-color: rgb(255, 255, 255);
      	 }
       	 #unsorted td{
      	     width: 120px;
      	     height: 145px;
      	     background-size: 120px 120px;
      	     background-repeat:no-repeat;
      	     background-position: center top;
      	     vertical-align:bottom;
      	     text-align:center;
      	 }
      	 #img1 {
      	     background-image: url('./images/fourthGrade/anim_1.jpg');
      	 }
      	 #img2 {
      	     background-image: url('./images/fourthGrade/anim_2.jpg');
      	 }
      	 #img3 {
      	     background-image: url('./images/fourthGrade/anim_3.jpg');
      	 }
      	 #img4 {
      	     background-image: url('./images/fourthGrade/anim_4.jpg');
      	 }
      	 #img5 {
      	     background-image: url('./images/fourthGrade/anim_5.jpg');
      	 }
      	 #img6 {
      	     background-image: url('./images/fourthGrade/anim_6.jpg');
      	 }
      	 #img7 {
      	     background-image: url('./images/fourthGrade/anim_7.jpg');
      	 }
      	 #img8 {
      	     background-image: url('./images/fourthGrade/anim_8.jpg');
      	 }
      	 #img9 {
      	     background-image: url('./images/fourthGrade/anim_9.jpg');
      	 }
      	 #img10 {
      	     background-image: url('./images/fourthGrade/anim_10.jpg');
      	 }
      	 #img11 {
      	     background-image: url('./images/fourthGrade/anim_11.jpg');
      	 }
      	 #img12 {
      	     background-image: url('./images/fourthGrade/anim_12.jpg');
      	 }
      	 #sorted td:empty {
      	     visibility: hidden;
      	 }
      	 #sorted th:empty {
      	     visibility: hidden;
      	 }
      	 caption {
      	     display: table-caption;
      	     text-align: center;
      	 }
      	 .fixed-table-body {
      	     overflow-x: auto;
      	     overflow-y: auto;
      	     height: auto;
      	 }
      	</style>
        <?php include 'partials/scripts.php' ?>
    </head>
    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php
      require_once('partials/nav-links.php');
      navigationLink($config,$userType);
       ?>
		    <!-- <ol class="breadcrumb"> -->
      <?php if ($lessonNum == 1) { ?>
        <!-- <li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-menu?lesson=1';">Lesson One</a></li>
  			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-menu?lesson=1&activity=1';">Activities One</a></li>
  			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-sub-menu?lesson=1&activity=1&name=animal';">Animal Sleep Sorting Task</a></li> -->
      <?php }elseif ($lessonNum == 3) { ?>
        <!-- <li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
  			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=3';">Activity Three</a></li> -->
  			<?php if ($userType == 'teacher') { ?>
          <!-- <li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-sub-menu?lesson=3&activity=3&name=animal';">Part 2</a></li> <?php } ?> -->
      <?php } ?>
		    <!-- </ol> -->
		    <div class="row">
    			<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="padding-top: 1em;">
            <div class="card" style="width: 100%;margin-bottom: 1.5em;">
              <div class="card-block">
                  <h3 class="card-title" style="margin: 20px 10 10px;">Animal Card Sorting</h3>
                  <h4 class="card-text" style="margin: 20px 10 10px;">Use what you know or have observed to put the animals in order from least to most amount of sleep. <br><br> Click on the animal that you think sleeps the least.  Then click on “1st.”  Place the other animals from least to most by clicking in the same way on the animal first and then the number.  To delete and change an answer, click on the animal name and it will return it to the list.  You will likely have to make some guesses so be prepared to explain your reasoning.</h4>
              </div>
            </div>
    			</div>
		    </div>
        <div class="row">
		        <div class="col-md-offset-4 col-md-4 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8" style="margin-top: 1em;">
      			    <table style="width:100%" id='unsorted'>
            				<tr>
            				    <td id="img1">HORSE &nbsp</td><td id="img2">TIGER &nbsp</td><td id="img3">BROWN BAT &nbsp</td>
            				</tr>
            				<tr>
            				    <td id="img4">RABBIT &nbsp</td><td id="img5">CAT &nbsp</td><td id="img6">CHIMPANZEE &nbsp</td>
            				</tr>
            				<tr>
            				    <td id="img7">ELEPHANT &nbsp</td><td id="img8">DOG &nbsp</td><td id="img9">PIG &nbsp</td>
            				</tr>
            				<tr>
            				    <td id="img10">COW &nbsp</td><td id="img11">DUCK &nbsp</td><td id="img12">RAT &nbsp</td>
            				</tr>
      			    </table>
      			</div>
		    </div>
        <div class="row">
		        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1em;">
      			    <table data-toggle="table" class="table table-bordered" id='sorted'>
      				<thead>
      				    <tr>
      					<th></th><th>1st</th><th>2nd</th><th>3rd</th><th>4th</th><th>5th</th><th>6th</th><th>7th</th><th>8th</th><th>9th</th><th>10th</th><th>11th</th><th>12th</th><th></th>
      				    </tr>
      				</thead>
      				<tbody>
      				    <tr>
      					<td>Least Sleep</td><td></td><td></td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td> <td></td><td></td><td></td><td>Most Sleep</td>
      				    </tr>
      				</tbody>
          			    </table>
      			</div>
			      <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
		    </div>

        <?php if($lessonNum != 1){ ?>
          <div id="originalResponse"  style="margin-top: 5em;">
        <h4 class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4 col-xs-offset-4 col-xs-4"> Original Response </h4>
        <div class="row">
            <table  data-toggle="table"  id="result" class="table table-striped table-hover col-md-12 col-sm-12 col-xs-12">
          <thead>
              <tr>
            <th></th><th>1st</th><th>2nd</th><th>3rd</th><th>4th</th><th>5th</th><th>6th</th><th>7th</th><th>8th</th><th>9th</th><th>10th</th><th>11th</th><th>12th</th><th></th>
              </tr>
          </thead>
          <tbody>
              <tr>
            <td>Least Sleep</td>
            <?php
            include 'connectdb.php';
            require_once('utilities.php');

            if ($config) {
              $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE contributors LIKE '%$userId%' order by resultRow DESC LIMIT 1");
              $_SESSION['current_work'] = mysql_fetch_array($result);
            }else {
              $result = mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId='$userId' order by resultRow DESC LIMIT 1");
            }
            if(mysql_num_rows($result)>0){
                $row = mysql_fetch_array($result);
                    $order = explode(",", $row['sortResult']);
                foreach($order as $animalName){
                  echo "<td>".$animalName."</td>";
                }
            }else{
                echo '<style type="text/css">
                      #originalResponse {
                          display: none;
                      }</style>';
            }
            mysql_close($con);
            ?>
            <td>Most Sleep</td>
              </tr>
          </tbody>
                </table>
        </div>
          <div class="center-block text-center" style="display: block;"><p><i class="fa fa-chevron-left" aria-hidden="true"></i>Scroll the above table to see more<i class="fa fa-chevron-right" aria-hidden="true"></i></p></div>
          </div>

        <?php } ?>





      			<?php if($_SESSION['userType']=="student" && !$demoMode){ ?>
                <div class="row">
            			<form action="animal-card-test-done" method='post' name='myform' onSubmit="send_value()">
                      <div class ="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                        <?php include 'add-group-member-button.php' ?>
                      </div>
            			    <input name='image_order' type='hidden' value=''>
            			    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                        <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
            				    <input class="btn btn-gradpr btn-roundThin btn-large btn-block" type="submit" name="submit" value="Submit" id="submit"/>
            			    </div>
            			</form>
                </div>
      			<?php }else{?>
              <div class="row">
                <div class ="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
                  <?php include 'add-group-member-button.php' ?>
                </div>
              </div>
      			    <div class="row">
            				<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
            				    <a class="btn btn-gradpr btn-roundThin btn-large btn-block" id="submit">Submit</a>
            				</div>
      			    </div>
      			<?php } ?>

    		    <div class="row">
          			<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
          			    <input class="btn btn-gradbb btn-roundThin btn-large btn-block" type="submit" name="erase" value="Clear All" onclick="erase()"/>
          			</div>
    		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    <script>
	 var arrOrder = [];
	 var count = 0;
	 var table;
	 var tableResult;
	 var buttonSubmit;
	 var selected = false;

	 var unsortClick  = function () {
	     unsortSelected(this);
	 };
	 var sortClick  = function () {
	     sortSelected(this);
	 };
	 var nameClick = function(){
	     undo(this);
	 };

	 var arrunSort = {
	     "unSortRow" : [],
	     "unSortCol" : [],
	     "unSortName" : []
	 };

	 var arrSort = {
	     "sortRow" : [],
	     "sortCol" : [],
	     "sortName" : []
	 };

	 var arrAnimalName = ["HORSE","TIGER","BROWN BAT","RABBIT","CAT","CHIMPANZEE","ELEPHANT","DOG","PIG","COW","DUCK","RAT"];
     window.onload = function () {
	     table = document.getElementById("unsorted");
	     tableResult = document.getElementById("sorted");
	     buttonSubmit = document.getElementById("submit");
	     buttonSubmit.style.visibility = "hidden";
	     for (var i = 0; i < table.rows.length; i++) {
    		 for (var j = 0; j < table.rows[i].cells.length; j++){
    		     table.rows[i].cells[j].onclick = unsortClick;
    		 }
	     }
	     for (var i = 0; i < tableResult.rows.length-1; i++) {
    		 for (var j = 1; j < tableResult.rows[i].cells.length-1; j++){
    		     tableResult.rows[i].cells[j].onclick = sortClick;
    		 }
	     }
	     for (var i = 1; i < tableResult.rows.length; i++) {
    		 for (var j = 1; j < tableResult.rows[i].cells.length-1; j++){
    		     tableResult.rows[i].cells[j].onclick = nameClick;
    		 }
	     }
	 }

     function unsortSelected(cell){
	     if(cell.style.backgroundColor === 'rgb(128, 216, 192)'){
		 var arrunSortLength = arrunSort.unSortName.length;
		 if(cell.innerHTML ==  arrunSort.unSortName[arrunSortLength-1]){
	             cell.style.backgroundColor = "rgb(255, 255, 255)";
		     var index = arrunSort.unSortName.indexOf(cell.innerHTML);
		     arrunSort.unSortRow.splice(index, 1);
		     arrunSort.unSortCol.splice(index, 1);
		     arrunSort.unSortName.splice(index, 1);
		     //alert( arrunSort.unSortName);
		     selected = false;
		 }
             }else{
		 if(!selected){
		     if(cell.innerHTML != "&nbsp;"){
			 cell.style.backgroundColor = "rgb(128, 216, 192)";
			 arrunSort.unSortRow.push(cell.parentNode.rowIndex);
			 arrunSort.unSortCol.push(cell.cellIndex);
			 arrunSort.unSortName.push(cell.innerHTML);
			 //alert(cell.innerHTML);
			 selected = true;
		     }
		 }
	     }
	 }

     function sortSelected(cell){
	 if(cell.style.backgroundColor != 'rgb(128, 216, 192)'){
	     if(tableResult.rows[cell.parentNode.rowIndex+1].cells[cell.cellIndex].innerHTML == ""){
		 if(selected){
		     cell.style.backgroundColor = "rgb(128, 216, 192)";
		     var arrunSortLength = arrunSort.unSortName.length;
		     arrSort.sortRow.push(cell.parentNode.rowIndex);
		     arrSort.sortCol.push(cell.cellIndex);
		     arrSort.sortName.push(arrunSort.unSortName[arrunSortLength-1]);

		     setTimeout(function () {
			 tableResult.rows[cell.parentNode.rowIndex+1].cells[cell.cellIndex].innerHTML = arrunSort.unSortName[arrunSortLength-1];
			 cell.style.backgroundColor = "rgb(255, 255, 255)";
			 table.rows[arrunSort.unSortRow[arrunSortLength-1]].cells[arrunSort.unSortCol[arrunSortLength-1]].innerHTML = "&nbsp";
			 table.rows[arrunSort.unSortRow[arrunSortLength-1]].cells[arrunSort.unSortCol[arrunSortLength-1]].style.backgroundColor = "rgb(255, 255, 255)";
			 table.rows[arrunSort.unSortRow[arrunSortLength-1]].cells[arrunSort.unSortCol[arrunSortLength-1]].style.backgroundImage = "url('')";
			 selected = false;
			 count+=1;
			 if(count==12){
			     buttonSubmit.style.visibility = "visible";
			 }
		     }, 10);
		 }
	     }
	 }
     }

     function undo(cell){
	 if(!selected){
	     var indexUnsort = arrunSort.unSortName.indexOf(cell.innerHTML);
	     //table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundColor = "rgb(255, 255, 255)";
	     table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].innerHTML = cell.innerHTML;
	     if(cell.innerHTML == "HORSE &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_1.jpg')";
	     }else if(cell.innerHTML == "TIGER &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_2.jpg')";
	     }else if(cell.innerHTML == "BROWN BAT &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_3.jpg')";
	     }else if(cell.innerHTML == "RABBIT &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_4.jpg')";
	     }else if(cell.innerHTML == "CAT &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_5.jpg')";
	     }else if(cell.innerHTML == "CHIMPANZEE &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_6.jpg')";
	     }else if(cell.innerHTML == "ELEPHANT &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_7.jpg')";
	     }else if(cell.innerHTML == "DOG &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_8.jpg')";
	     }else if(cell.innerHTML == "PIG &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_9.jpg')";
	     }else if(cell.innerHTML == "COW &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_10.jpg')";
	     }else if(cell.innerHTML == "DUCK &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_11.jpg')";
	     }else if(cell.innerHTML == "RAT &nbsp;"){
		 table.rows[arrunSort.unSortRow[indexUnsort]].cells[arrunSort.unSortCol[indexUnsort]].style.backgroundImage = "url('./images/fourthGrade/anim_12.jpg')";
	     }
	     arrunSort.unSortRow.splice(indexUnsort, 1);
	     arrunSort.unSortCol.splice(indexUnsort, 1);
	     arrunSort.unSortName.splice(indexUnsort, 1);

	     var indexSort = arrSort.sortName.indexOf(cell.innerHTML);
	     //tableResult.rows[arrSort.sortRow[indexSort]].cells[arrSort.sortCol[indexSort]].style.backgroundColor = "rgb(255, 255, 255)";
	     tableResult.rows[arrSort.sortRow[indexSort]+1].cells[arrSort.sortCol[indexSort]].innerHTML = "";
	     arrSort.sortRow.splice(indexSort, 1);
	     arrSort.sortCol.splice(indexSort, 1);
	     arrSort.sortName.splice(indexSort, 1);
	     count-=1;
	     if(count!=12){
		 buttonSubmit.style.visibility = "hidden";
	     }
	 }
     }

     function send_value() {
	 var indexSort;
	 if( arrSort.sortCol.length !=12 ){
	     alert("Please Finish the Sorting")
	     return false;
	 }
	 for (var i=1; i<13; i++){  //find 1 to 12
	     indexSort = arrSort.sortCol.indexOf(i);
	     arrOrder.push(arrSort.sortName[indexSort]);
	 }
	 document.myform.image_order.value = arrOrder.toString();
     }

     function erase() {
	 if(confirm("Do you want to clear all?")){
	     var undoIndex = 0;
	     buttonSubmit.style.visibility = "hidden";
	     count = 0;
	     arrOrder = [];
	     arrunSort.unSortRow = [];
	     arrunSort.unSortCol = [];
	     arrunSort.unSortName = [];
	     arrSort.sortRow = [];
	     arrSort.sortCol = [];
	     arrSort.sortName = [];
	     var path1 = "url('./images/fourthGrade/anim_";
	     var path2 = ".jpg')";
	     for (var i = 0; i < table.rows.length; i++) {
		 for (var j = 0; j < table.rows[i].cells.length; j++){
		     table.rows[i].cells[j].style.backgroundColor = "rgb(255, 255, 255)";
		     table.rows[i].cells[j].innerHTML = arrAnimalName[undoIndex].concat(" &nbsp;");
		     pathIndex = undoIndex+1;
		     var path = path1.concat(pathIndex);
		     path = path.concat(path2);
		     table.rows[i].cells[j].style.backgroundImage = path;
		     undoIndex+=1;
		 }
	     }
	     for (var i = 0; i < tableResult.rows.length-1; i++) {
		 for (var j = 1; j < tableResult.rows[i].cells.length-1; j++){
		     tableResult.rows[i].cells[j].style.backgroundColor = "rgb(255, 255, 255)";
		 }
	     }
	     for (var i = 1; i < tableResult.rows.length; i++) {
		 for (var j = 1; j < tableResult.rows[i].cells.length-1; j++){
		     tableResult.rows[i].cells[j].innerHTML = "";
		     }
	     }


	     }
	 }
	</script>
    </body>
</html>
