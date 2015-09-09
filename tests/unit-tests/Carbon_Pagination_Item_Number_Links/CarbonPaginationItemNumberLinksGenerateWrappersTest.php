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

}