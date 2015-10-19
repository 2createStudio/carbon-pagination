<?php
/**
 * Carbon Pagination - single post pagination class.
 * Provides the pagination for singular post.
 *
 * @uses Carbon_Pagination_HTML
 */
class Carbon_Pagination_Post extends Carbon_Pagination_HTML {

	/**
	 * Constructor.
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @param array $args Configuration options to modify the pagination settings.
	 */
	public function __construct( $args = array() ) {
		global $post;
		
		// get all sibling posts/pages
		$posts = $this->get_pagination_posts();

		// specify the default args for the Post pagination
		$this->default_args = array(
			// specify the sibling posts/pages for pagination pages
			'pages' => $posts,
			// the current post/page is the current page
			'current_page' => array_search( get_the_ID(), $posts ) + 1,
			// modify the text of the previous page link
			'prev_html' => '<a href="{URL}" class="paging-prev">' . esc_html__( '« Previous Entry', 'crb' ) . '</a>',
			// modify the text of the next page link
			'next_html' => '<a href="{URL}" class="paging-next">' . esc_html__( 'Next Entry »', 'crb' ) . '</a>',
		);

		// register additional tokens
		add_filter( 'carbon_pagination_after_setup_item', array( $this, 'add_tokens' ) );

		parent::__construct( $args );
	}

	/**
	 * Retrieve the posts that we'll paginate through.
	 *
	 * @return array $posts The posts to paginate through.
	 */
	public function get_pagination_posts() {
		global $post;

		// specify default query args to get all sibling posts/pages
		$query = array(
			'post_type' => get_post_type( get_the_ID() ),
			'posts_per_page'  => -1,
			'fields' => 'ids',
		);

		// allow the default query args to be filtered
		$query = apply_filters( 'carbon_pagination_post_pagination_query', $query, $this );
		
		// get all sibling posts/pages
		$posts = get_posts( $query );

		return $posts;
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
		$page = 0;
		
		if ( isset( $pages[ $page_number ] ) ) {
			$page = $pages[ $page_number ];
		}
		
		$url = get_permalink( $page );
		
		return $url;
	}

	/**
	 * Add tokens to all post items.
	 * Registers the {TITLE} token for this pagination type
	 *
	 * @param Carbon_Pagination_Item $item The item to add tokens to.
	 */
	public function add_tokens( Carbon_Pagination_Item $item ) {
		if ( ! ( $item instanceof Carbon_Pagination_Item_Page ) ) {
			return;
		}

		$tokens = $item->get_tokens();
		$tokens['TITLE'] = $this->get_post_title( $item );
		$item->set_tokens( $tokens );
	}

	/**
	 * Retrieve the title of a certain post.
	 *
	 * @param Carbon_Pagination_Item $item The item to add tokens to.
	 * @return string $title The title of the item's corresponding post.
	 */
	public function get_post_title( Carbon_Pagination_Item $item ) {
		if ( ! ( $item instanceof Carbon_Pagination_Item_Page ) ) {
			return;
		}
		
		$page_number = $item->get_page_number();

		$pages = $this->get_pages();

		$title = get_post_field( 'post_title', $pages[ $page_number ] );
		$title = apply_filters( 'the_title', $title );

		return $title;
	}

}