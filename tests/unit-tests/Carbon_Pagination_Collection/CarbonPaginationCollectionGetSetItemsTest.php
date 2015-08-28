<?php
/**
 * @group collection
 */
class CarbonPaginationCollectionGetSetItemsTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$item_params = array( $this->collection );
		$item = $this->getMock( 'Carbon_Pagination_Item', null, $item_params );
		$this->item = $item;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Collection::get_items
	 * @covers Carbon_Pagination_Collection::set_items
	 */
	public function testGetSetItems() {
		$items = array( $this->item );
		$this->collection->set_items( $items );
		$this->assertSame( $items, $this->collection->get_items() );

		$this->collection->set_items( array() );
		$this->assertSame( array(), $this->collection->get_items() );
	}

}