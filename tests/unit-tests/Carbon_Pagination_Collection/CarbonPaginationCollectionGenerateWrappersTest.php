<?php
/**
 * @group collection
 */
class CarbonPaginationCollectionGenerateWrappersTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass('Carbon_Pagination', array(), '', TRUE, TRUE, TRUE);
		$this->pagination = $paginationStub;

		$params = array($this->pagination, false);
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
	 * @covers Carbon_Pagination_Collection::generate_wrappers
	 */
	public function testWithNothingEnabled() {
		$this->collection->generate_wrappers();

		$this->assertSame( array(), $this->collection->get_items() );
	}

	/**
	 * @covers Carbon_Pagination_Collection::generate_wrappers
	 */
	public function testWithOneItem() {
		$this->collection->add_items( array( $this->item ) );
		$this->collection->generate_wrappers();
		$items = $this->collection->get_items();

		$this->assertSame( 3, count( $items ) );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[0] );
		$this->assertInstanceOf( 'Carbon_Pagination_Item_HTML', $items[2] );
	}

}