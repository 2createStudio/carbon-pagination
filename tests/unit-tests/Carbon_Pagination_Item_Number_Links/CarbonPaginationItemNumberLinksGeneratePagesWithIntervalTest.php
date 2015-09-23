<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGeneratePagesWithIntervalTest extends WP_UnitTestCase {

	public function setUp() {
		// mock pagination
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML');
		$this->pagination = $paginationStub;

		// mock collection
		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		// mock item
		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params);
		$this->item = $itemStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages_with_interval
	 */
	public function testGeneratePagesSameFromTo() {
		$items = $this->item->generate_pages_with_interval( 1, 1 );

		$this->assertSame( array(), $items );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages_with_interval
	 */
	public function testGeneratePagesSingleItem() {
		$items = $this->item->generate_pages_with_interval( 1, 2 );

		$this->assertSame( 1, count($items) );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 1, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages_with_interval
	 */
	public function testGeneratePagesSetOfItems() {
		$items = $this->item->generate_pages_with_interval( 1, 5 );

		$this->assertSame( 4, count($items) );
		for($i = 1; $i < 5; $i++) {
			$item = $items[ $i - 1 ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages_with_interval
	 */
	public function testGeneratePagesSetOfItemsWithCustomInterval() {
		$items = $this->item->generate_pages_with_interval( 1, 15, 3 );

		$this->assertSame( 5, count($items) );
		$key = 0;
		for($i = 1; $i < 15; $i += 3) {
			$item = $items[ $key ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
			$key++;
		}
	}

}