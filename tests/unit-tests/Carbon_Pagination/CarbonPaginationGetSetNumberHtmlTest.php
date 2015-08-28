<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetNumberHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_number_html
	 * @covers Carbon_Pagination::set_number_html
	 */
	public function testGetSetNumberHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_number_html( $html );
		$this->assertSame( $html, $this->pagination->get_number_html() );
	}

}