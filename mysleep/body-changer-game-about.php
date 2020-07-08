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
if($userId==""){
    header("Location: login");
    exit;
}
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
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li class="active">Body Changer Game About</li>
                            </ol>
                        </div>
                    </div>
		    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			<h1 style="font-family:Comic Sans MS; font-size:200%;">How Insufficient Sleep Puts Your Health at Risk</h1>
		    </div>
		    <div class="row" style="border-color:white">
			<div class="col-md-4 col-sm-4" style="border-color:white">
			    <div class="thumbnail" style="border-color:white">
				<h2 style="font-family:Comic Sans MS; font-size:170%;">Congratulations on completing the simulations.  You have now have learned how insufficient sleep affects the function of several body systems and increases the risk of disease.</h2>   
			    </div>
			</div>
			<div class="col-md-4 col-sm-4" style="border-color:white">
			    <div class="thumbnail" style="border-color:white"><class="thumb">
				<div class="caption" style="border-color:white">
				    <p>
					<img src="images/body-changer/nodes_whole.gif" style="height:450px; width: 500px;" align="middle" >      
				    </p>       
				</div>
			    </div>
			</div>
			<div class="col-md-4" style="border-color:white">
			    <div class="thumbnail" style="border-color:white" >
				<p> </p>
				<p> </p>
				<p align="right">
				    <a href="body-changer-game" class="btn btn-info btn-lg" role="button">Continue</a>
			    </div>
			</div>
		    </div>
		</div> 
	    </div>
	</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <?php include 'partials/scripts.php' ?>
</html>
