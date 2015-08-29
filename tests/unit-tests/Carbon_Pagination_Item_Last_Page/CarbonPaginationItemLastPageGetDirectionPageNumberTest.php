<?php
/**
 * @group item
 * @group item_direction_page
 * @group item_direction_page_forward
 * @group item_direction_page
 * @group item_last_page
 */
class CarbonPaginationItemLastPageGetDirectionPageNumberTest extends WP_UnitTestCase {

	public function setUp() {
		$mock_methods = array( 'get_total_pages' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Last_Page', null, $params);
		$this->item = $itemStub;

		$this->total_pages = 10;
		$this->pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( $this->total_pages ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Last_Page::get_direction_page_number
	 */
	public function testGetDirectionPageNumber() {
		$this->assertSame( $this->total_pages - 1, $this->item->get_direction_page_number() );
	}

}