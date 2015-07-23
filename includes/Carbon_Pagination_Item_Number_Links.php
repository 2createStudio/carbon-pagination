<?php
/**
 * The Carbon Pagination number links item class.
 * Responsible for the "1, 2, 3, ..., 10, 20, 30" pagination item.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Number_Links extends Carbon_Pagination_Item {

	/**
	 * Initialize the item.
	 * Generate the sub items (fragments) of this item.
	 *
	 * @access public
	 */
	public function init() {
		$collection = $this->get_collection();
		$pagination = $collection->get_pagination();

		// initialize fragments collection
		$fragments_collection = new Carbon_Pagination_Collection($pagination, false);
		$this->set_fragments_collection($fragments_collection);

		// get various pagination variables that we need
		$pages = $pagination->get_pages();
		$current_page = $pagination->get_current_page();
		$current_page_idx = array_search($current_page, $pages);
		$total_pages = $pagination->get_total_pages();
		$number_limit = $pagination->get_number_limit();
		$large_page_number_limit = $pagination->get_large_page_number_limit();
		$large_page_number_interval = $pagination->get_large_page_number_interval();

		// generate large numbers - before
		if ($large_page_number_limit > 0) {
			$from = $large_page_number_interval - 1;
			$to = $current_page_idx - $number_limit;
			$this->generate_pages($from, $to, $large_page_number_interval, $large_page_number_limit);
		}

		// generate page numbers
		if ($number_limit >= 0) {
			$from = max(0, $current_page_idx - $number_limit);
			$to = min($total_pages, $current_page_idx + $number_limit + 1);
		} else {
			$from = 0;
			$to = $total_pages;
		}
		$this->generate_pages($from, $to);

		// generate large numbers - after
		if ($large_page_number_limit > 0) {
			$from_raw = ($current_page_idx + $number_limit + 1);
			$from = ceil($from_raw / $large_page_number_interval) * $large_page_number_interval - 1;
			if ($from == $current_page_idx + 1) {
				$from += $large_page_number_interval;
			}

			$to = $total_pages - 1;

			$this->generate_pages($from, $to, $large_page_number_interval, $large_page_number_limit, true);
		}

		// generate & add limiters
		$this->generate_limiters();

		// generate & add wrappers
		$this->generate_wrappers();
	}

	/**
	 * Generate number pages (fragments) in a certain range.
	 *
	 * @access public
	 *
	 * @param int $from Index of the first page.
	 * @param int $to Index of the last page.
	 * @param int $limit Number of pages to create.
	 * @param bool $from_end Whether to start from the end.
	 */
	public function generate_pages($from, $to, $interval = 1, $limit = 0, $from_end = false) {
		// get various pagination variables that we need
		$collection = $this->get_collection();
		$new_fragments = array();

		// generate items for the current range, using the specified interval
		for($i = $from; $i < $to; $i += $interval) {
			$page_item = new Carbon_Pagination_Item_Page( $collection );
			$page_item->set_page_number( $i );
			$new_fragments[] = $page_item;
		}

		// limit items if necessary
		if ($limit) {
			$start = $from_end ? -1 * $limit : 0;
			$new_fragments = array_slice($new_fragments, $start, $limit);
		}

		// update the fragments collection with the new items
		$fragments_collection = $this->get_fragments_collection();
		$fragments_collection->add_items( $new_fragments );
	}

	/**
	 * Generate and add limiters where necessary.
	 *
	 * @access public
	 */
	public function generate_limiters() {
		// get various pagination variables that we need
		$collection = $this->get_collection();
		$pagination = $collection->get_pagination();
		$fragments_collection = $this->get_fragments_collection();
		$fragments = $fragments_collection->get_items();
		$large_page_number_interval = $pagination->get_large_page_number_interval();

		// generate a prototype limiter item
		$limiter_item = new Carbon_Pagination_Item_Limiter( $collection );

		// insert limiters before & after the page numbers
		for($i = count($fragments) - 1; $i > 0; $i--) {
			$prev = $fragments[$i - 1]->get_page_number();
			$current = $fragments[$i]->get_page_number();
			if ($current > $prev + 1 && $current - $prev != $large_page_number_interval) {
				$fragments_collection->insert_item_at(clone $limiter_item, $i);
			}
		}

		// get the updated set of fragments
		$fragments = $fragments_collection->get_items();

	}

	/**
	 * Generate and add wrappers.
	 *
	 * @access public
	 */
	public function generate_wrappers() {
		// get various pagination variables that we need
		$collection = $this->get_collection();
		$pagination = $collection->get_pagination();
		$fragments_collection = $this->get_fragments_collection();
		$total_fragments = count($fragments_collection->get_items());

		// if there is at least one fragment in the collection
		if ( $total_fragments ) {
			// insert wrapper before the fragments
			$wrapper_before = new Carbon_Pagination_Item_HTML( $collection );
			$wrapper_before->set_html( $pagination->get_numbers_wrapper_before() );
			$fragments_collection->insert_item_at($wrapper_before, 0);

			// insert wrapper after the fragments
			$wrapper_after = new Carbon_Pagination_Item_HTML( $collection );
			$wrapper_after->set_html( $pagination->get_numbers_wrapper_after() );
			$fragments_collection->insert_item_at($wrapper_after, $total_fragments + 1);
		}
	}
}