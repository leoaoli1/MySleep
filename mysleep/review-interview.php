<?php
#
# Part of the MySleep package
#
# © 2016, University of Arizona STEPS Team
#
# Authors: Ao Li <aoli1@email.arizona.edu>
#          James Geiger <jamesgeiger@email.arizona.edu>
#          Siteng Chen <sitengchen@email.arizona.edu>
#

require_once('utilities.php');
require_once('connectdb.php');
checkauth();
    $userId= $_SESSION['userId'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

<head>
    <?php include 'partials/header.php' ?>
    <title>MySleep // Review Your Interviews</title>
</head>

<body>
    <?php require 'partials/nav.php' ?>
    <div class="wrapper">
        <div class="main main-raised">
            <div class="container">
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                        <ol class="breadcrumb">
                            <li><a href="main-page">Home</a></li>
                            <li><a href="sleep-lesson">Lessons</a></li>
                            <li><a href="fourth-grade-lesson-menu?lesson=2">Lesson Two</a></li>
                            <li class="active">Review Your Interviews</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                        <!-- Start of Interview Results -->

                        <?php

                            $interviewQuery = "SELECT * FROM fourthGradeLessonOneAdultInterview WHERE userId='$userId' AND isSUbmitted=1";

                            $interviewResult = mysql_query($interviewQuery) or die(mysql_error());

                            $interviewNumRows = mysql_num_rows($interviewResult);

                            if($interviewNumRows == 0){
                                echo "<h3>You have not submitted any interviews!</h3>";
                            }
                            else{
                                ?><h3>Your Interviews<br><small>Click on the person you interviewed to review the results!</small></h3><br><div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'> <?php
                                for ($i=0;$i<$interviewNumRows;$i++) {
                                $row = mysql_fetch_assoc($interviewResult);
                                $interviewId = $row['uniqueId'];

                                ?>

                            <div class="panel panel-default" role="button" data-toggle="collapse" data-parent="#accordion" href="#interviewExpand<?php echo $interviewId ?>" aria-expanded="true" aria-controls="interviewExpand<?php echo $interviewId ?>">
                                <div class="panel-heading" role="tab" id="interview<?php echo $interviewId ?>">
                                    <h4 class="panel-title">
                                        <a role="button">
                                            <?php switch($row['interviewSubject']){case '1': echo "Mother"; break; case '2': echo "Father"; break; case '3': echo "Guardian"; break; case '4': echo "Grandparent"; case '5': echo $row['otherSubject'];}?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="interviewExpand<?php echo $interviewId ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <h5>Do you get enough sleep?</h5>
                                        <h3 style="margin-top:-.5em;">
                                            <?php switch($row['A1']){case '1': echo "Almost always"; break; case '2': echo "Most of the time"; break; case '3': echo "Sometimes"; break; case '4': echo "Not very often"; break; case '5': echo "Hardly ever";} ?>
                                        </h3><br>

                                        <h5>Explain:</h5>
                                        <h3 style="margin-top:-.5em;">
                                            <?php echo $row['A1Exp'];?>
                                        </h3><br>

                                        <h5>What are some things that help you get a good night's sleep?</h5>
                                        <h3 style="margin-top:-.5em;">
                                            <?php echo $row['A2'];?>
                                        </h3><br>

                                        <h5>What are some things that keep you from getting a good night's sleep?</h5>
                                        <h3 style="margin-top:-.5em;">
                                            <?php echo $row['A3'];?>
                                        </h3><br>




                                        <?php
                                        for ($j=4; $j<9 ; $j++) {

                                        $qname = "Q" . trim($j);
                                        $ques = ucfirst($row[$qname]);
                                        $aname = "A" . trim($j);
                                        $anss = ucfirst($row[$aname]);
                                        if (strlen($row[$qname])&&strlen($row[$aname])) {
                                        ?>

                                        <h5>
                                            <?php echo $ques;?>
                                        </h5>
                                        <h3 style="margin-top:-.5em;">
                                            <?php echo $anss;?>
                                        </h3><br>

                                        <?php }}?>




                                        </div>
                                </div>
                            </div><?php
                                }}
                                ?>
</div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'partials/footer.php' ?>
    </div>
</body>
<?php include 'partials/scripts.php' ?>
    <script>
        $(function () {
            $(".panel-collapse").collapse('hide');
        });
    </script>
</html>
