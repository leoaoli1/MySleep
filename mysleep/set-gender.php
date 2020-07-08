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
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php require 'partials/header.php' ?>
	<title>My Sleep // Set Gender</title>
	<style type="text/css">
	 .selector ul{
	     list-style: none;
	     height: 100%;
	     width: 100%;
	     margin: 0;
	     padding: 0;
	 }


	 .selector ul li{
	     color: #FFFFFF;
	     display: block;
	     position: relative;
	     float: left;
	     width: 100%;
	     height: 100px;
	     border-bottom: 1px solid #FFFFFF;
	 }

	 .selector ul li input[type=radio]{
	     position: absolute;
	     visibility: hidden;
	 }

	 .selector ul li label{
	     display: block;
	     position: relative;
	     font-weight: 300;
	     font-size: 1.35em;
	     color: #000000;
	     padding: 25px 25px 25px 80px;
	     margin: 10px auto;
	     height: 30px;
	     z-index: 9;
	     cursor: pointer;
	     -webkit-transition: all 0.25s linear;
	 }

	 .selector ul li:hover label{
	     color: #ff3300;
	 }

	 .selector ul li .check{
	     display: block;
	     position: absolute;
	     border: 5px solid #000000;
	     border-radius: 100%;
	     height: 30px;
	     width: 30px;
	     top: 30px;
	     left: 20px;
	     z-index: 5;
	     transition: border .25s linear;
	     -webkit-transition: border .25s linear;
	 }

	 .selector ul li:hover .check {
	     border: 5px solid ;
	     color: #ff3300;
	 }

	 .selector ul li .check::before {
	     display: block;
	     content: '';
	     border-radius: 100%;
	     height: 18px;
	     width: 18px;
	     margin-top: 1px;
	     margin-left: 1px;
	     transition: background 0.25s linear;
	     -webkit-transition: background 0.25s linear;
	 }

	 .selector input[type=radio]:checked ~ .check {
	     border: 5px solid #661aff;
	 }

	 .selector input[type=radio]:checked ~ .check::before{
	     background: #661aff;
	 }

	 .selector input[type=radio]:checked ~ label{
	     color: #661aff;
	 }
	</style>
    </head>
    

    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			
                        <li class="active">Set Gender</li>
		    </ol>
		    <div class="row">
			<div class="col-md-offset-5 col-md-4 col-sm-offset-5 col-sm-4 col-xs-offset-5 col-xs-4" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <div class="content" style="padding: 1cm">
			<form action="set-gender-done" method="post" id="genderForm" enctype="multipart/form-data">
			    <div class="selector col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6" style="padding-top: 1em;">
				<h4>Please select your gender</h4>
				<ul>
				    <li>
					<input type="radio" id="genderG" name="gender" value="Girl">
					<label for="genderG">Girl</label>
					<div class="check"></div>
				    </li>
				    <li>
					<input type="radio" id="genderB" name="gender" value="Boy">
					<label for="genderB">Boy</label>
					<div class="check"></div>
				    </li>
				    <li>
					<input type="radio" id="genderO" name="gender" value="Other">
					<label for="genderO">Other</label>
					<div class="check"></div>
				    </li>
				</ul>
			    </div>
			    <div class="row col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4 col-xs-offset-4 col-xs-4" style="padding-top: 1em;">
				<button class="btn btn-success btn-md btn-block" type="submit" name="submit"  id="submit" onClick="return validation()" />Submit</button>
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
     function validation(){
	 if($('#genderB').is(':checked') || $('#genderG').is(':checked') || $('#genderO').is(':checked')){
	     return true;
	 }else{
	     alert("Please select your gneder.");
	     return false;
	 }
     }
    </script>
</html>


