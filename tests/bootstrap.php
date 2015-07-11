<?php
/**
 * WooCommerce Unit Tests Bootstrap
 *
 * @since 2.2
 */
class Carbon_Pagination_Tests_Bootstrap {

	/** 
	 * The bootstrap instance.
	 *
	 * @var Carbon_Pagination_Tests_Bootstrap
	 */
	protected static $instance = null;

	/** 
	 * Directory where wordpress-tests-lib is installed
	 *
	 * @var string
	 */
	public $wp_tests_dir;

	/** 
	 * Testing directory.
	 *
	 * @var string
	 */
	public $tests_dir;

	/** 
	 * Plugin directory.
	 *
	 * @var string
	 */
	public $plugin_dir;

	/**
	 * Setup the unit testing environment
	 */
	private function __construct() {

		ini_set( 'display_errors','on' );
		error_reporting( E_ALL );

		$this->tests_dir    = dirname( __FILE__ );
		$this->plugin_dir   = dirname( $this->tests_dir );
		$this->wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : $this->plugin_dir . '/tmp/wordpress-tests-lib';

		// load test function so tests_add_filter() is available
		require_once( $this->wp_tests_dir . '/includes/functions.php' );

		// load plugin
		tests_add_filter( 'muplugins_loaded', array( $this, 'load_plugin' ) );

		// load the WP testing environment
		require_once( $this->wp_tests_dir . '/includes/bootstrap.php' );
	}

	/**
	 * Load the plugin
	 */
	public function load_plugin() {
		require_once( $this->plugin_dir . '/carbon-pagination.php' );
	}

	/**
	 * Get the single tests boostrap instance
	 *
	 * @return Carbon_Pagination_Tests_Bootstrap
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Carbon_Pagination_Tests_Bootstrap::instance();