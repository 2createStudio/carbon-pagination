<?php
/**
 * @group item
 * @group item_html
 */
class CarbonPaginationItemHtmlGetSetHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$this->item = $this->getMock('Carbon_Pagination_Item_HTML', null, $params);
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item_HTML::get_html
	 * @covers Carbon_Pagination_Item_HTML::set_html
	 */
	public function testGetSetCollection() {
		$html = '<span class="foo">Bar</span>';
		$this->item->set_html( $html );
		$this->assertSame( $html, $this->item->get_html() );
	}

}