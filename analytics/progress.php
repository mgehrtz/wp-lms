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

function thegift_save_submission_id_to_user( $form_id, $response ){
  $user_meta = array(
    'form_id' => $form_id,
    'entry_id' => $_POST['_form_submission_id']
  );
  $meta_key = 'user_answers_' . $_POST['page_id'];
  update_user_meta( get_current_user_id(), $meta_key, $user_meta);
}
add_action('forminator_form_after_save_entry', 'thegift_save_submission_id_to_user', 10, 2);

function thegift_track_user_submission( $entry, $form_id, $field_data_array ) {
	$_POST['_form_submission_id'] = $entry->entry_id;
}
add_action( 'forminator_custom_form_submit_before_set_fields', 'thegift_track_user_submission', 20, 3 );

function load_user_entries( $page_id ){
  $meta_key = 'user_answers_' . $page_id;
  $meta = get_user_meta( get_current_user_id(), $meta_key, true );
  if($meta){
    $entry = Forminator_API::get_entry( $meta['form_id'], $meta['entry_id'] );
    wp_enqueue_script('load-entries', plugins_url( '/js/load-entries.js', __FILE__ ), array( 'jquery' ), '1.0.,0', true);
    wp_localize_script('load-entries', 'application_answers', $entry->meta_data);
  }
}