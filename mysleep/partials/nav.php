<nav class="navbar" style="margin-bottom:4em; background: #de54d7; background-image: -webkit-linear-gradient(top right, #7973f4, #f26ec9);background-image: -moz-linear-gradient(top right, #7973f4, #f26ec9);background-image: -ms-linear-gradient(top right, #7973f4, #f26ec9);background-image: -o-linear-gradient(top right, #7973f4, #f26ec9);background-image: linear-gradient(to bottom left, #7973f4, #f26ec9);">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
            	<span class="sr-only">Toggle navigation</span>
          		<span class="icon-bar"></span>
          		<span class="icon-bar"></span>
          		<span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="main-page">MySleep</a>
        </div>

        <div class="collapse navbar-collapse" id="navigation-example">
            <ul class="nav navbar-nav navbar-left">
		<?php if ($userType != 'parent') { ?>
		<li>
    		    <a href="#" onclick="location.href='sleep-lesson'">
    			Lessons
    		    </a>
    		</li>
    		<li>
		    <a href="#" onclick="location.href='diary-menu?<?php echo 'parent=main-page' ?>'">
			Sleep and Activity Diary
		    </a>
    		</li>
                <?php if($_SESSION['userType'] !== 'student') { ?>
                    <li><a href="#" onclick="location.href='admin-tools'">Settings</a></li>
                <?php }
		}?>
            </ul>
            <div class="nav navbar-nav navbar-right">
                <?php if($_SESSION['userType'] == 'teacher') { ?>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><i class="material-icons">class</i></span> <?php echo $_SESSION['className'];?>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu" style="padding: .5em;">
                            <form action="select-school-and-class-done" method="post" id="classForm">


				<select name="classId" class="input input-lg" style="color: #000; width: 100%;" onchange="form.submit();">
				    <?php
				    echo "<option value='null' disabled selected>Change Class...</option>";
				    include 'connectdb.php';
				    $res = mysql_query("SELECT classId FROM class_table where userId='$userId'");
				    /*$scId = $_SESSION['schoolId'];
				    $res = mysql_query("SELECT classId, className FROM class_info_table where schoolNum='$scId'");*/
				    while ($r = mysql_fetch_array($res)) {
					$clId = $r['classId'];
					$result = mysql_query("SELECT className FROM class_info_table where classId='$clId'");
					$row = mysql_fetch_array($result);
					$clName = $row['className'];
					echo "<option value='$clId'>" . $clName. "</option>";
				    }
				    mysql_close($con);

				    ?>
				</select>
				<input type="hidden" name="location" value="<?php echo $_SERVER["REQUEST_URI"];?>">

			    </form>
                        </ul>
                    </li>

                <?php } ?>
                <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><i class="material-icons">account_circle</i></span><span style="text-transform: capitalize"><?php echo(ucwords($_SESSION['userDisplayName'])); ?></span>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="./set-email-address">Change E-Mail Address</a></li>
                        <li><a href="./update-password">Change Password</a></li>
                        <!-- <li><a href="#">Change User Icon</a></li> -->
                        <li role="separator" class="divider"></li>
                        <li><a onclick="location.href='logout'" href="#">Sign Out</a></li>
                    </ul>
                </li>
		<!-- <div id="google_translate_element" style="line-height: 50px; padding-right: 30px;"></div> -->
            </div>
        </div>
    </div>
</nav>
