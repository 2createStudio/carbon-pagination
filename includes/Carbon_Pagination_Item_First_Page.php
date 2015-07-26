<?php
/**
 * The Carbon Pagination first page item class.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_First_Page extends Carbon_Pagination_Item {

	/**
	 * Initialize the item.
	 * Generate the sub items (fragments) of this item.
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
		if ($current_page_idx <= $first_page) {
			return;
		}

		// create a page item
		$page_item = new Carbon_Pagination_Item_Page( $collection );
		$page_item->set_html( $pagination->get_first_html() );
		$page_item->set_page_number( $first_page );

		// create and assign the fragments collection
		$fragments_collection = new Carbon_Pagination_Collection($pagination, false);
		$fragments_collection->set_items( array($page_item) );
		$this->set_fragments_collection($fragments_collection);
	}
	
}