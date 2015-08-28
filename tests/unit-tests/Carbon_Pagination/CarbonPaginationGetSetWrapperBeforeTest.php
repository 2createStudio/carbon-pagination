<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetWrapperBeforeTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_wrapper_before
	 * @covers Carbon_Pagination::set_wrapper_before
	 */
	public function testGetSetWrapperBefore() {
		$html = '<div class="foo-pagination">';
		$this->pagination->set_wrapper_before( $html );
		$this->assertSame( $html, $this->pagination->get_wrapper_before() );
	}

}