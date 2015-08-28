<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetWrapperAfterTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_wrapper_after
	 * @covers Carbon_Pagination::set_wrapper_after
	 */
	public function testGetSetWrapperAfter() {
		$html = '<span class="foo"></span></div>';
		$this->pagination->set_wrapper_after( $html );
		$this->assertSame( $html, $this->pagination->get_wrapper_after() );
	}

}