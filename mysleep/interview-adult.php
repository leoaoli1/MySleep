<?php

#############################################################################
#                                                                           #
# © The University of Arizona STEPS Team                                    #
#                                                                           #
# Authors:                                                                  #
#           Ao Li           <aoli1@email.arizona.edu>                       #
#           James Geiger    <jamesgeiger@email.arizona.edu>
#           Siteng Chen    <sitengchen@email.arizona.edu>                   #
#                                                                           #
# Filename: InterviewAdult.php                                              #
#                                                                           #
# Purpose:  Grade 4 Lesson 1 Activity 5                                     #
#                                                                           #
#############################################################################

require_once('utilities.php');
require_once('connectdb.php');

checkauth();
$userType = $_SESSION['userType'];
$userId = $_SESSION['userId'];

if (empty($_GET)) {
  $config = getActivityConfigWithActivity('interview-adult');
} else {
  $lessonNum = $_GET['lesson'];
  $activityNum = $_GET['activity'];
  $config = getActivityConfigWithNumbers($lessonNum, $activityNum);
}
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

if ($config) {
  $result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterview WHERE contributors LIKE '%$userId%' ORDER BY submitTime DESC LIMIT 1");
}else {
  $result = mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterview WHERE userId = '$userId' ORDER BY submitTime DESC LIMIT 1");
}

if ($row = mysql_fetch_assoc($result)){

    $iS             = $row['interviewSubject'];
    $oS             = $row['otherSubject'];
    $A1             = $row['A1'];
    $A1Exp          = $row['A1Exp'];
    $A2             = $row['A2'];
    $A3             = $row['A3'];
    $interviewId    = $row['resultRow'];


    $questionsQuery = "SELECT * FROM fourthGradeLessonOneAdultInterviewQuestions WHERE interviewId = '$interviewId'";

    $questionsResult = mysql_query($questionsQuery);

    $questionsInsert = "";

		for ($i=4; $i<9 ; $i++) {

			$qname = "Q" . trim($i);
			$ques = ucfirst($row[$qname]);
      $aname = "A" . trim($i);
      $anss = ucfirst($row[$aname]);
			if (strlen($row[$qname])) {
        // $questionsInsert .= "<tr><td><div class='form-group' style='padding:0;margin:0;'><h5>" . $ques . "</h5></div></td></tr><tr><td><div class='form-group' style='padding:0;margin:0;'><input type='text'  class='form-control input-lg' name='response[]' /></div></td></tr>";

				$questionsInsert .= "<tr><td><div class='form-group' style='padding:0;margin:0;'><input type='text'  class='form-control input-lg' name='question[]' value='" . $ques . "' /></div></td><td><div class='form-group' style='padding:0;margin:0;'><input type='text'  class='form-control input-lg' name='response[]' value='" . $anss . "' /></div></td></tr>";
			}
		}
}
else {
    $iS             = "";
    $oS             = "";
    $A1             = "";
    $A1Exp          = "";
    $A2             = "";
    $A3             = "";

    $questionResult =mysql_query("SELECT * FROM fourthGradeLessonOneAdultInterviewQuestions WHERE userId='$userId'");
    $questionNumRow = mysql_num_rows($questionResult);
   	if ($questionNumRow>0) {
   		$row = mysql_fetch_array($questionResult);

  		$questionsInsert = "";
  		for ($i=4; $i<9 ; $i++) {

  			$name = "Q" . trim($i);
  			$ques = ucfirst($row[$name]);
  			if (strlen($row[$name])) {
  				$questionsInsert .= "<tr><td><div class='form-group' style='padding:0;margin:0;'><input type='text'  class='form-control input-lg' name='question[]' value='" . $ques . "' /></div></td><td><div class='form-group' style='padding:0;margin:0;'><input type='text'  class='form-control input-lg' name='response[]' /></div></td></tr>";
  			}
  		}
  	}
}

