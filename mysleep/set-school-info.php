<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Ao Li <aoli1@email.arizona.edu>
#
// Manage classes; show or add or delete
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // Create New School</title>
	<style>
	 caption {
	     font-size: 30pt;
	     display: table-caption;
	     text-align: center;
	 }
	</style>
    </head>

    <body>
	<?php require 'partials/nav.php' ?>
	<div class="wrapper">
            <div class="main main-raised">
		<div class="container">
                    <div class="row">
			<div class="col-sm-offset-1 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
				<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
				<li class="active">Create New School </li>
			    </ol>
			</div>
                    </div>

		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <div class="col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
			<table class="table table-striped table-border">
			    <caption> Current School </caption>
			    <thead>
				<tr>
				    <th> School ID </th><th> School Name </th>
				</tr>
			    </thead>
			    <tbody>
			    <?php
			    include 'connectdb.php';
			    $result = mysql_query("SELECT * FROM school_info");
			    while ($row = mysql_fetch_array($result)) {
						echo "<tr>";
						$schoolId = $row['schoolId'];
						$schoolName = $row['schoolName'];
						echo "<td>".$schoolId."</td><td>".$schoolName."</td>";
						echo "</tr>";
			    }
			    mysql_close($con);
			    ?>
			    </tbody>
			</table>
			    <div class="row">
				    <label for="schoolName" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">School Name: </label>
				    <div class="col-md-5 col-sm-5">
							<input class="form-control" type="text" id="schoolName" name="schoolName" value="" />
				    </div>
					</div>
					<div class="row">
				    <label for="email" class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 control-label">Email Address (optional): </label>
				    <div class="col-md-5 col-sm-5">
							<input class="form-control" type="text" id="emailAddress" name="emailAddress" value="" />
				    </div>
					</div>
				<div style="padding-top: 1cm">
  				    <div class="row">
					<div class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3">
						<button type="button" class="btn btn-gradbg btn-roundBold" style="width:100%;" onclick="schoolSubmit(0)">Add</button>
					</div>
					<div class="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3">
						<button type="button" class="btn btn-gradorange btn-roundBold" style="width:100%;" onclick="schoolSubmit(1)">Delete</button>
					</div>
   				    </div>
				</div>

		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
		<script type="text/javascript">
		function schoolSubmit(actionEmu){
			var schoolName = $("#schoolName").val();
			var emailAddress = $("#emailAddress").val();
			var actionType = ['addNewSchool', 'deleteExistingSchool'][actionEmu];
			$.ajax({
						type: "POST",
						url: "set-school-info-done",
						 data: {schoolName:schoolName, emailAddress:emailAddress, actionType:actionType}
						})
			.done(function(respond){
				location.reload();
			})
		}
		</script>
</html>
