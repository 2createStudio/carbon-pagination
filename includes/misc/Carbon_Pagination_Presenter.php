<?php
/**
 * The Carbon Pagination presenter.
 * Handles rendering and displaying of a particular pagination.
 *
 * @abstract
 */
class Carbon_Pagination_Presenter {

	/**
	 * @var Carbon_Pagination
	 * 
	 * The pagination object.
	 */
	protected $pagination;

	/**
	 * Constructor.
	 *
	 * Sets the pagination that will be displayed or rendered.
	 *
	 * @param Carbon_Pagination_HTML $pagination Pagination object that will be displayed.
	 */
	public function __construct( Carbon_Pagination_HTML $pagination ) {
		$this->set_pagination( $pagination );
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
	 * @param Carbon_Pagination_HTML $pagination The pagination object.
	 */
	public function set_pagination( $pagination ) {
		$this->pagination = $pagination;
	}

	/**
	 * Verify if the pagination is ready for presentation.
	 *
	 * @return bool|WP_Error $result True if everything is fine, false or WP_Error on failure.
	 */
	public function verify_pagination() {
		// handle unexisting pagination collection classes
		if ( ! class_exists( $this->get_pagination()->get_collection() ) ) {
			return new WP_Error( 'carbon_pagination_unexisting_pagination_collection', __( 'Unexisting pagination collection class.', 'carbon_pagination' ) );
		}

		// handle unexisting pagination renderer classes
		if ( ! class_exists( $this->get_pagination()->get_renderer() ) ) {
			return new WP_Error( 'carbon_pagination_unexisting_pagination_renderer', __( 'Unexisting pagination renderer class.', 'carbon_pagination' ) );
		}

		// if there are less than 2 pages, nothing will be shown
		if ( $this->get_pagination()->get_total_pages() <= 1 ) {
			return false;
		}

		return true;
	}

	/**
	 * Render the pagination.
	 *
	 * @return string $output The output of the pagination, or WP_Error on failure.
	 */
	public function render() {
		// get pagination and the collection & renderer class names
		$pagination = $this->get_pagination();
		$collection_classname = $pagination->get_collection();
		$renderer_classname = $pagination->get_renderer();

		// handle unexisting pagination collection classes
		if ( ! $this->verify_pagination() ) {
			return '';
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