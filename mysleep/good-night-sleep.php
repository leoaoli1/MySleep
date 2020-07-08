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
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
include 'connectdb.php';
$result = mysql_query("SELECT facilitatorAnswers, competitorAnswers FROM fourthGradeLessonThreeTableOne WHERE userId='$userId' order by recordId DESC LIMIT 1 ");
$facilitators = [];
$competitors = [];
if(mysql_num_rows($result)>0){
    $row = mysql_fetch_array($result);
    $facilitatorAnswers = $row['facilitatorAnswers'];
    $competitorAnswers = $row['competitorAnswers'];
    $facilitators = unserialize(base64_decode($facilitatorAnswers));
    $competitors = unserialize(base64_decode($competitorAnswers));
}
mysql_close($con);
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //I Could Use a Good Night's Sleep! </title>
	<style>
	 .rotate {
	     background-color: #6fdc6f;
	 }
	 .rotate > div {
	     transform:
	     translateX(45%)
	     rotate(-90deg);
	     height: 150px;
	     text-align: center;
	 }
	 .topBorder {
	     border-top: 1px solid  #ff0000;
	 }
	 .leftBorder{
	     border-left: 1px solid  #ff0000;
	 }
	 .bottomBorder{
	     border-bottom: 1px solid  #ff0000;
	 }
	 .generateHeight{
	     height: 60px;
	 }
	 .generateWidth{
	     width: 140px;
	 }
	 caption { 
	     display: table-caption;
	     text-align: center;
	     font-size: 25pt;
	     color: #000000;
	 }
	</style>
    </head>
    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='main-page';">Home</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='sleep-lesson';">Lessons</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-menu?lesson=3';">Lesson Three</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=2';">Activities Two</a></li>
			<li><a href="#" onclick="if (confirm('Are you sure you want to exit?  Your work will not be saved!')) location.href='fourth-grade-lesson-activity-sub-menu?lesson=3&activity=2&name=goodNightSleep';">I Can Use A Good Night's Sleep</a></li>
			<li class="active">Part One</li>
		    </ol>
		    <div class="row">
			<div class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
			    <h4 class="description">Brainstorm factors that help people sleep and factors that keep people from getting enough sleep. Select three of the "facilitators" and three of the "competitors" to include on the lists below. Submit to your teacher.</h4>
			</div>
		    </div>
		    <form action="good-night-sleep-done" method="post">
			<div class="row" style="padding-top: 1cm;">
				<table  cellpadding="0" cellspacing="0" align="center" class="col-md-offset-2 col-md-7 col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				    <caption>Facilitators</caption>
					<tr>
					    <th rowspan="8" colspan="1" class="rotate generateWidth"><div style="font-size: 20pt; color: #ffffff">Top Three</div></th><td>&nbsp</td><td>&nbsp</td><td class="generateHeight generateWidth" rowspan="2" colspan="4" style="background-color: #5bd75b;"><textarea name="facilitators_1" id="facilitators_1" class="form-control"><?php echo htmlspecialchars($facilitators[0]);?></textarea></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder topBorder">&nbsp</td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder">&nbsp</td><td class="generateHeight" colspan="4"></td>
				    </tr>
				    <tr>
					<td class="bottomBorder">&nbsp</td><td class="bottomBorder leftBorder">&nbsp</td><td class="generateHeight generateWidth" rowspan="2" colspan="4" style="background-color:  #6fdc6f;"><textarea name="facilitators_2" id="facilitators_2" class="form-control"><?php echo htmlspecialchars($facilitators[1]);?></textarea></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder topBorder">&nbsp</td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder">&nbsp</td><td class="generateHeight" colspan="4"></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder bottomBorder">&nbsp</td><td class="generateHeight generateWidth" rowspan="2" colspan="4" style="background-color: #adebad;"><textarea name="facilitators_3" id="facilitators_3" class="form-control"><?php echo htmlspecialchars($facilitators[2]);?></textarea></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td>&nbsp</td>
				    </tr>
				</table>
			</div>
			<div class="row" style="padding-top: 1cm;">
				<table  cellpadding="0" cellspacing="0" align="center" class="col-md-offset-2 col-md-7  col-sm-offset-1 col-sm-10" style="padding-top: 1em;">
				    <caption>Competitors</caption>
					<tr>
					<th rowspan="8" colspan="1" class="rotate generateWidth"><div style="font-size: 20pt; color: #ffffff">Top Three</div></th><td>&nbsp</td><td>&nbsp</td><td class="generateHeight generateWidth" rowspan="2" colspan="4" style="background-color: #5bd75b;"><textarea name="competitors_1" id="competitors_1" class="form-control"><?php echo htmlspecialchars($competitors[0]);?></textarea></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder topBorder">&nbsp</td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder">&nbsp</td><td class="generateHeight" colspan="4"></td>
				    </tr>
				    <tr>
					<td class="bottomBorder">&nbsp</td><td class="bottomBorder leftBorder">&nbsp</td><td class="generateHeight generateWidth" rowspan="2" colspan="4" style="background-color:  #6fdc6f;"><textarea name="competitors_2" id="competitors_2" class="form-control"><?php echo htmlspecialchars($competitors[1]);?></textarea></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder topBorder">&nbsp</td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder">&nbsp</td><td class="generateHeight" colspan="4"></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td class="leftBorder bottomBorder">&nbsp</td><td class="generateHeight generateWidth" rowspan="2" colspan="4" style="background-color: #adebad;"><textarea name="competitors_3" id="competitors_3" class="form-control"><?php echo htmlspecialchars($competitors[2]);?></textarea></td>
				    </tr>
				    <tr>
					<td>&nbsp</td><td>&nbsp</td>
				    </tr>
				</table>
			</div>
			<div class="row" style="padding-top: 1cm;">
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
				<button class="btn btn-info btn-large btn-block" type="submit" name="save">Save</button>
			    </div>
			    <div class="col-sm-offset-1 col-sm-10 col-md-4 col-md-offset-1">
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
	    </div>
</div>
<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
</html>
