<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetCurrentNumberHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_current_number_html
	 * @covers Carbon_Pagination::set_current_number_html
	 */
	public function testGetSetCurrentNumberHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_current_number_html( $html );
		$this->assertSame( $html, $this->pagination->get_current_number_html() );
	}

}