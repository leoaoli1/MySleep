<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
require_once('utilities.php');
include 'connectdb.php';
session_start();

$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$userDisplayName = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
if($userId==""){
    header("Location: login");
    exit;
}
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

$classGrade = $_SESSION['classGrade'];
$classId = $_SESSION['classId'];
$className = getClassName($classId);
if(($userType=='student')&&($classId == null)){
    $message = "Cannot find you class, Please contact your teacher!";
    echo "<script type='text/javascript'>alert('$message'); window.location.href = 'main-page';</script>";
}

$currentGrade = getGrade($userId);
$result = mysql_query("SELECT * FROM class_info_table WHERE classId='$classId'");
$row = mysql_fetch_array($result);

$hasConfig = False;
if ($config0 = getActivityConfigWithLesson(0)) {
  $hasConfig = True;
  $titleArray = explode("&z&", $config0['activity_title']);
  $lessonsRecord = $config0['config_id'];
}

$result2 = mysql_query("SELECT resultRow FROM dependCardGame WHERE contributors LIKE '%$userId%' AND winner IS NULL ORDER BY resultRow ASC LIMIT 1");
$resultRow = mysql_fetch_array($result2);
$resultRow = $resultRow['resultRow'];

?>
    <html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php require 'partials/header.php' ?>
            <title>MySleep // Select Lesson</title>
            <style>
            .banner {}

            .banner p {
              text-align: left;
              color: #aaa;
              margin-top: -10px;
              display: block;
             }
            .banner img {
              float: left;
                margin: 5px;
             }
             .banner span {
              padding-top: 50px;
              font-size: 17px;
              vertical-align:top;
             }
              .banner .ban2 span {
              padding-top: 50px;
              font-size: 17px;
              vertical-align:top;
             }
                .btn-rounded{
                    border-radius: 17px;
                }
                .form-control, .form-group .form-control {
                  border-radius: 20px;
                }
                .panel.panel-warning > .panel-heading {
                    background-color: #fff;
                }
                .card {
                    background: #fafafa;
                }

                  .draggable-list {
                  	background-color: #FAFAFA;
                  	list-style: none;
                  	margin: 0;
                  	min-height: 40px;
                  	padding: 0px;
                  }
                  .draggable-item {
                  	background-color: transparent;
                  	cursor: move;
                  	display: block;
                  	font-weight: bold;
                  	color:#CC0033;
                  	padding-bottom:  0px;
                    padding-top:  0px;
                  	margin: 0px;
                  }

            </style>
            <?php include 'partials/scripts.php' ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
            <div class="wrapper">
                <div class="main main-raised">
                    <div class="container">
                      <?php if ($config){
	                      require_once('partials/nav-links.php');
	                      navigationLink($config,$userType);
	                    } ?>
                              <div class="row" id="start_page">
                                  <div class="col-md-offset-1 col-md-10">
                                    <div style="width:100%; padding:0 0px;">
                                      <div class="banner">
                                        <img src="images/fifthgrade/itdepends.png" style="width:40%;">
                                        <span style="">Scientific investigations begin with a testable question and a hypothesis about the relationship between 2 variables.  The investigator tests the relationship by changing one variable to see if it causes an effect on the other.  The variable that changes is called the independent variable.   The effect variable is called the dependent variable.</span>
                                        <br><br>
                                        <span class="ban2">In the Body, Game and Grade changer experiments, the independent variable is hours of sleep.  We found that more sleep had a positive effect on free throw shooting, reaction time, glucose level, heart rate and the chance of getting a cold.</span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-offset-4 col-md-4">
                                    <div style="width:100%; padding:0 0px;">
                                      <button class="btn btn-gradpr btn-roundThin btn-large btn-block" onclick="nextPage()"><b>Next</b></button>
                                    </div>
                                  </div>
                              </div>
                              <div class="row" id="direction_page">
                                  <div class="col-md-offset-1 col-md-10">
                                    <div style="width:100%; padding:0 0px;">
                                      <h4>
                                        In the game “It Depends,” you are given four independent (cause) variables from 5th grade science fair experiments.  You must try to pair them with the dependent (effect) variables that are most likely be affected by them.   A good match would make a good experiment.   For example:  Independent variable: brand of paper towels and dependent variable: amount of liquid absorbed.
                                      </h4>
                                    </div>
                                  </div>
                                  <div class="col-md-offset-4 col-md-4">
                                    <div style="width:100%; padding:0 0px;">
                                      <button class="btn btn-gradpr btn-roundThin btn-large btn-block" onclick="start()"><b>Join Game</b></button>
                                    </div>
                                  </div>
                              </div>
                                <div class="form-group">
                                    <div class="panel-group" id="game_page">
                                      <div class="col-md-offset-1 col-md-10">
                                        <div style="width:100%; padding:0 0px;">
                                          <h4>
                                            <b>Directions:</b>
                                            <br>
                                            You will be playing with up to 3 other students.  The computer will tell you when it is your turn.
                                            <br><br>
                                            You start the game with 4 independent variables, which are displayed at the bottom of your screen.   The computer draws and displays a dependent variable card.  In every turn you must play a card.  There are 3 ways to make a play:
                                            <br>
                                             &nbsp &nbsp  1.  Move the new “Dependent Variable” card to match one of your independent variables.
                                            <br>
                                             &nbsp &nbsp  2.	Move the new “Dependent Variable” card to the discard pile.
                                            <br>
                                             &nbsp &nbsp  3.	Move a “Dependent Variable” card from another player’s matches to make a better match with one of your independent variables.
                                            <br><br>
                                            The turn ends when a card is moved. Click enter for the next player to go.
                                            <br><br>
                                            There is more than one possible match for the dependent variables.  When the best match is made, the pair of cards turns green and is locked.  The first player with 4 correctly matched cards wins.
                                          </h4>
                                        </div>
                                      </div>
                                      <!-- iv cards -->
                                      <div style="display:none">
                                        <?php $ivContent = [
                                          'Number of jumping jacks',
                                          'Type of surface',
                                          'Size of a wind turbine blade',
                                          'Type of liquid',
                                          'Time spent studying',
                                          'Exposure to light',
                                          'The design of a paper airplane',
                                          'Type of cleaning solution',
                                          'Cook time in microwave',
                                          'Number of caffeinated drinks',
                                          'Brand of battery',
                                          'Size of a magnet',
                                          'Brand/type of sponge',
                                          'Cookie sheet material (aluminum, non-stick)',
                                          'Color of M&M candy',
                                          'Temperature of water'
                                        ];
                                        foreach ($ivContent as $key => $value): ?>
                                        <div class="col-md-3" id="<?php echo "iv".($key+1); ?>" style="padding-left: 5px;padding-right: 5px;">
                                          <div class="card" style="background-color: #FBECD7;">
                                            <div class="card-block">
                                                <h4 style="margin-left: .2em;margin-right: .2em;"><small><B><?php echo $value; ?></B></small></h4>
                                            </div>
                                          </div>
                                          <div class="draggable-list" id="<?php echo "iv".($key+1)."list"; ?>">
                                          </div>
                                        </div>
                                        <?php endforeach; ?>
                                      </div>
                                      <!-- dv cards -->
                                      <div style="display:none">
                                        <?php $dvContent = [
                                          'Heart rate',
                                          'Distance a ball rolls',
                                          'Amount of energy produced',
                                          'Time to freeze',
                                          'Test score',
                                          'Plant growth',
                                          'Length of flight',
                                          'Shininess of a penny',
                                          'The ratio of unpopped to popped kernels',
                                          'Reaction time',
                                          'Brightness of a flashlight',
                                          'Number of paperclips held',
                                          'Amount of water that can be absorbed',
                                          'Risk of burning food',
                                          'Time it takes for chocolate to melt',
                                          'Time it takes for ice cubes to melt'
                                        ];
                                        foreach ($dvContent as $key => $value): ?>
                                        <div class="draggable-item" id="<?php echo "dv".($key+1); ?>">
                                          <input type='text' name='activityRecord[]' value='".$row['config_id']."' style='display: none;'>
                                          <div class="card" style="width: 100%;background-color: #D4ECE8;">
                                            <div class="card-block">
                                                <h4 style="margin-left: .2em;margin-right: .2em;"><small><B><?php echo $value; ?></B></small></h4>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach; ?>
                                      </div>


                                      <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                          <div class="btn-gradgray btn-roundExThin"><h4><b>Player A</b></h4>
                                            <div id="playeraiv">
                                            </div>
                                          </div>

                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="btn-gradgray btn-roundExThin"><h4><b>Player B</b></h4>
                                          </div>
                                          <div id="playerbiv">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="btn-gradgray btn-roundExThin"><h4><b>Player C</b></h4>
                                          </div>
                                          <div id="playerciv">
                                          </div>
                                        </div>
                                      </div>


                                      <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-4 col-md-offset-2">
                                          <div class="btn-gradgray btn-roundExThin"><h4><b>New Dependent Card</b></h4>
                                          </div>
                                          <div class="draggable-list" id="new_dv">
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="btn-gradgray btn-roundExThin"><h4><b>Discarded Dependent Card</b></h4>
                                          </div>
                                          <div class="draggable-list" id="used_dv">
                                          </div>
                                        </div>
                                      </div>
                                      <!-- my cards -->
                                      <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-12 col-sm-12">
                                          <div class="row">
                                            <div class="col-md-offset-1 col-md-10">
                                              <div style="width:100%; padding:0 0px;">
                                                <div class="btn-gradgray btn-roundExThin"><h4><b>My Cards</b></h4>
                                                  <div id='mycards'>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                        </div>
                                      </div>




                                </div>

                                <div class="row">
                              			<div class="col-xs-offset-4 col-xs-4 col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4">
                                      <h3 align="center" style="width:100%; padding:0 0px;" id="statusBoard">
                                      </h3>
                                      <div style="width:100%; padding:0 0px;">
                                           <button class="btn btn-gradbb btn-roundThin btn-large btn-block" onclick="next()" id="next"><b>Enter</b></button>
                                      </div>
                                      <div style="width:100%; padding:0 0px;">
                                           <button class="btn btn-gradpr btn-roundThin btn-large btn-block" onclick="skip()" id="skip"><b>Discard</b></button>
                                      </div>
                              			</div>
                        		    </div>
                            </div>
                        </form>
                  </div>
             </div>
        <?php include 'partials/footer.php' ?>
        </div>

		<?php mysql_close($con); ?>
    </body>

    <script>
    var resultRow = <?php echo $resultRow; ?>;
      console.log(resultRow);
    var waiting = false;
    var timer;
    var myCards;
    var playerACards;
    var playerBCards;
    var playerCCards;
    var myRound = -1;
    var dictionary = {
      'iv1': ['dv1'],
      'iv2': ['dv2'],
      'iv3': ['dv3'],
      'iv4': ['dv4'],
      'iv5': ['dv5'],
      'iv6': ['dv6'],
      'iv7': ['dv7'],
      'iv8': ['dv8'],
      'iv9': ['dv9'],
      'iv10': ['dv10'],
      'iv11': ['dv11'],
      'iv12': ['dv12'],
      'iv13': ['dv13'],
      'iv14': ['dv14'],
      'iv15': ['dv15'],
      'iv16': ['dv16'],
    };
    $('#game_page').hide();
    $('#direction_page').hide();
    function nextPage(){
      $('#start_page').hide();
      $('#direction_page').show();
    }
    function start(){
      $('#direction_page').hide();
      $('#game_page').show();
      document.getElementById('statusBoard').innerHTML = "Loading";
      enableWait();
    }

    function enableWait(){
      waiting = !waiting;
      if (waiting) {
        timer = setInterval(function(){
          if (!waiting) {
            clearInterval(timer)
          }else {
            console.log(waiting);
            $.ajax({
              type: "post",
              url: "itdepends-process",
              dataType: 'json',
              data: {session:'waiting',resultRow:resultRow},
              success: function (response) {
                if (response.submit) {
                  waiting = false;
                  if (response.myID == response.winner) {
                    swal('Congratulations!','You win the game!','success')
                    .then((value) => {
                      location.href = "lesson-menu?<?php echo $query; ?>";
                    });
                  } else {
                    swal('Sorry!',response.winnerName+' has correctly matched all cards!','error')
                    .then((value) => {
                      location.href = "lesson-menu?<?php echo $query; ?>";
                    });
                  }
                }
                myRound = response.myRound;
                if (myRound == response.round) {
                  waiting = false;
                  $('#skip').show();
                  $('#next').show();
                  document.getElementById('statusBoard').innerHTML = "It is your turn!";
                } else {
                  $('#skip').hide();
                  $('#next').hide();
                  document.getElementById('statusBoard').innerHTML = "Player " + response.playersName[parseInt(response.round, 10)] + " is playing.";
                }
                console.log(response);

                var newDVCards = response.newDV;
                newDVCardDealer(newDVCards);

                var usedDVCards = response.usedDV;
                usedDVPoolSetup(usedDVCards);

                myCards = response.myIVCard;
                var myPairs = response.myPairs;
                playersSetup('self',myCards, myPairs);
                playerACards = response.playerAIVCard;
                playersSetup('a',playerACards,response.playerAPairs);
                playerBCards = response.playerBIVCard;
                playersSetup('b',playerBCards,response.playerBPairs);
                playerCCards = response.playerCIVCard;
                playersSetup('c',playerCCards,response.playerCPairs);
                console.log(response.playerAIVCard);
              }
            });
          }
        }, 5000);
      } else {
        clearInterval(timer)
      }
    }
    function next(){
      var myPairs = [];
      var myDVs = [];
      for (var card in myCards) {
        var cardID = myCards[card];
        var itemOrder = $('#'+cardID+'list').sortable("toArray");
        if (itemOrder.length) {
          myPairs.push(cardID+'++'+itemOrder[0])
          myDVs.push(itemOrder[0])
        }
      }
      var correctPairs = 0;
      for (var key in myPairs) {
        var pair = myPairs[key].split("++");
        var pairIV = pair[0];
        var pairDV = pair[1];
        var correctConnect = dictionary[pairIV].includes(pairDV);
        if (correctConnect) {
          correctPairs += 1;
        }
      }
      console.log('correct: '+correctPairs);
      var winner = 0;
      if (correctPairs==4) {
        winner = 1;
      }
      // winner = 1;
      console.log('I win: '+winner);
      var myPairsString = myPairs.join(',')
      console.log('my pairs: '+myPairsString);
      $.ajax({
        type: "post",
        url: "itdepends-process",
        dataType: 'json',
        data: {session:'playing',resultRow:resultRow,myRound:myRound,myPairs:myPairsString,myDVs:myDVs,winner:winner},
        success: function (response) {
          console.log(response);
          $('#skip').hide();
          $('#next').hide();
          document.getElementById('statusBoard').innerHTML = "System processing.";
          enableWait();
        }
      });
    }
    function skip(){
      $.ajax({
        type: "post",
        url: "itdepends-process",
        dataType: 'json',
        data: {session:'skip',resultRow:resultRow},
        success: function (response) {
          console.log(response);
          $('#skip').hide();
          $('#next').hide();
          document.getElementById('statusBoard').innerHTML = "System processing.";
          enableWait();
        }
      });
    }
    function usedDVPoolSetup(usedCards){
      for (var card in usedCards) {
        var cardID = usedCards[card];
        $('#'+cardID).detach().appendTo("#used_dv");
      }
    }
    function newDVCardDealer(newCards){
      if (newCards.length){
        // get and place the the top card to new dv pool
        var topCard = newCards[0];
        $('#'+newCards).detach().appendTo("#new_dv");
      }
    }
    function playersSetup(player,ivCards,pairs) {
      var playerContainerID;
      var pairColor = "#FBECD7";
      var singleColor = "#F3EFE8";
      var singleText = 0;
      if (player == 'self') {
        playerContainerID = '#mycards';
        singleColor = pairColor;
        singleText = 1;
      }else {
        playerContainerID = "#player"+player+"iv";
      }
      for (var card in ivCards) {
        var cardID = ivCards[card];
        $('#'+cardID+'> .card').css("background-color",singleColor);
        $('#'+cardID+'> .card > .card-block').css("opacity",singleText);
        $('#'+cardID).detach().appendTo(playerContainerID);

      }
      for (var key in pairs) {
        var pair = pairs[key].split("++");
        var pairIV = pair[0];
        var pairDV = pair[1];
        $('#'+pairIV+'> .card').css("background-color",pairColor);
        $('#'+pairIV+'> .card > .card-block').css("opacity",1);
        $('#'+pairDV).detach().appendTo("#"+pairIV+"list");

        var correctConnect = dictionary[pairIV].includes(pairDV);
        if (correctConnect) {
          $("#"+pairIV+"list").sortable( "disable" );
          $('#'+pairIV+'> .card').css("background-color","#BAE58C");
        }
      }
    }
    $(document).ready(function () {
      $('#skip').hide();
      $('#next').hide();
    	$('.container .draggable-list').sortable({
    	connectWith: '.container .draggable-list',
    	});
    });
    </script>
</html>
