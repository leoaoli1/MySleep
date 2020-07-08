<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Ao Li <aoli1@email.arizona.edu>
#
// Parents choose there children's school. It will Save a School ID array in the user table. 
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
	<?php include 'partials/header.php' ?>
	<title>MySleep // Set School</title>
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
			<div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
				<li><a href="#" onclick="location.href='main-page'">Home</a></li>
				<li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
				<li class="active">Set School</li>
			    </ol>
			</div>
                    </div>

		    <div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding-top: 1em;">
			    <h4 class="description"></h4>
			</div>
		    </div>
		    <div class="row col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			<table class="table table-striped table-border">
			    <caption>Linked School </caption>
			    <thead>
				<tr>
				    <th> School ID </th><th> School Name </th>
				</tr>
			    </thead>
			    <tbody>
				<?php
				include 'connectdb.php';
				$result = mysql_query("SELECT schoolId FROM user_table Where userId = '$userId'");
				$row = mysql_fetch_array($result);
				//echo $row['schoolId'];
				$arrSettedSchoolId = explode("," , $row['schoolId']);
				//print_r($arrSchoolId);
				foreach($arrSettedSchoolId as $id){
				    echo "<tr>";            
				    $name = getSchoolName($id);
				    echo "<td>".$id."</td><td>".$name."</td>";
				    echo "</tr>";
				}
				?>
			    </tbody>
			</table>
			<form>
			    <div class="form-group">
                                <label class="control-label">School</label>
				<select name="schoolId" class="form-control input-lg">
				    <?php
				    $arrSchoolId = [];
				    $result = mysql_query("SELECT * FROM school_info");
				    while ($row = mysql_fetch_array($result)) {
					array_push($arrSchoolId, $row['schoolId']);	
				    }
				    //debugToConsole("schoolId", $arrSchoolId);
				    //debugToConsole("settedSchoolId", $arrSettedSchoolId);
				    $unsetSchoolId=array_diff($arrSchoolId,$arrSettedSchoolId);
				    echo "<option value='null' disabled selected>Please Choose A School</option>";
				    if(!empty($unsetSchoolId)){
					foreach($unsetSchoolId as $id){
					    $name = getSchoolName($id);
					    echo "<option value='$id'>" . $name. "</option>";
					}
				    }
				    mysql_close($con);
				    ?>
				</select>
			    </div>
			    <div style="padding-top: 1cm">
				<button class="btn btn-primary btn-lg" type="submit">Add</button>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	</div>
	<div id="linkSuccess" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="successLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Success</h4>
		    </div>
		    <div class="modal-body">
			<p>Successed</p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="reload()">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<div id="linkError" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="successLabel">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Error</h4>
		    </div>
		    <div class="modal-body">
			<p>Error. Please contact zfactor team.</p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<?php include 'partials/footer.php' ?>
	<?php include 'partials/scripts.php' ?>
	<script>
	 function reload() {
	     location.reload();
	 }
	 
         $(function () {
             $('form').on('submit', function (e) {
		 
		 e.preventDefault();

		 $.ajax({
		     type: 'post',
		     url: 'parent-set-school-done',
		     data: $('form').serialize(),
		     success: function () {
			 $("#linkSuccess").modal('show');
		     },
		     error: function (){
			 $("#linkError").modal('show');
		     }
		 });

             });

	 });
	</script>
    </body>
</html>
