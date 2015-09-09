<?php
/**
 * @group item
 * @group item_number_links
 */
class CarbonPaginationItemNumberLinksGenerateWrappersTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination_HTML');
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->pagination, false);
		$subitems_collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->subitems_collection = $subitems_collectionStub;

		$params = array($this->collection);
		$itemStub = $this->getMock('Carbon_Pagination_Item_Number_Links', null, $params, '', false);
		$this->item = $itemStub;
		$this->item->set_collection( $this->collection );
		$this->item->set_subitems_collection( $this->subitems_collection );

		$this->collection->expects( $this->any() )
			->method( 'get_items' )
			->will( $this->returnValue( array( $this->item ) ) );

		$subItemStub = $this->getMock('Carbon_Pagination_Item', null, $params, 'Carbon_Pagination_Item_Foo');
		$this->subitem = $subItemStub;

		$this->subitem_html = '<span class="foo">Bar</span>';
		$this->subitem->expects( $this->any() )
			->method( 'get_html' )
			->will( $this->returnValue( $this->subitem_html ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->subitems_collection);
		unset($this->item);
		unset($this->subitem);
		unset($this->subitem_html);
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_wrappers
	 */
	public function testGenerateWrappersEmptyCount() {
		$subitems_collection = $this->item->get_subitems_collection();
		$this->item->generate_wrappers();

		$this->assertSame( 0, count( $subitems_collection->get_items() ) );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_wrappers
	 */
	public function testGenerateWrappersNonEmpty() {
		$subitems_collection = $this->item->get_subitems_collection();
		$subitems_collection->add_items( $this->subitem );
		$this->item->generate_wrappers();
		$items = $subitems_collection->get_items();

		$this->assertSame( 3, count( $subitems_collection->get_items() ) );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Foo', $items[1] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[2] );
	}

	/**
	 * @covers Carbon_Pagination_Item_Number_Links::generate_wrappers
	 */
	public function testGenerateWrappersNonEmptyMoreItems() {
		$subitems_collection = $this->item->get_subitems_collection();
		$subitems_collection->add_items( array( $this->subitem, clone $this->subitem ) );
		$this->item->generate_wrappers();
		$items = $subitems_collection->get_items();

		$this->assertSame( 4, count( $subitems_collection->get_items() ) );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Foo', $items[1] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_Foo', $items[2] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[3] );
	}

}