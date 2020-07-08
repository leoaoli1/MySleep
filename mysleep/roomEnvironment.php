<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
	require_once('utilities.php');
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

    // If data has already been saved for this student, place it in the body.
	include 'connectdb.php';
	if ($config) {
		$result =mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE contributors LIKE '%$userId%' ORDER BY resultRow DESC LIMIT 1");
	}else {
		$result =mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE userId='$userId'");
	}
	$numRow = mysql_num_rows ($result);
	unset($_SESSION['current_work']);
	if ($numRow>0) {
		$row = mysql_fetch_array($result);
		if (isset($row['response'])) {
		   $content = $row['response'];
		}
		$_SESSION['current_work'] = $row;
	  $resultRow = $row['resultRow'];
   }else {
   	$content = "";
		$resultRow = -1;
   }
   mysql_close($con);
?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include 'partials/header.php' ?>
        <title>MySleep // Room Construction</title>

        <!-- CSS start -->
        <style type="text/css">
				table, th, td {
				  border: 1px solid black;
				  border-collapse: collapse;
				}
          .imagewrap {display:inline-block;position:relative;}
          #div-tv {
           position:absolute;top:15%;left:70%;width: 100%
          }
          #btn-tv {
           position:absolute;top:15%;left:70%;
          }
					#div-food {
           position:absolute;top:69%;left:5%;width: 100%
          }
          #btn-food {
           position:absolute;top:62%;left:5%;
          }
					#div-clock {
           position:absolute;top:6%;left:40%;width: 100%
          }
          #btn-clock {
           position:absolute;top:6%;left:40%;
          }
					#div-pets {
           position:absolute;top:45%;left:45%;width: 100%
          }
          #btn-pets {
           position:absolute;top:65%;left:45%;
          }
					#div-drink {
           position:absolute;top:68%;left:20%;height: 100%
          }
          #btn-drink {
           position:absolute;top:76%;left:15%;
          }
					#div-temp {
           position:absolute;top:64%;left:87%;width: 100%
          }
          #btn-temp {
           position:absolute;top:74%;left:80%;
          }
					#div-noise {
           position:absolute;top:44%;left:65%;width: 100%
          }
          #btn-noise {
           position:absolute;top:53%;left:63%;
          }
					#div-phone {
           position:absolute;top:58%;left:33%;width: 100%
          }
          #btn-phone {
           position:absolute;top:63%;left:29%;
          }
					#div-game {
           position:absolute;top:65%;left:65%;width: 100%
          }
          #btn-game {
           position:absolute;top:70%;left:63%;
          }
					#btn-window {
           position:absolute;top:30%;left:12%;
          }
					#btn-people {
           position:absolute;top:45%;left:28%;
          }

          #div-lamp {
           position:absolute;top:15%;left:5%;width: 100%
          }
          #btn-lamp {
           position:absolute;top:15%;left:5%;
          }
        </style>
        <!-- CSS end -->

    </head>
		<?php include 'partials/scripts.php' ?>
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
                                    <li class="active">What is Sleep?</li>
                                </ol>
                            </div>
                        </div>
												<?php } ?>

												<!-- <form action="what-is-sleep-done" method="post"> -->



                            <div class="row"><!-- Activity Content -->
																<div class="col-xs-offset-1 col-xs-10 col-md-10 col-md-offset-1">
                                    <!-- Hidden tabs -->
		                                <ul class="nav nav-justified nav-pills nav-pills-info" role="tablist" style="display:none;">
		                                  <li role="presentation" class="active"><a href="#panel1" aria-controls="datagraphs" role="tab" data-toggle="tab" id = "firstTab">1</a></li>
		                                  <li role="presentation" ><a href="#panel2" aria-controls="diarygraphs" role="tab" data-toggle="tab" id = "secondTab">2</a></li>
		                                </ul>
                                    <!-- Tab panes -->
		                                <div class="tab-content" style="">
																			<!-- Tab panes -->
	                                    <div role="tabpanel" class="tab-pane active" id="panel1">
																				<div class="row"><!-- Activity Configure -->
																						<div class="col-xs-offset-0 col-xs-12">
							                                  <h4>What decisions would you make about this room to improve Estrella’s sleep?<br><small>Click on each object and select the best answer to the question.  When all are complete, click on Continue.</small></h4>
																								<?php include 'add-group-member-button.php' ?>
																						</div>
						                            </div>
																				<div id="tvdialog" title="Television">
																				  <p>Which of the following is best for healthy sleep?</p>
																				</div>
																				<div id="fooddialog" title="Food">
																				  <p>Which of the following is best for healthy sleep?</p>
																				</div>
																				<div id="clockdialog" title="Clock">
																				  <p>When should 4th graders go to sleep at night?</p>
																				</div>
																				<div id="petsdialog" title="Pets">
																				  <p>What should happen to pets at bedtime?</p>
																				</div>
																				<div id="drinkdialog" title="Drinks">
																				  <p>What is the best type of drink to have at bedtime?</p>
																				</div>
																				<div id="tempdialog" title="Temperature">
																				  <p>What bedroom temperature is best for sleeping?</p>
																				</div>
																				<div id="lightdialog" title="Light">
																				  <p>How much light should there be at bedtime?</p>
																				</div>
																				<div id="noisedialog" title="Sound">
																				  <p>Which of the following is best for healthy sleep?</p>
																				</div>
																				<div id="phonedialog" title="Cell Phone">
																				  <p>Which of the following is best for healthy sleep?</p>
																				</div>
																				<div id="gamedialog" title="Video Gaming">
																				  <p>Which of the following is best for healthy sleep?</p>
																				</div>
																				<div id="windowdialog" title="Window">
																				  <p>Which is the following is best for healthy sleep?</p>
																				</div>
																				<div id="peopledialog" title="Roommate">
																				  <p>Which of the following is best for healthy sleep?</p>
																				</div>
                                        <div class="imagewrap">
                                            <img id="roomImage"src="images/fourthGrade/roomConstruction.jpg" style="width:100%">

                                            <div id="div-tv" data-role="fieldcontain">
                                              <img id="tvImage" src="images/fourthGrade/tvOn.png" style="width:25%">
                                            </div>
																						<div id="div-drink" data-role="fieldcontain">
                                              <img id="drinkImage" src="images/fourthGrade/coffee.png" style="height:10%">
                                            </div>
																						<div id="div-food" data-role="fieldcontain">
                                              <img id="foodImage" src="images/fourthGrade/food.png" style="width:15%">
                                            </div>
																						<div id="div-clock" data-role="fieldcontain">
                                              <img id="clockImage" src="images/fourthGrade/clock.png" style="width:10%">
                                            </div>
																						<div id="div-pets" data-role="fieldcontain">
                                              <img id="petsImage" src="images/fourthGrade/pets.png" style="width:12%">
                                            </div>
																						<div id="div-temp" data-role="fieldcontain">
                                              <img id="tempImage" src="images/fourthGrade/temp72.png" style="width:8%">
                                            </div>
																						<div id="div-noise" data-role="fieldcontain">
                                              <img id="noiseImage" src="images/fourthGrade/noiseloud.png" style="width:8%">
                                            </div>
																						<div id="div-phone" data-role="fieldcontain">
                                              <img id="phoneImage" src="images/fourthGrade/cellPhone.png" style="width:10%">
                                            </div>
																						<div id="div-game" data-role="fieldcontain">
                                              <img id="gameImage" src="images/fourthGrade/game.png" style="width:10%">
                                            </div>

                                            <!-- <div id="div-lamp" data-role="fieldcontain">
                                              <img id="lampImage" src="images/fourthGrade/lamp.png" style="width:10%">
                                            </div> -->

                                            <div id="btn-tv" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="tvButton" style="background-color: rgba(100, 100, 100, 0.5) ;font-size: 16px;font-weight: bold;color: white;padding: 10px 40px;text-align: center;text-decoration: none;display: inline-block;">TV</a>
                                            </div>
																						<div id="btn-drink" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="drinkButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 30px;text-align: center;text-decoration: none;display: inline-block;">Drink</a>
                                            </div>
																						<div id="btn-food" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="foodButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 10px 40px;text-align: center;text-decoration: none;display: inline-block;">Food</a>
                                            </div>
																						<div id="btn-clock" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="clockButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 10px 40px;text-align: center;text-decoration: none;display: inline-block;">Clock</a>
                                            </div>
																						<div id="btn-pets" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="petsButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 10px 40px;text-align: center;text-decoration: none;display: inline-block;">Pets</a>
                                            </div>
																						<div id="btn-temp" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="tempButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 10px;text-align: center;text-decoration: none;display: inline-block;">Temperature</a>
                                            </div>
																						<div id="btn-noise" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="noiseButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 10px;text-align: center;text-decoration: none;display: inline-block;">Sound</a>
                                            </div>
																						<div id="btn-phone" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="phoneButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 10px;text-align: center;text-decoration: none;display: inline-block;">Cell Phone</a>
                                            </div>
																						<div id="btn-game" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="gameButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 10px;text-align: center;text-decoration: none;display: inline-block;">Video Gaming</a>
                                            </div>
																						<div id="btn-window" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="windowButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 10px;text-align: center;text-decoration: none;display: inline-block;">Window</a>
                                            </div>
																						<div id="btn-people" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="peopleButton" style="background-color: rgba(100, 100, 100, 0.4) ;font-size: 16px;font-weight: bold;color: white;padding: 6px 10px;text-align: center;text-decoration: none;display: inline-block;">Room Mate</a>
                                            </div>

                                            <div id="btn-lamp" data-role="fieldcontain">
                                              <a href="javascript:void(0)" id="lightButton" style="background-color: rgba(100, 100, 100, 0.5) ;font-size: 16px;font-weight: bold;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;">Lighting</a>
                                            </div>

                                        </div>

                                        <div class="row">
        																    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
        																				<a class="btn btn-gradpr btn-roundBold btn-large btn-block" onclick="continueFeedback()">Continue</a>
        																    </div>
        																</div>
																				<div class="hidden">
																					<script type="text/javascript">
																							var images = new Array()
																							function preload() {
																								for (i = 0; i < preload.arguments.length; i++) {
																									images[i] = new Image()
																									images[i].src = preload.arguments[i]
																								}
																							}
																							preload(
																								"images/fourthGrade/roomConstructionDark.jpg",
																								"images/fourthGrade/roomConstructionNight.jpg"
																							)
																					</script>
																				</div>
                                      </div>
                                      <!-- Second panes -->
                                      <div role="tabpanel" class="tab-pane" id="panel2">
                                        <h4 id="feedback">Feedback</h4>
																				<table style="width:100%;">
																				  <tr>
																				    <th style="width:20%">Room choice</th>
																				    <th style="width:40%">Your answer</th>
																				    <th style="width:40%">Feedback</th>
																				  </tr>
																				  <tr>
																				    <td>Television</td>
																				    <td id="ans-tv"></td>
																				    <td>Watching television in bed is a bad sleep habit and blue light from the screen will make it harder to fall asleep.</td>
																				  </tr>
																				  <tr>
																				    <td>Food</td>
																				    <td id="ans-food"></td>
																				    <td>Eating a lot within 2 hours of bedtime is bad for sleep. A light snack with protein such as peanut butter or cheese would be best. Food with sugar or chocolate is not recommended.</td>
																				  </tr>
																					<tr>
																				    <td>Clock</td>
																				    <td id="ans-clock"></td>
																				    <td>4th graders need to go to bed at the same time every night and sleep between 9 and 12 hours.</td>
																				  </tr>
																					<tr>
																				    <td>Pets</td>
																				    <td id="ans-pet"></td>
																				    <td>Four legged friends are great company, but sleeping with you or even in your bedroom can cause you to sleep poorly.</td>
																				  </tr>
																					<tr>
																				    <td>Drinks</td>
																				    <td id="ans-drink"></td>
																				    <td>Drinking large amounts of fluid will make you get up to urinate. If you are a bit thirsty, avoid coffee, tea or chocolate milk because they have caffeine which will keep you awake.</td>
																				  </tr>
																					<tr>
																				    <td>Temperature</td>
																				    <td id="ans-temp"></td>
																				    <td>Your bedroom should be on the cool side (60-65 degrees), but some people sleep better at other temperatures.</td>
																				  </tr>
																					<tr>
																				    <td>Light</td>
																				    <td id="ans-light"></td>
																				    <td>A dark room is best for sleep. A small nightlight is ok if a small amount of light is needed to make you comfortable.</td>
																				  </tr>
																					<tr>
																				    <td>Sound</td>
																				    <td id="ans-sound"></td>
																				    <td>Loud noise make it harder to sleep, but some people find complete silence uncomfortable; they find constant soft (white) noise helps their sleep.</td>
																				  </tr>
																					<tr>
																				    <td>Cell Phone</td>
																				    <td id="ans-phone"></td>
																				    <td>The blue light from cell phone screens makes it harder to fall asleep. Friends calling or texting will interrupt your sleep.</td>
																				  </tr>
																					<tr>
																				    <td>Video Gaming</td>
																				    <td id="ans-game"></td>
																				    <td>You will delay your bedtime playing video games because once you start, it is hard to stop. The blue light from the screens also make it harder to fall asleep.</td>
																				  </tr>
																					<tr>
																				    <td>Window</td>
																				    <td id="ans-window"></td>
																				    <td>Outside light makes it harder to sleep especially during the summer months. Something covering windows in your bedroom is best for sleeping.</td>
																				  </tr>
																					<tr>
																				    <td>Other people in the room</td>
																				    <td id="ans-roommate"></td>
																				    <td>Other people sleeping in your room can make noise and wake you up. If possible, it is best to have your own bed and sleep by yourself.</td>
																				  </tr>
																				</table>

                                        <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
            														<input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
																				<div class="row">
																						<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
																								<a class="btn btn-gradbb btn-roundBold btn-large btn-block" onclick="edit()">Try again</a>
																						</div>
																				</div>
																				<div class="row">
																						<div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
																								<a class="btn btn-gradpr btn-roundBold btn-large btn-block" onclick="quit()">Quit</a>
																						</div>
																				</div>


                                      </div>
                                  </div>
																</div>
                            </div>




                        <!-- </form> -->
                    </div>
                </div>
            </div>
						<div class="modal fade" id="submit-success" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
					<div class="modal-dialog">
					    <div class="modal-content">
								<div class="modal-header">
								    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
								    Your teacher will now give you further instructions.
								</div>
					    </div>
					</div>
				    </div>
        <?php include 'partials/footer.php' ?>
    </body>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
    var light = -1;
    var tv = -1;
		var food = -1;
		var clock = -1;
		var pets = -1;
		var drink = -1;
		var temp = -1;
		var noise = -1;
		var phone = -1;
		var game = -1;
		var windows = -1;
		var people = -1;

        $(document).ready(function() {
            $('#tvButton').click(function() {
								$(this).html('TV <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#tvdialog" ).dialog( "open" );
            });
						$('#foodButton').click(function() {
								$(this).html('Food <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#fooddialog" ).dialog( "open" );
            });
						$('#clockButton').click(function() {
								$(this).html('Clock <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#clockdialog" ).dialog( "open" );
            });
						$('#petsButton').click(function() {
								$(this).html('Pets <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#petsdialog" ).dialog( "open" );
            });
						$('#drinkButton').click(function() {
								$(this).html('Drink <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#drinkdialog" ).dialog( "open" );
            });
						$('#tempButton').click(function() {
								$(this).html('Temperature <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#tempdialog" ).dialog( "open" );
            });
						$('#lightButton').click(function() {
								$(this).html('Lighting <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#lightdialog" ).dialog( "open" );
            });
						$('#noiseButton').click(function() {
								$(this).html('Sound <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#noisedialog" ).dialog( "open" );
            });
						$('#phoneButton').click(function() {
								$(this).html('Cell Phone <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#phonedialog" ).dialog( "open" );
            });
						$('#gameButton').click(function() {
								$(this).html('Video Gaming <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#gamedialog" ).dialog( "open" );
            });
						$('#windowButton').click(function() {
								$(this).html('Window <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#windowdialog" ).dialog( "open" );
            });
						$('#peopleButton').click(function() {
								$(this).html('Room Mate <i class="fa fa-check" style="color:rgba(126, 221, 33, 1)"></i>');
                $( "#peopledialog" ).dialog( "open" );
            });
        });

        // function lampClick() {
        //   light = !light;
        //   if ($('#lampImage').is(':visible')) {
        //     $('#lampImage').hide();
        //     $('#lampButton').text('Add Light');
				//
        //   }else {
        //     $('#lampImage').show();
        //     $('#lampButton').text('Remove Light');
        //   }
        // }

        function continueFeedback(){
					var sum = 12+light+tv+temp+food+drink+noise+clock+pets+phone+game+people+windows;
          document.getElementById('feedback').innerHTML = "Your sleep room score is: "+sum+"/24";
          $('#secondTab').trigger('click')
          window.scrollTo({ top: 100, behavior: 'smooth' });
        }
				function edit(){
					// $('#firstTab').trigger('click')
					window.location.reload();
        }
				function quit(){
					$('#submit-success').modal();
					// var lesson = <?php echo $_GET['lesson']; ?>;
					// window.location.href = "http://zfactor.coe.arizona.edu/mysleep/lesson-menu?lesson="+lesson;
        }

        $(function () {
					var showSettings = {
						effect: "blind",
						duration: 400
					};
					var hideSettings = {
						effect: "explode",
						duration: 400
					};

					$( "#tvdialog" ).dialog({
						height: 200,
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Turn TV On": function() {
								tv = -1;
								$('#tvImage').show();
								$('#tvImage').attr("src","images/fourthGrade/tvOn.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-tv').innerHTML = "Turn TV On";
			        },
							"Turn TV Off": function() {
								tv = 0;
								$('#tvImage').show();
								$('#tvImage').attr("src","images/fourthGrade/tvOff.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-tv').innerHTML = "Turn TV Off";
			        },
			        "No TV in bedroom": function() {
								tv = 1;
								$('#tvImage').hide();
			          $( this ).dialog( "close" );
								document.getElementById('ans-tv').innerHTML = "No TV in bedroom";
			        }
			      }
					});
					$( "#fooddialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Have food in bedroom": function() {
								food = -1;
								$('#foodImage').show();
			          $( this ).dialog( "close" );
								document.getElementById('ans-food').innerHTML = "Have food in bedroom";
			        },
			        "No food in bedroom": function() {
								food = 1;
								$('#foodImage').hide();
			          $( this ).dialog( "close" );
								document.getElementById('ans-food').innerHTML = "No food in bedroom";
			        }
			      }
					});
					$( "#clockdialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Bedtime between 8-9 pm everyday": function() {
								clock = 1;
			          $( this ).dialog( "close" );
								document.getElementById('ans-clock').innerHTML = "Bedtime between 8-9 pm everyday";
			        },
							"Bedtime between 8-9 pm, 5 or less nights per week": function() {
								clock = 0;
			          $( this ).dialog( "close" );
								document.getElementById('ans-clock').innerHTML = "Bedtime between 8-9 pm, 5 or less nights per week";
			        },
			        "Bedtime later than 9 pm": function() {
								clock = -1;
			          $( this ).dialog( "close" );
								document.getElementById('ans-clock').innerHTML = "Bedtime later than 9 pm";
			        }
			      }
					});
					$( "#petsdialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Keep pets in the room": function() {
								pets = -1;
								$('#petsImage').show();
			          $( this ).dialog( "close" );
								document.getElementById('ans-pet').innerHTML = "Keep pets in the room";
			        },
			        "Keep pets out of the room": function() {
								pets = 1;
								$('#petsImage').hide();
			          $( this ).dialog( "close" );
								document.getElementById('ans-pet').innerHTML = "Keep pets out of the room";
			        }
			      }
					});
					$( "#drinkdialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Caffeine": function() {
								drink = -1;
								$('#drinkImage').show();
								$('#drinkImage').attr("src","images/fourthGrade/coffee.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-drink').innerHTML = "Caffeine";
			        },
							"Water": function() {
								drink = 0;
								$('#drinkImage').show();
								$('#drinkImage').attr("src","images/fourthGrade/water.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-drink').innerHTML = "Water";
			        },
			        "No drink": function() {
								drink = 1;
								$('#drinkImage').hide();
			          $( this ).dialog( "close" );
								document.getElementById('ans-drink').innerHTML = "No drink";
			        }
			      }
					});
					$( "#tempdialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "64 degrees": function() {
								temp = -1;
								$('#tempImage').attr("src","images/fourthGrade/temp64.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-temp').innerHTML = "64 degree";
			        },
							"68 degrees": function() {
								temp = 1;
								$('#tempImage').attr("src","images/fourthGrade/temp68.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-temp').innerHTML = "68 degree";
			        },
			        "72 degrees": function() {
								temp = -1;
								$('#tempImage').attr("src","images/fourthGrade/temp72.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-temp').innerHTML = "72 degree";
			        }
			      }
					});
					$( "#lightdialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Bright light": function() {
								light = -1;
								$('#roomImage').attr("src","images/fourthGrade/roomConstruction.jpg");
			          $( this ).dialog( "close" );
								document.getElementById('ans-light').innerHTML = "Bright light";
			        },
							"Night light": function() {
								light = 0;
								$('#roomImage').attr("src","images/fourthGrade/roomConstructionNight.jpg");
			          $( this ).dialog( "close" );
								document.getElementById('ans-light').innerHTML = "Night light";
			        },
			        "No light": function() {
								light = 1;
								$('#roomImage').attr("src","images/fourthGrade/roomConstructionDark.jpg");
			          $( this ).dialog( "close" );
								document.getElementById('ans-light').innerHTML = "No light";
			        }
			      }
					});
					$( "#noisedialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Loud noise": function() {
								noise = -1;
								$('#noiseImage').attr("src","images/fourthGrade/noiseloud.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-sound').innerHTML = "Loud noise";
			        },
							"White noise": function() {
								noise = 0;
								$('#noiseImage').attr("src","images/fourthGrade/noisewhite.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-sound').innerHTML = "White noise";
			        },
			        "No noise": function() {
								noise = 1;
								$('#noiseImage').attr("src","images/fourthGrade/noiseno.png");
			          $( this ).dialog( "close" );
								document.getElementById('ans-sound').innerHTML = "No noise";
			        }
			      }
					});
					$( "#phonedialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Sleep with cell phone": function() {
								phone = -1;
								$('#phoneImage').show();
			          $( this ).dialog( "close" );
								document.getElementById('ans-phone').innerHTML = "Sleep with cell phone";
			        },
			        "Sleep without cell phone": function() {
								phone = 1;
								$('#phoneImage').hide();
			          $( this ).dialog( "close" );
								document.getElementById('ans-phone').innerHTML = "Sleep without cell phone";
			        }
			      }
					});
					$( "#gamedialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Video game before sleep": function() {
								game = -1;
								$('#gameImage').show();
			          $( this ).dialog( "close" );
								document.getElementById('ans-game').innerHTML = "Video game before sleep";
			        },
			        "No video game": function() {
								game = 1;
								$('#gameImage').hide();
			          $( this ).dialog( "close" );
								document.getElementById('ans-game').innerHTML = "No video game";
			        }
			      }
					});
					$( "#windowdialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "Uncover window": function() {
								windows = -1;
			          $( this ).dialog( "close" );
								document.getElementById('ans-window').innerHTML = "Uncover window";
			        },
			        "Window with blinds": function() {
								windows = 1;
			          $( this ).dialog( "close" );
								document.getElementById('ans-window').innerHTML = "Window with blinds";
			        }
			      }
					});
					$( "#peopledialog" ).dialog({
						width: 400,
						autoOpen: false,
						show: showSettings,
						hide: hideSettings,
						buttons: {
			        "1 bed 2 people": function() {
								people = -1;
			          $( this ).dialog( "close" );
								document.getElementById('ans-roommate').innerHTML = "1 bed 2 people";
			        },
							"2 beds 2 people": function() {
								people = 0;
			          $( this ).dialog( "close" );
								document.getElementById('ans-roommate').innerHTML = "2 beds 2 people";
			        },
			        "1 bed 1 person": function() {
								people = 1;
			          $( this ).dialog( "close" );
								document.getElementById('ans-roommate').innerHTML = "1 bed 1 person";
			        }
			      }
					});
            $("#exit-activity").click(function(){
                window.window.location.href = "fourth-grade-lesson-menu?lesson=1";
            });
            $("#submit-activity").click(function() {
                $( "form" ).submit();
              });

             });
</script>

    </html>
