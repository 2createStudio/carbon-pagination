<?php
/**
 * @group item
 * @group item_direction_page
 * @group item_direction_page_backward
 * @group item_direction_page
 * @group item_first_page
 */
class CarbonPaginationItemFirstPageGetDirectionPageNumberTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination');
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_First_Page', null, $params);
		$this->item = $itemStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_First_Page::get_direction_page_number
	 */
	public function testGetDirectionPageNumber() {
		$this->assertSame( 0, $this->item->get_direction_page_number() );
	}

}