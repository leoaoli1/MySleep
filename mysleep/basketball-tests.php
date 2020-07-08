<!DOCTYPE html>
<?php   
# 
# Part of the MySleep package
# 
# University of Arizona Own the Copyright
# 
# Author:Wo-Tak Wu <wotakwu@email.arizona.edu>
#
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
if($userId==""){
	header("Location: login");
	exit;
}
?>

<html>
<?php common_background("Basketball Tests"); ?>

<body>
<?php common_animation(); ?>
<div class="row"; >
    <div class="header">
        <a>MySleep</a>
    </div>

    <div id="guide">
        Compute free throw percentage. Choose a player:
    </div>
    
    <form name="input" action="basketball-test-player" method="post">
    <!--<form name="input" action="junk.php" method="post"> -->
        <div class="row_settings">
            <select name="basketballPlayer">
                <?php
                    include 'ConnectDb.php';
                    require_once('Utilities.php');
                    $result = mysql_query("SELECT * FROM basketball_test_table ORDER BY player");
                    $prevPlayer = -1;
                    while ($row = mysql_fetch_array($result)) {
                        $player = $row['player'];
                        if ($player == $prevPlayer)
                            continue;
                        echo "<option  value='$player'>Player " . $player . "</option>";
                        $prevPlayer = $player;
                    }
                    mysql_close($con);
                ?>
            </select>
        </div>
        <div class="row_settings">
            <input class="submit_all" type="submit" name="submit" value="Continue" /> 
            <input class="submit_all" type="submit" name="quit" value="Cancel" /> 
        </div>
    </form>
</div>
</body>

</html>
