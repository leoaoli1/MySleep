
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
if($userType != "parent"){
    header("Location: login");
    exit;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Parent Link Student</title>
    </head>

    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page'">Home</a></li>
				<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
                                <li class="active">Parent Link Student</li>
                            </ol>
                        </div>
                    </div>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description">
				Please let your child to generate a verification code. The verification code valid 3 hours. Using the verification code and child's username to connect them.
			    </h4>
			</div>
		    </div>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <?php 
			    include 'connectdb.php';
			    $linkUsers = getLinkedUserIds($userId);
			    ?>
			    <table class="table">
				<caption>Linked Children</caption>
				<thead>
				    <tr>
					<th>First Name</th><th>Last Name</th>
				    </tr>
				</thead>
				<tbody>
				    <?php
				    foreach($linkUsers as $user){
					list($firstName, $lastName) = getUserFirstLastNames($user);
					echo "<tr>";
					echo "<td>".$firstName."</td><td>".$lastName."</td>";
					echo "</tr>";
				    }
				    mysql_close($con);
				    ?>
				</tbody>
			    </table>
			</div>
		    </div>
		    <form>
			<div class="row" style="padding-top: 1em;">
			    <div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="username"><h4 style="color:black">Username:</h4></label>
					<input class="form-control"; type="text" name="username" id="username" value=""/>*
				    </div>
				</div>
				<div class="form-group">
				    <div class="form-inline">
					<label class="control-label" for="code"><h4 style="color:black">Verification Code:</h4></label>
					<input class="form-control"; type="text" name="code" id="code"/>*
				    </div>
				</div>
			    </div>
			</div>
			<div class="row">
			    <div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
				<input class="btn btn-danger btn-large btn-block"; type="submit" id="link" value="Link" onclick="return validation()"/>
			    </div>
			</div>
		    </form>
		</div>
            </div>
	</div>
	<div id="linkSuccess" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="successLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Success</h4>
		    </div>
		    <div class="modal-body">
			<p>You Linked Your Child</p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="reload()">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<div id="linkError" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="successLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Error</h4>
		    </div>
		    <div class="modal-body">
			<p>Please check the username and the verification code.</p>
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

	 function reload() {
	     location.reload();
	 }
	 
	 function validation(){
	     if($("#username").val()!=''&&$("#code").val()!=''){
		 return true;
	     }else{
		 alert("Please Finish All Fields")
		 return false;
	     }
	
	 }
         $(function () {
             $('form').on('submit', function (e) {
		 
		 e.preventDefault();

		 $.ajax({
		     type: 'post',
		     url: 'parent-link-student-done',
		     data: $('form').serialize(),
		     success: function () {
			 $("#linkSuccess").modal('show');
			 $("#username").val('');
			 $("#code").val('');
		     },
		     error: function (){
			 $("#linkError").modal('show');
		     }
		 });

             });

	 });
	</script>
    </body>
</html>
