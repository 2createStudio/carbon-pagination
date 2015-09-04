<?php
/**
 * The Carbon Pagination direction backward page item class.
 * Used for prev & first items.
 * Should be extended by each one of them.
 *
 * @abstract
 *
 * @uses Carbon_Pagination_Item_Direction_Page
 */
abstract class Carbon_Pagination_Item_Direction_Backward_Page extends Carbon_Pagination_Item_Direction_Page {

	/**
	 * If we're on the first page, the first and prev items
	 * should be disabled.
	 *
	 * @return bool $result The condition result.
	 */
	public function get_direction_disabled() {
		$pagination = $this->get_collection()->get_pagination();
		$result = $pagination->get_current_page() <= 1;
		return $result;
	}

}