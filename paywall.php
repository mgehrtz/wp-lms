<?php

if( ! defined( 'ABSPATH' )){
  exit;
}

function the_gift_paywall(){
  $is_lesson = is_singular( 'lesson' );
  $is_course = is_tax('course');

  if( !$is_lesson && !$is_course ) return;

  if( !is_user_logged_in() ){
    auth_redirect();
  }
  if( current_user_can('administrator') ) return;

  if( $is_lesson ){
    global $post;
    $related_course_id = get_the_terms($post, 'course')[0]->term_id;
  }

  if( $is_course ){
    $term = get_queried_object();
    $related_course_id = $term->term_id;
  }

  if( ! isset( $related_course_id ) ) return;

  $related_product_id = get_field('associated_product', "course_{$related_course_id}");
  if ( ! wc_customer_bought_product( '', get_current_user_id(), $related_product_id ) ) {
    $product_url = get_permalink( $related_product_id );
    wp_redirect( $product_url );
    exit();
  }
}
add_action( 'template_redirect', 'the_gift_paywall' );