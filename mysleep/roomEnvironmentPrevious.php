<!DOCTYPE html>
<?php
#
# Part of the MySleep package
#
# (C) 2016 University of Arizona, College of Education, STEPS Team
#
# Author:   James Geiger <jamesgeiger@email.arizona.edu>
#
#

require_once('utilities.php');
#checkAuth();
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$grade = $_GET['grade'];
$classId = $_SESSION['classId'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
?>
<html>
  <head>

    <!-- UIkit CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit-icons.min.js"></script>

    <title>MySleep | Room Enviroment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.css" integrity="sha256-0AEO0dmdWUZ8e17VwaCiLJ1k8VlFQq2jGRetjpVCr34=" crossorigin="anonymous" />
    <!-- STYLE OVERRIDE INJECTION -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css" integrity="sha256-iVhQxXOykHeL03K08zkxBGxDCLCuzRGGiTYf2FL6mLY=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/smartwizard@4.2.2/dist/css/smart_wizard.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.3.2/css/bootstrap-slider.css" />
      <style media="screen">

              @media (max-width: 1200px) {

                nav.uk-main-nav {
                  padding-bottom: 40px;
                }

                .uk-navbar-center {
                  padding-bottom: 40px;
                }

                .uk-main-container {
                  max-width: 960px;
                }
              }

              @media (min-width: 1160px){
                .uk-main-container {
                  max-width: 1000px;
                }
              }

              footer > nav {
                height: 3em;
              }


                .uk-main {
                  display: flex;
                  min-height: 100vh;
                  flex-direction: column;
                }

                footer {
                  position: relative;
                  bottom: 0;
                  width: 100%;
                }

                header {
                  position: relative;
                  top: 0;
                  width: 100%;
                }

                footer > nav > .uk-navbar-right > .uk-navbar-item, footer > nav > .uk-navbar-left > .uk-navbar-item {
                  height: 3em;
                }

                main {
                  position:relative;top:-40px;
                }

                .uk-main-card {
                  background: #fff;
                  box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
                  position: relative;
                  box-sizing: border-box;
                  -webkit-transition: box-shadow .1s ease-in-out;
                  transition: box-shadow .1s ease-in-out;
                  padding: 40px 40px;
                  border-radius: 5px;
                }

                .uk-nav-button {
                  z-index: 1000;
                  border-radius: 5px;
                  padding: 5px 15px;
                }

                .main-flex{
                  flex:1;
                }

                text.highcharts-credits {
                  display: none;
                }



      #main-drag-container:before {
        display: block;
        content: "My Room Environment";
        font-size: 1.5em;
        color: #fff;
        margin-bottom: 1em;
      }

      #main-drag-container {
        min-height: 15em;
      }

      #main-drag-container > .drag-item {
        display: inline-table;
      }

      .drag-container {
        display:flex;
        justify-content:center;
        align-items:center;
      }

      .drag-container>:last-child{
        margin-bottom: .5em;
      }

      .drag-item {
        border: solid 1px #000;
        border-radius: 5px;
        background: #fff;
        z-index: 100;
        margin: .5em;
      }

      .sw-main .step-content {
        margin: 2em 0;
      }

      /* These styles 'disable' the default link behavior for tabs */

      .uk-nolink>*>a:hover {
        cursor: default;
        text-decoration: none;
        color: #999;
      }

      .uk-nolink>.uk-active>a:hover {
        cursor: default;
        text-decoration: none;
        color: #333;
      }

      #container {
        margin: 20px;
        width: 400px;
        height: 8px;
      }
	      .nav-tabs>li>a {
	      margin-right: 2px;
	      line-height: 1.42857143;
	      border: 0px;
	      border-bottom: 1px solid transparent;
	      border-radius: 4px 4px 0 0;
	      }
      </style>
  </head>
  <body>
    <!-- MAIN CONTENT START -->
    <div class="uk-offcanvas-content uk-main">

      <!-- NAVBAR PARTIAL-->
    <header>
      <!--<nav class="uk-navbar-container uk-container uk-container-expand uk-main-nav" uk-navbar>
        <div class="uk-navbar-center uk-hidden@l">
          <a href="" class="uk-navbar-item uk-logo">MySleep</a>
        </div>
          <div class="uk-navbar-right">
            <a class="uk-navbar-toggle" uk-toggle="target: #side-nav" uk-navbar-toggle-icon></a>
        </div>
      </nav>-->
    </header>

      <!-- CONTENT -->
      <div class="main-flex">
        <div class="uk-container uk-main-container">
          <main>
            <div class="uk-main-card" style="padding-top: 10em">

              <!-- BREADCRUMBS -->
              <?php
              require_once('partials/nav-links.php');
              navigationLink($config,$userType);
               ?>

              <!-- CONTENT BLOCK -->
              <div id="smartwizard">
                <ul class="uk-tab uk-nolink uk-child-width-expand@s">
                  <li><a href="#slide-1">Introduction</a></li>
                  <li><a href="#slide-2">My Environment</a></li>
                  <li><a href="#slide-3">My Score</a></li>
                </ul>
                <div>
                  <div id="slide-1" class="uk-slide">
                    <h3>Room Environment Construction</h3>
                    <p>We have learned about ways that our sleep can be affected, including things in our own lightroom!  On the next tab, click and drag different environment <i>variables</i> into your "lightroom".  Decide which will be best for you, and be prepared to say why!</p>
                    <strong>Click next to get started.</strong>
                  </div>
                  <div id="slide-2" class="uk-slide">
                    <div class="row">
                      <div class="col-xs-offset-2 col-xs-8 col-md-8 col-md-offset-2">
                        <label style="font-size:25px;text-align:center;width: 100%;" id="scoreLabel">My Room Score: <label id="scoreVal">70</label>/100</label>
                      </div>
                    </div>
                    <div uk-grid>
                      <div class="uk-width-1-1">
                        <!-- <div class="uk-card uk-card-primary uk-card-body" id="main-drag-container">
                        </div> -->
                      </div>
                    </div>
                    <div uk-grid>
                      <div class="uk-width-1-2@m uk-width-1-1@s">
                        <h3>Room Temperature</h3>


                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                            <label style="font-size:20px;"id="temperatureCurrentSliderValLabel">Current Temperature: <label style="color:rgb(192,64,192);" id="temperatureSliderVal">75</label> °F</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2" style="margin-top: 20px;"><input id="temperature" data-slider-id='ex1Slider' type="text" data-slider-min="60" data-slider-max="80" data-slider-step="1" data-slider-value="75"/>
                          </div>
                        </div>
                        <!-- <div class="drag-container uk-card uk-card-default uk-card-body" id="temperature">
                          <div class="drag-item" data-type="temperature" data-value="79" title="79 Degrees" data-score="0" uk-tooltip="delay: 300">
                            <img class="uk-border-rounded" src="./assets/icons/tempIcons/highTemp.png" alt="Temperature 78 Degrees Farenheight" width="100" height="100">
                          </div>
                          <div class="drag-item" data-type="temperature" data-value="71" title="71 Degrees" data-score="0.5" uk-tooltip="delay: 300">
                            <img class="uk-border-rounded" src="./assets/icons/tempIcons/medTemp.png" alt="Temperature 71 Degrees Farenheight" width="100" height="100">
                          </div>
                          <div class="drag-item" data-type="temperature" data-value="65" title="65 Degrees" data-score="1" uk-tooltip="delay: 300">
                            <img class="uk-border-rounded" src="./assets/icons/tempIcons/lowTemp.png" alt="Temperature 65 Degrees Farenheight" width="100" height="100">
                          </div>
                        </div> -->
                      </div>
                      <div class="uk-width-1-2@m uk-width-1-1@s">
                        <h3>Room Brightness</h3>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                            <img class="uk-border-rounded" src="./images/fourthGrade/light4.png" alt="Light option" width="280" id="lightarea">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2" style="margin-top: 20px;"><input id="light" data-slider-id='ex2Slider' type="text" data-slider-min="0" data-slider-max="5" data-slider-step="1" data-slider-value="4"/>
                          </div>
                        </div>
                          <!-- <div class="drag-container uk-card uk-card-default uk-card-body" id="light">
                            <div class="drag-item" data-type="light" data-value="Bright" title="Bright Light" data-score="0" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/lightIcons/brightLight.png" alt="Bright light" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="light" data-value="Dim" title="Dim Light" data-score="0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/lightIcons/dimLight.png" alt="Dim light" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="light" data-value="No" title="No Light" data-score="1" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/lightIcons/offLight.png" alt="No light" width="100" height="100">
                            </div>
                        </div> -->
                      </div>
                      <div class="uk-width-1-2@m uk-width-1-1@s">
                        <h3>Bed Options</h3>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                            <img class="uk-border-rounded" src="./images/fourthGrade/firmbed.png" alt="Bed option" width="280" id="bedOption">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2" style="margin-top: 20px;"><input id="bed" data-slider-id='ex3Slider' type="text" data-slider-min="0" data-slider-max="2" data-slider-step="1" data-slider-value="2"/>
                          </div>
                        </div>
                          <!-- <div class="drag-container uk-card uk-card-default uk-card-body" id="bed">
                            <div class="drag-item" data-type="bed" data-value="Too Soft" title="Too Soft" data-score="0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/bedIcons/firmBed.png" alt="Too Soft Bed" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="bed" data-value="Supportive" title="Supportive" data-score="1" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/bedIcons/firmBed.png" alt="Supportive Bed" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="bed" data-value="Too Firm" title="Too Firm" data-score="0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/bedIcons/firmBed.png" alt="Too Firm Bed" width="100" height="100">
                            </div>
                        </div> -->
                      </div>
                      <div class="uk-width-1-2@m uk-width-1-1@s">
                        <h3>Ambient Room Noise</h3>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2">
                            <img class="uk-border-rounded" src="./images/fourthGrade/noise2.png" alt="Bed option" width="220" id="noiseOption">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-offset-1 col-xs-10 col-md-8 col-md-offset-2" style="margin-top: 20px;"><input id="noise" data-slider-id='ex4Slider' type="text" data-slider-min="0" data-slider-max="3" data-slider-step="1" data-slider-value="2"/>
                          </div>
                        </div>
                          <!-- <div class="drag-container uk-card uk-card-default uk-card-body" id="noise">
                            <div class="drag-item" data-type="noise" data-value="Loud" title="Loud Noise" data-score="0" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/noiseIcons/highNoise.png" alt="Loud Noise" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="noise" data-value="Low/White" title="White/Low Noise" data-score="0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/noiseIcons/lowNoise.png" alt="Low or White Noise" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="noise" data-value="No" title="Silent/No Noise" data-score="1" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/noiseIcons/noNoise.png" alt="Silent" width="100" height="100">
                            </div>
                        </div> -->
                      </div>
                      <div class="uk-width-1-1">
                        <h3>Other Room Options</h3>
                          <div class="drag-container uk-card uk-card-default uk-card-body" id="other">
                            <div class="drag-item" data-type="other" data-value="Phone" title="Cell Phone" data-score="-0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/otherIcons/cellphone.png" alt="Cell Phone" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="other" data-value="Pets" title="Pets" data-score="-0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/otherIcons/pets.png" alt="Pets" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="other" data-value="Television" title="Television" data-score="-0.3" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/otherIcons/television.png" alt="Television" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="other" data-value="Computer" title="Computer" data-score="-0.3" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/otherIcons/computer.png" alt="Computer" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="other" data-value="Alarm" title="Traditional Alarm Clock" data-score="0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/otherIcons/alarm.png" alt="Alarm Clock" width="100" height="100">
                            </div>
                            <div class="drag-item" data-type="other" data-value="Siblings" title="Siblings/Other People" data-score="-0.5" uk-tooltip="delay: 300">
                              <img class="uk-border-rounded" src="./assets/icons/otherIcons/others.png" alt="Siblings/Other People" width="100" height="100">
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="slide-3" class="uk-slide">
                    <h3>My Score</h3>
                    <div id="progressContainer" class="uk-margin-bottom"></div>
                    <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-large-bottom">
                      <h3 class="uk-card-title">My Selections</h3>
                      <p>
                        <strong>Room Temperature</strong><br>
                        <span id="temp-selection"></span>
                      </p>
                      <p>
                        <strong>Light Type</strong><br>
                        <span id="light-selection"></span>
                      </p>
                      <p>
                        <strong>Bed Type</strong><br>
                        <span id="bed-selection"></span>
                      </p>
                      <p>
                        <strong>Ambient Noise</strong><br>
                        <span id="noise-selection"></span>
                      </p>
                      <p>
                        <strong>Other Room Options</strong><br>
                        <span id="other-selection"></span>
                      </p>
                    </div>
                    <form class="uk-form-stacked" id="responseForm">
                      <input type="hidden" id="tempSelectForm" name="tempSelection" value="">
                      <input type="hidden" id="lightSelectForm" name="lightSelection" value="">
                      <input type="hidden" id="bedSelectForm" name="bedSelection" value="">
                      <input type="hidden" id="noiseSelectForm" name="noiseSelection" value="">
                      <input type="hidden" id="otherSelectForm" name="otherSelection" value="">
                      <div>
                        <label class="uk-form-label">1. What is one thing that you could change about your room environment?</label>
                        <div class="uk-form-controls">
                          <textarea class="uk-textarea" rows="5" name="responseOne"></textarea>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- END CONTENT BLOCK -->

            </div>
          </main>
        </div>
      </div>

      <footer>
        <nav class="uk-navbar-container uk-container uk-container-expand" uk-navbar>
          <div class="uk-navbar-left">
            <div class="uk-navbar-item">
              <div>&copy; University of Arizona</div>
            </div>
          </div>
          <div class="uk-navbar-right">
            <div class="uk-navbar-item">
              <a class="uk-button uk-button-text">Privacy Policy</a>
            </div>
          </div>
        </nav>
      </footer>
    </div>
    <!-- END MAIN CONTENT -->

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="./assets/js/jquery.smartWizard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.min.js" integrity="sha256-atgxWORFPH5jcOKVvZzWhe90dUmt2G7TEpl8v9Nf/ec=" crossorigin="anonymous"></script>
    <!-- SCRIPT INJECTION -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js" integrity="sha256-ug4bHfqHFAj2B5MESRxbLd3R3wdVMQzug2KHZqFEmFI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.0.1/progressbar.min.js"></script>
    <script src="./assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.3.2/bootstrap-slider.js"></script>
    <script type="text/javascript">
    function scoreChange() {
      var score = 100 - 2*Math.abs(temperatureslider.getValue()-71) - 3*light.getValue() - 4*Math.abs(bed.getValue()-1) - 3*noise.getValue();
      document.getElementById("scoreVal").textContent = score;
    };
    var temperatureslider = new Slider('#temperature', {
                          	formatter: function(value) {
                          		return value + '°F';
                          	}
                          });

    temperatureslider.on("slide", function(sliderValue) {
    	document.getElementById("temperatureSliderVal").textContent = sliderValue;
      $('#temperatureSliderVal').css('color', 'rgb('+12.75*(sliderValue-60)+','+64+','+192+')')
      scoreChange();
    });


    var RGBChange = function() {
      document.getElementById('lightarea').src='./images/fourthGrade/light'+light.getValue()+'.png';
    	// $('#lightarea').css('background', 'rgb('+ 51*light.getValue() +',' + 51*light.getValue() +','+0+')');
      // $('#lightarea').css('background', 'rgb('+'255,255,'+(5-light.getValue())*51+')');
      scoreChange();
    };
    var light = $('#light').slider()
    		.on('slide', RGBChange)
    		.data('slider');


    var bedOptions = ["Too Soft Bed", "Supportive Bed", "Too Firm Bed"];
    var bed = new Slider('#bed', {
                  formatter: function(value) {
                          		return bedOptions[value];
                          	}
                          });
    bed.on("slide", function(sliderValue) {
      if (bed.getValue()==0) {
        document.getElementById('bedOption').src='./images/fourthGrade/softbed.png';
      }else if (bed.getValue()==1) {
        document.getElementById('bedOption').src='./images/fourthGrade/confotbed.png';
      }else if (bed.getValue()==2) {
        document.getElementById('bedOption').src='./images/fourthGrade/firmbed.png';
      }
      scoreChange();
    });

    var noiseOptions = ["No Noise", "Low Noise", "Medium Noise","High Noise"];
    var noise = new Slider('#noise', {
                  formatter: function(value) {
                          		return noiseOptions[value];
                          	}
                          });
    noise.on("slide", function(sliderValue) {
      document.getElementById('noiseOption').src='./images/fourthGrade/noise'+noise.getValue()+'.png';
      scoreChange();
    });



    $(function() {

      var initialScore = 0;

      var bar = new ProgressBar.Line(progressContainer, {
        strokeWidth: 4,
        easing: 'easeInOut',
        trailWidth: 1,
        svgStyle: {width: '100%', height: '100%'},
        step: (state, bar) => {
         var value = bar.value();
         if (value >= 0) {
              bar.path.setAttribute('stroke', '#ff0000');
          }
          if (value >= 0.40) {
              bar.path.setAttribute('stroke', '#ff9900');
          }
          if (value >= 0.60) {
              bar.path.setAttribute('stroke', '#33cc33');
          }

        }
      });

      //console.log("barone");
      //console.log(bar);

      var drake = dragula([document.querySelector('#temperature'), document.querySelector('#light'), document.querySelector('#main-drag-container'), document.querySelector('#bed'), document.querySelector('#noise'), document.querySelector('#other')], {
        accepts: function (el, target, source, sibling) {
          if (target.id === "main-drag-container"){
            return true;
          }
          else if ($(el).attr('data-type') === target.id){
            return true
          }
          else {
            return false;
          }
        },
        invalid: function (el, handle) {
          if (el.tagName === "H1" | "HR"){
            return true;
          }
        },
      });

     drake.on('drop', function(el, target, source, sibling){

         var type = $(el).attr('data-type');
         var existing = $('#main-drag-container').children().map(function(){ return $(this).attr('data-type')});

         function countElement(item,array) {
           var count = 0;
           $.each(array, function(i,v) { if (v === item) count++; });
           return count;
         }

         var itemCount = countElement(type,existing);
           if (type === "other"){
             return true;
           }
           else if (itemCount > 1){
             drake.cancel(true);
           }
           else {
             return true;
           }

     });

     drake.on('drag',function(el,source){
         var h = $(window).height();
         $(document).mousemove(function(e) {
             var mousePosition = e.pageY - $(window).scrollTop();
             var topRegion = 220;
             var bottomRegion = 220;
             if(e.which == 1 && (mousePosition > bottomRegion || mousePosition < topRegion)){    // e.wich = 1 => click down !
                 var distance = e.clientY - h / 3;
                 distance = distance * 0.01; // <- velocity
                 $(document).scrollTop( distance + $(document).scrollTop()) ;
             }else{
                 $(document).unbind('mousemove');
             }
         });
     });

   $('#smartwizard').smartWizard({
     theme: 'none',
     toolbarSettings: {
       showFinishButton: true,
     },
   });

   $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
     // Enable finish button only on last step
     if(stepNumber == 0) {
       $('.uk-button-previous').addClass('uk-hidden');
     }
     else if(stepNumber == 2){
         $('.uk-button-finish').removeClass('uk-hidden');
         $('.uk-button-next').addClass('uk-hidden');
     }
     else{
       $('.uk-button-previous').removeClass('uk-hidden');
       $('.uk-button-finish').addClass('uk-hidden');
       $('.uk-button-next').removeClass('uk-hidden');
       //
       $('.uk-button-next').addClass('uk-hidden');
     }
   });

   $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
     var alert = '<strong>Please make a selection for:</strong>&nbsp;';
     var doReturn = true;

       if(stepNumber == 1 && stepDirection == 'forward'){

         var data = $('#main-drag-container').children();
         var dataArray = [];

         $.each(data, function(index, element){
           dataArray.push(element.dataset.type);
         })

         if (!dataArray.includes('temperature')){
           alert += '<br>Room Temperature';
           doReturn = false;
         }
         if (!dataArray.includes('light')){
           alert += '<br>Light Amount';
           doReturn = false;
         }
         if (!dataArray.includes('bed')){
           alert += '<br>Bed Option';
           doReturn = false;
         }
         if (!dataArray.includes('noise')){
           alert += '<br>Ambient Noise';
           doReturn = false;
         }

         if(!doReturn){
           swal(
             'Whoops!',
             alert,
             'warning'
           );
           return false;
         }

         var elements = 0;

         $.each(data, function(index, element){
           var type = element.dataset.type;
           var value = element.dataset.value;
           var score = parseInt(element.dataset.score);
           switch(type){
             case 'temperature':
                $('#temp-selection').html(value + ' Degrees');
                $('#tempSelectForm').val(value);
                initialScore += score;
                elements += 1;
                break;
              case 'light':
                $('#light-selection').html(value + ' light');
                $('#lightSelectForm').val(value);
                initialScore += score;
                elements += 1;
                break;
              case 'bed':
                $('#bed-selection').html(value + ' Bed');
                $('#bedSelectForm').val(value);
                initialScore += score;
                elements += 1;
                break;
              case 'noise':
                $('#noise-selection').html(value);
                $('#noiseSelectForm').val(value);
                initialScore += score;
                elements += 1;
                break;
              case 'other':
                $('#other-selection').append(value + '<br>');
                $("#otherSelectForm").val(function() {
                  return this.value + value + ';';
                });
                initialScore += score;
                elements += 1;
                break;
           }
         });
         if(!doReturn){
           swal(
             'Whoops!',
             alert,
             'warning'
           );
           return false;
         }
         else {
           initialScore = initialScore/elements;
           //console.log("bartwo");
           //console.log(bar);
           bar.set(initialScore);
           var scoreText = Math.round((initialScore*100)) + '%';
           bar.setText(scoreText);
           return true;

         }
       }
   });

   $(".uk-button-finish").on('click', function(e){
     e.preventDefault();

     var form = $('#responseForm');

     $.ajax({
       type: "POST",
       url: "roomEnvironmentDone",
       data: form.serialize(),
       success: function( response ) {
        window.location.href = 'sleep-lesson';
      },
     });
   })


    });

    </script>
    <!-- END SCRIPTS -->
  </body>
</html>
