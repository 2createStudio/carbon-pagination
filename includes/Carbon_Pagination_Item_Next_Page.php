<?php
/**
 * The Carbon Pagination next page item class.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Next_Page extends Carbon_Pagination_Item {

	/**
	 * Initialize the item.
	 * Generate the sub items of this item.
	 *
	 * @access public
	 */
	public function init() {
		$collection = $this->get_collection();
		$pagination = $collection->get_pagination();

		// get various pagination variables that we need
		$current_page_idx = $pagination->get_current_page() - 1;
		$total_pages = $pagination->get_total_pages();

		// bail if there is no next page
		if ($current_page_idx >= $total_pages - 1) {
			return;
		}

		// create a page item
		$page_item = new Carbon_Pagination_Item_Page( $collection );
		$page_item->set_html( $pagination->get_next_html() );
		$page_item->set_page_number( $current_page_idx + 1 );

		// create and assign the subitems collection
		$subitems_collection = new Carbon_Pagination_Collection($pagination, false);
		$subitems_collection->set_items( array($page_item) );
		$this->set_subitems_collection($subitems_collection);
	}

}