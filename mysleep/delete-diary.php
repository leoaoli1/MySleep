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
	<title>My Sleep // Delete Diary</title>
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
					       echo "Delete Sleep Diary";
					   }else{
					       echo "Delete Activity Diary";
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
			<form action="delete-diary-done" method="post" id="diaryForm">
			    <div class="col-md-offset-3 col-md-6">
				<div class="form-group">
                                    <label class="control-label"><h2>Diary Date</h2></label>
				    <div id="diaryDiv">
				      <select name="diaryId" id="diaryId" class="form-control input-lg">
					<option value='null' disabled selected>Please Choose A Diary Date</option>
					
				    </select>
				    </div>
				</div>
			    </div>
			    <div class="row" style="padding-top: 1cm">
				<div class="col-md-offset-5 col-md-2">
				    <input class="btn btn-danger btn-large btn-block" type="submit" name="quit" value="Delete" onclick="return confirm('Are you sure?')" />
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
	 link = 'completed-diary-list?diary=sleep';
     }else{
	 link = 'completed-diary-list?diary=activity';
     }
     $( document ).ready(function () {
         $('#nameForm :input').change( function (e) {
	     
	     e.preventDefault();

	     $.ajax({
		 type: 'post',
		 url: link,
		 data: $('#nameForm').serialize(),
		 success: function (response) {
		     $("#diaryId").html(response); 
		 }
	     });

         });
	 
     });
    </script>
</html>


