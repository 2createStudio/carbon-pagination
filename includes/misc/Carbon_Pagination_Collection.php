<?php
/**
 * The Carbon Pagination item collection class.
 * Contains and manages the pagination items.
 * Can generate the items based on the pagination settings.
 */
class Carbon_Pagination_Collection {

	/**
	 * @var array
	 * 
	 * Pagination items.
	 */
	protected $items = array();

	/**
	 * @var Carbon_Pagination_HTML
	 * 
	 * The pagination object.
	 */
	protected $pagination;

	/**
	 * Constructor.
	 * Creates and configures a new pagination collection for the provided pagination.
	 *
	 * @param Carbon_Pagination_HTML $pagination Pagination object.
	 * @param bool $autogenerate Whether to automatically generate pagination items.
	 */
	public function __construct( Carbon_Pagination_HTML $pagination, $autogenerate = true ) {
		$this->set_pagination( $pagination );

		// whether to auto generate pagination items
		$autogenerate = apply_filters( 'carbon_pagination_autogenerate_collection_items', $autogenerate, $this );
		if ( $autogenerate ) {
			$this->generate();
		}
	}

	/**
	 * Generate the pagination items and wrappers.
	 */
	public function generate() {
		$this->generate_items();
		$this->generate_wrappers();

		// allow developers to modify the collection items after it was generated
		do_action( 'carbon_pagination_collection_after_generate', $this );
	}

	/**
	 * Retrieve the item prototypes for the collection.
	 * These represent the classes of all items that will be generated and their
	 * corresponding pagination methods that determine their availability.
	 */
	public function get_item_prototypes() {
		// condition method => item class
		$item_classes = array(
			'get_enable_current_page_text' => 'Carbon_Pagination_Item_Current_Page_Text',
			'get_enable_first' => 'Carbon_Pagination_Item_First_Page',
			'get_enable_prev' => 'Carbon_Pagination_Item_Previous_Page',
			'get_enable_numbers' => 'Carbon_Pagination_Item_Number_Links',
			'get_enable_next' => 'Carbon_Pagination_Item_Next_Page',
			'get_enable_last' => 'Carbon_Pagination_Item_Last_Page',
		);

		// allow default methods => items to be filtered
		return apply_filters( 'carbon_pagination_default_collection_items', $item_classes, $this );
	}

	/**
	 * Generate the pagination items.
	 */
	public function generate_items() {
		$pagination = $this->get_pagination();
		$items = array();

		// allow default methods => items to be filtered
		$item_classes = $this->get_item_prototypes();

		// if item is enabled, generate it
		foreach ( $item_classes as $method => $classname ) {
			if ( call_user_func( array( $pagination, $method ) ) ) {
				$items[] = new $classname($this);
			}
		}

		$this->set_items( $items );
	}

	/**
	 * Generate the pagination wrappers.
	 */
	public function generate_wrappers() {
		$pagination = $this->get_pagination();
		$items = $this->get_items();

		if ( ! empty( $items ) ) {
			// insert wrapper before the items
			$wrapper_before = new Carbon_Pagination_Item_HTML( $this );
			$wrapper_before->set_html( $pagination->get_wrapper_before() );
			$this->insert_item_at( $wrapper_before, 0 );

			// insert wrapper after the items
			$wrapper_after = new Carbon_Pagination_Item_HTML( $this );
			$wrapper_after->set_html( $pagination->get_wrapper_after() );
			$this->insert_item_at( $wrapper_after, count( $items ) + 1 );
		}
	}

	/**
	 * Retrieve the pagination object.
	 *
	 * @return Carbon_Pagination_HTML $pagination The pagination object.
	 */
	public function get_pagination() {
		return $this->pagination;
	}

	/**
	 * Modify the pagination object.
	 *
	 * @param Carbon_Pagination_HTML $pagination The new pagination object.
	 */
	public function set_pagination( Carbon_Pagination_HTML $pagination ) {
		$this->pagination = $pagination;
	}

	/**
	 * Retrieve the pagination items in the collection.
	 *
	 * @return array $items The pagination items, contained in the collection.
	 */
	public function get_items() {
		return $this->items;
	}

	/**
	 * Modify the pagination items in the collection.
	 *
	 * @param array $items The new set of pagination items.
	 */
	public function set_items( $items = array() ) {
		$this->items = $items;
	}

	/**
	 * Add item(s) to the collection.
	 * If $new_items is not an array, it will be treated as one item.
	 * If $new_items is an array, it will be treated as a set of items.
	 *
	 * @param mixed $new_items The set of pagination items to add.
	 */
	public function add_items( $new_items = array() ) {
		if ( ! is_array( $new_items ) ) {
			$new_items = array( $new_items );
		} else {
			$new_items = array_values( $new_items );
		}

		$items = $this->get_items();
		$items = array_merge( $items, $new_items );

		$this->set_items( $items );
	}

	/**
	 * Insert item(s) at a specified index in the collection.
	 * If the $item is an array, it will be treated as a set of items.
	 * If the $item is not an array, it will be treated as a single item.
	 *
	 * @param mixed $item The item(s) to insert.
	 * @param int $index The index to insert the item at.
	 */
	public function insert_item_at( $item, $index ) {
		$items = $this->get_items();
		if ( ! is_array( $item ) ) {
			$item = array( $item );
		}

		$before = array_slice( $items, 0, $index );
		$after = array_slice( $items, $index );
		$new_items = array_merge( $before, $item, $after );

		$this->set_items( $new_items );
	}

}