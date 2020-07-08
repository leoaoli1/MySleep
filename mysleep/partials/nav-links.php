<?php
#
# Part of the MySleep package
#
# University of Arizona Own the Copyright
#
# Author: Siteng Chen <sitengchen@email.arizona.edu>
#
// nav-links functions

// ************************ Date and time related function ************************
// Function to get navigation links.

function navigationLink($config, $userType, $options = array()){
  $linkable = false;
  if ($options['parent']) {
    $parentPage = $options['parent'];
  } elseif ($options['linkable']) {
    $linkable = true;
  }

  echo '<div class="row">';
  echo '<div class="col-xs-offset-1 col-xs-10 col-sm-10">';
  echo '<ol class="breadcrumb">';
  echo '<li><a class="exit" data-location="main-page">Home</a></li>';
  if ('main-page' != $parentPage) {
    echo '<li><a class="exit" data-location="sleep-lesson" data-toggle="popover" data-trigger="hover" data-placement="top" data-title="Main Lessons Page" data-content="Go to main lessons page to check five different lessons.">Lessons</a></li>';
    if ($config) {
      echo '<li><a class="exit" data-location="lesson-menu?lesson='.$config['lesson_num'].'">Lesson '.ucfirst(num2word($config['lesson_num'])).'</a></li>';
      if ($userType == 'teacher' && ($config['activity_type']=='normal'||$config['activity_type']=='assignment')) {
        echo '<li><a class="exit" data-location="activity-console?lesson='.$config['lesson_num'].'&activity='.$config['activity_num'].'">Activity '.ucfirst(num2word($config['activity_num'])).'</a></li>';
      }
      if ($linkable) {
         echo '<li><a class="exit" data-location="'.$config['activity_id'].'?lesson='.$config['lesson_num'].'&activity='.$config['activity_num'].'">'.$config['activity_title'].'</a></li>';
      }else {
        echo '<li class="active">'.$config['activity_title'].'</li>';
      }
    }
  }else {
    if ($options['additional']) {
      echo $options['additional'];
    }
    echo '<li class="active">'.$config['activity_title'].'</li>';
  }


  echo '</ol>';
  echo '</div>';
  echo '</div>';


}

function navigationLinkReview($config, $userType){
  echo '<div class="row">';
  echo '<div class="col-xs-offset-1 col-xs-10 col-sm-10">';
  echo '<ol class="breadcrumb">';
  echo '<li><a class="exit" data-location="main-page">Home</a></li>';
  echo '<li><a class="exit" data-location="sleep-lesson" data-toggle="popover" data-trigger="hover" data-placement="top" data-title="Main Lessons Page" data-content="Go to main lessons page to check five different lessons.">Lessons</a></li>';
  if ($config) {
    echo '<li><a class="exit" data-location="lesson-menu?lesson='.$config['lesson_num'].'">Lesson '.ucfirst(num2word($config['lesson_num'])).'</a></li>';
    if ($userType == 'teacher' && ($config['activity_type']=='normal'||$config['activity_type']=='assignment')) {
      echo '<li><a class="exit" data-location="activity-console?lesson='.$config['lesson_num'].'&activity='.$config['activity_num'].'">Activity '.ucfirst(num2word($config['activity_num'])).'</a></li>';
    }
    echo '<li class="active">Review: '.$config['activity_title'].'</li>';
  }
    echo '</ol>';
    echo '</div>';
    echo '</div>';
}

function navigationLinkAddition($config, $userType, $addition){
  echo '<div class="row">';
  echo '<div class="col-xs-offset-1 col-xs-10 col-sm-10">';
  echo '<ol class="breadcrumb">';
  echo '<li><a class="exit" data-location="main-page">Home</a></li>';
  echo '<li><a class="exit" data-location="sleep-lesson" data-toggle="popover" data-trigger="hover" data-placement="top" data-title="Main Lessons Page" data-content="Go to main lessons page to check five different lessons.">Lessons</a></li>';
  // echo '<li><a class="exit" data-location="sleep-lesson" data-toggle="popover" data-trigger="hover" data-placement="top" data-title="Main Lessons Page" data-content="Go to main lessons page to check five different lessons.">Lessons</a></li>';
  if ($config) {
    echo '<li><a class="exit" data-location="lesson-menu?lesson='.$config['lesson_num'].'">Lesson '.ucfirst(num2word($config['lesson_num'])).'</a></li>';
    echo $addition;
    echo '<li class="active">'.$config['activity_title'].'</li>';
  }
    echo '</ol>';
    echo '</div>';
    echo '</div>';
}
?>
