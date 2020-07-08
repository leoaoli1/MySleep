<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#

session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep //Update Email Address</title>
    </head>

<body>
    <?php require 'partials/nav.php' ?>
    <div class="wrapper">
        <div class="main main-raised">
	    <div class="container">
                <div class="row">
		    <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                        <ol class="breadcrumb">
			    <li><a href="#" onclick="location.href='main-page'">Home</a></li>
			    <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
			    <li class="active">Update Email Address</li>
                        </ol>
		    </div>
                </div>
	    </div>
	    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
		<h4 class="description">
		    <div class="row" style="color:black">
			<?php
			include 'connectdb.php';

			$result = mysql_query("SELECT * FROM user_table WHERE userId='$userId'");
			$row = mysql_fetch_array($result);
			$emailAddress = $row['emailAddress'];
			echo "Current email address: ".$emailAddress, "</br>";
			mysql_close($con);
			?>
		    </div>
		</h4>
	    </div>
	    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 1em;">
		<form method="post" enctype="multipart/form-data" action="set-email-address-done" style="margin-top: 2em;">   
		    <div class="form-group">
			<div class="form-inline">
			    <label class="control-label" for="emailAddress"><h4 style="color:black">News Email Address:</h4></label>
			    <input class="form-control"; type="text" name="emailAddress" id="emailAddress" value="" </input>
			</div>
		    </div>
		    <div class="row" style="padding-top: 1cm">
			<input class='btn btn-danger btn-large btn-block' type='submit' name='updateEmailAddress' value='Update' onClick="return validation()" /> 
		    </div>
		</form>
	    </div>
	</div>
    </div>
    <?php include 'partials/scripts.php' ?>
</body>
<?php include 'partials/footer.php' ?>
<script>
 function validation(){
     if($("#emailAddress").val()!=""){
	 return true;
     }else{
	 alert("Please fill in your new email address")
	 return false;
     }
 }
</script>
</html>
