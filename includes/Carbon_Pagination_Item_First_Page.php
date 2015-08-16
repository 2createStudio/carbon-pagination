<?php
/**
 * The Carbon Pagination first page item class.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_First_Page extends Carbon_Pagination_Item {

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
		$first_page = 0;

		// bail if we are already on the first page
		if ( $current_page_idx <= $first_page ) {
			return;
		}

		// create subitem and its collection and assign it
		$subitems_collection = Carbon_Pagination_Item_Page::generate_single_subitem_collection( $collection, $pagination->get_first_html(), $first_page );
		$this->set_subitems_collection( $subitems_collection );
	}
	
}