<?php
/**
 * Carbon Pagination - comments pagination class.
 * Provides the pagination for comments within a post/page.
 *
 * @uses Carbon_Pagination
 */
class Carbon_Pagination_Comments extends Carbon_Pagination {

	/**
	 * Constructor.
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @access public
	 * @param array $args Configuration options to modify the pagination settings.
	 */
	public function __construct( $args = array() ) {
		global $wp_query;

		// get max page from query
		if ( empty( $wp_query->max_num_comment_pages ) ) {
			$max_page = $wp_query->max_num_comment_pages;
		}

		// if there is no max page in the query, calculate it
		if ( empty( $max_page ) ) {
			$max_page = get_comment_pages_count();
		}

		// specify the default args for the Comments pagination
		$this->default_args = array(
			// specify the total number of pages as retrieved above
			'total_pages' => max( $max_page, 1 ),

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
	 * Get the URL to a certain page.
	 *
	 * @access public
	 * @param int $page_number The page number.
	 * @param string $old_url Optional. The URL to add the page number to.
	 * @return string $url The URL to the page number.
	 */
	public function get_page_url( $page_number, $old_url = '' ) {
		$pages = $this->get_pages();
		$url = get_comments_pagenum_link( $pages[ $page_number ] );
		
		return $url;
	}

}