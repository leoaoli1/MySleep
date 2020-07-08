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
$classId = $_SESSION['classId'];
if($userId==""){
    header("Location: login");
    exit;
}

?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Group Selection</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	<style type="text/css">
	 .select {
	     width: 28px;
	     height: 28px;
	     position: relative;
	     margin: 20px auto;
	     background: #fcfff4;
	     background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     background: linear-gradient(to bottom, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label {
	     width: 20px;
	     height: 20px;
	     cursor: pointer;
	     position: absolute;
	     left: 4px;
	     top: 4px;
	     background: -webkit-linear-gradient(top, #222222 0%, #45484d 100%);
	     background: linear-gradient(to bottom, #222222 0%, #45484d 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px white;
	 }
	 .select label:after {
	     content: '';
	     width: 16px;
	     height: 16px;
	     position: absolute;
	     top: 2px;
	     left: 2px;
	     background: #27ae60;
	     background: -webkit-linear-gradient(top, #27ae60 0%, #145b32 100%);
	     background: linear-gradient(to bottom, #27ae60 0%, #145b32 100%);
	     opacity: 0;
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label:hover::after {
	     opacity: 0.3;
	 }
	 .select input[type=checkbox] {
	     visibility: hidden;
	 }
	 .select input[type=checkbox]:checked + label:after {
	     opacity: 1;
	 }
	</style>
    </head>
    <body>
        <?php include 'partials/nav.php' ?>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <ol class="breadcrumb">
			<li class="active">Group Selection</li>
		    </ol>
		    <div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="padding-top: 1em;">
			    <h4 class="description">Please select your group memebers. Your name is NOT in the list.</h4>
			</div>
		    </div>
			<div class="col-md-offset-23 col-md-8 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8" style="padding-top: 1em;">
			    <div class="row">
				<table id='group-member' class="table table-bordered">
				    <thead>
					<tr>
					    <?php
					    $memberLimit = 5; # Real Group members is limit plus 1
					    for($i=0; $i<$memberLimit; $i++){
						$num = $i + 1;
						echo "<th>Member $num</th>";
					    }
					    ?>
						<th>
						</th>
					</tr>
				    </thead>
				    <tbody>
					<tr>
					    <?php
					    for($i=0; $i<$memberLimit; $i++){
						echo "<td class='member' id='member$i'><input class='members' type='text' name='member$i' style='display:none'></td>";
					    }
					    ?>
						<td>
						<form action="group-selection-done" method='post' name='group' onSubmit='send_value()'>
							<input name='groupMember' type='hidden' value=''>
							<button class="btn btn-success btn-sm btn-block" type="submit" name="submit"  id="submit"/>Submit</button>
						</form>
						</td>
					</tr>
				</table>
			    </div>
			</div>
			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-offset-1 col-xs-10" style="padding-top: 1cm;">
			    <div class="row">
				<table id='name-list' class="table datatable table-striped table-bordered">
				    <thead>
					<tr>
					    <th>First Name</th><th>Last Name</th><th>Selection</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					include 'connectdb.php';
					$resultLink = getUserIdsInClass($classId);
					foreach ($resultLink as $studentId){
						if($studentId != $userId){
							list($firstName, $lastName) = getUserFirstLastNames($studentId);
							echo '<tr><td>'.$firstName.'</td><td>'.$lastName.'</td><td><section title="Select"><div class="select"><input type="checkbox" value="'.$studentId.'" id="member'.$studentId.'" name="'.$firstName.' '.$lastName.'"/><label for="member'.$studentId.'"></label></div></section></td></tr>';
						}
					}
					mysql_close($con);
					?>
				    </tbody>
				</table>
			    </div>
			</div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script>
	var memberLimit = <?php echo $memberLimit; ?>;
	 $(document).ready(function() {
	     $('#name-list').dataTable({
		 "ordering": false,
		 "order": [[ 0, "desc" ]],
		 "lengthMenu": [[3, 10, -1], [3, 10, "All"]],
		 'iDisplayLength': 3
	     });	
	 });

	 var count = 0;
	 var arrName = [];
	 var arrValue = [];
	 var index = 0;
	 $(":checkbox").click(function(e){
		 if(arrValue.length == memberLimit){
			 if(!e.target.checked){
				 index = $.inArray(e.target.name, arrName);
				 arrName.splice(index, 1 );
				 arrValue.splice(index, 1);
				 console.log(arrValue);
				 count-=1;
				 removeIndex = arrName.length;
				 $('#member'+removeIndex).text("");
				 for (var i=0; i<count; i++){
					 $('#member'+i).text(arrName[i]);
				 }
			 }else{
				 (e.target || e.srcElement).checked = false;
				 alert("You already have selected enough members.");
			 }
		 }else{
			 if (e.target.checked) {
				 $('#member'+count).text(e.target.name);
				 arrName.push(e.target.name);
				 arrValue.push(e.target.value);
				 count+=1;
			 } else {
				 index = $.inArray(e.target.name, arrName);
				 arrName.splice(index, 1 );
				 arrValue.splice(index, 1);
				 count-=1;
				 removeIndex = arrName.length;
				 $('#member'+removeIndex).text("");
				 for (var i=0; i<count; i++){
					 $('#member'+i).text(arrName[i]);
				 }
			 } 
		 }
		 //console.log(arrValue);
	 });
	 
	 function send_value(){
	     document.group.groupMember.value = arrValue.toString();
	 }
	</script>
    </body>
</html>
