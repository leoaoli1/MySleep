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
?>
<html style="background-image: url('assets/img/bkg-lgjpg');">
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
				<li class="active">Select</li>
                            </ol>
			</div>
                    </div>
		</div>
		<div class="row">
		    <div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			<h4 class="description"></h4>
		    </div>
		</div>
		<div class="row">
		    <div class="col-md-offset-4 col-md-4" style="padding-top: 1em;">
			<?php
			include 'connectdb.php';
			$resultLink = getUserIdsInClass($classId);
			$countNumber = 0;
			foreach ($resultLink as $studentId){
    	  		    $result = mysql_query("SELECT facilitatorAnswers FROM fourthGradeLessonThreeTableOne WHERE userId='$studentId' And submit='1' order by recordId DESC Limit 1");
			    if(mysql_num_rows($result)>0){
				$countNumber+=1;
			    }
			}
				
			echo "<p style='font-size: 25pt; color: red;'> Number of Teams Submitted: ".$countNumber."</p>"; 
			?>
		    </div>
		</div>
		<form action="good-night-sleep-teacher-select-done" id="dateForm"  enctype="multipart/form-data" method="post">
		    <div class="row" style="padding-top: 1cm">
			<div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4">
			    <table class="table">
				<tr>
				    <th>Facilitators</th><th><input type="checkbox" id="selectAllFacilitators" /> Select All</th>
				</tr>
				<?php
				$countFacilitor = 0;
				foreach ($resultLink as $studentId){
				    $facilitators = [];
    	  			    $result = mysql_query("SELECT facilitatorAnswers FROM fourthGradeLessonThreeTableOne WHERE userId='$studentId' And submit='1' order by recordId DESC Limit 1");
    	  			    $row = mysql_fetch_array($result); 
				    $facilitatorAnswers = $row['facilitatorAnswers'];
				    $facilitators = unserialize(base64_decode($facilitatorAnswers));
				    if($facilitators[0]!=""){
    	  				echo "<td><textarea name='facilitators$countFacilitor' id='facilitators$countFacilitor' class='form-control'>".htmlspecialchars($facilitators[0])."</textarea></td><td><input type='checkbox' class='selectFacilitators' name='checkboxFacilitators$countFacilitor'></td></tr>";
					$countFacilitor+=1;
				    }
				    
         			    if($facilitators[1]!=""){
    	  				echo "<td><textarea name='facilitators$countFacilitor' id='facilitators$countFacilitor' class='form-control'>".htmlspecialchars($facilitators[1])."</textarea></td><td><input type='checkbox' class='selectFacilitators' name='checkboxFacilitators$countFacilitor'></td></tr>";
					$countFacilitor+=1;
				    }
				    if($facilitators[2]!=""){
    	  				echo "<td><textarea name='facilitators$countFacilitor' id='facilitators$countFacilitor' class='form-control'>".htmlspecialchars($facilitators[2])."</textarea></td><td><input type='checkbox' class='selectFacilitators' name='checkboxFacilitators$countFacilitor'></td></tr>";
					$countFacilitor+=1;
				    }
				}

				//generate previous results --not done
				
				$countFacilitor-=1;
				?>
			    </table>
			</div>
			<div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4">
			    <table class="table">
				<tr>
				    <th>Competitors</th><th><input type="checkbox" id="selectAllCompetitors" /> Select All</th>
				</tr>
				<?php
				$resultLink = getUserIdsInClass($classId);
				$countCompetitor = 0;
				foreach ($resultLink as $studentId){
				    $competitors = [];
    	  			    $result = mysql_query("SELECT competitorAnswers FROM fourthGradeLessonThreeTableOne WHERE userId='$studentId' And submit='1' order by recordId DESC Limit 1");
    	  			    $row = mysql_fetch_array($result); 
				    $competitorAnswers = $row['competitorAnswers'];
				    $competitors = unserialize(base64_decode($competitorAnswers));
				    if($competitors[0]!=""){
					echo "<td><textarea name='competitors$countCompetitor' id='competitors$countCompetitor' class='form-control'>".htmlspecialchars($competitors[0])."</textarea></td><td><input type='checkbox' class='selectCompetitors' name='checkboxCompetitors$countCompetitor'></td></tr>";
					$countCompetitor+=1;
				    }
				    if($competitors[1]!=""){
					echo "<td><textarea name='competitors$countCompetitor' id='competitors$countCompetitor' class='form-control'>".htmlspecialchars($competitors[1])."</textarea></td><td><input type='checkbox' class='selectCompetitors' name='checkboxCompetitors$countCompetitor'></td></tr>";
					$countCompetitor+=1;
				    }
				    if($competitors[2]!=""){
					echo "<td><textarea name='competitors$countCompetitor' id='competitors$countCompetitor' class='form-control'>".htmlspecialchars($competitors[2])."</textarea></td><td><input type='checkbox' class='selectCompetitors' name='checkboxCompetitors$countCompetitor'></td></tr>";
					$countCompetitor+=1;
				    }
				   }
				   $countCompetitor -=1;
				   ?>
			    </table>
			</div>
			<div class="row" style="padding-top: 2cm">
			    <div class="col-sm-offset-4 col-sm-4 col-md-4 col-md-offset-4">
				<div class="collapse-group">
				    <a  href="#" id="previous" style="font-size: 16pt">Previous Selected</a>
				    <table class="table collapse">
					<thead>
					    <th>Facilitators</th><th>Competitors</th>
					</thead>
					<tbody>
					    <?php
					    $query = "SELECT facilitatorAnswers, competitorAnswers FROM fourthGradeLessonThreeTableOne WHERE userId='$userId' AND classId='$classId' AND submit='1' order by recordId DESC Limit 1";
					    $result = mysql_query($query);
					    $row = mysql_fetch_array($result); 
					    $facilitators = $row['facilitatorAnswers'];
					    $competitors = $row['competitorAnswers'];
					    $arrFacilitators = unserialize(base64_decode($facilitators));
					    $arrCompetitors = unserialize(base64_decode($competitors));
					    $arrCount = array(count($arrFacilitators), count($arrCompetitors));
					    $n = max($arrCount);
					    for($i=0; $i<$n; $i++){
						if(empty($arrFacilitators[$i])){
						    $facilitatorWord = '&nbsp';
						}else{
						    $facilitatorWord = $arrFacilitators[$i];
						}
						if(empty($arrCompetitors[$i])){
						    $competitorWord = '&nbsp';
						}else{
						    $competitorWord = $arrCompetitors[$i];
						}
						echo "<tr>";
						echo "<td>".$facilitatorWord."</td><td>".$competitorWord."</td>";
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
     $("#selectAllCompetitors").change(function(){
	 var status = $(this).is(":checked") ? true : false;
	 $(".selectCompetitors").prop("checked",status);
     });
     $("#selectAllFacilitators").change(function(){
	 var status = $(this).is(":checked") ? true : false;
	 $(".selectFacilitators").prop("checked",status);
     });

     $("#previous").on('click', function(e) {
	 e.preventDefault();
	 var $this = $(this);
	 var $collapse = $this.closest('.collapse-group').find('.collapse');
	 $collapse.collapse('toggle');
     });
    </script>
</html>
