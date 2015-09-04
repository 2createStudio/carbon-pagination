<?php
/**
 * @group item
 * @group item_base
 */
class CarbonPaginationItemGetSetCollectionTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$collectionStub2 = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection2 = $collectionStub2;

		$params = array($this->collection);
		$this->item = $this->getMock('Carbon_Pagination_Item', null, $params);
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->collection2 );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item::get_collection
	 * @covers Carbon_Pagination_Item::set_collection
	 */
	public function testGetSetCollection() {
		$this->item->set_collection( $this->collection2 );
		$this->assertSame( $this->collection2, $this->item->get_collection() );
	}

}