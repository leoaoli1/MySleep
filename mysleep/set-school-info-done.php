 <!DOCTYPE html>
 <?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>, Siteng Chen <sitengchen@email.arizona.edu>
#
require_once('utilities.php');
require_once('assets/mailer/class.phpmailer.php');
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login.php");
	exit;
}

if (isset($_POST['quit'])) {
    header("Location: admin-tools.php");
    exit;
}

$schoolName = $_POST['schoolName'];
$emailAddress = $_POST['emailAddress'];
$actionType = $_POST['actionType'];

include 'connectdb.php';

// Look up the school from table
$result = mysql_query("SELECT * FROM school_info WHERE schoolName='$schoolName'");
$rowCount = mysql_num_rows($result);

function getInitPassword($pwdLength) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $pwdLength; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

if ($actionType == 'deleteExistingSchool') {
    if ($rowCount == 0) {
        echo "Class not found: ", $schoolName, "</br>";
    }
    else {
        mysql_query("DELETE FROM school_info WHERE schoolName='$schoolName'");
    }
}
else {
    if ($rowCount > 0) {
        echo "Class already exists: ", $schoolName, "</br>";
    }
    else {
        mysql_query("INSERT INTO school_info (schoolName) VALUES ('$schoolName')");
        if (isset($emailAddress)) {
          // create admin account send email notification
          $result = mysql_query("SELECT schoolId FROM school_info WHERE schoolName='$schoolName'");
          $row = mysql_fetch_array($result);
          $adminName = 'admin'.$row['schoolId'];
          $adminPwd = getInitPassword(10);

          // register
          $username = base64_encode(strtolower($adminName));
          $email = $emailAddress;
          $user_type = "teacher";
          $schoolId = $row['schoolId'];
          $fname = $schoolName;
          $lname = "Admin";
          // check whether userid has been taken
          $validCheck = mysql_query("SELECT * FROM user_table WHERE userName='$username'");
          if (mysql_num_rows($validCheck)>0) {
            error_exit('Admin username exist');
          }
          $encrypted = SHA1($adminPwd);
          $status = mysql_query("INSERT INTO user_table(userName,firstName,lastName, password, type, emailAddress, schoolId) VALUES ('$username', '$fname','$lname','$encrypted','$user_type', '$email', '$schoolId')");
      		if (!$status) {
      		    error_exit('Could not add user to the database: ' . mysql_error());
      		}

          // send email
          $subject = '[MySleep] The admin account created.';
          $message = '<html><body>';
          $message .= '<h1 style="color:#000;">Welcome to MySleep.</h1>';
          $message .= '<p style="color:#000;font-size:18px;">The admin account for <B>'.$schoolName. '</B> has been created. Please go to http://zfactor.coe.arizona.edu/mysleep and login using the following information:</p>';
          $message .= '<p style="color:#000;font-size:18px;">Username: <B>'.$adminName.'</B></p>';
          $message .= '<p style="color:#000;font-size:18px;">Password: <B>'.$adminPwd.'</B></p>';
          $message .= '<p style="color:#000;font-size:18px;">Please change the password after your first time login.</p>';
          $message .= '<p style="color:#000;font-size:18px;">Best</p>';
          $message .= '<p style="color:#000;font-size:18px;">MySleep Team</p>';
          $message .= '</body></html>';
          $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $headers .= 'From: mysleep@zfactor.coe.arizona.edu';

          $result = mail($emailAddress, $subject, $message, $headers);
          if ($result == false){
            log_error("Failed to send alert email to " . $emailAddress);
          }
        }
    }
}
mysql_close($con);
echo "success";

?>
