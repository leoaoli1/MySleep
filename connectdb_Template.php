<?php   
    $con = mysql_connect($servername, $username, $password);
    if (!$con){
        die('Failed to connect to database server: ' . mysql_error());
    }
    mysql_select_db($dbname, $con);      
?>