?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Interviewing an Adult</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php if ($config){
                      require_once('partials/nav-links.php');
                      navigationLink($config,$userType);
                    } else {
                    ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a class = "exit" data-location="main-page">Home</a></li>
                                <li><a class = "exit" data-location="sleep-lesson">Lessons</a></li>
                                <li><a class = "exit" data-location="fourth-grade-lesson-menu?lesson=1">Activities</a></li>
                                <li class="active">Interviewing an Adult</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <form action="interview-adult-done" method="post">
                        <input type="text" id="query" name="query" value="<?php echo $query; ?>" style="display: none">
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                                <h3>Interviewing an Adult</h3>
                                <h5>Ask these questions about sleep, and any others you can think of, to an adult. Your work will automatically be saved when you select next.</h5>
                                <div id="rootwizard" style="margin-top: 2em;">
                                    <ul class="nav nav-pills nav-pills-info nav-justified">
                                        <li><a href="#basicInfo" data-toggle="tab">Basic Information</a></li>
                                        <li><a href="#sleepInfo" data-toggle="tab">Question 1</a></li>
                                        <li><a href="#Q3" data-toggle="tab">Question 2</a></li>
                                        <li><a href="#Q4" data-toggle="tab">Question 3</a></li>
                                        <li><a href="#otherInfo" data-toggle="tab">Other Questions</a></li>
                                    </ul>
                                    <div class="tab-content" style="margin-top: 1.2em;">
                                        <div class="tab-pane" id="basicInfo">
                                            <div class="form-group">
                                                <label>First, who are you interviewing?</label>
                                                <select class="form-control input-lg" name="iS" id="iS">
                                                        <option value="" <?php echo ($iS=="" )? 'selected': '' ?>>Select One...</option>
                                                        <option value="1" <?php echo ($iS=="1" )? 'selected': '' ?>>Mother</option>
                                                        <option value="2" <?php echo ($iS=="2" )? 'selected': '' ?>>Father</option>
                                                        <option value="3" <?php echo ($iS=="3" )? 'selected': '' ?>>Guardian</option>
                                                        <option value="4" <?php echo ($iS=="4" )? 'selected': '' ?>>Grandparent</option>
                                                        <option value="5" <?php echo ($iS=="5" )? 'selected': '' ?>>Other Adult</option>
                                                    </select>
                                            </div>
                                            <div class="form-group" id="otherIntervieweeType">
                                                <label for="oS">Okay, someone else. How are they related to you?</label>
                                                <input type="text" name="oS" id="oS" value="<?php echo htmlspecialchars($oS);?>" placeholder="Relationship" class="form-control input-lg" />
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="sleepInfo">
                                            <h4>Great! Now ask these questions to the person you're interviewing.</h4>

                                            <div class="form-group form-group-lg">
                                                <label for="Q3">Do you get enough sleep?</label>
                                                <div class="radio">
                                                    <label>
                                                            <input type="radio" name="A1" value="1" <?php echo ($A1==1)? 'checked': '' ?>> Almost always </label>

                                                    <label>
                                                            <input type="radio" name="A1" value="2" <?php echo ($A1==2)? 'checked': '' ?>> Most of the time </label>

                                                    <label>
                                                            <input type="radio" name="A1" value="3" <?php echo ($A1==3)? 'checked': '' ?>> Sometimes </label>

                                                    <label>
                                                            <input type="radio" name="A1" value="4" <?php echo ($A1==4)? 'checked': '' ?>> Not very often </label>

                                                    <label>
                                                            <input type="radio" name="A1" value="5" <?php echo ($A1==5)? 'checked': '' ?>> Hardly ever </label>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-lg">
                                                <label for="A1Exp">Explain your answer.</label>
                                                <textarea name="A1Exp" id="A1Exp" class="form-control input-lg" rows="10"><?php echo htmlspecialchars($A1Exp);?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="Q3">
                                            <div class="form-group">
                                                <label for="A2">What are some things that help you get a good night's sleep?</label>
                                                <textarea name="A2" id="interviewGoodSleep" class="form-control input-lg" rows="10"><?php echo htmlspecialchars($A2);?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="Q4">
                                            <div class="form-group">
                                                <label for="Q5">What are some things that keep you from getting a good night's sleep?</label>
                                                <textarea name="A3" id="A3" class="form-control input-lg" rows="10"><?php echo htmlspecialchars($A3);?></textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="otherInfo">
                                            <h4>Now, try to come up with at least one of your <b>own</b> questions about sleep</h4>
                                            <div class="form-group">
                                                <label for="interviewQuestionsOther">Write your questions, and the answers the adult gave, in the space below.</label>
                                                <table class="table" id="suppQuestions">
                                                    <thead>
                                                        <tr>
                                                            <th>Your Questions</th>
                                                            <th>Your Answers</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($questionsInsert)){echo $questionsInsert;} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <a id="addRow" class="btn btn-gradbb btn-roundThin">Add New Question</a>
                                        </div>
                                        <ul class="pager wizard">
                                            <li class="previous"><a href="#">Previous</a></li>
                                            <li class="next"><a href="#">Next</a></li>
                                            <li class="finish"><a href="">Finished!  Submit to Teacher</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($interviewId)){echo "<input type='hidden' name='interviewId' value='$interviewId'>";} ?>
                    </form>
                </div>
            </div>
        </div>
        <!-- Submit Modal -->
        <div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
                    </div>
                    <div class="modal-body">
                        Are you ready to submit your work to your teacher?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
                        <button id="submit-activity" name="btnSubmit" class="btn btn-success btn-simple">Yes, Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'partials/footer.php' ?>
    </body>
    <?php include 'partials/scripts.php' ?>
    <script>
        $(function() {
            $("#addRow").click(function() {
                $('#suppQuestions tr:last').after('<tr><td><div class="form-group" style="padding:0;margin:0;"><input type="text"  class="form-control input-lg" name="question[]" /></div></td><td><div class="form-group" style="padding:0;margin:0;"><input type="text"  class="form-control input-lg" name="response[]" /></div></td></tr>');
            });

            $("#submit-activity").click(function() {
                var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "btnSubmit").val("1");
                $('form').append($(input));
                $("form").submit();
            })

            $('#rootwizard').bootstrapWizard({
                'nextSelector': '.next',
                'previousSelector': '.previous',

                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index + 1;

                    // If it's the last tab then hide the last button and show the finish instead
                    if ($current >= $total) {
                        $('#rootwizard').find('.pager .next').hide();
                        $('#rootwizard').find('.pager .finish').show();
                        $('#rootwizard').find('.pager .finish').removeClass('disabled');
                    } else {
                        $('#rootwizard').find('.pager .next').show();
                        $('#rootwizard').find('.pager .finish').hide();
                    }
                },
                onNext: function(tab, navigation, index) {
                    $data = $("form").serialize();
                    $.ajax({
                        url: "interview-adult-done",
                        type: "POST",
                        data: $data,
                        success: function(data) {
                            if (!$.trim(data)) {
                                return true;
                            } else {
                                var input = $("<input>")
                                    .attr("type", "hidden")
                                    .attr("name", "interviewId").val($.trim(data));
                                $('form').append($(input));
                            }
                        },
                        error: function() {
                            return false;
                        }
                    });
                },
            });
            $('#rootwizard .finish').click(function(event) {
                event.preventDefault();
		            var type = "<?php echo $_SESSION["userType"]?>";
        		    if(type == "student"){
                  $('#submit-modal').modal();
        		    }

            });

            if ($("#oS").val() != "") {
                $("#otherIntervieweeType").show();
            } else {
                $("#otherIntervieweeType").hide();
            }

            $('#iS').on('change', function() {
                if ($(this).val() === "5") {
                    $("#otherIntervieweeType").slideDown();
                } else {
                    $("#otherIntervieweeType").slideUp();
                    $("#oS").val("");
                }
            });

        });

    </script>

    </html>
