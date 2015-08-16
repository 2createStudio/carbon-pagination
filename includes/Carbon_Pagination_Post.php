<?php
/**
 * Carbon Pagination - single post pagination class.
 * Provides the pagination for singular post.
 *
 * @uses Carbon_Pagination
 */
class Carbon_Pagination_Post extends Carbon_Pagination {

	/**
	 * Constructor.
	 *
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @access public
	 *
	 * @param array $args Configuration options to modify the pagination settings.
	 */
	public function __construct( $args = array() ) {
		global $post;

		// specify default query args to get all sibling posts/pages
		$query = array(
			'post_type' => get_post_type( get_the_ID() ),
			'posts_per_page'  => -1,
			'fields' => 'ids',
		);

		// allow the default query args to be filtered
		$query = apply_filters( 'carbon_pagination_post_pagination_query', $query );
		
		// get all sibling posts/pages
		$posts = get_posts( $query );

		// specify the default args for the Post pagination
		$this->default_args = array(
			// specify the sibling posts/pages for pagination pages
			'pages' => $posts,

			// the current post/page is the current page
			'current_page' => array_search( get_the_ID(), $posts ) + 1,

			// the total number of pages is the number of sibling posts/pages
			'total_pages' => count( $posts ),

			// modify the text of the previous page link
			'prev_html' => '<a href="{URL}" class="paging-prev">' . __( '&laquo; Previous Entry', 'crb' ) . '</a>',

			// modify the text of the next page link
			'next_html' => '<a href="{URL}" class="paging-next">' . __( 'Next Entry &raquo;', 'crb' ) . '</a>',
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
	public function get_page_url( $page_number, $old_url = '' ) {
		$pages = $this->get_pages();
		$url = get_permalink( $pages[$page_number] );
		
		return $url;
	}

}