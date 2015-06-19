<?php
/**
 * Plugin Name: Carbon Pagination
 * Description: A basic plugin for pagination with advanced capabilities for extending.
 * Version: 0.1
 * Author: 2create Studio
 * Author URI: http://2create.bg/
 * License: GPL2
 * Requires at least: 3.8
 * Tested up to: 4.2.2
 */

// allows the plugin to be included as a library in themes
if (class_exists('Carbon_Pagination')) {
	return;
}

// include the pagination classes
$includes_dir = dirname(__FILE__) . '/includes/';
include_once($includes_dir . 'Carbon_Pagination.php');
include_once($includes_dir . 'Carbon_Pagination_Builder.php');