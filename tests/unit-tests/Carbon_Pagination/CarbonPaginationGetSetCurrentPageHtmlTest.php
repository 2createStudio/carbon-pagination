<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetCurrentPageHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_current_page_html
	 * @covers Carbon_Pagination::set_current_page_html
	 */
	public function testGetSetCurrentPageHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_current_page_html( $html );
		$this->assertSame( $html, $this->pagination->get_current_page_html() );
	}

}