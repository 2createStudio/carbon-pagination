<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetLimiterHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_limiter_html
	 * @covers Carbon_Pagination::set_limiter_html
	 */
	public function testGetSetLimiterHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_limiter_html( $html );
		$this->assertSame( $html, $this->pagination->get_limiter_html() );
	}

}