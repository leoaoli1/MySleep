<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team

require 'utilities.php';
checkAuth();
/* ***Flexible Framework Request Start*** */
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if ($userId == ""){
    header("Location: login");
    exit;
}
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;
/* ***Flexible Framework Request end*** */

?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php include 'partials/header.php' ?>
        <title>MySleep // Sleep Detective</title>
    </head>
    <?php include 'partials/scripts.php' ?>
    <body>
        <?php include 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">

                  <?php
                      if ($config) {
                        require_once('partials/nav-links.php');
                        navigationLink($config,$userType);
                      } else {
                        echo "Invalid class!";
                      }
                  ?>
                  <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                      <?php include 'add-group-member-button.php' ?>
                      <h4>In the zzzActogram pull down menu, select the actogram assigned to you by your teacher.</h4>
                      <!-- Nav tabs -->
                      <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist">
                          <li role="presentation" class="active"><a href="#actigraphy" aria-controls="actigraphy" role="tab" data-toggle="tab">zzzActogram</a></li>
                          <li role="presentation"><a href="#questions" aria-controls="questions" role="tab" data-toggle="tab">zzzQuestions</a></li>
                          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">zzzProfile</a></li>
                          <li role="presentation"><a href="#pattern" aria-controls="pattern" role="tab" data-toggle="tab">zzzSleep Pattern</a></li>
                      </ul>
                      <!-- Tab panels -->
                      <div class="tab-content" style="margin-top: 2em;">
                        <!-- Panel 1 -->
                        <div role="tabpanel" class="tab-pane active" id="actigraphy">
                          <b>Select one actogram</b>
                          <select class="input-lg" name='workId' id="workId">
                            <option value='null' disabled selected>Please choose an actogram</option>
                            <option value='0'>Mike</option>
                            <option value='1'>Mary</option>
                            <option value='2'>Ricardo</option>
                          </select>
                          <div class="row">
                            <div class="col-xs-11 col-md-11">
                              <img class="img-responsive" id="actigram">
                            </div>
                            <div class="col-xs-1 col-md-1">
                            <button id="black" type="button" class="btn btn-sm" style="background-color: black"></button><label for="black">Activity</label>
                            <button id="blue" type="button" class="btn btn-sm" style="background-color: blue"></button><label for="black">Blue Light</label>
                            <button id="yellow" type="button" class="btn btn-sm" style="background-color: yellow"></button><label for="black">Yellow Light</label>
                            </div>
                          </div>
                        </div>
                        <!-- Panel 2 -->
                        <div role="tabpanel" class="tab-pane" id="questions">
                          <form action="zprofile-done" method="post" id='questionForm1'>
                            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                            <input type="text" name="caseID" value="" id="caseID0" style="display: none">
                            <input type="text" name="patternDiv" value="" id="patternDiv0" style="display: none">
                            <input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 1: Does Mike fall asleep at the same time every night? </h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="1">
                                  <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="2">
                                  <label class="form-check-label">No</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 2: Does Mike wake up at the same time every morning?</h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q2" value="1">
                                  <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q2" value="2">
                                  <label class="form-check-label">No</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 3: How many nights does Mike get the recommended amount of sleep? [Hint: 9-12 hours]</h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="1">
                                  <label class="form-check-label">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="2">
                                  <label class="form-check-label">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="3">
                                  <label class="form-check-label">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="4">
                                  <label class="form-check-label">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="5">
                                  <label class="form-check-label">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="6">
                                  <label class="form-check-label">6</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 4: Does Mike wake up during the night after falling asleep? </h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q4" value="1">
                                  <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q4" value="2">
                                  <label class="form-check-label">No</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 5: What was Mike doing on Thursday between 4 and 5:30 pm?</h4>
                                <textarea name="q5" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 6: What is the impact of his wake-up times on Wednesday and Thursday? </h4>
                                <textarea name="q6" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                          </form>
                          <form action="zprofile-done" method="post" id='questionForm2'>
                            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                            <input type="text" name="caseID" value="" id="caseID1" style="display: none">
                            <input type="text" name="patternDiv" value="" id="patternDiv1" style="display: none">
                            <input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 1: During the school week, between what hours of the night does Mary fall asleep? </h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="1">
                                  <label class="form-check-label">9-11 pm</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="2">
                                  <label class="form-check-label">11p-1a</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="3">
                                  <label class="form-check-label">1a-3am</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 2: During the school week why do you think that Mary wakes up at the same time on school days?</h4>
                                <textarea name="q2" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 3: How many nights does Mary get the recommended amount of sleep? [Hint: 9-12 hours]</h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="1">
                                  <label class="form-check-label">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="2">
                                  <label class="form-check-label">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="3">
                                  <label class="form-check-label">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="4">
                                  <label class="form-check-label">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="5">
                                  <label class="form-check-label">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="6">
                                  <label class="form-check-label">6</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 4: Does Mary wake up during the night after falling asleep? </h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q4" value="1">
                                  <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q4" value="2">
                                  <label class="form-check-label">No</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 5: What was Mary doing between 7-10 am on Sunday?</h4>
                                <textarea name="q5" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 6: What explains Mary’s sleep pattern on weekend nights?</h4>
                                <textarea name="q6" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                          </form>
                          <form action="zprofile-done" method="post" id='questionForm3'>
                            <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                            <input type="text" name="caseID" value="" id="caseID2" style="display: none">
                            <input type="text" name="patternDiv" value="" id="patternDiv2" style="display: none">
                            <input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 1: During the school week, between what hours of the night does Ricardo fall asleep? </h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="1">
                                  <label class="form-check-label">9-11 pm</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="2">
                                  <label class="form-check-label">11p-1a</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q1" value="3">
                                  <label class="form-check-label">1a-3am</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 2: Does Ricardo fall asleep on weekend nights (Friday and Saturday) at the same time as on school nights?</h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q2" value="1">
                                  <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q2" value="2">
                                  <label class="form-check-label">No</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 3: How many nights does Ricardo get the recommended amount of sleep? [Hint: 9-12 hours]</h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="1">
                                  <label class="form-check-label">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="2">
                                  <label class="form-check-label">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="3">
                                  <label class="form-check-label">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="4">
                                  <label class="form-check-label">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="5">
                                  <label class="form-check-label">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q3" value="6">
                                  <label class="form-check-label">6</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 4: Does Ricardo wake up during the night after falling asleep? </h4>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q4" value="1">
                                  <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="q4" value="2">
                                  <label class="form-check-label">No</label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 5: What was Ricardo doing between 7-10 am on Sunday?</h4>
                                <textarea name="q5" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-11 col-md-11">
                                <h4>Question 6: Why is Ricardo sleepy and tired on Monday mornings?</h4>
                                <textarea name="q6" class="form-control" rows="1"></textarea>
                              </div>
                            </div>
                          </form>
                          <!-- <div class="row">
                              <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                  <a class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
                              </div>
                          </div> -->
                        </div>
                        <!-- Panel 3 -->
                        <div role="tabpanel" class="tab-pane" id="profile">
                          <div class="row">
                            <div class="col-xs-11 col-md-11">
                              <div id='profile'>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Panel 4 -->
                        <div role="tabpanel" class="tab-pane" id="pattern">
                          <div class="row">
                            <div class="col-xs-11 col-md-11">
                              <form action="zprofile-done" method="post" id='patternForm'>
                                <div class="row">
                                  <div class="col-xs-11 col-md-11">
                                    <h4 id="patternIntro"></h4>
                                    <div class="form-check form-check-inline">
                                      <div class="col-xs-1 col-md-1">
                                        <input class="form-check-input" type="radio" name="pattern" value="1">
                                      </div>
                                      <div class="col-xs-11 col-md-11" style="padding-bottom: 25px;">
                                        <label class="form-check-label">“Good sleeper”: A good sleeper goes to bed and gets up at the same time every night and gets 9 to 11 hours of high-quality sleep every night. As a result, during the day, he or she is in a good mood, is energetic and is able to focus on school work and other activities.</label>
                                      </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <div class="col-xs-1 col-md-1">
                                        <input class="form-check-input" type="radio" name="pattern" value="2">
                                      </div>
                                      <div class="col-xs-11 col-md-11" style="padding-bottom: 25px;">
                                        <label class="form-check-label">“Weekend late nighter”: This person gets enough sleep during the week, but stays up late and sleeps in on weekend nights. As a result, he or she may have problems waking up and will have sleepiness and difficulty focusing on school work and other activities on Mondays.</label>
                                      </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <div class="col-xs-1 col-md-1">
                                        <input class="form-check-input" type="radio" name="pattern" value="3">
                                      </div>
                                      <div class="col-xs-11 col-md-11" style="padding-bottom: 25px;">
                                        <label class="form-check-label">“School night short sleeper”: This person goes to bed late school nights and therefore gets consistent, but inadequate sleep during the week. On weekends, he or she will sleep longer to try catch up on her sleep. He or she will have difficulty waking up for school and may be tardy frequently. Sleepiness during the day, especially in the morning will be a problem. </label>
                                      </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <div class="col-xs-1 col-md-1">
                                        <input class="form-check-input" type="radio" name="pattern" value="4">
                                      </div>
                                      <div class="col-xs-11 col-md-11" style="padding-bottom: 25px;">
                                        <label class="form-check-label">“Irregular sleeper”: This person goes to bed at different times and sleeps for a different amount of time every night.  His or her mood, alertness and, ability to focus will change daily.</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </form>
                              <?php if($_SESSION['userType']=="student"){ ?>
                                  <div class="row">
                                      <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <a class="btn btn-gradpr btn-roundBold btn-large btn-block" data-toggle="modal" data-target="#submit-modal">Save &amp; Submit</a>
                                      </div>
                                  </div>
                                    <?php }else{?>
                                  <div class="row">
                                      <div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                          <a class="btn btn-gradpr btn-roundBold btn-large btn-block">Save &amp; Submit</a>
                                      </div>
                                  </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
  						        <button id="pattern-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
  						      </div>
  						    </div>
  						  </div>
  						</div>
    </body>
    <?php include 'partials/footer.php' ?>
    <script>
    var actogramArray = ["images/fifthgrade-lessontwo/acti-case-one.png","images/fifthgrade-lessontwo/acti-case-two.png","images/fifthgrade/Case3weekendSleepLoss.png"];
    var nameArray = ['Mike', 'Mary', 'Ricardo'];
    var ProfileArray = ['<h4>Mike is an 11-year old night owl. He likes playing video games, texting with his friends and watching late night TV. He sleeps soundly, but he finds that several hours after awakening he becomes fatigued and tired. It is difficult for him to wake up in the morning.<br><br>School is difficult for him. He has trouble paying attention and may fall asleep in class especially in the mornings. Sometimes he is moody and irritable during the day.</h4>','<h4>Mary is a 10-year old who is involved in many after school activities. Gymnastics practice, dance, piano lessons and girl scout activities all occur after school and sometimes in the evenings after dinner. Doing homework doesn’t start until 10 pm. Afterwards, she also likes to text and talk with her friends.<br><br>At school in the morning, she struggles to keep her eyes open when the teacher is talking and has problems concentrating on the lessons.   She doodles and plays with her pencil and fools around during cooperative learning tasks.  The teacher frequently has to remind her to get to work.</h4>','<h4>Ricardo is an 11-year old student musician. He also enjoys walking and bike-riding to be outdoors and get exercise. He reports feeling not sleepy and pleasant throughout the entire week. On weekend nights, he likes to play computer games and watch TV because he doesn’t get to do them during the week. He usually does well in school, but is grumpy on Monday mornings and doesn’t look forward to school. He has difficulty getting up and needs to use an alarm clock.</h4>'];
    var formArray = ['questionForm1', 'questionForm2', 'questionForm3'];
    hideAllForm();
    var caseID=-1;
    $('#workId').change( function (e) {
        e.preventDefault();
        caseID = $('#workId').val();
        var name = nameArray[caseID]
        $("#actigram").attr("src", actogramArray[caseID]);
        $("#profile").html(ProfileArray[caseID]);
        $("#patternIntro").html('Read the sleep profiles below. Which profile best fits '+ name + '?');
        hideAllForm();
        $("#"+formArray[caseID]).show();
    });
    function hideAllForm(){
      $("#questionForm1").hide();
      $("#questionForm2").hide();
      $("#questionForm3").hide();
    }
    $(function () {
        $("#pattern-activity").click(function() {
          var pattern = $('input[name=pattern]:checked').val();
          console.log(pattern)
          $('#caseID'+caseID).val(caseID);
          $('#patternDiv'+caseID).val(pattern);
          $("#"+formArray[caseID]).submit();
        });
    });



    </script>
</html>
