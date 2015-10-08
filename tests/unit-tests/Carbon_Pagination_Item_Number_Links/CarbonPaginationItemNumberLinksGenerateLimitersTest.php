<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGenerateLimitersTest extends WP_UnitTestCase {

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

		// mock page item
		$this->item_page = $this->getMock('Carbon_Pagination_Item_Page', null, $params, '', false);

		// setup main item's subitems collection manually
		$params = array( $this->pagination, false );
		$this->subitems_collection = $this->getMock('Carbon_Pagination_Collection', null, $params );
		$this->item->set_subitems_collection( $this->subitems_collection );

	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item);
		unset($this->item_page);
		unset($this->subitems_collection);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_limiters()
	 */
	public function testWithNoItems() {
		$this->item->generate_limiters();
		$items = $this->item->get_subitems_collection()->get_items();

		$this->assertSame( array(), $items );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_limiters()
	 */
	public function testWithConsecutiveItems() {
		$subitem_params = array( $this->collection, false );
		$subitems_collection = $this->item->get_subitems_collection();
		
		for($i = 0; $i < 3; $i++) {
			$new_item = $this->getMock('Carbon_Pagination_Item_Page', null, $subitem_params);
			$new_item->set_page_number( $i );
			$subitems_collection->add_items( $new_item );
		}

		$items = $subitems_collection->get_items();
		$this->item->generate_limiters();

		$this->assertSame( $items, $subitems_collection->get_items() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_limiters()
	 */
	public function testWithLargerConsecutiveItems() {
		$subitem_params = array( $this->collection, false );
		$subitems_collection = $this->item->get_subitems_collection();
		
		for($i = 10; $i < 13; $i++) {
			$new_item = $this->getMock('Carbon_Pagination_Item_Page', null, $subitem_params);
			$new_item->set_page_number( $i );
			$subitems_collection->add_items( $new_item );
		}

		$items = $subitems_collection->get_items();
		$this->item->generate_limiters();

		$this->assertSame( $items, $subitems_collection->get_items() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_limiters()
	 */
	public function testWithOneMissingItemInMiddle() {
		$subitem_params = array( $this->collection, false );
		$subitems_collection = $this->item->get_subitems_collection();
		
		for($i = 0; $i < 5; $i++) {
			if ($i == 2) {
				continue;
			}
			$new_item = $this->getMock('Carbon_Pagination_Item_Page', null, $subitem_params);
			$new_item->set_page_number( $i );
			$subitems_collection->add_items( $new_item );
		}

		$old_items = $subitems_collection->get_items();
		$this->item->generate_limiters();
		$new_items = $subitems_collection->get_items();

		for($i = 0; $i < 5; $i++) {
			if ($i == 2) {
				$this->assertInstanceOf( 'Carbon_Pagination_Item_Limiter', $new_items[ $i ] );
			} else {
				$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $new_items[ $i ] );
				$this->assertSame( $i, $new_items[ $i ]->get_page_number() );
			}
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_limiters()
	 */
	public function testWithSeveralMissingItemsInMiddle() {
		$subitem_params = array( $this->collection, false );
		$subitems_collection = $this->item->get_subitems_collection();
		
		for($i = 0; $i < 10; $i++) {
			if ($i > 2 && $i < 7) {
				continue;
			}
			$new_item = $this->getMock('Carbon_Pagination_Item_Page', null, $subitem_params);
			$new_item->set_page_number( $i );
			$subitems_collection->add_items( $new_item );
		}

		$old_items = $subitems_collection->get_items();
		$this->item->generate_limiters();
		$new_items = $subitems_collection->get_items();

		for($i = 0; $i <= 2; $i++) {
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $new_items[ $i ] );
			$this->assertSame( $i, $new_items[ $i ]->get_page_number() );
		}

		$this->assertInstanceOf( 'Carbon_Pagination_Item_Limiter', $new_items[ 3 ] );

		for($i = 8; $i <= 9; $i++) {
			$key = $i - 3;
			$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $new_items[ $key ] );
			$this->assertSame( $i, $new_items[ $key ]->get_page_number() );
		}
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_limiters()
	 */
	public function testWithSeveralMissingSetsOfItems() {
		$subitem_params = array( $this->collection, false );
		$subitems_collection = $this->item->get_subitems_collection();
		$skipped = array(2, 5, 8);
		
		for($i = 0; $i < 10; $i++) {
			if ( in_array( $i, $skipped ) ) {
				continue;
			}
			$new_item = $this->getMock('Carbon_Pagination_Item_Page', null, $subitem_params);
			$new_item->set_page_number( $i );
			$subitems_collection->add_items( $new_item );
		}

		$old_items = $subitems_collection->get_items();
		$this->item->generate_limiters();
		$new_items = $subitems_collection->get_items();

		for($i = 0; $i < 10; $i++) {
			if ( in_array( $i, $skipped ) ) {
				$this->assertInstanceOf( 'Carbon_Pagination_Item_Limiter', $new_items[ $i ] );
			} else {
				$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $new_items[ $i ] );
				$this->assertSame( $i, $new_items[ $i ]->get_page_number() );
			}
		}
	}

}