<?php
/**
 * Carbon Pagination - posts pagination class.
 * Provides the pagination for non-singular post loops (index, search, archive).
 *
 * @uses Carbon_Pagination_HTML
 */
class Carbon_Pagination_Posts extends Carbon_Pagination_HTML {

	/**
	 * Constructor.
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @param array $args Configuration options to modify the pagination settings.
	 */
	public function __construct( $args = array() ) {
		global $wp_query;

		// specify the default args for the Posts pagination
		$this->default_args = array(
			// get the total pages from the query
			'total_pages' => max( $wp_query->max_num_pages, 1 ),

			// get the current page from the query
			'current_page' => max( get_query_var( 'paged' ), 1 ),

			// modify the text of the previous page link
			'prev_html' => '<a href="{URL}" class="paging-prev">' . esc_html__( '« Previous Entries', 'crb' ) . '</a>',

			// modify the text of the next page link
			'next_html' => '<a href="{URL}" class="paging-next">' . esc_html__( 'Next Entries »', 'crb' ) . '</a>',
		);

		parent::__construct( $args );
	}

	/**
	 * Get the URL to a certain page.
	 *
	 * @param int $page_number The page number.
	 * @param string $old_url Optional. The URL to add the page number to.
	 * @return string $url The URL to the page number.
	 */
	public function get_page_url( $page_number, $old_url = '' ) {
		$pages = $this->get_pages();
		$page = isset( $pages[ $page_number ] ) ? $pages[ $page_number ] : 0;
		return get_pagenum_link( $page );
	}

}