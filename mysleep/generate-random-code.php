
<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#

// Generate Random Verification Code for link parents and students
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if($userType != "student"){
    header("Location: login");
    exit;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg')">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Generate Random Verification Code</title>
	<style type="text/css">
	 .top{
	     margin-top: 200px;
	 }
	</style>
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
                                <li class="active">Generate Random Verification Code</li>
                            </ol>
                        </div>
                    </div>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description">
				Click the button to generate a verification code. Please show the code to your parents. Your parent will use it to link your account. The verification code valid 3 hours.
			    </h4>
			</div>
		    </div>
		    <div class="row" style="padding-top: 1em;">
			<div class="col-sm-offset-2 col-sm-10 col-md-6 col-md-offset-3">
			    Verification Code:
			    <?php
			    include "connectdb.php";
			    $result = mysql_query("SELECT random, updateTime FROM random_code_table Where userId='$userId'");
			    if( mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
				$verificationCode = $row['random']; 
				$currentTime = get_localtime($format="Y-m-d H:i:s");
				$threeHours = 3*60*60;
				$substractTime = strtotime($currentTime) - strtotime($row['updateTime']);
				//echo strtotime($row['updateTime']);
				//echo $currentTime;
				//echo $substractTime;
				if( $substractTime > $threeHours){
				    $status = "Invalid";
				}
				else{
				    $status = "Valid";
				}
			    }
			    mysql_close($con);
			    ?>
			    <span id="code"><?php echo $verificationCode; ?></span>&nbsp&nbsp&nbsp<span id="status" style="color:red">(<?php echo $status; ?>)</span>
			</div>
		    </div>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <form>
				<input class="btn btn-danger btn-large btn-block"; type="button" id="generate" value="Generate"/>
			    </form>
			</div>
		    </div>
		</div>
            </div>
            <?php include 'partials/footer.php' ?>
	</div>
	<?php include 'partials/scripts.php' ?>
        <script>
	 $('#generate').click( function (e) {
	     e.preventDefault();
	     $.ajax({
		 type: 'post',
		 url: 'generate-random-code-done',
		 dataType: 'json',
		 success: function (response) {
		     $("#code").html(response.code);
		     $("#status").html("Valid");
		 }
	     });
	 });
	</script>
    </body>
</html>
