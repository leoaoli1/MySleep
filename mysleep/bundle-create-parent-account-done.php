<!DOCTYPE html>
<?php 

# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu> James Michael Geiger<jamesgeiger@email.arizona.edu >
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
} 
if($userType!="teacher" && $userType!="researcher"){
    header("Location: login");
    exit;
} 
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Bundle Create Account</title>
	<style>
	 caption { 
	     display: table-caption;
	     text-align: center;
	 }
	</style>
    </head>
    <body>
	<?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="location.href='main-page'">Home</a></li>
			<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
			<li class="active">Bundle Create Parent Accounts</li>
		    </ol>
		    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em;">
			<h4 class="description">
			    <div class="row" style="color:black">
				
			    </div>
			</h4>
		    </div>
				<?php
				header("Content-type:text/html;charset:utf-8");
				header("content-type: text/plain");

				
				$accountFile=$_FILES['createParentAccounts'];
				$accountFname=$accountFile['name'];
				$accountFtype=strtolower(substr(strrchr($accountFname,'.'),1));
				log_info("Uploaded file: ".$accountFname);

				$uploadAccountFile=$accountFile['tmp_name'];

				if($_SERVER['REQUEST_METHOD']=='POST'){
				    if(is_uploaded_file($uploadAccountFile)){
					if($accountFtype!='csv'){
					    echo "Import file type is error";
					    exit;   
					}
				    }
				    else{
					echo "The file is empty!";
					exit; 
				    } 
				}

				//echo "Start";
				list($userName, $firstName, $lastName, $emailAddress, $firstId, $secondId) = userInfo($uploadAccountFile);
				//list($userName, $firstName, $lastName, $emailAddress, $firstId, $secondId, $thirdId) = userInfo($uploadAccountFile);
				//print_r($userName);
				//print_r($firstName);
				//print_r($lastName);
				//print_r($emailAddress);
				//exit;
				include 'connectdb.php';
				//process different types of registration
				if($userType == 'researcher'){
				    $user_type = 'parent';
				}elseif($userType == 'teacher'){
				    $schoolId = $_SESSION['schoolId'];
				    $user_type = 'student';
				    $classGrade = getClassGrade($classId);
				}
			
				$initPassword = 'zfactor';
				$encryptedPassword = SHA1($initPassword);
				
				
				#---------------------------------------------------
				# Create Account for each student. If not success, student info will in be in the unsuccess table. 
				#--------------------------------------------------
				$sUserNameSuccess = [];
				$sFirstNameSuccess = [];
				$sLastNameSuccess = [];
				$sEmailAddressSuccess = [];
				$sFirstIdSuccess = [];
				$sSecondIdSuccess = [];
				//$sThirdIdSuccess = [];
				

				$sUserNameUnsuccess = [];
				$sFirstNameUnsuccess = [];
				$sLastNameUnsuccess = [];
				$sEmailAddressUnsuccess = [];
				$sFirstIdUnsuccess = [];
				$sSecondIdUnsuccess = [];
				//$sThirdIdUnsuccess = [];
				
				for($i = 0; $i<count($userName); $i++){
				    #init each student's info
				    $sUserName = base64_encode($userName[$i]);
				    $sFirstName = $firstName[$i];
				    $sLastName = $lastName[$i];
				    $sEmailAddress = $emailAddress[$i];
				    $sFirstId = $firstId[$i];
				    $sSecondId = $secondId[$i];
				    //$sThirdId = $thirdId[$i];
				    //echo $sUserName;
				    
				    // Check if userName are already in the database
				    $result = mysql_query("SELECT * FROM user_table Where userName = '$sUserName'");
				    //echo $sUserName.'<br>';
				    //echo mysql_num_rows($result).'<br>';
				    if (mysql_num_rows($result) > 0) {
					array_push($sUserNameUnsuccess, $sUserName);
					array_push($sFirstNameUnsuccess, $sFirstName);
					array_push($sLastNameUnsuccess, $sLastName);
					array_push($sEmailAddressUnsuccess, $sEmailAddress);
					array_push($sFirstIdUnsuccess, $sFirstId);
					array_push($sSecondIdUnsuccess, $sSecondId);
					//array_push($sThirdIdUnsuccess, $sThirdId);

					/*print_r($sUserNameUnsuccess);
					print_r($sFirstNameUnsuccess);
					print_r($sLastNameUnsuccess);
					print_r($sEmailAddressUnsuccess);*/
					
				    }else{
					$status = mysql_query("INSERT INTO user_table(`firstName`, `lastName`, `userName`, `password`, `emailAddress`, `type`, `firstId`, `secondId`) VALUES ('$sFirstName','$sLastName','$sUserName','$encryptedPassword',  '$sEmailAddress', '$user_type', '$sFirstId', '$sSecondId')"); 
					//$status = mysql_query("INSERT INTO user_table(`firstName`, `lastName`, `userName`, `password`, `currentGrade`, `emailAddress`, `type`, `classId`, `schoolId`, `firstId`, `secondId`, `thirdId`) VALUES ('$sFirstName','$sLastName','$sUserName','$encryptedPassword', '$classGrade', '$sEmailAddress', '$user_type','$classId', '$schoolId', '$sFirstId', '$sSecondId', '$sThirdId')"); 
					if (!$status) {
					    error_exit('Could not add user to the database: ' . mysql_error());
					}
					array_push($sUserNameSuccess, $sUserName);
					array_push($sFirstNameSuccess, $sFirstName);
					array_push($sLastNameSuccess, $sLastName);
					array_push($sEmailAddressSuccess, $sEmailAddress);
					array_push($sFirstIdSuccess, $sFirstId);
					array_push($sSecondIdSuccess, $sSecondId);
					//array_push($sThirdIdSuccess, $sThirdId);
					//print_r($sUserNameSuccess);
					/*print_r($sFirstNameSuccess);
					   print_r($sLastNameSuccess);
					   print_r($sEmailAddressSuccess);*/
				    }
				}
				//echo count($sUserNameSuccess);
				mysql_close($con);
				?>

		    <!-- Success Table -->
		    <div class="row col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			<div id="toolbarSuccess">
			    <a class="btn btn-sm btn-block" download="SuccessCreate.csv" href="#" onclick="return ExcellentExport.csv(this, 'success');">Create My File</a>
			</div>
			<table class="table table-striped" data-toggle="table" data-toolbar="#toolbarSuccess"  data-icons-prefix="fa"   id="success">
			    <caption> Success Create Users </caption>
			    <thead>
				<tr>
				    <td>Username</td><td>First Name</td><td>Last Name</td><td>Eamil Address</td><td>Password</td><td>First ID</td><td>Second ID</td><!-- <td>Third ID</td> -->
				</tr>
			    </thead>
			    <tbody>
				<?php
				
				for($i=0; $i<count($sUserNameSuccess); $i++){
				    echo "<tr>";
				    echo "<td>".base64_decode($sUserNameSuccess[$i])."</td><td>".$sFirstNameSuccess[$i]."</td><td>".$sLastNameSuccess[$i]."</td><td>".$sEmailAddressSuccess[$i]."</td><td>zfactor</td><td>".$sFirstIdSuccess[$i]."</td><td>".$sSecondIdSuccess[$i]."</td>";
				    //echo "<td>".base64_decode($sUserNameSuccess[$i])."</td><td>".$sFirstNameSuccess[$i]."</td><td>".$sLastNameSuccess[$i]."</td><td>".$sEmailAddressSuccess[$i]."</td><td>zfactor</td><td>".$sFirstIdSuccess[$i]."</td><td>".$sSecondIdSuccess[$i]."</td><td>".$sThirdIdSuccess[$i]."</td>";
				    echo "</tr>";
				}
				
				?>
			    </tbody>
			</table>
		    </div>
		    <!-- Unsuccess Table -->
		    <div class="row col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			<div id="toolbarUnsuccess">
			    <a class="btn btn-sm btn-block" download="UnsuccessCreate.csv" href="#" onclick="return ExcellentExport.csv(this, 'unsuccess');">Create My File</a>
			</div>
			<table class="table table-striped" data-toggle="table" data-toolbar="#toolbarUnsuccess"  data-icons-prefix="fa"   id="unsuccess">
			    <caption> Unsuccess Create Users (User is existing)</caption>
			    <thead>
				<tr>
				    <td>Username</td><td>First Name</td><td>Last Name</td><td>Eamil Address</td><td>First ID</td><td>Second ID</td><!-- <td>Third ID</td> -->
				</tr>
			    </thead>
			    <tbody>
				<?php
				
				for($i=0; $i<count($sUserNameUnsuccess); $i++){
				    echo "<tr>";
				    echo "<td>".base64_decode($sUserNameUnsuccess[$i])."</td><td>".$sFirstNameUnsuccess[$i]."</td><td>".$sLastNameUnsuccess[$i]."</td><td>".$sEmailAddressUnsuccess[$i]."</td><td>".$sFirstIdUnsuccess[$i]."</td><td>".$sSecondIdUnsuccess[$i]."</td>";
				    //echo "<td>".base64_decode($sUserNameUnsuccess[$i])."</td><td>".$sFirstNameUnsuccess[$i]."</td><td>".$sLastNameUnsuccess[$i]."</td><td>".$sEmailAddressUnsuccess[$i]."</td><td>".$sFirstIdUnsuccess[$i]."</td><td>".$sSecondIdUnsuccess[$i]."</td><td>".$sThirdIdUnsuccess[$i]."</td>";
				    echo "</tr>";
				}
				
				?>
			    </tbody>
			</table>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
    </body>
