<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetLastHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_last_html
	 * @covers Carbon_Pagination::set_last_html
	 */
	public function testGetSetLastHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_last_html( $html );
		$this->assertSame( $html, $this->pagination->get_last_html() );
	}

}