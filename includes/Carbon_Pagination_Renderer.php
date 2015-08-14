<?php
/**
 * The Carbon Pagination renderer class.
 * Handles rendering of the pagination.
 */
class Carbon_Pagination_Renderer {

	/**
	 * The pagination collection object.
	 *
	 * @access protected
	 *
	 * @var Carbon_Pagination_Collection
	 */
	protected $collection;

	/**
	 * Constructor.
	 *
	 * Creates and configures a new pagination renderer for the provided pagination collection.
	 *
	 * @access public
	 *
	 * @param Carbon_Pagination_Collection $collection Pagination collection object.
	 */
	public function __construct( Carbon_Pagination_Collection $collection ) {
		$this->set_collection( $collection );
	}

	/**
	 * Retrieve the collection object.
	 *
	 * @access public
	 *
	 * @return Carbon_Pagination_Collection $collection The collection object.
	 */
	public function get_collection() {
		return $this->collection;
	}

	/**
	 * Modify the collection object.
	 *
	 * @access public
	 *
	 * @param Carbon_Pagination_Collection $collection The new collection object.
	 */
	public function set_collection( Carbon_Pagination_Collection $collection ) {
		$this->collection = $collection;
	}

	/**
	 * Parse all tokens within a string.
	 * 
	 * Tokens should be passed in the array in the following way:
	 * array( 'TOKENNAME' => 'tokenvalue' )
	 *
	 * Tokens should be used in the string in the following way:
	 * 'lorem {TOKENNAME} ipsum'
	 *
	 * @access public
	 *
	 * @param string $string The unparsed string.
	 * @param array $tokens An array of tokens and their values.
	 * @return string $string The parsed string.
	 */
	public function parse_tokens( $string, $tokens = array() ) {
		foreach ($tokens as $find => $replace) {
			$string = str_replace('{' . $find . '}', $replace, $string);
		}

		return $string;
	}

	/**
	 * Render the current collection items.
	 * Each item can have sub items, which are rendered recursively.
	 *
	 * @access public
	 *
	 * @param array $items Items to render. If not specified, will render the collection items.
	 * @param bool $echo Whether to display or return the output. True will display, false will return.
	 */
	public function render( $items = array(), $echo = true ) {
		// if no items are specified, use the ones from the collection
		if ( empty( $items ) ) {
			$items = $this->get_collection()->get_items();
		}

		$output = '';

		// loop through items
		foreach ($items as $item) {
			// allow only Carbon_Pagination_Item instances here
			if ( !( $item instanceof Carbon_Pagination_Item ) ) {
				continue;
			}

			$subitems_collection = $item->get_subitems_collection();
			if ($subitems_collection && $items = $subitems_collection->get_items()) {
				// loop the subitem collection items
				$output .= $this->render( $items, false );
			} else {
				// setup the item
				$item->setup();

				// render the item
				$html = $this->parse_tokens( $item->render(), $item->get_tokens() );

				// add item HTML to output
				$output .= $html;
			}
		}

		if (!$echo) {
			return $output;
		}

		echo $output;
	}

}