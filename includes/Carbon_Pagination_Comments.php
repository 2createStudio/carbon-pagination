<?php
/**
 * Carbon Pagination - comments pagination class.
 * Provides the pagination for comments within a post/page.
 *
 * @uses Carbon_Pagination_Builder
 */
class Carbon_Pagination_Comments extends Carbon_Pagination_Builder {

	/**
	 * Constructor.
	 *
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @access public
	 *
	 * @param array $args Configuration options to modify the pagination settings.
	 * @return Carbon_Pagination
	 */
	public function __construct( $args = array() ) {
		global $wp_query;

		if ( empty($max_page) ) {
			$max_page = $wp_query->max_num_comment_pages;
		}

		if ( empty($max_page) ) {
			$max_page = get_comment_pages_count();
		}

		$this->default_args = array(
			'current_page' => max(get_query_var('cpage'), 1),
			'total_pages' => max($max_page, 1),
			'prev_html' => '<a href="{URL}" class="paging-prev">' . __('&laquo; Older Comments', 'crb') . '</a>',
			'next_html' => '<a href="{URL}" class="paging-next">' . __('Newer Comments &raquo;', 'crb') . '</a>',
		);

		parent::__construct( $args );
	}

	/**
	 * Get the URL to a certain page.
	 *
	 * @access public
	 *
	 * @param int $page_number The page number.
	 * @param string $old_url Optional. The URL to add the page number to.
	 * @return string $url The URL to the page number.
	 */
	public function get_page_url($page_number, $old_url = '') {
		$pages = $this->get_pages();
		return get_comments_pagenum_link( $pages[$page_number] );
	}

}