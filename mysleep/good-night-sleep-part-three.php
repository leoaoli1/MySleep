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
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //I Could Use a Good Night's Sleep! </title>
	<style>
	 .bottomBorder{
	     border-bottom: 3px solid  #ff0000;
	 }
	 td{
	     height: 60px;
	     width: 60px;
	 }
	 .circle { 
	     background: #9999ff; 
	 }
	 .crossRight .child{
	     position:absolute; 
	     display:block;
	     height:3px; 
	     background:red;
	 }
	 .crossLeft .child{
	     position:absolute; 
	     display:block;
	     height:3px; 
	     background:red;
	 }
	</style>
    </head>
    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='main-page';">Home</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='sleep-lesson';">Lessons</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep';">I Can Use A Good Night's Sleep</a></li>
			<li class="active">Part Three</li>
		    </ol>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <form action="good-night-sleep-part-three-done" method="post">
			<div class="row" style="padding-top: 1cm;">
			    <table  cellpadding="0" cellspacing="0" align="center" class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="padding-top: 1em;">
				<thead>
				    <tr>
					<th colspan="2">Hard Change or Achieve</th><th></th><th colspan="2"></th><th></th><th colspan="2">Easy Change or Achieve</th> 
				    </tr>
				</thead>
			        <tr>
				    <td class="circle" colspan="2" rowspan="2">
					<select name="hardOne" id="hardOneId" class="form-control input-lg">
					</select>
				    </td>
				    <td rowspan="2"></td><td colspan="2" rowspan="2"></td><td rowspan="2"></td>
				    <td class="circle" colspan="2" rowspan="2">
					<select name="easyOne" id="easyOneId" class="form-control input-lg">
					</select>
				    </td> 
				</tr>
				<tr>
				</tr>
				<tr>
				    <td colspan="2"></td><td class="crossLeft">&nbsp</td><td colspan="2"></td><td class="crossRight"></td><td colspan="2"></td> 
				</tr>
				<tr>
				    <td class="circle" colspan="2" rowspan="2">
					<select name="hardTwo" id="hardTwoId" class="form-control input-lg">
					</select>
				    </td><td  class="bottomBorder"></td>
				    <td class="circle" colspan="2" rowspan="2">
					<select name='categories' id='categories' class='form-control input-lg'>
					    <option value='null' disabled selected>Categories</option>
					    <option value='1'>Family behavior, activity and routines</option>
					    <option value='2'>Student behavior, activity and routines</option>
					    <option value='3'>Environment and Community</option>
					</select>
				    </td>
				    <td class="bottomBorder"></td>
				    <td class="circle" colspan="2" rowspan="2">
					<select name="easyTwo" id="easyTwoId" class="form-control input-lg">
					</select>
				    </td> 
				    </tr>
				    
				    <tr>
					<td></td><td></td>
				    </tr>
				    <tr>
					<td colspan="2"></td><td class="crossRight"></td><td colspan="2"></td><td class="crossLeft"></td><td colspan="2"></td> 
				    </tr>
				    <tr>
					<td class="circle" colspan="2" rowspan="2">
					    <select name="hardThree" id="hardThreeId" class="form-control input-lg">
					    </select>
					</td><td rowspan="2"></td><td colspan="2" rowspan="2"></td><td rowspan="2"></td>
					<td class="circle" colspan="2" rowspan="2">
					    <select name="easyThree" id="easyThreeId" class="form-control input-lg">
					    </select>
					</td> 
				    </tr>
				</table>
			</div>
			<div class="row" style="padding-top: 1cm;">
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
				<p>Submit Times:</p><p id="submitTimesId"></p> 
			    </div>
			</div>
			<div class="row" style="padding-top: 1cm;">
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
				<button class="btn btn-info btn-large btn-block" type="submit" name="save" onclick="return validation()">Save</button>
			    </div>
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
				<button class="btn btn-success btn-large btn-block" type="submit" name="submit" onclick="return validation()">Submit</a>
			    </div>
			</div>
			<div class="row">
			    <div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
				<button class="btn btn-danger btn-large btn-block" type="submit" name="quit" onclick=" return confirm('Are you sure you want to exit?  Your work will not be saved!')">Exit without Saving</a>
			    </div>
			</div>
		    </form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     function draw(){
	 var cw = $('.circle').width();
	 $('.circle').css({'height':cw+'px'});
	 var radius = cw/2;
	 $('.circle').css({'-moz-border-radius':radius+'px'});
	 $('.circle').css({'-webkit-border-radius':radius+'px'});
	 $('.circle').css({'border-radius':radius+'px'});
     }
     function drawLine(){
	 var arrCrossLeft = $('.crossLeft');
	 arrCrossLeft.each(function(i){
	     var elementRight = $(this),
		 width   = elementRight.innerWidth(),
		 height  = elementRight.innerHeight(),
		 line      = 1.41*Math.sqrt(width*width + height*height),
		 rad  = Math.PI-Math.atan2(height,width),
		 angle = rad*360/(2*Math.PI), 
		 s = '<b class="child" ';
	     s += 'style="width:'+line+'px;';
	     s += '-webkit-transform: rotate(-'+angle+'deg);';
	     s += '-moz-transform: rotate(-'+angle+'deg);';
	     s += '-ms-transform: rotate(-'+angle+'deg);';
	     s += '-o-transform: rotate(-'+angle+'deg);';
	     s += 'transform: rotate(-'+angle+'deg);';
	     s += '-sand-transform: rotate(-'+angle+'deg);';
	     topMargin     = (height/5);
	     leftMargin = (width/2);
	     s += 'margin-top: -'+topMargin+'px;';
	     s += 'margin-left: -'+leftMargin+'px;';
	     s += '"></b>';
	     elementRight.append(s);
	 });

	 var arrCrossRight = $('.crossRight');
	 arrCrossRight.each(function(i){
	     var elementLeft = $(this),
		 width   = elementLeft.innerWidth(),
		 height  = elementLeft.innerHeight(),
		 line      = 1.41*Math.sqrt(width*width + height*height),
		 rad = Math.atan2(height,width),
		 angle = rad*360/(2*Math.PI),
		 s = '<b class="child" ';
	     s += 'style="width:'+line+'px;';
	     s += '-webkit-transform: rotate(-'+angle+'deg);';
	     s += '-moz-transform: rotate(-'+angle+'deg);';
	     s += '-ms-transform: rotate(-'+angle+'deg);';
	     s += '-o-transform: rotate(-'+angle+'deg);';
	     s += 'transform: rotate(-'+angle+'deg);';
	     s += '-sand-transform: rotate(-'+angle+'deg);';
	     topMargin     = (height/8);
	     leftMargin = (height/2);
	     s += 'margin-top: -'+topMargin+'px;';
	     s += 'margin-left: -'+leftMargin+'px;';
	     s += '"></b>';
	     elementLeft.append(s);
	 });
     }
     $(document).ready(function() {
	 draw();
	 drawLine();
     });

     $('#categories').change( function (e) {
	 
	 e.preventDefault();

	 $.ajax({
	     type: 'post',
	     url: 'good-night-sleep-list',
	     data: {categories: $('#categories').val()},
	     dataType: 'json',
	     success: function (response) {
		 $("#hardOneId").html(response.hardOneList);
		 $("#hardTwoId").html(response.hardTwoList);
		 $("#hardThreeId").html(response.hardThreeList);
		 $("#easyOneId").html(response.easyOneList);
		 $("#easyTwoId").html(response.easyTwoList);
		 $("#easyThreeId").html(response.easyThreeList);
		 $("#submitTimesId").html(response.submitTimes);
	     }
	 });

     });
     
     $( window ).resize(function() {
	 draw();
     });

     function validation(){
	 if($("#hardOneId").val()!=null&&$("#hardTwoId").val()!=null&&$("#hardThreeId").val()!=null&&$("#easyOneId").val()!=null&&$("#easyTwoId").val()!=null&&$("#easyThreeId").val()!=null){
	     return true;
	 }else{
	     alert("Please Finish All Selections")
	     return false;
	 }
     }
    </script>
</html>

