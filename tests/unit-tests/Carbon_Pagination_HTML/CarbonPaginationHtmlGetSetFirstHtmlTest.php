<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlGetSetFirstHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_first_html
	 * @covers Carbon_Pagination_HTML::set_first_html
	 */
	public function testGetSetFirstHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_first_html( $html );
		$this->assertSame( $html, $this->pagination->get_first_html() );
	}

}