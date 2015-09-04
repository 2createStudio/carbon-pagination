<?php
/**
 * The Carbon Pagination previous page item class.
 *
 * @uses Carbon_Pagination_Item_Direction_Backward_Page
 */
class Carbon_Pagination_Item_Previous_Page extends Carbon_Pagination_Item_Direction_Backward_Page {

	/**
	 * The HTML of the direction item.
	 *
	 * @return string $html The direction item HTML.
	 */
	public function get_direction_html() {
		$pagination = $this->get_collection()->get_pagination();
		return $pagination->get_prev_html();
	}

	/**
	 * The number of the page to link to.
	 *
	 * @return int $page The number of the page to link to.
	 */
	public function get_direction_page_number() {
		$pagination = $this->get_collection()->get_pagination();
		$current_page_idx = $pagination->get_current_page() - 1;

		return $current_page_idx - 1;
	}

}