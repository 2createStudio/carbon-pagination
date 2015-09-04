<?php
/**
 * @group collection
 */
class CarbonPaginationCollectionGetSetPaginationTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$paginationStub2 = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination2 = $paginationStub2;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->pagination2 );
		unset( $this->collection );
	}

	/**
	 * @covers Carbon_Pagination_Collection::get_pagination
	 * @covers Carbon_Pagination_Collection::set_pagination
	 */
	public function testGetSetPagination() {
		$this->collection->set_pagination( $this->pagination2 );
		$this->assertSame( $this->pagination2, $this->collection->get_pagination() );
	}

}