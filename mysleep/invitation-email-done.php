<!DOCTYPE html>
<?php
# 
# Part of the MySleep package
# 
# University of Arizona Copyright 2016
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#         James Geiger    <jamesgeiger@email.arizona.edu> 
require_once('utilities.php');
require_once('assets/mailer/class.phpmailer.php');  
session_start();
$userId= $_SESSION['userId'];
if ($userId == ""){
    header("Location: login.php");
    exit;
}
$classId = $_SESSION['classId'];
include 'connectdb.php';
$currentGrade = getClassGrade($classId);

$subject = $_POST['subject'];
$name = $_POST['name'];
$emailAddress = $_POST['emailAddress'];
$msg =  $_POST['content'];
if(currentGrade=='4'){
    $path = 'docs/parent_letter_4th_grade_implementation_FINAL.pdf';
    $path2 = 'docs/parent_letter_4th_grade_implementation_FINAL_SPANISH.pdf';
}else{
    $path = 'docs/parent_letter_5th_grade_implementation_FINAL.pdf';
    $path2 = 'docs/parent_letter_5th_grade_implementation_FINAL_SPANISH.pdf';
}
$fname = "parents-letter-English.pdf";
$fname2 = "parents-letter-Spanish.pdf";
$result = sendEmail($emailAddress, $msg, $path, $fname, $path2, $fname2, $subject, $name);


/*
   $emailAddress = $_POST['emailAddress'];
   $subject = 'Zfactor Program Invitation';

   $headers = 'From: mysleep@zfactor.coe.arizona.edu';

   $result = mail($emailAddress, $subject, $content, $headers);
 */
if ($result)
{
    $message = "Success! Your invitation has been sent.";
}
else{
    $message = 'Oops! Something wrong. Please click "Send Another Invitation" to re-try it or contact the Zfactor team.';
}


function sendEmail($destination, $bodyText, $filePath, $fileName, $filePath2, $fileName2, $subjectSend, $nameSend){  
    $email = new PHPMailer();
    $email->From      = 'mysleep@zfactor.coe.arizona.edu';
    $email->FromName  =  $nameSend;
    $email->Subject   =  $subjectSend;
    $email->Body      =  rtrim($bodyText);
    $email->AddAddress($destination);
    $email->AddAttachment( $filePath , $fileName );
    $email->AddAttachment( $filePath2 , $fileName2 );
    return $email->Send();
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
			    
			    echo '<h3>'.$message.'</h3>';

			    ?>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <?php
			    if($result){
				echo '<a class="btn btn-large btn-block btn-primary"  href="invitation-email">Send Another Invitation</a>';
				echo '<a class="btn btn-large btn-block btn-primary"  href="admin-tools">Done</a>';
			    }else{
				echo '<a class="btn btn-large btn-block btn-primary"  href="invitation-email">Send Another Invitation</a>';
			    }
			    ?>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
