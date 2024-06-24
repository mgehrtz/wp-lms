<?php

defined( 'ABSPATH' ) || exit;

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
	wp_reset_postdata();
	return $field;
}
add_filter( 'acf/load_field/name=associated_product', 'populate_associated_product_select_field' );

function enqueue_lesson_stylesheet(){
	wp_enqueue_style(
		'lesson-stylesheet',
		THEGIFT_PLUGIN_ROOT . '/stylesheets/single-lesson.css'
	);
}

function enqueue_course_stylesheet(){
	wp_enqueue_style(
		'course-stylesheet',
		THEGIFT_PLUGIN_ROOT . '/stylesheets/taxonomy-course.css'
	);
}

function get_purchased_course_ids(){
	$customer_orders = wc_get_orders( array(
		'limit' => -1,
		'customer_id' => get_current_user_id(),
		'status' => array_values( wc_get_is_paid_statuses() ),
		'return' => 'ids',
	) );

	if( !$customer_orders ){
		return array();
	}

	$product_ids = array();
	foreach ( $customer_orders as $order_id ) {
		$order = wc_get_order( $order_id );
		$items = $order->get_items();
		foreach ( $items as $item ) {
			$product_ids[] = $item->get_product_id();
		}
	}
	$purchased_course_ids = array();
	$course_ids = get_terms( array(
		'taxonomy' => 'course',
		'hide_empty' => false,
		'fields' => 'ids'
	) );
	if( !$course_ids ){
		return array();
	}
	foreach ( $course_ids as $course_id ){
		$associated_product_id = get_field('associated_product', "course_{$course_id}");
		if( !$associated_product_id ) continue;
		if(in_array($associated_product_id, $product_ids)){
			$purchased_course_ids[] = $course_id;
		}
	}

	wp_reset_postdata();

	return $purchased_course_ids;
}

function get_lesson_ids_by_course( $course_id ){
	$args = array(
		'post_type' => 'lesson',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(
			'taxonomy' => 'course',
			'field' => 'term_id',
			'terms' => $course_id
		),
		'fields' => 'ids',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	$query = new WP_Query( $args );
	return $query->get_posts();
}

function remove_image_zoom_support() {
	remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );

function thegift_safe_id($string) {
	$string = strtolower($string);
	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	$string = preg_replace("/[\s-]+/", " ", $string);
	$string = preg_replace("/[\s_]/", "-", $string);
	return $string;
}

function allow_customers_to_read_private_posts() {
	$subRole = get_role( 'customer' ); //change the name of the user here 
	$subRole->add_cap( 'read_private_posts' ); //allows the above to read posts 
	$subRole->add_cap( 'read_private_pages' ); //allows the above to read pages
}
add_action( 'init', 'allow_customers_to_read_private_posts' );