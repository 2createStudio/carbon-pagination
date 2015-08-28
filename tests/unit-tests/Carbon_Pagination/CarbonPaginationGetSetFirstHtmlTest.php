<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetFirstHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_first_html
	 * @covers Carbon_Pagination::set_first_html
	 */
	public function testGetSetFirstHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_first_html( $html );
		$this->assertSame( $html, $this->pagination->get_first_html() );
	}

}