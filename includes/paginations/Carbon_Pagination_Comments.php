<?php
/**
 * Carbon Pagination - comments pagination class.
 * Provides the pagination for comments within a post/page.
 *
 * @uses Carbon_Pagination_HTML
 */
class Carbon_Pagination_Comments extends Carbon_Pagination_HTML {

	/**
	 * Constructor.
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @param array $args Configuration options to modify the pagination settings.
	 */
	public function __construct( $args = array() ) {

		// specify the default args for the Comments pagination
		$this->default_args = array(
			// specify the total number of pages as retrieved above
			'total_pages' => $this->get_total_comment_pages(),

			// get the current comments page from the query
			'current_page' => max( get_query_var( 'cpage' ), 1 ),

			// modify the text of the previous page link
			'prev_html' => '<a href="{URL}" class="paging-prev">' . esc_html__( '« Older Comments', 'crb' ) . '</a>',

			// modify the text of the next page link
			'next_html' => '<a href="{URL}" class="paging-next">' . esc_html__( 'Newer Comments »', 'crb' ) . '</a>',
		);

		parent::__construct( $args );
	}

	/**
	 * Retrieve the total number of comment pages.
	 *
	 * @return int $total Total number of comment pages.
	 */
	public function get_total_comment_pages() {
		global $wp_query;

		// get max page from query
		if ( ! empty( $wp_query->max_num_comment_pages ) ) {
			$max_page = $wp_query->max_num_comment_pages;
		}

		// if there is no max page in the query, calculate it
		if ( empty( $max_page ) ) {
			$max_page = get_comment_pages_count();
		}

		return intval( max( $max_page, 1 ) );
	}

	/**
	 * Get the URL to a certain page.
	 *
	 * @param int $page_number The page number.
	 * @param string $old_url Optional. The URL to add the page number to.
	 * @return string $url The URL to the page number.
	 */
	public function get_page_url( $page_number, $old_url = '' ) {
		return get_comments_pagenum_link( $page_number + 1 );
	}

}