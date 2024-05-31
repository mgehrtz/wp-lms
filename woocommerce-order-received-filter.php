<?php

add_filter('woocommerce_thankyou_order_received_text', function( $html ) {
  $content = file_get_contents(THEGIFT_PLUGIN_ROOT . '/templates/woocommerce/order-received.php');
  wp_enqueue_style(
    'woo-order-received-stylesheet',
    THEGIFT_PLUGIN_ROOT . '/stylesheets/woocommerce-order-received.css'
  );
  return $html . $content;
});