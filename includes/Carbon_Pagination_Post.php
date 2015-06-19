<?php
/**
 * Carbon Pagination - single post pagination class.
 * Provides the pagination for singular post.
 *
 * @uses Carbon_Pagination_Builder
 */
class Carbon_Pagination_Post extends Carbon_Pagination_Builder {

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
		global $post;

		$query = array(
			'post_type' => get_post_type( get_the_ID() ),
			'posts_per_page'  => -1,
			'fields' => 'ids',
		);
		$query = apply_filters('carbon_pagination_post_pagination_query', $query);
		
		$posts = get_posts($query);

		$this->default_args = array(
			'pages' => $posts,
			'current_page' => get_the_ID(),
			'total_pages' => count($posts),
			'prev_html' => '<a href="{URL}" class="paging-prev">' . __('&laquo; Previous Entry', 'crb') . '</a>',
			'next_html' => '<a href="{URL}" class="paging-next">' . __('Next Entry &raquo;', 'crb') . '</a>',
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
		return get_permalink( $pages[$page_number] );
	}

}