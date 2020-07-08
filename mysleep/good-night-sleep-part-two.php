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
checkauth();
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
include 'connectdb.php';
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // </title>
    </head>

    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
	    <div class="main main-raised">
		<div class="container">
		    <div class="row">
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
			    <ol class="breadcrumb">
				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='main-page';">Home</a></li>
				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='sleep-lesson';">Lessons</a></li>
				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
				<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep';">I Can Use A Good Night's Sleep</a></li>
				<li class="active">Part Two</li>
			    </ol>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			<h4 class="description"></h4>
		    </div>
		</div>
		<form action="good-night-sleep-part-two-done" id="dateForm"  enctype="multipart/form-data" method="post">
		    <div class="row" style="padding-top: 1cm">
			<div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4">
			    <table class="table">
				<tr>
				    <th>Facilitators</th><th>Categories</th>
				</tr>
				<?php
				$facilitators = [];
    	  			$result = mysql_query("SELECT facilitatorAnswers FROM fourthGradeLessonThreeTableOne WHERE classId='$classId' And submit='1' And userType='teacher' order by recordId DESC Limit 1");
    	  			$row = mysql_fetch_array($result); 
				$facilitatorAnswers = $row['facilitatorAnswers'];
				$facilitators = unserialize(base64_decode($facilitatorAnswers));
				for($countFacilitor=0; $countFacilitor<count($facilitators); $countFacilitor++){
    	  			    echo "<td><textarea name='facilitators$countFacilitor' id='facilitators$countFacilitor' class='form-control' readonly>".htmlspecialchars($facilitators[$countFacilitor])."</textarea></td>
																															  <td>
																															    <select name='facilitatorsOption$countFacilitor' id='facilitatorsOption$countFacilitor' class='form-control input-lg'>
																															      <option value='null' disabled selected>Categories</option>
																															      <option value='1'>Family behavior, activity and routines</option>
																															      <option value='2'>Student behavior, activity and routines</option>
																															      <option value='3'>Environment and Community</option>
																															    </select>
																															  </td>
										</tr>";
				}
				?>
			    </table>
			</div>
			<div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4">
			    <table class="table">
				<tr>
				    <th>Competitors</th><th>Categories</th>
				</tr>
				<?php
				$competitors = [];
    	  			$result = mysql_query("SELECT competitorAnswers FROM fourthGradeLessonThreeTableOne WHERE classId='$classId' And submit='1' And  userType='teacher' order by recordId DESC Limit 1");
    	  			$row = mysql_fetch_array($result); 
				$competitorAnswers = $row['competitorAnswers'];
				$competitors = unserialize(base64_decode($competitorAnswers));
				for($countCompetitor=0; $countCompetitor<count($competitors); $countCompetitor++){
    	  			    echo "<td><textarea name='competitors$countCompetitor' id='competitors$countCompetitor' class='form-control' readonly>".htmlspecialchars($competitors[$countCompetitor])."</textarea></td>
																															   <td>
																															     <select name='competitorsOption$countCompetitor' id='competitorsOption$countCompetitor' class='form-control input-lg'>
																															       <option value='null' disabled selected>Categories</option>
																															       <option value='1'>Family behavior, activity and routines</option>
																															      <option value='2'>Student behavior, activity and routines</option>
																															      <option value='3'>Environment and Community</option>
																															     </select>
																															   </td>
										 </tr>";
				}
				?>
			    </table>
			</div>
			<div class="row" style="padding-top: 2cm">
			    <div class="col-sm-offset-4 col-sm-4 col-md-4 col-md-offset-4">
				<div class="collapse-group">
				    <a href="#" id="previous" style="font-size: 16pt">Previous Categories</a>
				    <table class="table collapse">
					<thead>
					    <th>Family Routines</th><th>Activities</th><th>Environment</th>
					</thead>
					<tbody>
					    <?php
					    $query = "SELECT * FROM fourthGradeLessonThreeTableTwo WHERE userId='$userId' AND submit='1' order by recordId DESC Limit 1";
					    $result = mysql_query($query);
					    $row = mysql_fetch_array($result); 
					    $familyList = $row['familyRoutines'];
					    $activitiesList = $row['activities'];
					    $environmentList = $row['environment'];
					    $family = unserialize(base64_decode($familyList));
					    $activities= unserialize(base64_decode($activitiesList));
					    $environment = unserialize(base64_decode($environmentList));
					    $arrCount = array(count($family), count($activities), count($environment));
					    $n = max($arrCount);
					    for($i=0; $i<$n; $i++){
						if(empty($family[$i])){
						    $familyWord = '&nbsp';
						}else{
						    $familyWord = $family[$i];
						}
						if(empty($activities[$i])){
						    $activitieWord = '&nbsp';
						}else{
						    $activitieWord = $activities[$i];
						}
						if(empty($environment[$i])){
						    $environmentWord = '&nbsp';
						}else{
						    $environmentWord = $environment[$i];
						}
						echo "<tr>";
						echo "<td>".$familyWord."</td><td>".$activitieWord."</td><td>".$environmentWord."</td>";
						echo "</tr>";
					    }
					    mysql_close($con);
					    ?>
					</tbody>
				    </table>
				</div>
			    </div>
			</div>
			
			<input name='countFacilitor'  style="display:none" value=<?php echo $countFacilitor; ?>>
			<input name='countCompetitor' style="display:none" value=<?php echo $countCompetitor; ?>>
		    </div>
		    
		    <div class="row" style="padding-top: 1cm;">
			<div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1" style="display: none">
			    <button class="btn btn-info btn-large btn-block" type="submit" name="save">Save</button>
			</div>
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <button class="btn btn-success btn-large btn-block" type="submit" name="submit">Submit</a>
			</div>
		    </div>
		    <div class="row">
			<div class="col-sm-offset-1 col-sm-10 col-md-5 col-md-offset-3">
			    <button class="btn btn-danger btn-large btn-block" type="submit" name="quit" onclick=" return confirm('Are you sure you want to exit?  Your work will not be saved!')">Exit without Saving</a>
			</div>
		    </div>
		</form>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
     $("#previous").on('click', function(e) {
	 e.preventDefault();
	 var $this = $(this);
	 var $collapse = $this.closest('.collapse-group').find('.collapse');
	 $collapse.collapse('toggle');
     });
    </script>
</html>

