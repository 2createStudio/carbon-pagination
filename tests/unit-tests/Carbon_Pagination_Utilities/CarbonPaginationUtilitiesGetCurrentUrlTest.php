<?php
/**
 * @group utilities
 */
class CarbonPaginationUtilitiesGetCurrentUrlTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
		$_GET = array();
		parent::tearDown();
	}

	public function registerQueryVars($vars) {
		$vars[] = 'foo';
		return $vars;
	}

	public function testNoVars() {
		$this->go_to( '/' );
		$this->assertSame( home_url('/'), Carbon_Pagination_Utilities::get_current_url() );
	}

	public function testWithUnregisteredQueryVarsWithoutGET() {
		$this->go_to( '/?foo=bar' );
		$this->assertSame( home_url('/'), Carbon_Pagination_Utilities::get_current_url() );
	}

	public function testWithRegisteredQueryVars() {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );

		$this->go_to( '/?p=5' );
		$this->assertSame( home_url('/'), Carbon_Pagination_Utilities::get_current_url() );

		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '' );

		$this->go_to( '/?p=5' );
		$this->assertSame( home_url('/?p=5'), Carbon_Pagination_Utilities::get_current_url() );
	}

	public function testWithoutQueryVarsWithGET() {
		$this->go_to( '/?foo=bar' );
		$_GET = array( 'foo' => 'bar' );
		$this->assertSame( home_url('/'), Carbon_Pagination_Utilities::get_current_url() );
	}

	public function testWithRegisteredQueryVarsWithGET() {
		$this->go_to( '/?p=5' );
		$_GET = array( 'p' => '5' );
		$this->assertSame( home_url('/?p=5'), Carbon_Pagination_Utilities::get_current_url() );
	}

	public function testWithCustomQueryVarsWithGET() {
		add_filter('query_vars', array($this, 'registerQueryVars'));

		$this->go_to( '/?foo=bar' );
		$_GET = array( 'foo' => 'bar' );
		$this->assertSame( home_url('/?foo=bar'), Carbon_Pagination_Utilities::get_current_url() );

		remove_filter('query_vars', array($this, 'registerQueryVars'));
	}

	public function testWithMixedQueryVarsWithGET() {
		add_filter('query_vars', array($this, 'registerQueryVars'));

		$this->go_to( '/?foo=bar&p=5' );
		$_GET = array( 
			'p' => 5,
			'foo' => 'bar',
			'bar' => 'foo',
		);
		$this->assertSame( home_url('/?p=5&foo=bar'), Carbon_Pagination_Utilities::get_current_url() );

		remove_filter('query_vars', array($this, 'registerQueryVars'));
	}

}