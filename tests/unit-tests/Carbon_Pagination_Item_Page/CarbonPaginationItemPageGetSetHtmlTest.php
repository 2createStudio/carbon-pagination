<?php
/**
 * @group item
 * @group item_page
 */
class CarbonPaginationItemPageGetSetHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$this->item = $this->getMock('Carbon_Pagination_Item_Page', null, $params);
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::get_html
	 * @covers Carbon_Pagination_Item_Page::set_html
	 */
	public function testGetSetHtml() {
		$html = '<span class="foo">Bar</span>';
		$this->item->set_html( $html );
		$this->assertSame( $html, $this->item->get_html() );
	}

}