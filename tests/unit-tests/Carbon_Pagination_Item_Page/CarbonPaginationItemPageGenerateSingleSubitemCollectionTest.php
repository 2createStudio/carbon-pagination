<?php
/**
 * @group item
 * @group item_page
 */
class CarbonPaginationItemPageGenerateSingleSubitemCollectionTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE, array());
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$this->html = '<span class="foo">Bar</span>';
		$this->page_number = 5;
		$this->subitems_collection = Carbon_Pagination_Item_Page::generate_single_subitem_collection( $this->collection, $this->html, $this->page_number );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->html);
		unset($this->page_number);
		unset($this->subitems_collection);
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::generate_single_subitem_collection
	 */
	public function testSubitemsCollectionExistance() {
		$this->assertInstanceOf('Carbon_Pagination_Collection', $this->subitems_collection);
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::generate_single_subitem_collection
	 */
	public function testSubitemsCollectionPagination() {
		$this->assertInstanceOf('Carbon_Pagination', $this->subitems_collection->get_pagination());
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::generate_single_subitem_collection
	 */
	public function testSubitemsCollectionItemCount() {
		$items = $this->subitems_collection->get_items();
		$this->assertSame( 1, count( $items ) );
	}

	/**
	 * @covers Carbon_Pagination_Item_Page::generate_single_subitem_collection
	 */
	public function testSubitemsCollectionItemData() {
		$items = $this->subitems_collection->get_items();
		$item = $items[0];

		$this->assertInstanceOf( 'Carbon_Pagination_Item_Page', $item );
		$this->assertSame( $this->html, $item->get_html() );
		$this->assertSame( $this->page_number, $item->get_page_number() );
	}

}