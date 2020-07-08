<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# Copyright 2017 University of Arizona
#

require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];

$config = $_SESSION['current_config'];

if($userId==""){
    header("Location: login");
    exit;
   }
   if(isset($_GET['answer'])){
    $_SESSION['bsAnswer'] = $_GET['answer'];
   }
//debugToConsole('answer', $_SESSION['bsAnswer']);

?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Body Changer</title>
    </head>

    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
      <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType);
                } else {?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                              <li><a href="#" onclick="location.href='main-page'">Home</a></li>
			       <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                              <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=3'">Lesson Three</a></li>
			      <li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=3&activity=4'">Activity Four</a></li>
			      <li><a href="#" onclick="location.href='body-changer-index'">Body Change Welcome Page</a></li>
			      <!--<li><a href="#" onclick="location.href='body-changer-simulator-display'">Body Change Simulator Display</a></li>
			      <li><a href="#" onclick="location.href='body-changer-simulation-selection'">Body Change Simulation Selection</a></li>-->
			      <li><a href="#" onclick="location.href='body-changer-bs-simulation-description'">Body Changer Endocrine System Description</a></li>
                              <li class="active">Endocrine System Simulation</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>

		    <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
			<h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>Test your hypothesis</strong></h1>
		    </div>
		    <form action="body-changer-bs-simulation" method="post">
			<div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
			    <h2 style="font-family:Comic Sans MS; color:blue;font-size:150%;" >
				<?php if($_SESSION['clickTimesBS']>=1){ ?>
				    <!-- <p style="color:black;">Click on another value for hours of sleep. Then click on simulate.</p> -->
				    <ol>
					<li>Select a number of hours of sleep. Click Simulate</li>
					<li>Compare the amounts of glucose and insulin to perform the function of your body’s pancreas, which has to produce the right amount of insulin. Then hit the space bar.</li>
					<li>The data displayed in the graph is the average glucose level for people with that amount of sleep.</li>
					<li>Repeat.  When you have 3 data points, you will be asked to draw a conclusion about the data.</li>
				    </ol>
				<?php }else{ ?>
				    <!-- <p style="color:black;">Select a number of hours of sleep. Then click the Simulate box. When you see the “illustratation” on the screen compare the amounts of glucose and insulin.  By doing this, you are performing the function of your body’s pancreas, which has to produce the right amount of insulin.  Then hit the space bar.  For the purposes of this simulation, however, the result displayed is actual data from research studies.</p>
					 <p>After three trials, you will be asked to draw a conclusion about the relationship between the amount of nightly sleep and blood glucose levels.</p>-->
				    <ol>
					<li>Select a number of hours of sleep. Click Simulate</li>
					<li>Compare the amounts of glucose and insulin to perform the function of your body’s pancreas, which has to produce the right amount of insulin. Then hit the space bar.</li>
					<li>The data displayed in the graph is the average glucose level for people with that amount of sleep.</li>
					<li>Repeat.  When you have 3 data points, you will be asked to draw a conclusion about the data.</li>
				    </ol>
				    <?php } ?>
			    </h2>
			    <div>
				<input type="radio" name="sleephours"  id="question-1-answers-A" value="A" />
				<label style="font-family:Comic Sans MS; color:green;font-size:150%;" for="question-1-answers-A">10</label>
			    </div>
			    <div>
				<input type="radio" name="sleephours" id="question-1-answers-B" value="B" />
				<label style="font-family:Comic Sans MS; color:green; font-size:150%;" for="question-1-answers-B">9</label>
			    </div>

			    <div>
				<input type="radio" name="sleephours" id="question-1-answers-C" value="C" />
				<label style="font-family:Comic Sans MS; color:green; font-size:150%;" for="question-1-answers-C">8</label>
			    </div>

			    <div>
				<input type="radio" name="sleephours" id="question-1-answers-D" value="D" />
				<label style="font-family:Comic Sans MS; color:green; font-size:150%;" for="question-1-answers-D">7</label>
			    </div>
			    <div>
				<input type="radio" name="sleephours" id="question-1-answers-E" value="E" />
				<label style="font-family:Comic Sans MS; color:green; font-size:150%;" for="question-1-answers-E">6</label>
			    </div>
			    <div>
				<input type="radio" name="sleephours" id="question-1-answers-F" value="F" />
				<label style="font-family:Comic Sans MS; color:green; font-size:150%;" for="question-1-answers-F">5</label>
			    </div>
			    <div>
				<input type="radio" name="sleephours" id="question-1-answers-G" value="G" />
				<label style="font-family:Comic Sans MS; color:green; font-size:150%;" for="question-1-answers-G">4</label>
			    </div>
			</div>
			<div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
			    <input type="submit" class="btn btn-primary bnt-lg" name="formSubmit" value="Simulate">
			</div>
		    </form>
		</div>
	    </div>
	</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
    <script type="text/javascript">
     var radio = <?php echo json_encode($_SESSION['radioBS']); ?>;
     //console.log(radio);
    for(var i = 0; i < radio.length; i++){
	 if(radio[i] == 'A'){
	     $("#question-1-answers-A").attr('disabled', true);
	     $('label[for=question-1-answers-A]').css({color:'grey'});
	 }else if(radio[i] == 'B'){
	     $("#question-1-answers-B").attr('disabled', true);
	     $('label[for=question-1-answers-B]').css({color:'grey'});
	 }else if(radio[i] == 'C'){
	     $("#question-1-answers-C").attr('disabled', true);
	     $('label[for=question-1-answers-C]').css({color:'grey'});
	 }else if(radio[i] == 'D'){
	     $("#question-1-answers-D").attr('disabled', true);
	     $('label[for=question-1-answers-D]').css({color:'grey'});
	 }else if(radio[i] == 'E'){
	     $("#question-1-answers-E").attr('disabled', true);
	     $('label[for=question-1-answers-E]').css({color:'grey'});
	 }else if(radio[i] == 'F'){
	     $("#question-1-answers-F").attr('disabled', true);
	     $('label[for=question-1-answers-F]').css({color:'grey'});
	 }else if(radio[i] == 'G'){
	     $("#question-1-answers-G").attr('disabled', true);
	     $('label[for=question-1-answers-G]').css({color:'grey'});
	 }
     }

     $("form").submit(function () {
	 var flag = true;
	 $(':radio').each(function () {
             name = $(this).attr('name');
             if (flag && !$(':radio[name="' + name + '"]:checked').length) {
		 alert('Please select a value');
		 flag = false;
             }
	 });
	 return flag;
     });

    </script>
</html>
