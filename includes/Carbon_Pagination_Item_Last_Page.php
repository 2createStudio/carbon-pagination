<?php
/**
 * The Carbon Pagination last page item class.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Last_Page extends Carbon_Pagination_Item {

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

		// bail if we are already on the last page
		if ( $current_page_idx >= $total_pages - 1 ) {
			return;
		}

		// create subitem and its collection and assign it
		$subitems_collection = Carbon_Pagination_Item_Page::generate_single_subitem_collection( $collection, $pagination->get_last_html(), $total_pages - 1 );
		$this->set_subitems_collection( $subitems_collection );
	}
	
}