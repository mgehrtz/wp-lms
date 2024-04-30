<?php

defined('ABSPATH') || die;

add_shortcode( 'application-question', 'thegift_insert_application_question' );
function thegift_insert_application_question( $atts, $content ){
  ob_start();
  ?>
  <div class='question-wrapper' style="display: flex; flex-direction: column;">
    <h4><?= $content ?></h4>
    <textarea name="<?= $atts['id'] ?>" class="question-answer" style="width: 100%" placeholder="Write your thoughts here..."></textarea>
    <button class="save button">Save All Answers</button>
  </div>
  <?php
  $html = ob_get_contents();
  ob_clean();
  return $html;
}