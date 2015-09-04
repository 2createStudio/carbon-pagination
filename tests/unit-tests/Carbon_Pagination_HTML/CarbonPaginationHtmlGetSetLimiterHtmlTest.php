<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlGetSetLimiterHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_limiter_html
	 * @covers Carbon_Pagination_HTML::set_limiter_html
	 */
	public function testGetSetLimiterHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_limiter_html( $html );
		$this->assertSame( $html, $this->pagination->get_limiter_html() );
	}

}