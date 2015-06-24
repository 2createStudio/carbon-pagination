<?php
/**
 * Carbon Pagination - custom pagination class.
 * Allows to create and maintain a custom pagination.
 *
 * @uses Carbon_Pagination_Builder
 */
class Carbon_Pagination_Custom extends Carbon_Pagination_Builder {
	/**
	 * The default argument values.
	 * This array has higher priority than the general default values, but has
	 * lesser priority than the specific arguments, passed to the constructor.
	 *
	 * @access public
	 *
	 * @var array
	 */
	public $default_args = array();

	/**
	 * The query var that is used to specify the pagination number.
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $query_var = 'page';

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