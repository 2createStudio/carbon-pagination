<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetNextHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_next_html
	 * @covers Carbon_Pagination::set_next_html
	 */
	public function testGetSetNextHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_next_html( $html );
		$this->assertSame( $html, $this->pagination->get_next_html() );
	}

}