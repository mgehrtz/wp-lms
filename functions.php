<?php

// Called by ACF custom meta box for course
function fill_course_meta_box_content( $post ) {
	$terms = get_terms( array(
		'taxonomy' => 'course',
		'hide_empty' => false // Retrieve all terms
	));

	// We assume that there is a single category
	$currentTaxonomyValue = get_the_terms($post->ID, 'course')[0];
  include_once('templates/admin/course-meta-box.php');
}

function populate_associated_product_select_field( $field ) {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
		'product_cat'    => 'online-course',
		'post_status'		 => 'publish',
	);
	$products = new WP_Query( $args );
	$options = array();
	if ( $products->have_posts() ) {
		while ( $products->have_posts() ) {
			$products->the_post();
			$options[get_the_ID()] = get_the_title();
		}
	}
	$field['choices'] = $options;
	return $field;
	}
	add_filter( 'acf/load_field/name=associated_product', 'populate_associated_product_select_field' );