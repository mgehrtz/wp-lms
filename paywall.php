<?php

if( ! defined( 'ABSPATH' )){
  exit;
}

function the_gift_paywall(){
  if( is_singular( 'lesson' ) ){
    if( !is_user_logged_in() ){
      auth_redirect();
    }
    if( current_user_can('administrator') ) return;
    global $post;
    $related_course_id = get_the_terms($post, 'course')[0]->term_id;
    $related_product_id = get_field('associated_product', "course_{$related_course_id}");
    if ( ! wc_customer_bought_product( '', get_current_user_id(), $related_product_id ) ) {
      $product_url = get_permalink( $related_product_id );
      wp_redirect( $product_url );
      exit();
    }
  }
}
add_action( 'template_redirect', 'the_gift_paywall' );