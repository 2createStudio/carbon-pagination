<?php
/**
 * The Carbon Pagination current page item class.
 * Responsible for the "Page X of Y" pagination item.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Current_Page_Text extends Carbon_Pagination_Item {

	/**
	 * Setup the item before rendering.
	 * Setup item tokens.
	 */
	public function setup() {
		$pagination = $this->get_collection()->get_pagination();
		$current_page = $pagination->get_current_page();

		$tokens = array(
			'CURRENT_PAGE' => $current_page,
			'TOTAL_PAGES' => $pagination->get_total_pages(),
		);

		$this->set_tokens( $tokens );
	}

	/**
	 * Render the item.
	 *
	 * @return string $html The HTML of the item.
	 */
	public function render() {
		$pagination = $this->get_collection()->get_pagination();

		$html = $pagination->get_current_page_html();
		$html = apply_filters( 'carbon_pagination_current_page_text', $html, $this );

		return $html;
	}

}