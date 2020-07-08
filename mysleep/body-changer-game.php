<!DOCTYPE html>
<html lang="en">
    <style>
     body {
	 margin: 10px;
	 font-family: "Georgia", serif;
	 font-size:15px;
	 line-height: 1.2em;
	 color: #C1090C;
     }
     
     /* Give headings their own font */
     
     h1, h2, h3, h4 {
	 font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
     }
     
     /* Main content area */
     
     #content {
	 margin: 10px 0px;
	 text-align: center;
	 -moz-user-select: none;
	 -webkit-user-select: none;
	 user-select: none;
     }
     
     /* Header/footer boxes */
     
     .wideBox {
	 clear: both;
	 text-align: center;
	 margin: 0px;
	 padding: 10px;
	 background: #ebedf2;
	 border: 1px solid #333;
     }
     
     .wideBox h1 {
	 font-weight: bold;
	 margin: 10px;
	 color: #666;
	 font-size: 1.5em;
     }
     
     /* Slots for final card positions */
     

     #cardSlotsT {
	 margin: 0px auto 0 auto;
	 background: orange;
     }

     #cardSlotsF {
	 margin: 0px auto 0 auto;
	 background: #49E373;
     }
     /* The initial pile of unsorted cards */
     
     #cardPile {
	 margin: 0 auto;
	 background: red; /*#ffd;*/
     }
     
     #cardPile {
	 width: 880px;
	 height: 120px;
	 padding: 20px;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
     }

     #cardSlot {
	 margin: 30px auto;
	 background: *#ffd;
	 display:inline-block;
	 border:hidden;
     }
     
     #cardSlot {
	 width: 1200px;
	 height: 160px;
	 padding: 20px;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
     }

     #cardSlotsT{
	 height: 120px;
	 padding: 20px;
	 float:left;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
     }

     #cardSlotsF {
	 height: 120px;
	 padding: 20px;
	 float:right;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
	 box-shadow: 0 0 .3em rgba(0, 0, 0, .8);
     }
     /* Individual cards and slots */
     
     #cardPile div {
	 float: left;
	 width: 75px;
	 height: 100px;
	 padding: 10px;
	 padding-top: 20px;
	 padding-bottom: 0;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 margin: 0 0 0 10px;
	 background: orange; /*#fff;*/
     }
     

     #cardSlotsT div {
	 float: left;
	 width: 75px;
	 height: 90px;
	 padding: 10px;
	 padding-top: 40px;
	 padding-bottom: 0;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 margin: 0 0 0 10px;
	 background: orange; /*#fff;*/
     }

     #cardSlotsF div {
	 float: left;
	 width: 75px;
	 height: 75px;
	 padding: 10px;
	 padding-top: 40px;
	 padding-bottom: 0;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 margin: 0 0 0 10px;
	 background: #49E373; /*#fff;*/
     }

     #cardPile div:first-child {
	 margin-left: 0;
     }


     #cardSlotsT div:first-child {
	 margin-left: 0;
     } 

     #cardSlotsT div.hovered {
	 background: #aaa;
     }
     
     #cardSlotsT div {
	 border-style: hidden;
     }

     #cardSlotsF div:first-child {
	 margin-left: 0;
     }
     
     #cardSlotsF div.hovered {
	 background: #aaa;
     }
     
     #cardSlotsF div {
	 border-style: hidden;
     }

     #cardPile div {
	 background: green; /*#666;*/
	 color: #fff;
	 font-size: 12px;
	 text-shadow: 0 0 3px #000;
     }
     
     #cardPile div.ui-draggable-dragging {
	 -moz-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
	 box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
     }
     
     /* Individually coloured cards */
     
     #card1.correct { background: red; }
     #card2.correct { background: brown; }
     #card3.correct { background: orange; }
     #card4.correct { background: yellow; }
     #card5.correct { background: green; }
     #card6.correct { background: cyan; }
     #card7.correct { background: blue; }
     #card8.correct { background: indigo; }
     /*#card9.correct { background: purple; }
	#card10.correct { background: violet; }
      */
     
     /* "You did it!" message */
     #successMessage {
	 position: absolute;
	 left: 580px;
	 top: 250px;
	 width: 0;
	 height: 0;
	 z-index: 100;
	 background: #dfd;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 padding: 20px;
     }

     #resultMessage {
	 position: absolute;
	 left: 580px;
	 top: 250px;
	 width: 0;
	 height: 0;
	 z-index: 100;
	 background: #dfd;
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 padding: 20px;
     }
     
     #oneMessage {
	 position: absolute;
	 left: 280px;
	 top: 250px;
	 width: 0;
	 height: 0;
	 z-index: 100;
	 background: #3BC590; /*#dfd;*/
	 border: 2px solid #333;
	 -moz-border-radius: 10px;
	 -webkit-border-radius: 10px;
	 border-radius: 10px;
	 -moz-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 -webkit-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
	 padding: 20px;
     }

     #progress {
	 width: 100%;
	 background-color: lightgrey;
     }
     #bar {
	 width: 1%;
	 height: 30px;
	 background-color: green;
	 text-align: center; 
	 line-height: 30px;
	 color: white; 
     }
    </style>
    <head>
	<script type="text/javascript" src="assets/js/jquery-1.5.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	
	<title>A Drag-and-Drop Cards Game</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<h1 style="font-family:Comic Sans MS; color:red;font-size:200%;"> Sleep as a Body Changer: Fact or Fiction</h1>
	<div id="progress">
	    <div id="bar"></div>
	</div>
	<h3>Timer: &nbsp <span id="timer">0</span>s</h3>
	<button onclick="init()" style="font-size:200%;" id="control"><b>Start</b></button> 
	<h2 style="font-family:Comic Sans MS; color:green;font-size:150%;"> Instructions: 
	</h2>
	<p style="font-family:Comic Sans MS; color:green;font-size:110%;">The following are 8 statements about possible effects of insufficient sleep. Drag each correct statement into the TRUE box, and each incorrect statement into the FALSE box. <b style="font-size:150%;">Click the "Start" button to start the game.</b></p>
    </head>
    <script type="text/javascript">
     
     // JavaScript will go here
     var correctCards = 0;
     var totalTry = 0;
     var bar = document.getElementById("bar"); //progress bar
     var timeValue = 0; //init timer
     var timeoutHandle;
     var timerInterval;
     var resultMessageContent;
     var tcount = 1;
     var fcount = 1;
     var timer; //button timer
     $(setup);
     $(toggleColors);
     
     function toggleColors(){
	 var miliseconds = 500;
	 var colors =  ['#F00', '#FFF', '#0F0' ];
	 var counter = 0
	 var change = function(){
             document.getElementById("control").style.background = colors[ counter%colors.length ];// Change the color
             counter ++;
             if( colors.length > 1 )
		 timer = setTimeout(change, miliseconds); // Call the changer
	 };

	 change();
     }
     
     //set timer
     function changeValue() {
	 document.getElementById("timer").innerHTML = ++timeValue;
     }

     function init(){
	 var control = document.getElementById("control");
	 control.innerText="Play Again";
	 bar.style.width = '1%';
	 bar.innerHTML = '';
	 timeValue = 0;
	 clearTimeout(timer);
	 document.getElementById("control").style.background = '#FFF';
	 clearTimeout(timerInterval);
	 timerInterval = setInterval(changeValue, 1000); 
	 clearTimeout(timeoutHandle);
	 // Hide the success message
	 $('#successMessage').hide();
	 /*$('#successMessage').css( {
	    left: '580px',
	    top: '250px',
	    width: 0,
	    height: 0
	    } );*/

	 $('#resultMessage').hide();
	 /*$('#resultMessage').css( {
	    left: '580px',
	    top: '250px',
	    width: 0,
	    height: 0
	    } );*/
	 
	 // Reset the game
	 correctCards = 0;
	 $('#cardPile').html( '' );
	 $('#cardSlotsT').html( '' );
	 $('#cardSlotsF').html( '' );
	 setup();
	 $('.card').draggable( 'enable' );
     }
     
     function setup() {
	 
	 $('#successMessage').hide();
	 /*$('#successMessage').css( {
	    left: '580px',
	    top: '250px',
	    width: 0,
	    height: 0
	    } );*/

	 $('#resultMessage').hide();
	 /*$('#resultMessage').css( {
	    left: '580px',
	    top: '250px',
	    width: 0,
	    height: 0
	    } );*/
	 // Create the pile of shuffled cards
	 
	 
	 var texts = [ 'Lack of sleep can increase your blood sugar.', 'Lack of sleep can increase your heart rate.', 'Lack of sleep increases your risk of catching a cold.', 'Lack of sleep makes it easier to gain weight.','Lack of sleep increases your risk of getting a skin rash.', 'Lack of sleep makes you a nicer person.', 'Lack of sleep increases your ability to fight infections.', 'Lack of sleep improves your ability to learn.'];
	 texts.sort( function() { return Math.random() - .5 } );
	 

	 $('<div class="card">' + 'Lack of sleep can increase your blood sugar.'  + '</div>').data("zfactor", {first:'true',last: 1 }).attr( 'id', 'card'+'Lack of sleep can increase your blood sugar.' ).appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 

	 $('<div class="card">' + 'Lack of sleep can increase your heart rate.'  + '</div>').data( "zfactor", {first:'true',last: 2} ).attr( 'id', 'card'+'Lack of sleep can increase your heart rate.' ).appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 
	 $('<div class="card">' +'Lack of sleep increases your risk of catching a cold.'   + '</div>').data( "zfactor", {first:'true',last: 3} ).attr( 'id', 'card'+'Lack of sleep increases your risk of catching a cold.' ).appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 
	 $('<div class="card">' + 'Lack of sleep increases your risk of getting a skin rash.'  + '</div>').data( "zfactor", {first:'false', last: 4} ).attr( 'id', 'card'+'Lack of sleep increases your risk of getting a skin rash.' ).appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 
	 $('<div class="card">' +'Lack of sleep makes you a nicer person.'
	 + '</div>').data( "zfactor", {first:'false', last: 5} ).attr( 'id', 'card'+'Lack of sleep makes you a nicer person.').appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 
	 $('<div class="card">' + 'Lack of sleep makes it easier to gain weight.'  + '</div>').data( "zfactor", {first:'true', last: 6} ).attr( 'id', 'card'+'Lack of sleep makes it easier to gain weight.' ).appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 $('<div class="card">' +'Lack of sleep increases your ability to fight infections.'+ '</div>').data( "zfactor", {first:'false', last: 7} ).attr( 'id', 'card'+'Lack of sleep increases your ability to fight infections.').appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );
	 
	 $('<div class="card">' +'Lack of sleep improves your ability to learn.'+ '</div>').data( "zfactor", {first:'false', last: 8} ).attr( 'id', 'card'+'Lack of sleep improves your ability to learn.').appendTo( '#cardPile' ).draggable( {
	     containment: '#content',
	     stack: '#cardPile div',
	     cursor: 'move',
	     revert: true
	 } );

	 $('.card').draggable( 'disable' );
	 // Create the card slots
	 
	 $('<div>' + 'True' + '</div>').data( "zfactor", {first:'true', last: tcount} ).appendTo( '#cardSlotsT' ).droppable( {
	     accept: '#cardPile div',
	     hoverClass: 'hovered',
	     drop: handleCardDrop
	 } );

	 tcount += 1;
	 $('<div>' + 'False' + '</div>').data( "zfactor", {first:'false', last: fcount} ).appendTo( '#cardSlotsF' ).droppable( {
	     accept: '#cardPile div',
	     hoverClass: 'hovered',
	     drop: handleCardDrop
	 } );
	 fcount += 1;
     }

     
     // set progress bar
     function move(num) {
	 switch(num){
	     case 1:
		 bar.style.width = 12 + '%';
		 break;
	     case 2:
		 bar.style.width = 24 + '%';
		 break;
	     case 3:
		 bar.style.width = 36 + '%';
		 break;
	     case 4:
		 bar.style.width = 48 + '%';
		 break;
	     case 5:
		 bar.style.width = 60 + '%';
		 break;
	     case 6:
		 bar.style.width = 72 + '%';
		 break;
	     case 7:
		 bar.style.width = 84 + '%';
		 break;
	     case 8:
		 bar.style.width = 100 + '%';
		 bar.innerHTML = 'Done!';
		 break;
	 }
     }

     function handleCardDrop( event, ui ) {
	 var slotNumber = $(this).data( "zfactor" ).first;
	 var messageNumber = ui.draggable.data("zfactor").last;
	 var cardNumber = ui.draggable.data( "zfactor").first;
	 totalTry ++;
	 console.log(totalTry);
	 // If the card was dropped to the correct slot,
	 // change the card colour, position it directly
	 // on top of the slot, and prevent it being dragged
	 // again
	 
	 if ( slotNumber == cardNumber ) {
	     if($(this).data( "zfactor" ).first == 'true'){
		 $('<div>' + '' + '</div>').data( "zfactor", {first:'true', last: tcount} ).appendTo( '#cardSlotsT' ).droppable( {
		     accept: '#cardPile div',
		     hoverClass: 'hovered',
		     drop: handleCardDrop
		 } );
		 tcount += 1;
	     }else{
		 $('<div>' + '' + '</div>').data( "zfactor", {first:'false', last: fcount} ).prependTo( '#cardSlotsF' ).droppable( {
		     accept: '#cardPile div',
		     hoverClass: 'hovered',
		     drop: handleCardDrop
		 } );
		 fcount += 1;
	     }
	     ui.draggable.addClass( 'correct' );
	     ui.draggable.draggable( 'disable' );
	     $(this).droppable( 'disable' );
	     ui.draggable.position( { of: $(this), my: 'left top', at: 'left top' } );
	     ui.draggable.draggable( 'option', 'revert', false ); 
	     // If all the cards have been placed correctly then display a message
	     // and reset the cards for another go
	     
	     
	     switch (messageNumber) {
		 case 1:
		     $('#successMessage').show();
		     $('#successMessage').text("Correct! Insufficient sleep reduces insulin secretion from the pancreas leading to increases in blood sugar. It may increase the risk of diabetes.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 2: 
		     $('#successMessage').show();
		     $('#successMessage').text("Correct! An increase in heart rate can put more stress on your heart, and may lead to heart problems later in life.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 3:
		     $('#successMessage').show();
		     $('#successMessage').text("Correct! Lack of sleep makes it harder for you to fight off the cold virus.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 4:
		     $('#successMessage').show();
		     $('#successMessage').text("Good choice! There is no evidence that sleep and skin rashes are related.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 5:
		     $('#successMessage').show();
		     $('#successMessage').text("Good choice! Insufficient sleep has the opposite effect. It makes you more irritable and sad.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 6:
		     $('#successMessage').show();
		     $('#successMessage').text("Correct! Insufficient sleep increases hunger by changes in some of your hormones. You tend to eat more and especially foods with high carbohydrates and sugar.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 7:
		     $('#successMessage').show();
		     $('#successMessage').text("Good choice! Sleep actually improves your immune system. For example, getting a good night’s sleep before a vaccination increases production of antibodies.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
		 case 8:
		     $('#successMessage').show();
		     $('#successMessage').text("Good choice! Lack of sleep has the opposite effect. Sleep is necessary for good memory. That is why it is important to get a good night’s sleep before a test.");
		     $('#successMessage').animate( {
			 left: '380px',
			 top: '200px',
			 width: '400px',
			 height: '50px',
			 opacity: 1
		     } );
		     $('#successMessage').delay(6500).fadeOut([400]);
		     correctCards++;
		     move(correctCards);
		     break;
	     }
	     if(correctCards == 8){
		 resultMessageContent = "Total spend time: " + timeValue + "s<br>" + "Total attempts times: " + totalTry + "<br>";
		 if(timeValue<=180){
		     resultMessageContent += "Great! Your speed is faster than the average speed."
		 }else if(timeValue >180 && timeValue <= 360){
		     resultMessageContent += "Good! Your speed is same as the average speed."
		 }else if(timeValue > 360){
		     resultMessageContent += "Your speed is slower than the average speed."
		 }
		 clearTimeout(timerInterval);
		 timeoutHandle = setTimeout(showResult, 6550);
	     }
	 }
     }

     function showResult(){
	 $('#resultMessage').show();
	 $('#resultMessage').animate( {
	     left: '380px',
	     top: '200px',
	     width: '400px',
	     height: '50px',
	     opacity: 1
	 } );
	 $('#resultMessage').html(resultMessageContent);
	 $('#resultMessage').delay(10000).fadeOut([400]);  
     }
    </script>
    <script src="assets/js/body-changer-drag-drop-touch.js"></script>
    <body ng-app="app" ng-controller="appCtrl">
	
	<div id="content">
	    
	    <div id="cardPile" draggable="true"> </div>
	    <div id="cardSlot">
		<div id="cardSlotsT">  </div> 
		<div id="cardSlotsF">  </div>
	    </div>
	    <div id="successMessage">
		<h2> Correct!  </h2>
		<!-- <button onclick="init()">Play Again</button>-->
		
	    </div>
	    <div id="resultMessage">

	    </div>
	    <div>
		<h2><a href="body-changer-game-done">Next</a></h2>
		<div>
    </body>


</html>
