<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlGetSetNumberHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_number_html
	 * @covers Carbon_Pagination_HTML::set_number_html
	 */
	public function testGetSetNumberHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_number_html( $html );
		$this->assertSame( $html, $this->pagination->get_number_html() );
	}

}