<?php

add_filter( 'woocommerce_account_menu_items', 'thegift_woocommerce_sidebar_items' );
function thegift_woocommerce_sidebar_items( $items ) {
  $reordered_items = array(
    'dashboard' => __('Enrolled Courses', 'woocommerce'),
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