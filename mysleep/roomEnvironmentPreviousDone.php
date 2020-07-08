<?php
#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#           James Geiger    <jamesgeiger@email.arizona.edu>                 #
#                                                                           #
# Filename: IdentificationTaskDone.php                                      #
#                                                                           #
# Purpose:  To recieve and handle form input from roomEnvironment.php       #
#                                                                           #
#############################################################################

require_once('utilities.php');
require_once('connectdb.php');
checkAuth();

# SET UP DATA

$userId = $_SESSION['userId'];

$roomTemp     = $_POST['tempSelection'];
$roomBed      = $_POST['bedSelection'];
$roomLight    = $_POST['lightSelection'];
$roomNoise    = $_POST['noiseSelection'];
$roomOther    = $_POST['otherSelection'];
$roomResponse = $_POST['responseOne'];

$q = "INSERT INTO roomConstruction (userId, temp, bed, light, noise, other, response) VALUES ('$userId', '$roomTemp', '$roomBed', '$roomLight', '$roomNoise', '$roomOther', '$roomResponse')";

$result = mysql_query($q, $con);

mysql_close($con);

?>
