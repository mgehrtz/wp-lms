<?php

defined('ABSPATH') || exit;

function track_course_progress(){
  // if( current_user_can('administrator') ) return; // do not track admin
  global $post;
  if( get_post_type( $post->ID ) !== 'lesson' && $post->post_name !== 'my-account' ) return;
  $user_id = get_current_user_id();
  $meta = get_user_meta( $user_id, 'progress', true );
  if( ! $meta ){
    $meta = array();
  }
  if( ! array_key_exists( $post->ID, $meta ) ){
    $meta[ $post->ID ] = 'started';
  }
  if( isset( $_GET['complete'] )) {
    if( get_post_type( $_GET['complete'] ) === 'lesson' ){
      $meta[ $_GET['complete'] ] = 'complete';
    }
  }
  update_user_meta( $user_id, 'progress', $meta );
}

function get_progress_marker_class( $lesson_id, $progress ){
  if( ! $progress ) return '';
  if( ! array_key_exists( $lesson_id, $progress) ) return '';
  return $progress[ $lesson_id ];
}