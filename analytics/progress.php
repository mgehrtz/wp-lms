<?php
defined('ABSPATH') || exit;

function track_course_progress(){
  if( current_user_can('administrator') ) return; // do not track admin
  global $post;
  if( get_post_type( $post->ID ) !== 'lesson' ) return;
  $user_id = get_current_user_id();
  $meta = get_user_meta( $user_id, 'progress' );
  $meta[ $post->ID ] = 'started';
  if( isset( $_GET['complete'] )) {
    if( get_post_type( $_GET['complete'] ) === 'lesson' ){
      $meta[ $_GET['complete'] ] = 'complete';
    }
  }
  update_user_meta( $user_id, 'progress', $meta );
}

/* Setup to handle ajax requests
// Load Tracking Script
add_action( 'wp_enqueue_scripts', 'thegift_enqueue_tracking_scripts' );
function thegift_enqueue_tracking_scripts(){
  if( get_post_type() != 'lesson' ) return;
  if( ! is_user_logged_in() ) return;

  wp_enqueue_script(
    'progress-tracking-script',
    plugins_url( '/js/progress.js', __FILE__ ),
    array( 'jquery' ),
    '1.0.,0',
    array(
       'in_footer' => true,
    )
  );

  wp_localize_script(
    'progress-tracking-script',
    'progress_ajax_obj',
    array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'nonce' => wp_create_nonce( 'progress_nonce' )
    )
  );
}

// Handle Ajax Requests
add_action( 'wp_ajax_track_course_progress', 'thegift_progress_ajax_handler' );
function thegift_progress_ajax_handler(){
  check_ajax_referer( 'progress_nonce' );
  wp_die();
}
*/