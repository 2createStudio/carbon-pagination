<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlGetSetPrevHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_prev_html
	 * @covers Carbon_Pagination_HTML::set_prev_html
	 */
	public function testGetSetPrevHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_prev_html( $html );
		$this->assertSame( $html, $this->pagination->get_prev_html() );
	}

}