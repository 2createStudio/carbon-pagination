<?php

class CarbonPaginationItemConstructTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
	}

	public function testIfCollectionProperlySet() {
		$params = array($this->collection);
		$item = $this->getMock('Carbon_Pagination_Item', null, $params);
		$this->assertSame( $this->collection, $item->get_collection() );
	}

}