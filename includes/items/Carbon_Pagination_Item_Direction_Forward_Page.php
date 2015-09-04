<?php
/**
 * The Carbon Pagination direction forward page item class.
 * Used for next & last items.
 * Should be extended by each one of them.
 *
 * @abstract
 *
 * @uses Carbon_Pagination_Item_Direction_Page
 */
abstract class Carbon_Pagination_Item_Direction_Forward_Page extends Carbon_Pagination_Item_Direction_Page {

	/**
	 * If on the last page, the next and last items should be disabled.
	 *
	 * @return bool $result The condition result.
	 */
	public function get_direction_disabled() {
		$pagination = $this->get_collection()->get_pagination();

		// get various pagination variables that we need
		$current_page_idx = $pagination->get_current_page() - 1;
		$total_pages = $pagination->get_total_pages();

		// bail if there is no previous page
		if ( $current_page_idx >= $total_pages - 1 ) {
			return true;
		}

		return false;
	}

}