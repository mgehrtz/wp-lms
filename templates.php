<?php

add_filter('single_template', 'thegift_lesson_template');
function thegift_lesson_template( $single ) {
    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'lesson' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'templates/frontend/single-lesson.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'templates/frontend/single-lesson.php';
        }
    }
    return $single;
}

add_filter('taxonomy_template', 'thegift_course_template');
function thegift_course_template( $taxonomy_template ){
    $term = get_queried_object();
    if( $term->taxonomy == 'course'){
        if(file_exists( plugin_dir_path( __FILE__ ) . 'templates/frontend/taxonomy-course.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'templates/frontend/taxonomy-course.php';
        }
    }
    return $taxonomy_template;
}