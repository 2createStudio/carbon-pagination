<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationGetSetLastHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_last_html
	 * @covers Carbon_Pagination_HTML::set_last_html
	 */
	public function testGetSetLastHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_last_html( $html );
		$this->assertSame( $html, $this->pagination->get_last_html() );
	}

}