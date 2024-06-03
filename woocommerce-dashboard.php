<?php

add_filter( 'woocommerce_account_menu_items', 'thegift_woocommerce_sidebar_items' );
function thegift_woocommerce_sidebar_items( $items ) {
  $reordered_items = array(
    'dashboard' => __('Enrolled Courses', 'woocommerce'),
    'resources' => __('Additional Resources', 'woocommerce'),
    'edit-account' => __('Account Details', 'woocommerce'),
    'edit-address' => __('Addresses', 'woocommerce'),
    'orders' => __('Orders', 'woocommerce'),
    'customer-logout' => __('Logout', 'woocommerce'),
  );
  return $reordered_items;
}

add_filter( 'wc_get_template', 'thegift_override_woo_dash', 10, 5 );
function thegift_override_woo_dash( $located, $template_name, $args, $template_path, $default_path ) {    
  if ( 'myaccount/dashboard.php' == $template_name ) {
    $located = plugin_dir_path( __FILE__ ) . 'templates/frontend/woo-dashboard.php';
    track_course_progress();
  }
  
  return $located;
}

add_action( 'init', 'thegift_add_woo_endpoints' );
function thegift_add_woo_endpoints() {
	add_rewrite_endpoint( 'resources', EP_PAGES );
}

add_action( 'woocommerce_account_resources_endpoint', 'thegift_woo_resources_endpoint_content' );
function thegift_woo_resources_endpoint_content() {
  $args = array(
    'post_type' => 'resource',
    'nopaging' => true,
    'status' => 'publish'
  );
  $resources = get_posts( $args );
  echo '<h2>Additional Resources</h2>';

  if( $resources ){
    include('templates/frontend/additional-resources.php');
    wp_enqueue_style(
      'woo-resources-stylesheet',
      THEGIFT_PLUGIN_ROOT . '/stylesheets/additional-resources.css'
    );
  } else {  
    echo '<p>There are no additional resources at this time. Check back again soon!</p>';
  }
}