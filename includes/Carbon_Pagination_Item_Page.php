<?php
/**
 * The Carbon Pagination previous page item class.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Page extends Carbon_Pagination_Item {

	/**
	 * The page number index.
	 *
	 * @access protected
	 *
	 * @var int
	 */
	protected $page_number = 0;

	/**
	 * The HTML of the item.
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $html = '';

	/**
	 * Setup the item before rendering.
	 * Setup item tokens.
	 *
	 * @access public
	 */
	public function setup() {
		$pagination = $this->get_collection()->get_pagination();

		// get various pagination stuff
		$page_number = $this->get_page_number();

		// build the page link URL 
		$url = $pagination->get_page_url($page_number, $pagination->get_current_url());

		// parse tokens
		$tokens = array(
			'URL' => $url,
			'PAGE_NUMBER' => $page_number + 1,
		);
		
		$this->set_tokens($tokens);
	}

	/**
	 * Render the item.
	 *
	 * @access public
	 *
	 * @return string $link The HTML of the item.
	 */
	public function render() {
		$pagination = $this->get_collection()->get_pagination();
		$current_page_idx = $pagination->get_current_page() - 1;

		// if there is no text/HTML for the link, use the default one
		$html = $this->get_html();
		if (!$html) {
			if ($this->get_page_number() == $current_page_idx) {
				$html = $pagination->get_current_number_html();
			} else {
				$html = $pagination->get_number_html();
			}
		}

		// allow the page link HTML to be filtered
		$html = apply_filters('carbon_pagination_page_link', $html, $this);

		return $html;
	}

	/**
	 * Retrieve the page index number.
	 *
	 * @access public
	 *
	 * @return int $page_number The page index number.
	 */
	public function get_page_number() {
		return $this->page_number;
	}

	/**
	 * Modify the page index number.
	 *
	 * @access public
	 *
	 * @param int $page_number The new page index number.
	 */
	public function set_page_number($page_number) {
		$this->page_number = $page_number;
	}

	/**
	 * Retrieve the page item HTML.
	 *
	 * @access public
	 *
	 * @return string $html The page item HTML.
	 */
	public function get_html() {
		return $this->html;
	}

	/**
	 * Modify the page item HTML.
	 *
	 * @access public
	 *
	 * @param string $html The new page item HTML.
	 */
	public function set_html($html) {
		$this->html = $html;
	}

}