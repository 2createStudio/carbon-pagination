<?php
/**
 * The Carbon Pagination renderer class.
 * Handles rendering of the pagination.
 */
class Carbon_Pagination_Renderer {

	/**
	 * @var Carbon_Pagination_Collection
	 * 
	 * The pagination collection object.
	 */
	protected $collection;

	/**
	 * Constructor.
	 * Creates and configures a new pagination renderer for the provided pagination collection.
	 *
	 * @param Carbon_Pagination_Collection $collection Pagination collection object.
	 */
	public function __construct( Carbon_Pagination_Collection $collection ) {
		$this->set_collection( $collection );
	}

	/**
	 * Retrieve the collection object.
	 *
	 * @return Carbon_Pagination_Collection $collection The collection object.
	 */
	public function get_collection() {
		return $this->collection;
	}

	/**
	 * Modify the collection object.
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
	 * @param string $string The unparsed string.
	 * @param array $tokens An array of tokens and their values.
	 * @return string $string The parsed string.
	 */
	public function parse_tokens( $string, $tokens = array() ) {
		foreach ( $tokens as $find => $replace ) {
			$string = str_replace( '{' . $find . '}', $replace, $string );
		}

		return $string;
	}

	/**
	 * Prepare the items for rendering.
	 * If no items are specified, fetches the ones from the collection.
	 * Filters out incorrect items.
	 *
	 * @return array $ready_items The prepared items.
	 */
	public function prepare_items( $items = array() ) {
		// if no items are specified, use the ones from the collection
		if ( empty( $items ) ) {
			$items = $this->get_collection()->get_items();
		}

		$ready_items = array();

		// allow only Carbon_Pagination_Item instances here
		foreach ( $items as $item ) {
			if ( $item instanceof Carbon_Pagination_Item ) {
				$ready_items[] = $item;
			}
		}

		return $ready_items;
	}

	/**
	 * Render the current collection items.
	 * Each item can have sub items, which are rendered recursively.
	 *
	 * @param array $items Items to render. If not specified, will render the collection items.
	 * @param bool $echo Whether to display or return the output. True will display, false will return.
	 */
	public function render( $items = array(), $echo = true ) {
		// allow developers to filter the items before rendering
		$items = apply_filters( 'carbon_pagination_items_before_render', $items, $this );
		$items = $this->prepare_items( $items );

		// loop through all items and get their output
		$output = $this->render_items( $items );

		// allow developers to filter the output before it is rendered
		$output = apply_filters( 'carbon_pagination_renderer_output', $output, $this );

		if ( ! $echo ) {
			return $output;
		}

		echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
	}

	/**
	 * Render a set of pagination items, recursively.
	 *
	 * @param array $items Items to render.
	 * @return string $output The HTML output of all items.
	 */
	public function render_items( $items ) {
		$output = '';

		// loop through items
		foreach ( $items as $item ) {
			$subitems_collection = $item->get_subitems_collection();
			if ( $subitems_collection && $items = $subitems_collection->get_items() ) {
				// loop the subitem collection items
				$output .= $this->render_items( $items );
			} else {
				// add item HTML to output
				$output .= $this->render_item( $item );
			}
		}

		return $output;
	}

	/**
	 * Setup, parse tokens & render a specific item.
	 *
	 * @param Carbon_Pagination_Item $item Item to render.
	 * @return string $output The HTML of the item.
	 */
	public function render_item( Carbon_Pagination_Item $item ) {
		// allow item to be modified before setup
		do_action( 'carbon_pagination_before_setup_item', $item );

		// setup the item
		$item->setup();

		// allow item to be modified after setup
		do_action( 'carbon_pagination_after_setup_item', $item );

		// render the item
		$html = $this->parse_tokens( $item->render(), $item->get_tokens() );

		// allow item HTML to be filtered
		$html = apply_filters( 'carbon_pagination_render_item_html', $html, $item );

		return $html;
	}

}