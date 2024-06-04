<?php

defined('ABSPATH') || die;

add_shortcode( 'application-question', 'thegift_insert_application_question' );
function thegift_insert_application_question( $atts, $content ){
  $atts = shortcode_atts(array(
    "id" => null,
    "type" => "textarea",
    "sections" => "",
  ), $atts);
  $atts[ 'id' ] = thegift_safe_id( $atts[ 'id' ] );

  ob_start();
  ?>
  <div class='question-wrapper <?= $atts['type'] ?>' style="display: flex; flex-direction: column;">
    <h4><?= $content ?></h4>
    <?php if( $atts['type'] === 'scale'): ?>
      <input name="<?= strtolower( $atts['id'] ) ?>" type="hidden" class="question-answer <?= $atts['type'] ?>" value="0" />
      <div class="numbers-wrapper" data-name="<?= $atts['id'] ?>" style="display: flex; justify-content: space-around;">
        <button data-value="1">1</button>
        <button data-value="2">2</button>
        <button data-value="3">3</button>
        <button data-value="4">4</button>
        <button data-value="5">5</button>
        <button data-value="6">6</button>
        <button data-value="7">7</button>
        <button data-value="8">8</button>
        <button data-value="9">9</button>
        <button data-value="10">10</button>
      </div>
    <?php elseif( $atts['type'] === 'textarea' ): ?>
      <textarea name="<?= strtolower( $atts['id'] ) ?>" class="question-answer <?= $atts['type'] ?>" style="width: 100%" placeholder="Write your thoughts here..."></textarea>
    <?php 
      elseif( $atts['type'] === 'multipart' ): 
        $sections = explode( '|', $atts['sections'] );
    ?>
      <div class="multipart-outer">
    <?php
        foreach( $sections as $index => $section ):
    ?>
      <div class="multipart-wrapper">
        <label for="<?= strtolower( $atts[ 'id' ] . '_' . $index ) ?>"><?= $section ?></label>
        <textarea class="question-answer <?= $atts[ 'type' ] ?>" name="<?= strtolower( $atts[ 'id' ] . '_' . $index ) ?>"></textarea>
      </div>
    <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <span style="display: none" class="save-success">Answers successfully saved.</span>
    <span style="display: none" class="save-error">Something went wrong trying to save your answers.</span>
    <button class="save button">Save All Answers</button>
  </div>
  <?php
  $html = ob_get_contents();
  ob_clean();
  return $html;
}