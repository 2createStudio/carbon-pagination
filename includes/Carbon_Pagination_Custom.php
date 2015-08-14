<?php
/**
 * Carbon Pagination - custom pagination class.
 * Allows to create and maintain a custom pagination.
 * By default it takes advantage of the post content pagination (<!--nextpage--> Quicktag)
 *
 * @uses Carbon_Pagination
 */
class Carbon_Pagination_Custom extends Carbon_Pagination {
	/**
	 * The query var that is used to specify the pagination number.
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $query_var = 'page';

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
		// specify the default args for the Custom pagination
		$this->default_args = array(
			'current_page' => get_query_var( $this->get_query_var() ),
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
		$url = add_query_arg($this->get_query_var(), $pages[$page_number], $old_url);
		
		return $url;
	}

	/**
	 * Retrieve the query var name.
	 *
	 * @access public
	 *
	 * @return string $query_var The query var name.
	 */
	public function get_query_var() {
		return $this->query_var;
	}

	/**
	 * Modify the query var name.
	 *
	 * @access public
	 *
	 * @param string $query_var The new query var name.
	 */
	public function set_query_var($query_var) {
		$this->query_var = $query_var;
	}

}