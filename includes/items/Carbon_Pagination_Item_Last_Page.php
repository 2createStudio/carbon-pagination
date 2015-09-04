<?php
/**
 * The Carbon Pagination last page item class.
 *
 * @uses Carbon_Pagination_Item_Direction_Forward_Page
 */
class Carbon_Pagination_Item_Last_Page extends Carbon_Pagination_Item_Direction_Forward_Page {

	/**
	 * The HTML of the direction item.
	 *
	 * @return string $html The direction item HTML.
	 */
	public function get_direction_html() {
		$pagination = $this->get_collection()->get_pagination();
		return $pagination->get_last_html();
	}

	/**
	 * The number of the page to link to.
	 *
	 * @return int $page The number of the page to link to.
	 */
	public function get_direction_page_number() {
		$pagination = $this->get_collection()->get_pagination();
		$total_pages = $pagination->get_total_pages();

		return $total_pages - 1;
	}
	
}