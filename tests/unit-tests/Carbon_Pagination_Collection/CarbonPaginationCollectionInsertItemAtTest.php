<?php
/**
 * @group collection
 */
class CarbonPaginationCollectionInsertItemAtTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock( 'Carbon_Pagination_Collection', null, $params );
		$collectionStub->set_items( array() );
		$this->collection = $collectionStub;

		$item_params = array( $this->collection );
		$item = $this->getMock( 'Carbon_Pagination_Item', null, $item_params );
		$this->item = $item;

		$item2 = $this->getMock( 'Carbon_Pagination_Item', null, $item_params );
		$this->item2 = $item2;

		$item3 = $this->getMock( 'Carbon_Pagination_Item', null, $item_params );
		$this->item3 = $item3;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
		unset( $this->item2 );
		unset( $this->item3 );
	}

	public function testInsertAtBeginningInEmpty() {
		$this->collection->insert_item_at( $this->item, 0 );

		$expected = array( $this->item );
		$this->assertSame( $expected, $this->collection->get_items() );
	}

	public function testInsertAtSomewhereInEmpty() {
		$this->collection->insert_item_at( $this->item, 99 );

		$expected = array( $this->item );
		$this->assertSame( $expected, $this->collection->get_items() );
	}

	public function testInsertAtBeginningNotEmpty() {
		$this->collection->set_items( array( $this->item ) );
		$this->collection->insert_item_at( $this->item2, 0 );

		$expected = array( $this->item2, $this->item );
		$this->assertSame( $expected, $this->collection->get_items() );
	}

	public function testInsertAtEndNotEmpty() {
		$this->collection->set_items( array( $this->item ) );
		$this->collection->insert_item_at( $this->item2, 1 );

		$expected = array( $this->item, $this->item2 );
		$this->assertSame( $expected, $this->collection->get_items() );
	}

	public function testInsertAtSomewhereNotEmpty() {
		$this->collection->set_items( array( $this->item ) );
		$this->collection->insert_item_at( $this->item2, 99 );

		$expected = array( $this->item, $this->item2 );
		$this->assertSame( $expected, $this->collection->get_items() );
	}

	public function testInsertBetweenItems() {
		$this->collection->set_items( array( $this->item, $this->item3 ) );
		$this->collection->insert_item_at( $this->item2, 1 );

		$expected = array( $this->item, $this->item2, $this->item3 );
		$this->assertSame( $expected, $this->collection->get_items() );
	}

}