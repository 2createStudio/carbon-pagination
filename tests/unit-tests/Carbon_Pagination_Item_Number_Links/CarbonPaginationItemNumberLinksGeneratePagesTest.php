<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGeneratePagesTest extends WP_UnitTestCase {

	public function setUp() {
		// mock pagination
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML');
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
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
		unset($this->subitems_collection);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSameFromTo() {
		$this->item->generate_pages( 1, 1 );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( array(), $items );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSingleItem() {
		$this->item->generate_pages( 1, 2 );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 1, count($items) );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $items[0] );
		$this->assertSame( 1, $items[0]->get_page_number() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSetOfItems() {
		$this->item->generate_pages( 1, 5 );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 4, count($items) );
		for($i = 1; $i < 5; $i++) {
			$item = $items[ $i - 1 ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSetOfItemsWithCustomInterval() {
		$this->item->generate_pages( 1, 15, 3 );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 5, count($items) );
		$key = 0;
		for($i = 1; $i < 15; $i += 3) {
			$item = $items[ $key ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
			$key++;
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSetOfItemsWithLimit() {
		$this->item->generate_pages( 1, 5, 1, 3 );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 3, count($items) );
		for($i = 1; $i < 3; $i++) {
			$item = $items[ $i - 1 ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSetOfItemsFromEnd() {
		$this->item->generate_pages( 1, 5, 1, 0, true );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 4, count($items) );
		for($i = 4; $i > 0; $i--) {
			$item = $items[ $i - 1 ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_pages
	 */
	public function testGeneratePagesSetOfItemsWithLimitFromEnd() {
		$this->item->generate_pages( 1, 5, 1, 3, true );
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( 3, count($items) );
		for($i = 5; $i < 3; $i++) {
			$item = $items[ $i - 1 ];
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
			$this->assertSame( $i, $item->get_page_number() );
		}
	}

}