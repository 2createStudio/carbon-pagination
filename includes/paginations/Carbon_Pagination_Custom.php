<?php
/**
 * Carbon Pagination - custom pagination class.
 * Allows to create and maintain a custom pagination.
 * By default it takes advantage of the post content pagination (<!--nextpage--> Quicktag)
 *
 * @uses Carbon_Pagination_HTML
 */
class Carbon_Pagination_Custom extends Carbon_Pagination_HTML {
	/**
	 * @var string
	 * 
	 * The query var that is used to specify the pagination number.
	 */
	protected $query_var = 'page';

	/**
	 * Constructor.
	 * Creates and configures a new pagination with the provided settings.
	 *
	 * @param array $args Configuration options to modify the pagination settings.
	 */
	public function __construct( $args = array() ) {
		// get the default total number of pages from the <!--nextpage--> functionality
		global $numpages;
		$total_pages = ! empty( $numpages ) ? $numpages : '';

		// specify the default args for the Custom pagination
		$this->default_args = array(
			'total_pages' => $total_pages,
			'current_page' => get_query_var( $this->get_query_var() ),
			'enable_numbers' => true,
			'enable_prev' => false,
			'enable_next' => false,
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

		if ( ! $old_url ) {
			$old_url = Carbon_Pagination_Utilities::get_current_url();
		}

		if ( ! isset( $pages[ $page_number ] ) ) {
			return $old_url;
		}

		return add_query_arg( $this->get_query_var(), $pages[ $page_number ], $old_url );
	}

	/**
	 * Retrieve the query var name.
	 *
	 * @return string $query_var The query var name.
	 */
	public function get_query_var() {
		return $this->query_var;
	}

	/**
	 * Modify the query var name.
	 *
	 * @param string $query_var The new query var name.
	 */
	public function set_query_var( $query_var ) {
		$this->query_var = $query_var;
	}

}