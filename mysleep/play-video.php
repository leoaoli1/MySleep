<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author: Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$player = $_GET['player'];
$attempt = $_GET['attempt'];
$day = $_GET['day'];
//$madeOrMissed= $_GET['madeOrMissed'];
?>

<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Game Changer</title>
    </head>

    <body>
	<div class="wrapper" >
	    <div class="main main-raised">
		<div class="container">
		    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
			<div class="row"> 
			    <div class="embed-responsive embed-responsive-16by9">
				<video class="" id="freeThrowVideo" controls preload="auto" autoplay>
				    <?php
				    include 'connectdb.php';
				    require_once('utilities.php');
				    if ($day=='Day1'){
					$result = mysql_query("SELECT after_sleep_made FROM basketball_test_table WHERE player='$player' AND attempt='$attempt'");
					$row = mysql_fetch_array($result);
					$madeOrMissed = $row['after_sleep_made'] ? 'made' : 'missed';
				    }else{
					$result = mysql_query("SELECT after_more_sleep_made FROM basketball_test_table WHERE player='$player' AND attempt='$attempt'");
					$row = mysql_fetch_array($result);
					$madeOrMissed = $row['after_more_sleep_made'] ? 'made' : 'missed';
				    }

				    mysql_close($con);
				    if ($madeOrMissed == 'made')
					echo '<source src="videos/Game-Changer/Player'. $player. '/Player'.$player.'-'. $day. '-S1.mp4" type="video/mp4">';
				    else
					echo '<source src="videos/Game-Changer/Player'. $player. '/Player'.$player.'-'. $day. '-A'. $attempt .'.mp4" type="video/mp4">';
				    ?>
				</video>
			    </div>
			</div>
		    </div>
		    <div class="row">
			<div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4" style="padding-top: 1em">
			    <input class="btn btn-success btn-large btn-block" type="button" name="return" value="Return" onClick="history.go(-1);return false;"/>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<script type="text/javascript">
	 // After playing video, go right back to previous page
	 var video = document.getElementById('freeThrowVideo');
	 video.addEventListener('ended',function(){
             window.history.go(-1);
             return false; 
	 });
	</script>
    </body>
</html>
