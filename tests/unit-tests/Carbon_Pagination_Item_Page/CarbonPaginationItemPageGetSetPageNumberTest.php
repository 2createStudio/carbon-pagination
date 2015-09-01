<?php
/**
 * @group item
 * @group item_page
 */
class CarbonPaginationItemPageGetSetPageNumberTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
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
	 * @covers Carbon_Pagination_Item_Page::get_page_number
	 * @covers Carbon_Pagination_Item_Page::set_page_number
	 */
	public function testGetSetHtml() {
		$page_number = 123;
		$this->item->set_page_number( $page_number );
		$this->assertSame( $page_number, $this->item->get_page_number() );
	}

}