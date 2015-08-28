<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetNumbersWrapperAfterTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_numbers_wrapper_after
	 * @covers Carbon_Pagination::set_numbers_wrapper_after
	 */
	public function testGetSetNumbersWrapperAfter() {
		$html = '<span class="foo"></span></div>';
		$this->pagination->set_numbers_wrapper_after( $html );
		$this->assertSame( $html, $this->pagination->get_numbers_wrapper_after() );
	}

}