<?php
/**
 * Plugin Name: Carbon Pagination
 * Description: A basic plugin for pagination with advanced capabilities for extending.
 * Version: 1.0
 * Author: 2create Studio
 * Author URI: http://2create.bg/
 * License: GPL2
 * Requires at least: 3.8
 * Tested up to: 4.3
 */

// allows the plugin to be included as a library in themes
if ( class_exists( 'Carbon_Pagination' ) ) {
	return;
}

// include the pagination classes
$includes_dir = dirname( __FILE__ ) . '/includes/';
include_once( $includes_dir . 'Carbon_Pagination.php' );
include_once( $includes_dir . 'Carbon_Pagination_Renderer.php' );
include_once( $includes_dir . 'Carbon_Pagination_Collection.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Page.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Limiter.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_HTML.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Current_Page_Text.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Direction_Page.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Direction_Backward.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Direction_Forward.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_First_Page.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Previous_Page.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Next_Page.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Last_Page.php' );
include_once( $includes_dir . 'Carbon_Pagination_Item_Number_Links.php' );
include_once( $includes_dir . 'Carbon_Pagination_Posts.php' );
include_once( $includes_dir . 'Carbon_Pagination_Post.php' );
include_once( $includes_dir . 'Carbon_Pagination_Comments.php' );
include_once( $includes_dir . 'Carbon_Pagination_Custom.php' );

/**
 * A lazy way to build, configure and display a new pagination.
 *
 * @param string $pagination The pagination type, can be one of the following:
 *    - Posts
 *    - Post
 *    - Comments
 *    - Custom
 * @param array $args Configuration options to modify the pagination settings.
 * @param bool $echo Whether to display or return the output. True will display, false will return.
 *
 * @see Carbon_Pagination::__construct()
 */
function carbon_pagination( $pagination, $args = array(), $echo = true ) {
	$output = Carbon_Pagination::display( $pagination, $args, false );

	if ( ! $echo ) {
		return $output;
	}

	echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
}