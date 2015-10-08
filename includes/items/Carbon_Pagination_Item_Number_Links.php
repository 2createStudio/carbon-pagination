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
	 * Generate the sub items of this item.
	 */
	public function init() {
		$pagination = $this->get_collection()->get_pagination();

		// initialize subitems collection
		$subitems_collection = new Carbon_Pagination_Collection( $pagination, false );
		$this->set_subitems_collection( $subitems_collection );

		// generate large numbers - before
		$this->generate_large_number_pages_before();

		// generate page numbers
		$this->generate_regular_number_pages();

		// generate large numbers - after
		$this->generate_large_number_pages_after();

		// generate & add limiters
		$this->generate_limiters();

		// generate & add wrappers
		$this->generate_wrappers();
	}

	/**
	 * Generate number pages (subitems) in a certain range,
	 * with a specified interval and within a specific limit.
	 * Can optionally generate the items starting from the end.
	 *
	 * @param int $from Index of the first page.
	 * @param int $to Index of the last page.
	 * @param int $interval Interval between pages.
	 * @param int $limit Number of pages to create.
	 * @param bool $from_end Whether to start from the end.
	 */
	public function generate_pages( $from, $to, $interval = 1, $limit = 0, $from_end = false ) {
		// generate items for the current range, using the specified interval
		$new_subitems = $this->generate_pages_with_interval( $from, $to, $interval );

		// limit items if necessary
		if ( $limit ) {
			$start = $from_end ? -1 * $limit : 0;
			$new_subitems = array_slice( $new_subitems, $start, $limit );
		}

		// update the subitems collection with the new items
		$subitems_collection = $this->get_subitems_collection();
		$subitems_collection->add_items( $new_subitems );
	}

	/**
	 * Generate number pages (subitems) in a certain range with a specified interval.
	 *
	 * @param int $from Index of the first page.
	 * @param int $to Index of the last page.
	 * @param int $interval Interval between pages.
	 * @return array $new_subitems Generated items.
	 */
	public function generate_pages_with_interval( $from, $to, $interval = 1 ) {
		$collection = $this->get_collection();
		$new_subitems = array();

		for ( $i = $from; $i < $to; $i += $interval ) {
			$page_item = new Carbon_Pagination_Item_Page( $collection );
			$page_item->set_page_number( $i );
			$new_subitems[] = $page_item;
		}

		return $new_subitems;
	}

	/**
	 * Generate the regular consecutive number pages.
	 */
	public function generate_regular_number_pages() {
		// get various pagination variables that we need
		$pagination = $this->get_collection()->get_pagination();
		$current_page_idx = $pagination->get_current_page() - 1;
		$number_limit = $pagination->get_number_limit();
		$total_pages = $pagination->get_total_pages();

		// determine the range and generate the pages
		if ( $number_limit >= 0 ) {
			$from = max( 0, $current_page_idx - $number_limit );
			$to = min( $total_pages, $current_page_idx + $number_limit + 1 );
		} else {
			$from = 0;
			$to = $total_pages;
		}
		$this->generate_pages( $from, $to );
	}

	/**
	 * Generate the large number page items - before the regular number pages.
	 */
	public function generate_large_number_pages_before() {
		// get various pagination variables that we need
		$pagination = $this->get_collection()->get_pagination();
		$current_page_idx = $pagination->get_current_page() - 1;
		$number_limit = $pagination->get_number_limit();
		$large_page_number_limit = $pagination->get_large_page_number_limit();
		$large_page_number_interval = $pagination->get_large_page_number_interval();

		// if enabled, determine the range and generate the pages
		if ( $large_page_number_limit > 0 ) {
			$from = $large_page_number_interval - 1;
			$to = $current_page_idx - $number_limit;
			$this->generate_pages( $from, $to, $large_page_number_interval, $large_page_number_limit );
		}
	}

	/**
	 * Generate the large number page items - after the regular number pages.
	 */
	public function generate_large_number_pages_after() {
		// get various pagination variables that we need
		$pagination = $this->get_collection()->get_pagination();
		$current_page_idx = $pagination->get_current_page() - 1;
		$total_pages = $pagination->get_total_pages();
		$number_limit = $pagination->get_number_limit();
		$large_page_number_limit = $pagination->get_large_page_number_limit();
		$large_page_number_interval = $pagination->get_large_page_number_interval();

		// if enabled, determine the range and generate the pages
		if ( $large_page_number_limit > 0 ) {
			$from_raw = $current_page_idx + $number_limit + 1;
			$from = intval( ceil( $from_raw / $large_page_number_interval ) ) * $large_page_number_interval - 1;
			if ( $from == $current_page_idx + $number_limit ) {
				$from += $large_page_number_interval;
			}

			$to = $total_pages;

			$this->generate_pages( $from, $to, $large_page_number_interval, $large_page_number_limit, true );
		}
	}

	/**
	 * Generate and add limiters where necessary.
	 */
	public function generate_limiters() {
		// get various pagination variables that we need
		$collection = $this->get_collection();
		$pagination = $collection->get_pagination();
		$subitems_collection = $this->get_subitems_collection();
		$subitems = $subitems_collection->get_items();
		$large_page_number_interval = $pagination->get_large_page_number_interval();

		// generate a prototype limiter item
		$limiter_item = new Carbon_Pagination_Item_Limiter( $collection );

		// insert limiters before & after the page numbers
		for ( $i = count( $subitems ) - 1; $i > 0; $i-- ) {
			$prev = $subitems[ $i - 1 ]->get_page_number();
			$current = $subitems[ $i ]->get_page_number();
			if ( $current > $prev + 1 && $current - $prev != $large_page_number_interval ) {
				$subitems_collection->insert_item_at( clone $limiter_item, $i );
			}
		}
	}

	/**
	 * Generate and add wrappers.
	 */
	public function generate_wrappers() {
		// get various pagination variables that we need
		$collection = $this->get_collection();
		$pagination = $collection->get_pagination();
		$subitems_collection = $this->get_subitems_collection();
		$total_subitems = count( $subitems_collection->get_items() );

		// if there is at least one subitem in the collection
		if ( $total_subitems ) {
			// insert wrapper before the subitems
			$wrapper_before = new Carbon_Pagination_Item_HTML( $collection );
			$wrapper_before->set_html( $pagination->get_numbers_wrapper_before() );
			$subitems_collection->insert_item_at( $wrapper_before, 0 );

			// insert wrapper after the subitems
			$wrapper_after = new Carbon_Pagination_Item_HTML( $collection );
			$wrapper_after->set_html( $pagination->get_numbers_wrapper_after() );
			$subitems_collection->insert_item_at( $wrapper_after, $total_subitems + 1 );
		}
	}
}