<?php
/**
 * @group item
 * @group item_base
 */
class CarbonPaginationItemRenderTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$this->item = $this->getMock('Carbon_Pagination_Item', null, $params);
	}

	public function tearDown() {
		unset( $this->pagination );
		unset( $this->collection );
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Pagination_Item::render
	 */
	public function testRenderValue() {
		$this->assertSame( '', $this->item->render() );
	}

}