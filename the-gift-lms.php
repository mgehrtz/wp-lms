<?php 
/* 
* Plugin Name: The Gift - Learning Management System
* Description: A plugin to manage courses and add functionality to The Gift.
* Version: 0.0.1
* Author: Gehrtz Creative
*/

define('THEGIFT_PLUGIN_ROOT', plugins_url('/', __FILE__) );

include('paywall.php');
include('functions.php');
include('templates.php');
include('woocommerce-dashboard.php');
include('analytics/progress.php');
include('shortcodes/application-question.php');
include('application/application-processing.php');