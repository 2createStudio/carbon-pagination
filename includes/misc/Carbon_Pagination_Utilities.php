<?php
/**
 * The Carbon Pagination utilities class.
 * Contains various helper functionality.
 */
class Carbon_Pagination_Utilities {

	/**
	 * Get the current URL, in WordPress style.
	 *
	 * @static
	 * @return string $url The current page URL.
	 */
	public static function get_current_url() {
		global $wp;
		$query_vars = array();
		$permalink_structure = get_option( 'permalink_structure' );

		// preserve all query vars that are in the GET as well
		// if the default permalink structure is used, all query vars should be added
		foreach ( $wp->query_vars as $qv_key => $qv_value ) {
			if ( isset( $_GET[ $qv_key ] ) || ! $permalink_structure ) {
				$query_vars[ $qv_key ] = $qv_value;
			}
		}

		return add_query_arg( $query_vars, home_url( '/' . $wp->request ) );
	}

}