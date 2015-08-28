<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetNumbersWrapperBeforeTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_numbers_wrapper_before
	 * @covers Carbon_Pagination::set_numbers_wrapper_before
	 */
	public function testGetSetNumbersWrapperAfter() {
		$html = '<div class="foo-pagination-numbers">';
		$this->pagination->set_numbers_wrapper_before( $html );
		$this->assertSame( $html, $this->pagination->get_numbers_wrapper_before() );
	}

}