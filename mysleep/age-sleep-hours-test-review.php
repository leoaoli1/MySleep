<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# (C) Univeristy of Arizona, College of Education 2016
# Not to be changed, modified, or distributed without express written permission of the entity.
#
# Authors: Ao Li <aoli1@email.arizona.edu>
#          James Geiger <jamesgeiger@email.arizona.edu>
#

require_once('utilities.php');
require_once('connectdb.php');
checkauth();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

    	  $hour_1 = array_fill(0, 6, "");
    	  $hour_2 = array_fill(0, 6, "");
    	  $hour_3 = array_fill(0, 6, "");
    	  $hour_4 = array_fill(0, 6, "");
    	  $hour_5 = array_fill(0, 6, "");
    	  $hour_6 = array_fill(0, 6, "");
    	  /*function generate_id() {
    	  }*/
    	  function count_number($student_id, $column_name) {
    	  		$count_array = array_fill(0, 6, "");
    	  		$result = mysql_query("SELECT * FROM age_sleep_hours_test_answers_table WHERE userId='$student_id'");
    	  		$value = mysql_fetch_array($result);
    	  		//echo $value[$column_name];
    	  		if($value[$column_name]==="7-8") {
    	  			$count_array[0]="X";
				 }elseif($value[$column_name]==="7-9") {
				   $count_array[1]="X";         
				}elseif($value[$column_name]==="8-10") {
					$count_array[2]="X";
				}elseif($value[$column_name]==="9-11") {
					$count_array[3]="X";
				}elseif($value[$column_name]==="10-13") {
					$count_array[4]="X";
				}elseif($value[$column_name]==="11-14") {
					$count_array[5]="X";
				}
				return $count_array;
        }
        //print_r($result_link, $return = null);
        $age_list=["1-2 yr", "3-5 yr", "6-13 yr", "14-17 yr", "18-65 yr", "Over 65 yr"];
        $hour_1 = count_number($userId, "S_1_2_years_old");
        //print_r($years_1, $return = null);
		  $hour_2 = count_number($userId, "S_3_5_years_old");
        $hour_3 = count_number($userId, "S_6_13_years_old");
        $hour_4 = count_number($userId, "S_14_17_years_old");
        $hour_5 = count_number($userId, "S_18_64_years_old");
        $hour_6 = count_number($userId, "S_65_years_and_older");
        $hour_array = [$hour_1, $hour_2, $hour_3, $hour_4, $hour_5, $hour_6];
            mysql_close($con);
    ?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Review: Your Sleep Vote</title>
    </head>
    
<body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <ol class="breadcrumb">
                                    <li><a href="main-page">Home</a></li>
                                    <li><a href="sleep-lesson">Lessons</a></li>
                                    <li><a href="fifth-grade-lesson-menu?lesson=1">Lesson One</a></li>
                                    <li><a href="fifth-grade-lesson-activity-menu.php?lesson=1&activity=1">Activity One</a></li>
                                    <li class="active">Review: Your Sleep Vote</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                                <table class='table table-bordered text-center' id='reviewTable'>
                                    <thead>
                                       <tr>
                                           <th></th>
                                           <th class="text-center">7-8 hr</th>
                                           <th class="text-center">7-9 hr</th>
                                           <th class="text-center">8-10 hr</th>
                                           <th class="text-center">9-11 hr</th>
                                           <th class="text-center">10-13 hr</th>
                                           <th class="text-center">11-14 hr</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for($i=0; $i<6; $i++) {
                                                echo "<tr>";
                                                echo "<th scope='row' class='text-right'>".$age_list[$i]."</th><td>".$hour_array[$i][0]."</td><td>".$hour_array[$i][1]."</td><td>".$hour_array[$i][2]."</td><td>".$hour_array[$i][3]."</td><td>".$hour_array[$i][4]."</td><td>".$hour_array[$i][5]."</td>";
                                                echo "</tr>";
                                        }?>  
                                    </tbody>
                               </table>
                            </div>
                        </div>
                    </div>
                </div>
                                <?php include 'partials/footer.php' ?>
            </div>
    </body>
    <?php include 'partials/scripts.php' ?>

    <script>
        $(function(){
            $('td').click(function() {
                
                if ($(this).hasClass("danger")) {
                    $(this).removeClass("danger");
                } else {
                    $(this).addClass("danger");
                }
            });
        });
    </script>
</html>
