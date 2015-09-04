<?php
/**
 * The Carbon Pagination HTML item class.
 * Responsible for inserting HTML items like wrappers and separators.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_HTML extends Carbon_Pagination_Item {

	/**
	 * @var string
	 * 
	 * The HTML of the item.
	 */
	protected $html = '';

	/**
	 * Render the item.
	 *
	 * @return string $html The HTML of the item.
	 */
	public function render() {
		$html = apply_filters( 'carbon_pagination_html', $this->get_html(), $this );

		return $html;
	}

	/**
	 * Retrieve the item HTML.
	 *
	 * @return string $html The item HTML.
	 */
	public function get_html() {
		return $this->html;
	}

	/**
	 * Modify the item HTML.
	 *
	 * @param string $html The new item HTML.
	 */
	public function set_html( $html ) {
		$this->html = $html;
	}

}