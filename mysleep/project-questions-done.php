<?php

require_once 'utilities.php';
require_once 'connectdb.php';

checkauth();

$userId         = $_SESSION['userId'];
$grade = getGrade($userId);
$questions = mysql_escape_string($_POST['questions']);

if(isset($_POST['btnSubmit'])){
    $isSubmitted = 1;
}
else {
    $isSubmitted = 0;
}

$sql = "INSERT INTO projectQuestion (userId,grade,questions,submit) VALUES ('$userId','$grade','$questions', '$isSubmitted');";
    
$result = mysql_query($sql);

if (mysql_error()){
    header('HTTP/1.1 500 INSERT ERROR');
}

?>
<html>
    <head>
	<?php include 'partials/header.php' ?>
	<style type="text/css">
	 .top{
	     margin-top: 200px;
	 }
	</style>
    </head>
    <body>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
		    <div class="row top">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    <?php
			    if($isSubmitted == 1){
				echo '<h2>You Submitted it</h2>';
			    }
			    
			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    if(isset($_POST['btnSubmit'])){
				echo '<a class="btn btn-large btn-block"  name="Done" href="fifth-grade-lesson-activity-menu?lesson=4&activity=3">Done</a>';
			    }
			    
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
