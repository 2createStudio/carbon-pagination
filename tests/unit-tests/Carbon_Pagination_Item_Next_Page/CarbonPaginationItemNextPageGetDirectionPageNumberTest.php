<?php
/**
 * @group item
 * @group item_direction_page
 * @group item_direction_page_forward
 * @group item_direction_page
 * @group item_next_page
 */
class CarbonPaginationItemNextPageGetDirectionPageNumberTest extends WP_UnitTestCase {

	public function setUp() {
		$mock_methods = array( 'get_current_page' );
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Next_Page', null, $params);
		$this->item = $itemStub;

		$this->current_page = 10;
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( $this->current_page ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Next_Page::get_direction_page_number
	 */
	public function testGetDirectionPageNumber() {
		$current_page_idx = $this->current_page - 1;
		$this->assertSame( $current_page_idx + 1, $this->item->get_direction_page_number() );
	}

}