<?php
/**
 * The Carbon Pagination presenter.
 * Handles rendering and displaying of a particular pagination.
 *
 * @abstract
 */
class Carbon_Pagination_Presenter {

	/**
	 * The pagination object.
	 * @var Carbon_Pagination
	 */
	protected $pagination;

	/**
	 * Constructor.
	 *
	 * Sets the pagination that will be displayed or rendered.
	 *
	 * @access public
	 * @param Carbon_Pagination $pagination Pagination object that will be displayed.
	 */
	public function __construct( Carbon_Pagination $pagination ) {
		$this->set_pagination( $pagination );
	}

	/**
	 * Retrieve the pagination object.
	 *
	 * @access public
	 * @return Carbon_Pagination $pagination The pagination object.
	 */
	public function get_pagination() {
		return $this->pagination;
	}

	/**
	 * Modify the pagination object.
	 *
	 * @access public
	 * @param Carbon_Pagination $pagination The pagination object.
	 */
	public function set_pagination( $pagination ) {
		$this->pagination = $pagination;
	}

	/**
	 * Render the pagination.
	 *
	 * @access public
	 * @return string|WP_Error $output The output of the pagination, or WP_Error on failure.
	 */
	public function render() {
		// get pagination and the collection & renderer class names
		$pagination = $this->get_pagination();
		$collection_classname = $pagination->get_collection();
		$renderer_classname = $pagination->get_renderer();

		// handle unexisting pagination collection classes
		if ( ! class_exists( $collection_classname ) ) {
			return new WP_Error( 'carbon_pagination_unexisting_pagination_collection', __( 'Unexisting pagination collection class.', 'carbon_pagination' ) );
		}

		// handle unexisting pagination renderer classes
		if ( ! class_exists( $renderer_classname ) ) {
			return new WP_Error( 'carbon_pagination_unexisting_pagination_renderer', __( 'Unexisting pagination renderer class.', 'carbon_pagination' ) );
		}

		// initialize & generate pagination item collection
		$collection = new $collection_classname( $pagination );

		// render the pagination item collection
		$renderer = new $renderer_classname( $collection );
		$output = $renderer->render( array(), false );

		return $output;
	}

	/**
	 * Build, configure and display a new pagination.
	 *
	 * @static
	 * @access public
	 * @param string $pagination The pagination type, can be one of the following:
	 *    - Posts
	 *    - Post
	 *    - Comments
	 *    - Custom
	 * @param array $args Configuration options to modify the pagination settings.
	 * @param bool $echo Whether to display or return the output. True will display, false will return.
	 * @see Carbon_Pagination::__construct()
	 */
	public static function display( $pagination, $args = array(), $echo = true ) {
		$pagination_classname = 'Carbon_Pagination_' . $pagination;

		// handle unexisting pagination types
		if ( ! class_exists( $pagination_classname ) ) {
			return new WP_Error( 'carbon_pagination_unexisting_pagination_type', __( 'Unexisting pagination type class.', 'carbon_pagination' ) );
		}

		// initialize pagination
		$pagination = new $pagination_classname( $args );
		$presenter = new self( $pagination );
		$output = $presenter->render();

		if ( ! $echo ) {
			return $output;
		}

		echo wp_kses( $output, wp_kses_allowed_html( 'post' ) );
	}

}