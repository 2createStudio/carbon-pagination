<?php

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
 */
function carbon_pagination( $pagination, $args = array(), $echo = true ) {
	$output = Carbon_Pagination_Presenter::display( $pagination, $args, false );

	if ( ! $echo ) {
		return $output;
	}

	echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
}