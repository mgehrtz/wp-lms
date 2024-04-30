<?php

defined('ABSPATH') || die;

// Load Tracking Script
add_action( 'wp_enqueue_scripts', 'thegift_enqueue_application_scripts' );
function thegift_enqueue_application_scripts(){
  global $post;
  if( get_post_type() != 'lesson' && get_field('type') != 'Application' ) return;
  if( ! is_user_logged_in() ) return;

  wp_enqueue_script(
    'application-script',
    plugins_url( '/js/application.js', __FILE__ ),
    array( 'jquery' ),
    '1.0.,0',
    array(
       'in_footer' => true,
    )
  );

  wp_localize_script(
    'application-script',
    'application_ajax_obj',
    array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => wp_create_nonce( 'application_nonce' ),
      'post_id' => $post->ID
    )
  );
}

function get_user_answers( $page_id ){
  $meta_key = get_application_answers_meta_key( $page_id );
  $meta = get_user_meta( get_current_user_id(), $meta_key, true );
  if( ! $meta ) return;

  wp_localize_script(
    'application-script',
    'previous_application_answers',
    $meta
  );
}

// Handle Ajax Requests
add_action( 'wp_ajax_process_application_answers', 'thegift_application_ajax_handler' );
function thegift_application_ajax_handler(){
  check_ajax_referer( 'application_nonce' );
  $answers = $_POST['answers'];
  $response = save_user_answers( $_POST['post_id'], $answers );
  wp_send_json( $response );
}

function sanitize_application_answers( $answers ){
  if( ! is_array( $answers ) ) return;
  $keys = array_keys($answers);
  $keys = array_map('sanitize_key', $keys);
  $values = array_values($answers);
  $values = array_map('sanitize_text_field', $values);
  $array = array_combine($keys, $values);
  return $array;
}

function save_user_answers( $application_id, $answers ){
  $sanitized_array = sanitize_application_answers( $answers );
  $sanitized_meta_key = get_application_answers_meta_key( $application_id );
  return update_user_meta( get_current_user_id(), $sanitized_meta_key, $sanitized_array );
}

function get_application_answers_meta_key( $post_id ){
  $sanitized_key = sanitize_key( $post_id );
  return 'application_' . $sanitized_key . '_answers';
}