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
	 * The result of the condition which would disable this item.
	 * If true, this item wont be displayed.
	 *
	 * @access public
	 *
	 * @return bool $result The condition result.
	 */
	public function get_direction_disabled() {
		$pagination = $this->get_collection()->get_pagination();

		// get various pagination variables that we need
		$current_page_idx = $pagination->get_current_page() - 1;
		$first_page = 0;

		// bail if there is no previous page
		if ( $current_page_idx <= $first_page ) {
			return true;
		}

		return false;
	}

}