</html>
<?php

function userInfo($filename)
{
    $NUM_DATA_COLUMNS = 6;         //Number of columns of data
    $userName = [];
    $firstName = [];
    $lastName = [];
    $emailAddress = [];
    $firstId = [];
    $secondId = [];
    //$thirdId = [];
    //echo "Done 1";

    $fhandle = fopen($filename, 'r');
    while (!feof($fhandle)) {
        $lines[] = fgetcsv($fhandle, $delimiter=',');
    }
    fclose($fhandle);
    
    //print_r($lines);
    
    $row=0;
    // Random Check File
    for (; $row<count($lines); $row++) {
        if (count($lines[$row]) != $NUM_DATA_COLUMNS)
            continue;
        // Verify data type
        if ($lines[$row][0] != "userName")
            continue;
        if ($lines[$row][1] != "firstName")
            continue;
        if ($lines[$row][2] != "lastName")
            continue;
        if ($lines[$row][3] != "emailAddress")
            continue;
	if ($lines[$row][4] != "firstId")
            continue;
	/*if ($lines[$row][5] != "secondId")
            continue;
	if ($lines[$row][6] != "thirdId")
            continue;*/
        break;
    }

    $headerRow = $row;

    //echo $row;
    //echo "Done 2";
    
    if ($row == count($lines)) {          // Nothing has been found
        log_error($filename);
        log_error("No data header is found in file.");
        return;
    }
    
    $i = $headerRow+1;
    //echo count($lines);
    // get how many line of data, break at last line 
    for ($j= 0; $j<count($lines); $j++) {
        if (count($lines[$j]) != $NUM_DATA_COLUMNS)
            break;
    }
    //count($lines)
    while ($i < $j) {  
	$numCol = count($lines[$i]);
	//echo count($lines[$i]);
	if (count($lines[$i]) != $NUM_DATA_COLUMNS)
            continue;
	for($index=0; $index<$numCol; $index++){
            if($lines[$headerRow][$index] == "userName"){
		$account = strtolower($lines[$i][$index]);
		array_push($userName, $account);
		//print_r($userName);
		continue;
	    }elseif($lines[$headerRow][$index] == "firstName"){
		array_push($firstName, $lines[$i][$index]);
		continue;
	    }elseif($lines[$headerRow][$index] == "lastName"){
		array_push($lastName, $lines[$i][$index]);
		continue;
	    }elseif($lines[$headerRow][$index] == "emailAddress"){
		array_push($emailAddress, $lines[$i][$index]);
		//print_r($emailAddress);
		continue;
	    }elseif($lines[$headerRow][$index] == "firstId"){
		array_push($firstId, $lines[$i][$index]);
		continue;
	    }elseif($lines[$headerRow][$index] == "secondId"){
		array_push($secondId, $lines[$i][$index]);
		continue;
	    }
	    /*elseif($lines[$headerRow][$index] == "thirdId"){
		array_push($thirdId, $lines[$i][$index]);
		continue;
	    }*/
	}
	$i++;	
	//echo $i;
    }

    //echo "Done";
    //echo $i;
    //print_r($userName);
    //exit;
    return  array(
	$userName,
	$firstName,
	$lastName,
	$emailAddress,
	$firstId,
	$secondId,
    );
    /*return  array(
	$userName,
	$firstName,
	$lastName,
	$emailAddress,
	$firstId,
	$secondId,
	$thirdId,
    );*/
}
?>


