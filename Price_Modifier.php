<?php
/**
 * @package  Price Modifier
 */
/*
Plugin Name: Price Modifier
Description: A simple and free plugin to apply discounts on all products without losing the original price.
Version: 1.1.0
Author: Anas Nagati
License: GPLv2 or later
*/




// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'You are not supposed to be here' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_Price_Modifier_plugin() {
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_Price_Modifier_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_Price_Modifier_plugin() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_Price_Modifier_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}
require 'calculator/modifier.php';