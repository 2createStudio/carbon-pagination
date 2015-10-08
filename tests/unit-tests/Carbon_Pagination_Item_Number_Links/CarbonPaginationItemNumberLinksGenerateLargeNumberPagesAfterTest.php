<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGenerateLargeNumberPagesAfterTest extends WP_UnitTestCase {

	public function setUp() {
		// mock pagination
		$mock_methods = array(
			'get_number_limit',
			'get_total_pages',
			'get_current_page',
			'get_large_page_number_limit', 
			'get_large_page_number_interval'
		);
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML', array(), '', TRUE, TRUE, TRUE, $mock_methods);
		$this->pagination = $paginationStub;

		// mock collection
		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		// mock item
		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params, '', false);
		$this->item = $itemStub;
		$this->item->set_collection($this->collection);

		// setup item's subitems collection manually
		$params = array( $this->pagination, false );
		$this->subitems_collection = $this->getMock('Carbon_Pagination_Collection', null, $params );
		$this->item->set_subitems_collection( $this->subitems_collection );

		// mock total number of pages is always the same - 50
		$this->pagination->expects( $this->any() )
			->method( 'get_total_pages' )
			->will( $this->returnValue( 50 ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
		unset($this->subitems_collection);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithNoPages() {
		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( array(), $items );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithDisabledLargePageNumbers() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 25 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 0 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( array(), $items );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithLargeCurrentPage() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 49 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( array(), $items );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithMediumCurrentPageAndOneLargeItem() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 40 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithMediumCurrentPageAndTwoLargeItems() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 40 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithTooCloseCurrentPageAndTwoLargeItems() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 39 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithNotTooCloseCurrentPageAndTwoLargeItems() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 38 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 2, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[1] );
		$this->assertSame( 39, $items[0]->get_page_number() );
		$this->assertSame( 49, $items[1]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithSmallCurrentPageAndOneLargeItem() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 5 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithSmallCurrentPageAndTwoLargeItems() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 1 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 5 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 2, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[1] );
		$this->assertSame( 39, $items[0]->get_page_number() );
		$this->assertSame( 49, $items[1]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithTooCloseCurrentPageAndTwoLargeItemsAndLargerNumberLimit() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 39 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithYetTooCloseCurrentPageAndTwoLargeItemsAndLargerNumberLimit() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 38 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithNotTooCloseCurrentPageAndTwoLargeItemsAndLargerNumberLimit() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 37 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 10 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 2, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[1] );
		$this->assertSame( 39, $items[0]->get_page_number() );
		$this->assertSame( 49, $items[1]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithTooCloseCurrentPageAndTwoLargeItemsAndSmallerInterval() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 44 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 5 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithYetTooCloseCurrentPageAndTwoLargeItemsAndSmallerInterval() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 43 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 5 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 1, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 49, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_large_number_pages_after
	 */
	public function testWithNotTooCloseCurrentPageAndTwoLargeItemsAndSmallerInterval() {
		$this->pagination->expects( $this->any() )
			->method( 'get_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_current_page' )
			->will( $this->returnValue( 42 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_limit' )
			->will( $this->returnValue( 2 ) );
		$this->pagination->expects( $this->any() )
			->method( 'get_large_page_number_interval' )
			->will( $this->returnValue( 5 ) );

		$this->item->generate_large_number_pages_after();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertCount( 2, $items );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[1] );
		$this->assertSame( 44, $items[0]->get_page_number() );
		$this->assertSame( 49, $items[1]->get_page_number() );
	}

}