<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationGetSetWrapperBeforeTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_wrapper_before
	 * @covers Carbon_Pagination_HTML::set_wrapper_before
	 */
	public function testGetSetWrapperBefore() {
		$html = '<div class="foo-pagination">';
		$this->pagination->set_wrapper_before( $html );
		$this->assertSame( $html, $this->pagination->get_wrapper_before() );
	}

}