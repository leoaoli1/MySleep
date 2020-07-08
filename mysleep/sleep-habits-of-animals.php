<!DOCTYPE html>
<?PHP

require_once('utilities.php');
checkAuth();

$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];

?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php require 'partials/header.php' ?>
        <title>MySleep // Sleep Habits of Our Favorite Animals</title>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                    <?php
                    if ($config) {
                      require_once('partials/nav-links.php');
                      navigationLink($config,$userType);
                    }else {
                     ?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fourth-grade-lesson-menu?lesson=3'">Lesson Three</a></li>
				                        <li><a href="#" onclick="location.href='fourth-grade-lesson-activity-menu?lesson=3&activity=3'">Activity Three</a></li>
                                <li class="active">Sleep Habits of Our Favorite Animals</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                  			<div class="col-md-offset-2 col-md-8 col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10">
                  			    <div class="card card-carousel">
                  				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false" >
                  				    <div class="carousel slide" data-ride="carousel">
                  					<!-- Wrapper for slides -->
                  					<div class="carousel-inner">
                  					    <div class="item active">
                        						<div  style="min-width: 100%; height: 240px;">

                        						<div class="carousel-caption" style="top:0;margin-top: 1em;">
                                      <h5>Click here to begin a slide show to learn about the factors that affect the amount of sleep animals get.<h5>
                        						    <button id="slideshowStart" class="btn btn-primary btn-block" style="padding-top: 1.5em;padding-bottom: 1.5em;height: ;">Click here to begin</button>
                        						</div>
                                    </div>
                  					    </div>

                  					    <div class="item">
                        						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide1.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                        						<div class="col-md-offset-1 col-md-10">
                        						    <h5>Almost all animals have a consistent daily sleep pattern. Scientists have discovered that they adapt their sleep schedules based on several factors. Safety during rest is thought to be a factor in how long animals rest.  For example, burrowing animals tend to sleep more than those who are out in the open.  Tree tops and cavities, cactus and rocky dens also provide safety.
                                          </h5>
                        						</div>
                  					    </div>
                                <div class="item">
                        						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide2.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                        						<div class="col-md-offset-1 col-md-10">
                        						    <h5>Animals that live or used to live on open grasslands sleep less and sleep standing up.  Their sleep patterns are an adaptation to the need to be alert to danger from predators. Domestic animals or pets sleep more than those in the wild. Their total sleep comes from the sleep at night like their human owners, but also from one or more sleep periods (naps) during the day.</h5>
                        						</div>
                  					    </div>
                  					    <div class="item">
                  						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide3.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                  						<div class="col-md-offset-1 col-md-10">
                  						    <h5>Plant eaters, or herbivores tend to sleep less than meat eaters, or carnivores.  Animals that eat plants have to spend more time foraging and eating.  Herbivores have to eat great quantities of plant materials to get the nutrition they need and grind or chew them to break down the fibers.  An exception is the koala bear.  It’s food source, eucalyptus leaves, is so hard to digest that the koala sleeps most of the time to conserve energy for digestion. </h5>
                  						</div>
                  					    </div>
                  					    <div class="item">
                  						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide4.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                  						<div class="col-md-offset-1 col-md-10">
                  						    <h5>There are two reasons why animals, like lions, that are at the top-of-the-food-chain spend a lot of time sleeping during the day and night.  Their prey provides them with large, high protein meat meals, so they do not have to eat or hunt for food as often as the herbivores.   They can also take long naps without fear of attack.</h5>
                  						</div>
                  					    </div>

                  					    <div class="item">
                  						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide5.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                  						<div class="col-md-offset-1 col-md-10">
                  						    <h5>In general, smaller animals have higher rates of brain metabolism than larger animals. This allows them to perceive and respond to danger quickly. They need more rest to conserve energy for brain function. Many larger animals have slower reaction times.  More of their energy goes to maintaining their strength and size. Their brains are consuming less energy so they can sleep less.</h5>
                  						</div>
                  					    </div>

                  					    <div class="item">
                  						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide6.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                  						<div class="col-md-offset-1 col-md-10">
                  						    <h5>Most birds sleep when it is dark because they need light for all their other activities. They sleep more when nights are longer and less during summer months.  Because they cannot see well at night, they must find safe spots to roost. Many sleep with one eye open, which allows one side of their brains to sleep while the other remains alert.  Water fowl sleep on or in the water where they can detect vibrations from predators. The talons of perching birds close around a branch when the legs are bent and release only when the legs are straightened.  This allows the sleeping bird to hold tightly without expending any energy.</h5>
                  						</div>
                  					    </div>

                  					    <div class="item">
                      						<img class="col-md-offset-1 col-md-10" src="images/fourthGrade/slide7.jpg" alt="Awesome Image" id="carousalImg" style="width: 80%;">
                      						<div class="col-md-offset-1 col-md-10">
                      						    <h5>Some animals are nocturnal, which is when they sleep during the day and are active at night. Owls’ eyes are adapted to seeing in the dark and they hunt at night, so they sleep during the day to conserve energy. Bats’ sleep schedules allow them to hunt for food at night using echolocation (sound from their prey) rather than sight.</h5>
                                      <label>After you finish, wait for instructions from your teacher.</label>
                      						</div>
                  					    </div>
                  					</div>

                  				    </div>
                  				</div>
                  				<!-- End Carousel Card -->
                  				<button id="previous" class="btn btn-simple" style="display:none;float:left;"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Previous</button>
                          <!-- <button id="audio" class="btn btn-simple" style="display:none;"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Click to play audio</button> -->
                  				<!-- <button id="replay" class="btn btn-simple" style="display:none;"><i class="fa fa-undo" aria-hidden="true"></i></button> -->
                  				<button id="pause" class="btn btn-simple" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Click to pause audio&nbsp;&nbsp;&nbsp; <i class="fa fa-pause" aria-hidden="true"></i></button>
                  				<button id="play" class="btn btn-simple" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Click to play audio&nbsp;&nbsp;&nbsp; <i class="fa fa-play" aria-hidden="true"></i></button>
                  				<button id="next" class="btn btn-simple" style="display:none;float:right;">Next&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                  				<!-- End Carousel Card -->
                  			    </div>
                  			</div>
                    </div>
                </div>
            </div>
        </div>
        <audio class="slideAudio" id="audioSlideOne" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide1.m4a' type='audio/mp4'>
        </audio>
	<audio class="slideAudio" id="audioSlideTwo" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide2.m4a' type='audio/mp4'>
        </audio>
	<audio class="slideAudio" id="audioSlideThree" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide3.m4a' type='audio/mp4'>
        </audio>
	<audio class="slideAudio" id="audioSlideFour" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide4.m4a' type='audio/mp4'>
        </audio>
	<audio class="slideAudio" id="audioSlideFive" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide5.m4a' type='audio/mp4'>
        </audio>
	<audio class="slideAudio" id="audioSlideSix" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide6.m4a' type='audio/mp4'>
        </audio>
  <audio class="slideAudio" id="audioSlideSeven" preload="auto" style="display: none;">
            <source src='audio/fourthGrade/Slide7.m4a' type='audio/mp4'>
        </audio>
        </div>
        </div>
        <?php require 'partials/footer.php' ?>
        </div>
    </body>
    <?php require 'partials/scripts.php' ?>
    <script>
     $(function() {

         $("#next").click(function(){
             $("#carousel-example-generic").carousel('next');
             var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
             var from = active.index();
             if (from == 6) {
               $("#next").hide();
             }
         });

         $("#previous").click(function(){
             $("#carousel-example-generic").carousel('prev');
             var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
             var from = active.index();
             if (from == 7) {
               $("#next").show();
             }
         });

         $("#play").click(function(){
             getSlideIndex();
         });

	       $("#slideshowStart").click(function(){
           console.log('start');
             $("#carousel-example-generic").carousel(1);
             $("#next").show();
             $("#previous").show();
         });

         $("#carousel-example-generic").on('slid.bs.carousel', function () {
             $(".slideAudio").trigger('pause');
             $(".slideAudio").prop("currentTime",0);
             $("#replay").hide();
             $("#pause").hide();
             $("#play").show();

             var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
             var from = active.index();
             if (from==0) {
                $("#previous").hide();
                 $("#next").hide();
                 $("#pause").hide();
                 $("#play").hide();
             }
         })

         function getSlideIndex(){
           console.log('getindex');
             var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
             var from = active.index();
             $("#replay").hide();

             if (from == 1) {
                 $("#audioSlideOne").trigger('play');
             }
             else if (from == 2) {
                 $("#audioSlideTwo").trigger('play');
             }
             else if (from == 3) {
                 $("#audioSlideThree").trigger('play');
             }
             else if (from == 4) {
                 $("#audioSlideFour").trigger('play');
             }
             else if (from == 5) {
                 $("#audioSlideFive").trigger('play');
             }
             else if (from == 6) {
                 $("#audioSlideSix").trigger('play');
                 $("#next").hide();
             }
             else if (from == 7) {
                 $("#audioSlideSeven").trigger('play');
             }
         }
         $('.slideAudio').on('ended', function() {
             $("#replay").show();
             $("#pause").hide();
         });

         $('.slideAudio').on('playing', function() {
             $("#pause").show();
             $("#replay").hide();
         });

         $("#pause").click(function(){
             $(".slideAudio").trigger('pause');
             $("#play").show();
             $("#pause").hide();
         });

         $("#play").click(function(){
             getSlideIndex();
             $("#play").hide();
             $("#pause").show();
         });

         $("#replay").click(function(){
             getSlideIndex();
         });

     //     function getSlideIndex(){
     //         var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
     //         var from = active.index();
     //         $("#replay").hide();
     //
     //         if (from == 0) {
     //             $("#previous").hide();
     //             $("#next").hide();
     //             $("#pause").hide();
     //             $("#play").hide();
     //         }
     //
     //         if (from == 1) {
     //             $("#audioSlideOne").trigger('play');
     //         }
     //         else if (from == 2) {
     //             $("#audioSlideTwo").trigger('play');
     //         }
     //         else if (from == 3) {
     //             $("#audioSlideThree").trigger('play');
     //         }
     //         else if (from == 4) {
     //             $("#audioSlideFour").trigger('play');
     //         }
     //         else if (from == 5) {
     //             $("#audioSlideFive").trigger('play');
     // }
     // else if (from == 6) {
     //             $("#audioSlideSix").trigger('play');
     //         }
     //     }

         $("a[data-toggle='tab']").click(function(){
             $("audio").trigger("pause");
             $("video").trigger("pause");
         });
     });
    </script>
</html>
