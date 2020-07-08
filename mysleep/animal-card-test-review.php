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
$query = $_SERVER['QUERY_STRING'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
?>

<html>
    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Animal Card Review</title>
    </head>
    <body>
	<?php include 'partials/nav.php' ; ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		      <div class="container">
        <?php
        require_once('partials/nav-links.php');
        navigationLink($config,$userType);
         ?>
		     <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <div class="row"; >
    			<table data-toggle="table" data-buttons-class="white btn-just-icon" data-search="true" data-show-columns="true" id="result" class="table table-striped table-hover">
			    <thead>
			    <tr>
				<th>Least Sleep</th><th>1st</th><th>2nd</th><th>3rd</th><th>4th</th><th>5th</th><th>6th</th><th>7th</th><th>8th</th><th>9th</th><th>10th</th><th>11th</th><th>12th</th><th>Most Sleep</th><th>Submit Time</th>
			    </tr>
			    </thead>
			    <tbody>
				<?php
				include 'connectdb.php';
				require_once('utilities.php');
				$result =mysql_query("SELECT * FROM animal_card_test_answers_table WHERE userId='$userId' order by resultRow");
	                        while($row = mysql_fetch_array($result)){
				   echo "<tr>";
				 echo "<td> < </td>";
				$order = explode(",", $row['sortResult']);
				foreach($order as $item){
                		    echo "<td>".$item."</td>";
				   }
				   echo "<td> > </td><td>".$row['submitTime']."</td>";
				    echo "</tr>";
			        }
				mysql_close($con);
				?>

			    </tbody>
			</table>
		    </div>
		</div>
	    </div>
	    <?php include 'partials/footer.php' ?>
	</div>
    </body>
<?php include 'partials/scripts.php' ?>
</html>
