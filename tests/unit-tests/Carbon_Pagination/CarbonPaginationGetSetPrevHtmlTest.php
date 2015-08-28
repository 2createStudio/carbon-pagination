<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetPrevHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_prev_html
	 * @covers Carbon_Pagination::set_prev_html
	 */
	public function testGetSetPrevHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_prev_html( $html );
		$this->assertSame( $html, $this->pagination->get_prev_html() );
	}

}