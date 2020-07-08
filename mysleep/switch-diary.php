<!DOCTYPE html>
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
if($userId==""){
    header("Location: login");
    exit;
}

$location = $_GET['location'];

$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
   $diary = $_GET['diary'];
   $_SESSION['diary'] = $diary;
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Switch Diary</title>
    </head>
    

    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
                        <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
                        <li class="active"><?php if($diary == "sleep"){
					       echo "Switch Sleep Diary";
					   }else{
					       echo "Switch Activity Diary";
					   }
					   ?>
			</li>
		    </ol>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <div class="content" style="padding: 1cm">
			<form method="post" id="nameForm" enctype="multipart/form-data">
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>Name</h2></label>
				    <select name="studentId" id="studentId" class="form-control input-lg">
					<?php
					include 'connectdb.php';
					echo "<option value='null' disabled selected>Please Choose A Student</option>";
					
					$linkedStudents = getUserIdsInClass($classId);
				        foreach($linkedStudents as $studentId){
					    list($firstName, $lastName) = getUserFirstLastNames($studentId);
					    echo "<option value='$studentId'>" . $firstName." ".$lastName. "</option>";
					}
					mysql_close($con);
					?>
				    </select>
				</div>
			    </div>
			</form>
		    </div>

		    <div class="content" style="padding-top: 1cm">
			<form action="switch-diary-done" method="post" id="diaryForm">
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>From</h2></label>
				    <div id="diaryDiv">
				      <select name="fromDiaryId" id="fromDiaryId" class="form-control input-lg">
					<option value='null' disabled selected>Please Choose A Diary Date</option>
					
				    </select>
				    </div>
				</div>
			    </div>
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>To</h2></label>
				    <div id="diaryDiv">
					<select name="toDiaryId" id="toDiaryId" class="form-control input-lg">
					    <option value='null' disabled selected>Please Choose A Diary Date</option>
					</select>
				    </div>
				</div>
			    </div>
			    <div class="row" style="padding-top: 1cm">
				<div class="col-md-offset-5 col-md-2">
				    <input class="btn btn-danger btn-large btn-block" type="submit" name="quit" value="Switch" onclick="return confirm('Are you sure?')" />
				</div>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>	
    <?php require 'partials/scripts.php' ?>
    <script>
     var diary = "<?php echo $diary; ?>";
     var link;
     if(diary == 'sleep'){
	 fromLink = 'completed-diary-list?diary=sleep';
	 toLink = 'empty-diary-list?diary=sleep';
     }else{
	 fromLink = 'completed-diary-list?diary=activity';
	 toLink = 'empty-diary-list?diary=activity';
     }
     $( document ).ready(function () {
         $('#nameForm :input').change( function (e) {
	     
	     e.preventDefault();

	     $.ajax({
		 type: 'post',
		 url: fromLink,
		 data: $('#nameForm').serialize(),
		 success: function (response) {
		     $("#fromDiaryId").html(response); 
		 }
	     });

	     $.ajax({
		 type: 'post',
		 url: toLink,
		 data: $('#nameForm').serialize(),
		 success: function (response) {
		     $("#toDiaryId").html(response); 
		 }
	     });

         });
	 
     });
    </script>
</html>

