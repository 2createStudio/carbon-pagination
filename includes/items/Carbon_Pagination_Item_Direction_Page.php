<?php
/**
 * The Carbon Pagination direction page item class.
 * Used for prev, next, first & last items.
 * Should be extended by each one of them.
 *
 * @abstract
 *
 * @uses Carbon_Pagination_Item
 */
abstract class Carbon_Pagination_Item_Direction_Page extends Carbon_Pagination_Item {

	/**
	 * Initialize the item.
	 * Generate the sub items of this item.
	 */
	public function init() {
		$collection = $this->get_collection();

		// bail if this direction is disabled
		if ( $this->get_direction_disabled() ) {
			return;
		}

		// create subitem and its collection and assign it
		$html = $this->get_direction_html();
		$page = $this->get_direction_page_number();
		$subitems_collection = Carbon_Pagination_Item_Page::generate_single_subitem_collection( $collection, $html, $page );
		$this->set_subitems_collection( $subitems_collection );
	}

	/**
	 * The HTML of the direction item.
	 *
	 * @abstract
	 * @return string $html The direction item HTML.
	 */
	abstract public function get_direction_html();
	
	/**
	 * The result of the condition which would disable this item.
	 * If true, this item wont be displayed.
	 *
	 * @abstract
	 * @return bool $result The condition result.
	 */
	abstract public function get_direction_disabled();

	/**
	 * The number of the page to link to.
	 *
	 * @abstract
	 * @return int $page The number of the page to link to.
	 */
	abstract public function get_direction_page_number();

}