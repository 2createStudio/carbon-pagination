<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksInitTest extends WP_UnitTestCase {

	public function setUp() {
		// mock pagination
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML');
		$this->pagination = $paginationStub;

		// mock collection
		$params = array($this->pagination, false);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		// mock item 1
		$params = array($this->collection);
		$itemStub1 = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params, '', false);
		$this->item1 = $itemStub1;
		$this->item1->set_collection($this->collection);

		// mock item 2
		$itemStub2 = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params, '', false);
		$this->item2 = $itemStub2;
		$this->item2->set_collection($this->collection);
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->item1);
		unset($this->item2);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::init
	 */
	public function testInitSubItemsCollection() {
		$this->item1->init();

		$this->assertInstanceOf( 'Carbon_Pagination_Collection', $this->item1->get_subitems_collection() );
		$this->assertSame( $this->pagination, $this->item1->get_subitems_collection()->get_pagination() );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::init
	 */
	public function testInitSubItemsCollectionContents() {
		$this->item1->init();

		// manually generate expected items for $this->item2
		$params = array($this->pagination, false);
		$subitems_collection = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->item2->set_subitems_collection( $subitems_collection );
		$this->item2->generate_large_number_pages_before();
		$this->item2->generate_regular_number_pages();
		$this->item2->generate_large_number_pages_after();
		$this->item2->generate_limiters();
		$this->item2->generate_wrappers();

		$expected_items = $this->item2->get_subitems_collection()->get_items();
		$actual_items = $this->item1->get_subitems_collection()->get_items();
		$expected = count( $expected_items );
		$actual = count( $actual_items );
		$this->assertSame( $expected, $actual );

		foreach ($expected_items as $key => $item) {
			$expected_classname = get_class( $item );
			$actual_classname = get_class( $actual_items[ $key ] );
			$this->assertSame( $expected_classname, $actual_classname );
		}
	}

}