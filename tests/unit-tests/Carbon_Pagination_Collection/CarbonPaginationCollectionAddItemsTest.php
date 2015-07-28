<?php

class CarbonPaginationCollectionAddItemsTest extends WP_UnitTestCase {

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
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	public function testAddEmptyArray() {
		$this->collection->add_items( array() );
		$this->assertSame( array(), $this->collection->get_items() );
	}

	public function testNonArrayItem() {
		$this->collection->add_items( $this->item );
		$this->assertSame( array( $this->item ), $this->collection->get_items() );

		$this->collection->add_items( $this->item );
		$this->assertSame( array( $this->item, $this->item ), $this->collection->get_items() );		
	}

	public function testArrayOfItems() {
		$new_items = array( $this->item );

		$this->collection->add_items( $new_items );
		$this->assertSame( array( $this->item ), $this->collection->get_items() );

		$this->collection->add_items( $new_items );
		$this->assertSame( array( $this->item, $this->item ), $this->collection->get_items() );
	}

	public function testAssocArrayOfItems() {
		$new_items = array( 'foo' => $this->item );
		
		$this->collection->add_items( $new_items );
		$this->assertSame( array( $this->item ), $this->collection->get_items() );

		$this->collection->add_items( $new_items );
		$this->assertSame( array( $this->item, $this->item ), $this->collection->get_items() );
	}

}