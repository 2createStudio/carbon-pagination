<?php
/**
 * The Carbon Pagination previous page item class.
 *
 * @uses Carbon_Pagination_Item
 */
class Carbon_Pagination_Item_Page extends Carbon_Pagination_Item {

	/**
	 * @var int
	 * 
	 * The page number index.
	 */
	protected $page_number = 0;

	/**
	 * @var string
	 * 
	 * The HTML of the item.
	 */
	protected $html = '';

	/**
	 * Setup the item before rendering.
	 * Setup item tokens.
	 */
	public function setup() {
		$pagination = $this->get_collection()->get_pagination();

		// get various pagination stuff
		$page_number = $this->get_page_number();

		// build the page link URL 
		$url = $pagination->get_page_url( $page_number, Carbon_Pagination_Utilities::get_current_url() );

		// parse tokens
		$tokens = array(
			'URL' => $url,
			'PAGE_NUMBER' => $page_number + 1,
		);
		
		$this->set_tokens( $tokens );
	}

	/**
	 * Render the item.
	 *
	 * @return string $link The HTML of the item.
	 */
	public function render() {
		$pagination = $this->get_collection()->get_pagination();
		$current_page_idx = $pagination->get_current_page() - 1;

		// if there is no text/HTML for the link, use the default one
		$html = $this->get_html();
		if ( ! $html ) {
			if ( $this->get_page_number() == $current_page_idx ) {
				$html = $pagination->get_current_number_html();
			} else {
				$html = $pagination->get_number_html();
			}
		}

		// allow the page link HTML to be filtered
		$html = apply_filters( 'carbon_pagination_page_link', $html, $this );

		return $html;
	}

	/**
	 * Retrieve the page index number.
	 *
	 * @return int $page_number The page index number.
	 */
	public function get_page_number() {
		return $this->page_number;
	}

	/**
	 * Modify the page index number.
	 *
	 * @param int $page_number The new page index number.
	 */
	public function set_page_number( $page_number ) {
		$this->page_number = $page_number;
	}

	/**
	 * Retrieve the page item HTML.
	 *
	 * @return string $html The page item HTML.
	 */
	public function get_html() {
		return $this->html;
	}

	/**
	 * Modify the page item HTML.
	 *
	 * @param string $html The new page item HTML.
	 */
	public function set_html( $html ) {
		$this->html = $html;
	}

	/**
	 * Create a new subitems collection with a single subitem
	 * for the specified collection with the specified HTML and page number.
	 *
	 * @static
	 * @param Carbon_Pagination_Collection $collection Collection of the original item.
	 * @param string $html HTML of the new subitem.
	 * @param int $page_number The number of the page to link the subitem to.
	 * @return Carbon_Pagination_Collection $subitems_collection The new subitems collection.
	 */
	public static function generate_single_subitem_collection( $collection, $html, $page_number ) {
		$page_item = new Carbon_Pagination_Item_Page( $collection );
		$page_item->set_html( $html );
		$page_item->set_page_number( $page_number );

		// create and assign the subitems collection
		$subitems_collection = new Carbon_Pagination_Collection( $collection->get_pagination(), false );
		$subitems_collection->set_items( array( $page_item ) );

		return $subitems_collection;
	}

}