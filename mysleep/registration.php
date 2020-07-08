<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#


require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userType == "teacher"){
    $classId = $_SESSION['classId'];
}
if($userId==""){
    header("Location: login");
    exit;
} 

?>
<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Create Account</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
			<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
			<li class="active">Create Account</li>
		    </ol>
		    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em;">
			<h4 class="description">
			    <div class="row" style="color:black">
				
			    </div>
			</h4>
			<h4 class="description">
			    <div class="row" style="color:red">
				<?php
				if($userType == "teacher"){
				    include 'connectdb.php';
				    $className = getClassName($classId);
				    $classGrade = getClassGrade($classId);
				    echo "Current class is: ".$className."<br>";
				    echo "Class Grade is: ".$classGrade."<br>";
				    mysql_close($con);
				}
				?>
			    </div>
			</h4>
		    </div>
		    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
			<form>
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="username"><h4 style="color:black">Username:</h4></label>
				    <input class="form-control"; type="text" name="username" id="username" value="" required/>*
				</div>
			    </div>
			    <div class="form-group" style="display:none">
				<div class="form-inline">
				    <label class="control-label" for="password1"><h4 style="color:black">Password:</h4></label>
				    <input class="form-control"; type="password" name="password1" id="password1"/>
				</div>
			    </div>
			    <div class="form-group" style="display:none">
				<div class="form-inline">
				    <label class="control-label" for="password2"><h4 style="color:black">Re-enter Password:</h4></label>
				    <input class="form-control"; type="password" name="password2" id="password2"/>
				</div>
			    </div>
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="fname"><h4 style="color:black">First Name:</h4></label>
				    <input class="form-control"; type="text" name="fname" id="fname" value="" required/>*
				</div>
			    </div>
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="lname"><h4 style="color:black">Last Name:</h4></label>
				    <input class="form-control"; type="text" name="lname" id="lname" value="" required/>*
				</div>
			    </div>
			    <?php if($userType == "teacher"){ ?>
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="firstId"><h4 style="color:black">New ID (Student ID):</h4></label> <!-- First ID -->
					<input class="form-control"; type="text" name="firstId" id="firstId" value="" required/>*
				    </div>
				</div>
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="secondId"><h4 style="color:black">Subject ID (If you do not know this ID, please contact zfacto team):</h4></label> <!-- Second ID -->
					<input class="form-control"; type="text" name="secondId" id="secondId" value="" required/>*
				    </div>
				</div>
				<!-- <div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="thirdId"><h4 style="color:black">Third ID:</h4></label>
					<input class="form-control"; type="text" name="thirdId" id="thirdId" value=""/>*
				    </div>
				</div> -->
			    <?php }?>
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="email"><h4 style="color:black">Email Address:</h4></label>
				    <input class="form-control"; type="email" name="email" id="email" value=""/>
				</div>
			    </div>
			    <div class="form-group">
				<div class="form-inline">
				    <label class="control-label" for="user_type"><h4 style="color:black">User Type:</h4></label> 
				    <select name="user_type" id="user_type" class="form-control input-lg" required>
					<option value=''>User Type</option>;
					<?php
					if($userType == 'researcher'){
					    echo '<option value="researcher"> Researcher </option>';
					    echo '<option value="teacher"> Teacher </option>';
					    echo '<option value="parent"> Parent </option>';
					}elseif($userType == 'teacher'){
					    echo '<option value="student"> Student </option>';
					}elseif($userType == "student"){
					    echo '<option value="parent"> Parents </option>';
					}
					?>
				    </select>*
				</div>
			    </div>
			    <?php if($userType == "researcher"){ ?>
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="school_Id"><h4 style="color:black">School ID:</h4></label> 
					<select name="school_Id" id="school_Id" class="form-control input-lg">
					    <?php
					    include 'connectdb.php';
					    if(empty($schoolId)) {
						echo "<option value=''>Please Choose Teacher's School</option>";
					    }else{
						$result = mysql_query("SELECT * FROM school_info where schoolId='$schoolId'");
						$row = mysql_fetch_array($result);
						$schoolName = $row['schoolName'];
						echo "<option value='$schoolId'>" . $schoolName. "</option>";
					    }
					    $result = mysql_query("SELECT * FROM school_info");
					    while ($row = mysql_fetch_array($result)) {         
						$schoolId_show = $row['schoolId'];
						$schoolName_show = $row['schoolName'];
						echo "<option value='$schoolId_show'>" . $schoolName_show. "</option>";
					    }
					    mysql_close($con); 
					    
					    ?>
					</select> <h5>If user type is teacher, please fill in this field</h5>
				    </div>
				</div>
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="firstId"><h4 style="color:black">New ID (Student ID):</h4></label> <!-- First ID -->
					<input class="form-control"; type="text" name="firstId" id="firstId" value=""/> <h5>If user type is parent, please fill in this field</h5>
				    </div>
				</div>
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="secondId"><h4 style="color:black">Subject ID:</h4></label> <!-- Second ID -->
					<input class="form-control"; type="text" name="secondId" id="secondId" value=""/> <h5>If user type is parent, please fill in this field</h5>
				    </div>
				</div>
			    <?php } ?>
			    <div class="row" style="padding-top: 2cm">
				<input class="btn btn-danger btn-large btn-block"; type="submit" value="Create"/>
			    </div>
			</form>
		    </div>
		    <!-- Modal -->
		</div>
	    </div>
	</div>
	<div id="createSuccess" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="successLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Success</h4>
		    </div>
		    <div class="modal-body">
			<p>The initial password is "zfactor". Please update it as soon as possible.</p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<div id="createError" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="successLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Error</h4>
		    </div>
		    <div class="modal-body">
			<p>The username exists</p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	 <script>
	    var userType = '<?php echo $userType; ?>';
        $(function () {
        $('form').on('submit', function (e) {
            
          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'registration-done',
            data: $('form').serialize(),
              success: function () {
		  $("#createSuccess").modal('show');
		  $("#username").val('');
		  $("#password1").val('');
		  $("#password2").val('');
		  $("#fname").val('');
		  $("#lname").val('');
		  $("#firstId").val('');
		  $("#secondId").val('');
		  //$("#thirdId").val('');
		  $("#email").val('');
            },
              error: function (){
		  $("#createError").modal('show');
              }
          });

        });

      });
    </script>
    </body>
</html>
